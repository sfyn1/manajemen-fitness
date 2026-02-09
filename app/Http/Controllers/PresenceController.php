<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Presence;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresenceController extends Controller
{
    // 1. Halaman Scan (Kiosk)
    public function index()
    {
        // Tetap kirim data log harian untuk sidebar kanan (opsional, tapi bagus untuk monitoring)
        $recentPresences = Presence::with('member.user')
                            ->whereDate('check_in_time', Carbon::today())
                            ->orderBy('check_in_time', 'desc')
                            ->take(10)
                            ->get();

        return view('admin.presences.scan', compact('recentPresences'));
    }

    // 2. Proses Simpan Presensi (LOGIKA BARU: UNLIMITED CHECK-IN)
    public function store(Request $request)
    {
        $memberId = $request->member_id;
        
        // Cek Member Ada/Tidak
        $member = Member::with('user')->find($memberId);
        
        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan!',
                'audio' => 'error' 
            ]);
        }

        // Cek Masa Aktif
        if ($member->expiry_date < date('Y-m-d')) {
            return response()->json([
                'status' => 'error',
                'message' => 'MEMBER EXPIRED! Harap perpanjang paket.',
                'member' => $member->user->name,
                'audio' => 'expired'
            ]);
        }

        // --- PERUBAHAN: TIDAK ADA CEK DUPLIKAT HARI INI ---
        // Langsung simpan data kunjungan
        Presence::create([
            'member_id' => $memberId,
            'check_in_time' => now(),
            'status' => 'Hadir'
        ]);

        // Hitung Kunjungan Hari Ini (Untuk Info di layar scan)
        $visitCountToday = Presence::where('member_id', $memberId)
                            ->whereDate('check_in_time', Carbon::today())
                            ->count();

        $photoUrl = $member->photo 
            ? asset('storage/' . $member->photo) 
            : asset('template/assets/images/avatar/1.png');

        return response()->json([
            'status' => 'success',
            'message' => 'Silakan Masuk!',
            'member' => $member->user->name,
            // Kirim Data Tanggal untuk Tampilan
            'join_date' => date('d M Y', strtotime($member->join_date)),
            'expiry_date' => date('d M Y', strtotime($member->expiry_date)),
            'visit_count' => $visitCountToday, // Kunjungan ke-berapa hari ini
            'photo' => $photoUrl,
            'audio' => 'success'
        ]);
    }

    // 3. Halaman "Kehadiran Member" (Rekap Statistik)
    public function history()
    {
        // Kita ambil data Member beserta hitungan kehadirannya
        $members = Member::with('user')
            ->withCount([
                // Hitung kedatangan Hari Ini
                'presences as visits_today' => function ($query) {
                    $query->whereDate('check_in_time', Carbon::today());
                },
                // Hitung kedatangan Minggu Ini
                'presences as visits_week' => function ($query) {
                    $query->whereBetween('check_in_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                },
                // Hitung kedatangan Bulan Ini
                'presences as visits_month' => function ($query) {
                    $query->whereMonth('check_in_time', Carbon::now()->month)
                          ->whereYear('check_in_time', Carbon::now()->year);
                },
                // Total Seumur Hidup
                'presences as visits_total'
            ])
            ->orderBy('visits_today', 'desc') // Yang hadir hari ini paling atas
            ->get();

        return view('admin.presences.history', compact('members'));
    }

    // 4. HALAMAN LAPORAN HARIAN/BULANAN (FILTER TANGGAL)
    public function report(Request $request)
    {
        // Default tanggal: Awal bulan ini sampai Hari ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Query Data Presensi dengan Range Tanggal
        $presences = Presence::with('member.user')
            ->whereDate('check_in_time', '>=', $startDate)
            ->whereDate('check_in_time', '<=', $endDate)
            ->orderBy('check_in_time', 'desc')
            ->get();

        return view('admin.presences.report', compact('presences', 'startDate', 'endDate'));
    }
}