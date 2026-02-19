<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\CoachPresence;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CoachDashboardController extends Controller
{
    // DASHBOARD: Tampilkan Jadwal Coach Hari Ini
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Pastikan user ini terhubung ke data Coach
        if (!$user->coachProfile) {
            abort(403, 'Akun Anda tidak terdaftar sebagai Coach.');
        }

        $coachId = $user->coachProfile->id;
        
        // --- LOGIKA BARU: FILTER TANGGAL ---
        // Jika user memilih tanggal via filter, pakai itu. Jika tidak, pakai Hari Ini.
        $targetDate = $request->date ? Carbon::parse($request->date) : Carbon::today();
        
        // Set Locale ID agar nama hari (Senin, Selasa) sesuai
        Carbon::setLocale('id');
        $targetDayName = $targetDate->translatedFormat('l'); // Senin, Selasa...

        // Ambil Jadwal Coach sesuai HARI yang dipilih
        $schedules = Schedule::with('classType')
            ->where('coach_id', $coachId)
            ->where('day', $targetDayName) // Filter berdasarkan Nama Hari (Senin/Selasa)
            ->orderBy('start_time')
            ->get();

        // Cek status laporan/absensi untuk setiap jadwal di TANGGAL tersebut
        foreach($schedules as $schedule) {
            $schedule->presence = CoachPresence::where('schedule_id', $schedule->id)
                ->whereDate('date', $targetDate) // Cek presensi di tanggal spesifik
                ->first();
            
            // Hitung jumlah member yang booking di jadwal & tanggal ini
            $schedule->total_members = \App\Models\Booking::where('schedule_id', $schedule->id)
                ->where('date', $targetDate->format('Y-m-d'))
                ->count();
        }

        return view('coach.dashboard', compact('schedules', 'targetDate', 'targetDayName'));
    }

    // PROSES UPLOAD BUKTI FOTO
    public function storePresence(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'photo'       => 'required|image|max:5120', // Max 5MB
        ]);

        $user = Auth::user();
        $schedule = Schedule::with('classType')->findOrFail($request->schedule_id);

        // Upload File
        $path = $request->file('photo')->store('evidence', 'public');

        // Simpan ke Database (Status PENDING)
        CoachPresence::create([
            'coach_id'       => $user->coachProfile->id,
            'schedule_id'    => $schedule->id,
            'date'           => Carbon::today(),
            'coach_fee'      => $schedule->classType->price, // Simpan harga saat ini
            'evidence_photo' => $path,
            'status'         => 'pending' // Menunggu Admin
        ]);

        return back()->with('success', 'Laporan berhasil dikirim! Menunggu persetujuan Admin.');
    }
}