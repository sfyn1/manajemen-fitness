<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberBookingController extends Controller
{
    // 1. HALAMAN PILIH JADWAL
    public function index()
    {
        $schedules = Schedule::with(['classType', 'coach'])->get();
        $upcomingClasses = [];
        $today = Carbon::now();

        // Peta Nama Hari (Indo -> Inggris)
        $daysMap = [
            'Senin'  => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu'   => 'Wednesday',
            'Kamis'  => 'Thursday',
            'Jumat'  => 'Friday',
            'Sabtu'  => 'Saturday',
            'Minggu' => 'Sunday',
        ];

        foreach($schedules as $schedule) {
            // Ambil nama hari Inggris dari map
            $englishDay = $daysMap[$schedule->day] ?? null;

            if (!$englishDay) continue; // Skip jika nama hari tidak valid

            // Cek apakah hari ini sama dengan hari jadwal?
            if ($today->format('l') == $englishDay) {
                // Jika hari sama, cek jamnya
                if ($today->format('H:i:s') < $schedule->start_time) {
                    $targetDate = Carbon::today();
                } else {
                    // Jika sudah lewat jamnya, ambil minggu depan
                    $targetDate = Carbon::parse('next ' . $englishDay);
                }
            } else {
                // Jika beda hari, cari hari tersebut yang akan datang
                $targetDate = Carbon::parse('next ' . $englishDay);
            }

            // Cek status booking
            $isBooked = Booking::where('user_id', Auth::id())
                               ->where('schedule_id', $schedule->id)
                               ->where('date', $targetDate->format('Y-m-d'))
                               ->exists();

            $upcomingClasses[] = [
                'schedule_id' => $schedule->id,
                'class_name'  => $schedule->classType->name,
                'coach_name'  => $schedule->coach->name,
                'day'         => $schedule->day, // Tetap tampilkan nama hari Indo
                'time'        => Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . Carbon::parse($schedule->end_time)->format('H:i'),
                'real_date'   => $targetDate,
                'is_booked'   => $isBooked
            ];
        }

        // Urutkan berdasarkan tanggal terdekat
        usort($upcomingClasses, function($a, $b) {
            return $a['real_date'] <=> $b['real_date'];
        });

        return view('member.booking.index', compact('upcomingClasses'));
    }

    // 2. PROSES SIMPAN BOOKING
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'date'        => 'required|date', // Tanggal hasil hitungan tadi dikirim balik
        ]);

        // Cek duplikasi (server side validation)
        $exists = Booking::where('user_id', Auth::id())
                         ->where('schedule_id', $request->schedule_id)
                         ->where('date', $request->date)
                         ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah booking kelas ini sebelumnya.');
        }

        Booking::create([
            'user_id'      => Auth::id(),
            'schedule_id'  => $request->schedule_id,
            'date'         => $request->date,
            'booking_code' => 'BK-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('booking.history')->with('success', 'Booking berhasil! Jangan terlambat ya.');
    }

    // 3. RIWAYAT BOOKING SAYA
    public function history()
    {
        $bookings = Booking::with(['schedule.classType', 'schedule.coach'])
                           ->where('user_id', Auth::id())
                           ->latest()
                           ->get();

        return view('member.booking.history', compact('bookings'));
    }

    // 4. BATALKAN BOOKING
    public function destroy($id)
    {
        // Cari booking berdasarkan ID dan pastikan milik user yang sedang login (agar aman)
        $booking = Booking::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        // Hapus data booking
        $booking->delete();

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}