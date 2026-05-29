<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Member;
use App\Models\PtPackage;
use App\Models\PtSubscription;
use App\Models\PtSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PtSubscriptionController extends Controller
{
    // =========================================================================
    // ADMIN: Kelola semua langganan PT
    // =========================================================================

    public function adminIndex()
    {
        $subscriptions = PtSubscription::with(['member.user', 'coach', 'package'])
            ->latest()
            ->paginate(15);

        return view('admin.pt_subscriptions.index', compact('subscriptions'));
    }

    /**
     * Admin mengkonfirmasi langganan PT yang pending (status → active)
     * Sekaligus set start_date & end_date
     */
    public function activate($id)
    {
        $sub = PtSubscription::with(['package', 'member'])->findOrFail($id);

        if ($sub->status !== 'pending') {
            return back()->with('error', 'Langganan ini sudah diproses.');
        }

        $startDate = Carbon::today();
        $endDate   = Carbon::parse($sub->member->expiry_date);

        $sub->update([
            'status'     => 'active',
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ]);

        return back()->with('success', "Langganan PT #{$sub->id} berhasil diaktifkan! Berlaku s/d {$endDate->format('d M Y')}.");
    }

    /**
     * Admin menandai pembayaran sudah diterima
     */
    public function markPaid(Request $request, $id)
    {
        $sub = PtSubscription::findOrFail($id);

        $sub->update([
            'payment_status' => 'paid',
            'paid_at'        => now(),
            'payment_note'   => $request->input('payment_note'),
        ]);

        return back()->with('success', 'Pembayaran berhasil dicatat!');
    }

    /**
     * Admin batalkan langganan
     */
    public function cancel($id)
    {
        $sub = PtSubscription::findOrFail($id);

        if ($sub->payment_status === 'unpaid') {
            $sub->sessions()->delete();
            $sub->delete();
            return back()->with('success', 'Langganan yang belum dibayar berhasil dibatalkan dan dihapus dari sistem.');
        }

        $sub->update(['status' => 'cancelled']);
        return back()->with('success', 'Langganan berhasil dibatalkan.');
    }

    // =========================================================================
    // MEMBER: Daftar PT dari halaman member
    // =========================================================================

    /**
     * Halaman daftar semua PT yang tersedia (member lihat & pilih)
     */
    public function memberIndex()
    {
        $personalTrainers = Coach::where('coach_type', 'personal_trainer')
            ->with('user')
            ->get();

        $packages = PtPackage::where('is_active', true)
            ->orderBy('session_count')
            ->get();

        // Cek apakah member sudah punya langganan PT aktif
        $member = Auth::user()->member;
        $activeSub = null;
        if ($member) {
            $activeSub = PtSubscription::where('member_id', $member->id)
                ->whereIn('status', ['pending', 'active'])
                ->with(['coach', 'package'])
                ->latest()
                ->first();
        }

        return view('member.pt-booking.index', compact('personalTrainers', 'packages', 'activeSub'));
    }

    /**
     * Member submit pendaftaran PT (pilih PT + paket)
     */
    public function memberRegister(Request $request)
    {
        $request->validate([
            'coach_id'      => 'required|exists:coaches,id',
            'pt_package_id' => 'required|exists:pt_packages,id',
        ]);

        $member = Auth::user()->member;

        if (!$member) {
            return back()->with('error', 'Data member tidak ditemukan.');
        }

        // Cek apakah sudah punya langganan aktif / pending
        $existing = PtSubscription::where('member_id', $member->id)
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Anda sudah memiliki langganan PT yang aktif atau menunggu konfirmasi.');
        }

        $package = PtPackage::findOrFail($request->pt_package_id);
        $coach   = Coach::findOrFail($request->coach_id);

        if ($coach->coach_type !== 'personal_trainer') {
            return back()->with('error', 'Coach yang dipilih bukan Personal Trainer.');
        }

        PtSubscription::create([
            'member_id'      => $member->id,
            'coach_id'       => $coach->id,
            'pt_package_id'  => $package->id,
            'sessions_total' => $package->session_count,
            'sessions_used'  => 0,
            'status'         => 'pending', // Menunggu konfirmasi admin
            'payment_status' => 'unpaid',  // Bayar saat sesi pertama
        ]);

        return redirect()->route('member.pt.my-subscription')
            ->with('success', "Pendaftaran PT berhasil! Menunggu konfirmasi admin. Pembayaran dilakukan saat sesi pertama.");
    }

    /**
     * Halaman "Langganan PT Saya" — status + tombol booking sesi
     */
    public function mySubscription()
    {
        $member = Auth::user()->member;

        // Hapus langganan yang belum dibayar & dibatalkan dari database
        $unpaidCancelled = PtSubscription::where('member_id', $member->id)
            ->where('payment_status', 'unpaid')
            ->where('status', 'cancelled')
            ->get();

        foreach ($unpaidCancelled as $sub) {
            $sub->sessions()->delete(); // Hapus sesi terkait (jika ada) untuk menghindari error foreign key
            $sub->delete();
        }

        // Tampilkan langganan selain yang dibatalkan
        $subscriptions = PtSubscription::where('member_id', $member->id)
            ->where('status', '!=', 'cancelled')
            ->with(['coach', 'package', 'sessions' => function ($q) {
                $q->orderBy('session_date')->orderBy('start_time');
            }])
            ->latest()
            ->get();

        return view('member.pt-booking.my-subscription', compact('subscriptions'));
    }
}
