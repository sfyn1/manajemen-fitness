<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\CoachPresence;
use App\Models\CoachPayout;
use Carbon\Carbon;

class CoachPayoutController extends Controller
{
    // 1. HALAMAN UTAMA & LOGIKA HITUNG
    public function create(Request $request)
    {
        $coaches = Coach::all();
        
        // Variabel penampung hasil
        $presences = [];
        $totalSalary = 0;
        $selectedCoach = null;
        $selectedMonth = $request->month ?? date('Y-m'); // Default bulan ini (2026-02)

        // JIKA TOMBOL "CEK HITUNGAN" DIKLIK (Ada parameter coach_id & month)
        if ($request->has('coach_id') && $request->has('month')) {
            
            $coachId = $request->coach_id;
            $monthInput = $request->month; // Format: "2026-02"
            $date = Carbon::parse($monthInput);

            $selectedCoach = Coach::find($coachId);

            // QUERY PENTING: Ambil data absensi yang sudah DI-APPROVE admin
            $presences = CoachPresence::with('schedule.classType')
                ->where('coach_id', $coachId)
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->where('status', 'approved') // <--- HANYA YANG SUDAH DIAKUI ADMIN
                ->get();

            // Hitung Total Gaji
            $totalSalary = $presences->sum('coach_fee');
        }

        return view('admin.payouts.create', compact('coaches', 'presences', 'totalSalary', 'selectedCoach', 'selectedMonth'));
    }

    // 2. SIMPAN PEMBAYARAN (BAYAR & SIMPAN)
    public function store(Request $request)
    {
        $request->validate([
            'coach_id' => 'required',
            'month' => 'required',
            'total_amount' => 'required|numeric|min:1',
        ]);

        $date = Carbon::parse($request->month);

        // Buat Slip Gaji
        $payout = CoachPayout::create([
            'payout_number' => 'PAY-' . strtoupper(uniqid()),
            'coach_id' => $request->coach_id,
            'month' => $date->format('m'),
            'year' => $date->format('Y'),
            'total_sessions' => $request->total_sessions,
            'total_amount' => $request->total_amount,
            'paid_at' => now(),
        ]);

        // (Opsional) Tandai presensi sebagai "PAID" agar tidak dihitung 2x
        // CoachPresence::where(...)->update(['status' => 'paid']);

        return redirect()->route('admin.payouts.index')->with('success', 'Gaji berhasil dibayarkan & disimpan.');
    }

    public function index()
    {
        $payouts = CoachPayout::with('coach')->latest()->get();
        return view('admin.payouts.index', compact('payouts'));
    }

    // 4. CETAK SLIP GAJI (PDF VIEW)
    public function print($id)
    {
        // Ambil data payout berdasarkan ID
        $payout = CoachPayout::with('coach')->findOrFail($id);
        
        // Render tampilan slip gaji (bisa langsung diprint browser Ctrl+P)
        return view('admin.payouts.print', compact('payout'));
    }
}