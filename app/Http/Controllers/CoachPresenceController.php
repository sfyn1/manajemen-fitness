<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\CoachPresence;
use Carbon\Carbon;

class CoachPresenceController extends Controller
{
    // 1. HALAMAN ADMIN: LIHAT DAFTAR LAPORAN COACH
    public function index(Request $request)
    {
        // Default hari ini, atau ambil dari filter tanggal
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();
        
        // Translate hari ke Indonesia (Senin, Selasa...)
        Carbon::setLocale('id');
        $dayName = $date->translatedFormat('l');

        // Ambil Jadwal Rutin pada HARI tersebut
        $schedules = Schedule::with(['coach', 'classType'])
                             ->where('day', $dayName)
                             ->orderBy('start_time')
                             ->get();

        return view('admin.presences.coach', compact('schedules', 'date'));
    }

    // 2. ADMIN APPROVE (KONFIRMASI SELESAI)
    public function approve($id)
    {
        // Cari data presensi berdasarkan ID yang dikirim
        $presence = CoachPresence::findOrFail($id);
        
        // Ubah status jadi Approved
        $presence->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Sesi berhasil disetujui. Gaji coach telah dihitung.');
    }
    
    // 3. ADMIN REJECT (OPSIONAL - JIKA FOTO TIDAK JELAS)
    public function reject($id)
    {
        $presence = CoachPresence::findOrFail($id);
        $presence->update(['status' => 'rejected']);
        
        return back()->with('error', 'Laporan sesi ditolak.');
    }
}