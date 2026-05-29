<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\CoachPresence;
use App\Models\CoachPayout;
use App\Models\PtSession;
use Carbon\Carbon;

class CoachPayoutController extends Controller
{
    /**
     * Halaman utama daftar semua slip gaji
     */
    public function index()
    {
        $payouts = CoachPayout::with('coach')->latest('paid_at')->get();
        return view('admin.payouts.index', compact('payouts'));
    }

    /**
     * Halaman kalkulasi gaji — tampilkan preview sebelum bayar
     */
    public function create(Request $request)
    {
        // Semua coach, pisahkan berdasarkan tipe
        $personalTrainers = Coach::where('coach_type', 'personal_trainer')->get();
        $groupCoaches     = Coach::where('coach_type', 'group_coach')->get();

        $result        = null;
        $selectedCoach = null;
        $selectedMonth = $request->month ?? date('Y-m');

        if ($request->filled('coach_id') && $request->filled('month')) {
            $coach   = Coach::findOrFail($request->coach_id);
            $date    = Carbon::parse($request->month);

            $selectedCoach = $coach;

            if ($coach->coach_type === 'personal_trainer') {
                // === PT: Gaji Flat Bulanan ===
                $result = [
                    'type'        => 'monthly_salary',
                    'base_salary' => $coach->base_salary,
                    'bonus'       => 0,
                    'total'       => $coach->base_salary,
                    'sessions'    => [], // PT tidak ada sesi untuk dihitung
                ];
            } else {
                // === Group Coach: Hitung Sesi yang Approved ===
                $presences = CoachPresence::with('schedule.classType')
                    ->where('coach_id', $coach->id)
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->where('status', 'approved')
                    ->get();

                $totalSalary = $presences->sum('coach_fee');

                $result = [
                    'type'        => 'session_fee',
                    'presences'   => $presences,
                    'total'       => $totalSalary,
                    'base_salary' => 0,
                    'bonus'       => 0,
                ];
            }
        }

        return view('admin.payouts.create', compact(
            'personalTrainers', 'groupCoaches',
            'result', 'selectedCoach', 'selectedMonth'
        ));
    }

    /**
     * Simpan slip gaji (bayar)
     */
    public function store(Request $request)
    {
        $request->validate([
            'coach_id'     => 'required|exists:coaches,id',
            'month'        => 'required',
            'total_amount' => 'required|numeric|min:0',
            'payout_type'  => 'required|in:monthly_salary,session_fee',
        ]);

        $coach = Coach::findOrFail($request->coach_id);
        $date  = Carbon::parse($request->month);

        CoachPayout::create([
            'payout_number'  => 'PAY-' . strtoupper(uniqid()),
            'coach_id'       => $coach->id,
            'payout_type'    => $request->payout_type,
            'month'          => $date->format('m'),
            'year'           => $date->format('Y'),
            'total_sessions' => $request->input('total_sessions', 0),
            'base_salary'    => $request->input('base_salary', 0),
            'bonus'          => $request->input('bonus', 0),
            'total_amount'   => $request->total_amount,
            'notes'          => $request->input('notes', ''),
            'paid_at'        => now(),
        ]);

        return redirect()->route('admin.payouts.index')
            ->with('success', 'Gaji berhasil dibayarkan & slip disimpan!');
    }

    /**
     * Cetak slip gaji
     */
    public function print($id)
    {
        $payout = CoachPayout::with('coach')->findOrFail($id);
        return view('admin.payouts.print', compact('payout'));
    }

    /**
     * Route calculate (alias ke create)
     */
    public function calculate(Request $request)
    {
        return $this->create($request);
    }
}