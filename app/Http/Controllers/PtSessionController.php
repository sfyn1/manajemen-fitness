<?php

namespace App\Http\Controllers;

use App\Models\PtSession;
use App\Models\PtSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PtSessionController extends Controller
{
    // =========================================================================
    // MEMBER: Booking sesi PT
    // =========================================================================

    /**
     * Halaman pilih tanggal & jam untuk sesi PT
     */
    public function create($subscriptionId)
    {
        $member = Auth::user()->member;

        $subscription = PtSubscription::where('id', $subscriptionId)
            ->where('member_id', $member->id)
            ->where('status', 'active')
            ->with(['coach', 'package', 'member'])
            ->firstOrFail();

        if ($subscription->sessions_left <= 0) {
            return redirect()->route('member.pt.my-subscription')
                ->with('error', 'Semua sesi sudah habis digunakan.');
        }

        // Ambil slot yang sudah dibooking PT ini (Senin–Sabtu ke depan, max 4 minggu)
        $bookedSlots = PtSession::where('coach_id', $subscription->coach_id)
            ->where('status', 'scheduled')
            ->where('session_date', '>=', Carbon::today())
            ->get(['session_date', 'start_time', 'end_time'])
            ->groupBy(fn($s) => $s->session_date->format('Y-m-d'));

        return view('member.pt-booking.create-session', compact('subscription', 'bookedSlots'));
    }

    /**
     * Simpan booking sesi baru
     * Jam operasional: 07:00 – 22:00 (step 1 jam)
     * Member pilih jam mulai → end_time dihitung otomatis (+ duration_minutes)
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:pt_subscriptions,id',
            'session_date'    => 'required|date|after:today',
            'start_time'      => 'required|date_format:H:i',
        ]);

        $member       = Auth::user()->member;
        $subscription = PtSubscription::where('id', $request->subscription_id)
            ->where('member_id', $member->id)
            ->where('status', 'active')
            ->with('package')
            ->firstOrFail();

        // Validasi: tidak boleh Minggu
        $date = Carbon::parse($request->session_date);
        if ($date->isSunday()) {
            return back()->with('error', 'Gym tutup hari Minggu. Pilih hari lain.');
        }

        // Validasi: tidak boleh melewati masa aktif membership
        if ($member->expiry_date && $date->startOfDay()->gt(Carbon::parse($member->expiry_date)->startOfDay())) {
            return back()->with('error', 'Tanggal sesi tidak boleh melewati masa aktif membership Anda.');
        }

        // Validasi: tanggal tidak boleh hari ini (booking minimal H+1 sebenarnya tidak, tp jam operasional dicek)
        $startTime = Carbon::parse($request->session_date . ' ' . $request->start_time . ':00');
        if ($startTime->isPast()) {
            return back()->with('error', 'Jam yang dipilih sudah lewat. Pilih jam lain.');
        }

        // Hitung end_time berdasarkan durasi paket
        $durationMinutes = $subscription->package->duration_minutes;
        $endTime = Carbon::parse($request->start_time)->addMinutes($durationMinutes)->format('H:i');

        // Validasi jam operasional: start 07:00 – 21:00, end max 22:00
        $startHour = (int) explode(':', $request->start_time)[0];
        $endHour   = (int) explode(':', $endTime)[0];

        if ($startHour < 7 || $startHour >= 21) {
            return back()->with('error', 'Jam mulai harus antara 07:00 – 21:00.');
        }
        if ($endHour > 22 || ($endHour === 22 && (int) explode(':', $endTime)[1] > 0)) {
            return back()->with('error', 'Sesi tidak boleh melebihi jam 22:00.');
        }

        // Cek bentrok dengan sesi PT lain di jam yang sama
        $conflict = PtSession::where('coach_id', $subscription->coach_id)
            ->where('session_date', $date->format('Y-m-d'))
            ->where('status', 'scheduled')
            ->where(function ($q) use ($request, $endTime) {
                // Overlap check: start < end_existing AND end > start_existing
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $request->start_time . ':00');
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'PT sudah ada sesi di waktu tersebut. Pilih jam lain.');
        }

        // Cek sisa sesi
        if ($subscription->sessions_left <= 0) {
            return back()->with('error', 'Sesi sudah habis.');
        }

        // Hitung nomor sesi (ke berapa)
        $sessionNumber = $subscription->sessions()->count() + 1;

        // Simpan sesi
        PtSession::create([
            'pt_subscription_id' => $subscription->id,
            'member_id'          => $member->id,
            'coach_id'           => $subscription->coach_id,
            'session_date'       => $date->format('Y-m-d'),
            'start_time'         => $request->start_time . ':00',
            'end_time'           => $endTime . ':00',
            'session_number'     => $sessionNumber,
            'status'             => 'scheduled',
        ]);

        return redirect()->route('member.pt.my-subscription')
            ->with('success', "Sesi #{$sessionNumber} berhasil dijadwalkan! {$date->translatedFormat('l, d F Y')} pukul {$request->start_time}.");
    }

    /**
     * Member batalkan sesi (H-1 sebelum sesi)
     */
    public function cancel(Request $request, $id)
    {
        $member  = Auth::user()->member;
        $session = PtSession::where('id', $id)
            ->where('member_id', $member->id)
            ->firstOrFail();

        if (!$session->isCancellable()) {
            return back()->with('error', 'Sesi hanya bisa dibatalkan minimal H-1 (sehari sebelum sesi).');
        }

        $session->update([
            'status'        => 'cancelled',
            'cancel_reason' => $request->input('cancel_reason', 'Dibatalkan oleh member'),
            'cancelled_at'  => now(),
        ]);

        return back()->with('success', 'Sesi berhasil dibatalkan.');
    }

    /**
     * Member ubah jadwal sesi (reschedule, harus H-1)
     */
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'session_date' => 'required|date|after:today',
            'start_time'   => 'required|date_format:H:i',
        ]);

        $member  = Auth::user()->member;
        $session = PtSession::where('id', $id)
            ->where('member_id', $member->id)
            ->with('subscription.package')
            ->firstOrFail();

        if (!$session->isReschedulable()) {
            return back()->with('error', 'Jadwal hanya bisa diubah minimal H-1 (sehari sebelum sesi).');
        }

        $newDate = Carbon::parse($request->session_date);

        // Tidak boleh hari Minggu
        if ($newDate->isSunday()) {
            return back()->with('error', 'Gym tutup hari Minggu. Pilih hari lain.');
        }

        $durationMinutes = $session->subscription->package->duration_minutes;
        $newEndTime = Carbon::parse($request->start_time)->addMinutes($durationMinutes)->format('H:i');

        // Validasi jam operasional
        $startHour = (int) explode(':', $request->start_time)[0];
        $endHour   = (int) explode(':', $newEndTime)[0];
        if ($startHour < 7 || $startHour >= 21) {
            return back()->with('error', 'Jam mulai harus antara 07:00 – 21:00.');
        }
        if ($endHour > 22 || ($endHour === 22 && (int) explode(':', $newEndTime)[1] > 0)) {
            return back()->with('error', 'Sesi tidak boleh melebihi jam 22:00.');
        }

        // Cek bentrok (kecuali sesi ini sendiri)
        $conflict = PtSession::where('coach_id', $session->coach_id)
            ->where('session_date', $newDate->format('Y-m-d'))
            ->where('status', 'scheduled')
            ->where('id', '!=', $session->id)
            ->where(function ($q) use ($request, $newEndTime) {
                $q->where('start_time', '<', $newEndTime . ':00')
                  ->where('end_time', '>', $request->start_time . ':00');
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'PT sudah ada sesi di waktu tersebut. Pilih jam lain.');
        }

        // Simpan jadwal lama untuk audit
        $session->update([
            'rescheduled_from_date' => $session->session_date,
            'rescheduled_from_time' => $session->start_time,
            'rescheduled_at'        => now(),
            'session_date'          => $newDate->format('Y-m-d'),
            'start_time'            => $request->start_time . ':00',
            'end_time'              => $newEndTime . ':00',
        ]);

        return back()->with('success', "Jadwal berhasil diubah ke {$newDate->translatedFormat('l, d F Y')} pukul {$request->start_time}.");
    }


    // =========================================================================
    // PT/COACH: Kelola sesi (lihat jadwal & tandai selesai)
    // =========================================================================

    /**
     * PT lihat semua sesi mendatang miliknya
     */
    public function coachSessions(Request $request)
    {
        $user  = Auth::user();
        $coach = $user->coachProfile;

        if (!$coach || !$coach->isPersonalTrainer()) {
            abort(403, 'Hanya Personal Trainer yang bisa mengakses halaman ini.');
        }

        $targetDate = $request->date ? Carbon::parse($request->date) : Carbon::today();

        $sessions = PtSession::where('coach_id', $coach->id)
            ->where('session_date', $targetDate->format('Y-m-d'))
            ->with('member.user')
            ->orderBy('start_time')
            ->get();

        // Sesi mendatang (7 hari ke depan)
        $upcomingSessions = PtSession::where('coach_id', $coach->id)
            ->where('session_date', '>', $targetDate->format('Y-m-d'))
            ->where('session_date', '<=', Carbon::today()->addDays(7)->format('Y-m-d'))
            ->where('status', 'scheduled')
            ->with('member.user')
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->get();

        return view('coach.pt_sessions', compact('sessions', 'upcomingSessions', 'targetDate', 'coach'));
    }

    /**
     * PT tandai sesi sebagai selesai + tambahkan catatan latihan
     */
    public function complete(Request $request, $id)
    {
        $user    = Auth::user();
        $coach   = $user->coachProfile;
        $session = PtSession::where('id', $id)
            ->where('coach_id', $coach->id)
            ->where('status', 'scheduled')
            ->with('subscription')
            ->firstOrFail();

        $session->update([
            'status' => 'completed',
            'notes'  => $request->input('notes', ''),
        ]);

        // Tambah sessions_used di subscription
        $sub = $session->subscription;
        $sub->increment('sessions_used');

        // Cek apakah semua sesi selesai
        if ($sub->sessions_used >= $sub->sessions_total) {
            $sub->update(['status' => 'completed']);
        }

        return back()->with('success', "Sesi #{$session->session_number} ditandai selesai!");
    }

    /**
     * PT tandai member tidak hadir (no-show)
     */
    public function noShow($id)
    {
        $user    = Auth::user();
        $coach   = $user->coachProfile;
        $session = PtSession::where('id', $id)
            ->where('coach_id', $coach->id)
            ->where('status', 'scheduled')
            ->with('subscription')
            ->firstOrFail();

        $session->update(['status' => 'no_show']);

        // No-show juga menghitung sesi (sesi tetap berkurang)
        $sub = $session->subscription;
        $sub->increment('sessions_used');

        if ($sub->sessions_used >= $sub->sessions_total) {
            $sub->update(['status' => 'completed']);
        }

        return back()->with('success', 'Member ditandai tidak hadir. Sesi tetap dihitung.');
    }

    // =========================================================================
    // ADMIN: Lihat semua sesi PT (monitoring)
    // =========================================================================

    public function adminIndex(Request $request)
    {
        $sessions = PtSession::with(['member.user', 'coach', 'subscription.package'])
            ->latest('session_date')
            ->paginate(20);

        return view('admin.pt_sessions.index', compact('sessions'));
    }
}
