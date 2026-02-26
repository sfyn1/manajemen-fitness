<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Coach;
use App\Models\ClassType;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Product;
use App\Models\Presence;
use App\Models\Transaction;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK MEMBER
        $totalMembers = Member::count();
        $newMembersThisMonth = Member::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $activeMembersThisWeek = Presence::whereBetween('created_at', [
            Carbon::now()->subWeek(),
            Carbon::now()
        ])->distinct('member_id')->count('member_id');

        // 2. STATISTIK COACH
        $totalCoaches = Coach::count();
        $activeCoachesThisMonth = Schedule::whereMonth('created_at', Carbon::now()->month)
            ->distinct('coach_id')
            ->count('coach_id');

        // 3. STATISTIK KELAS
        $totalClassTypes = ClassType::count();
        $totalSchedules = Schedule::count();

        // 4. STATISTIK PRODUK
        $totalProducts = Product::count();

        // 5. STATISTIK TRANSAKSI (INCOME)
        $totalIncome = Transaction::where('status', 'completed')->sum('grand_total');
        $thisMonthIncome = Transaction::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('grand_total');

        // 6. DATA UNTUK CHART - MEMBER REGISTRATION (12 BULAN TERAKHIR)
        $memberRegistrationChart = $this->getMemberRegistrationChart();

        // 7. DATA UNTUK CHART - INCOME (12 BULAN TERAKHIR)
        $incomeChart = $this->getIncomeChart();

        // 8. DATA UNTUK CHART - ATTENDANCE (7 HARI TERAKHIR)
        $attendanceChart = $this->getAttendanceChart();

        // 9. DATA UNTUK CHART - KELAS POPULER
        $popularClassesChart = $this->getPopularClassesChart();

        // 10. DATA UNTUK CHART - COACH PERFORMANCE
        $coachPerformanceChart = $this->getCoachPerformanceChart();

        return view('admin.dashboard', [
            'totalMembers' => $totalMembers,
            'newMembersThisMonth' => $newMembersThisMonth,
            'activeMembersThisWeek' => $activeMembersThisWeek,
            'totalCoaches' => $totalCoaches,
            'activeCoachesThisMonth' => $activeCoachesThisMonth,
            'totalClassTypes' => $totalClassTypes,
            'totalSchedules' => $totalSchedules,
            'totalProducts' => $totalProducts,
            'totalIncome' => $totalIncome,
            'thisMonthIncome' => $thisMonthIncome,
            'memberRegistrationChart' => $memberRegistrationChart,
            'incomeChart' => $incomeChart,
            'attendanceChart' => $attendanceChart,
            'popularClassesChart' => $popularClassesChart,
            'coachPerformanceChart' => $coachPerformanceChart,
        ]);
    }

    // Chart: Member Registration (12 Bulan)
    private function getMemberRegistrationChart()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            $count = Member::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    // Chart: Income (12 Bulan)
    private function getIncomeChart()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');

            $income = Transaction::where('status', 'completed')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('grand_total');
            $data[] = (int) $income;
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    // Chart: Attendance (7 Hari Terakhir)
    private function getAttendanceChart()
    {
        $days = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('D');

            $count = Presence::whereDate('created_at', $date->toDateString())->count();
            $data[] = $count;
        }

        return [
            'labels' => $days,
            'data' => $data,
        ];
    }

    // Chart: Kelas Populer (Top 5)
    private function getPopularClassesChart()
    {
        $classTypes = ClassType::withCount('schedules')
            ->orderBy('schedules_count', 'desc')
            ->limit(5)
            ->get();

        return [
            'labels' => $classTypes->pluck('name')->toArray(),
            'data' => $classTypes->pluck('schedules_count')->toArray(),
        ];
    }

    // Chart: Coach Performance (Kehadiran Member di Kelas Coach)
    private function getCoachPerformanceChart()
    {
        $coaches = Coach::withCount(['schedules' => function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month);
        }])->orderBy('schedules_count', 'desc')->limit(5)->get();

        return [
            'labels' => $coaches->pluck('name')->toArray(),
            'data' => $coaches->pluck('schedules_count')->toArray(),
        ];
    }
}
