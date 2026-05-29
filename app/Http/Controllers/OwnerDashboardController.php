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
use App\Models\PtSubscription;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
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
        $totalIncome = Transaction::where('status', 'paid')->sum('grand_total');
        $thisMonthIncome = Transaction::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('grand_total');

        // Breakdown Income
        $incomeMembership = Transaction::where('status', 'paid')
            ->whereHas('items', function ($q) {
                $q->where('itemable_type', 'App\Models\MembershipPackage');
            })->sum('grand_total');

        $incomeProduct = Transaction::where('status', 'paid')
            ->whereHas('items', function ($q) {
                $q->where('itemable_type', 'App\Models\Product');
            })->sum('grand_total');

        $incomeClass = Transaction::where('status', 'paid')
            ->whereHas('items', function ($q) {
                $q->where('itemable_type', 'App\Models\ClassType');
            })->sum('grand_total');

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

        // 11. DATA UNTUK CHART - INCOME BREAKDOWN (TAMBAHAN BARU)
        $incomeBreakdownChart = $this->getIncomeBreakdownChart();

        // 12. DATA UNTUK CHART - MEMBER AKTIF TREND (TAMBAHAN BARU)
        $memberActiveTrendChart = $this->getMemberActiveTrendChart();

        // 13. DATA PERSONAL TRAINER
        $ptData = $this->getPtData();

        return view('owner.dashboard', [
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
            'incomeMembership' => $incomeMembership,
            'incomeProduct' => $incomeProduct,
            'incomeClass' => $incomeClass,
            'memberRegistrationChart' => $memberRegistrationChart,
            'incomeChart' => $incomeChart,
            'attendanceChart' => $attendanceChart,
            'popularClassesChart' => $popularClassesChart,
            'coachPerformanceChart' => $coachPerformanceChart,
            'incomeBreakdownChart' => $incomeBreakdownChart,
            'memberActiveTrendChart' => $memberActiveTrendChart,
            'ptData' => $ptData,
        ]);
    }

    // Realtime endpoint tidak digunakan (tabel PT ada di owner tidak ada, cukup stats)

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

    // Chart: Income (12 Bulan) - termasuk income PT
    private function getIncomeChart()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');

            $txIncome = Transaction::where('status', 'paid')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('grand_total');

            $ptIncome = PtSubscription::where('payment_status', 'paid')
                ->whereMonth('pt_subscriptions.updated_at', $month->month)
                ->whereYear('pt_subscriptions.updated_at', $month->year)
                ->join('pt_packages', 'pt_subscriptions.pt_package_id', '=', 'pt_packages.id')
                ->sum('pt_packages.price');

            $data[] = (int)($txIncome + $ptIncome);
        }

        return [
            'labels' => $months,
            'data'   => $data,
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

    // Chart: Income Breakdown per bulan (Membership vs Produk vs Kelas vs PT)
    private function getIncomeBreakdownChart()
    {
        $months = [];
        $membership = [];
        $product = [];
        $kelas = [];
        $pt = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');

            $membership[] = (int) Transaction::where('status', 'paid')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->whereHas('items', function ($q) {
                    $q->where('itemable_type', 'App\Models\MembershipPackage');
                })->sum('grand_total');

            $product[] = (int) Transaction::where('status', 'paid')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->whereHas('items', function ($q) {
                    $q->where('itemable_type', 'App\Models\Product');
                })->sum('grand_total');

            $kelas[] = (int) Transaction::where('status', 'paid')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->whereHas('items', function ($q) {
                    $q->where('itemable_type', 'App\Models\ClassType');
                })->sum('grand_total');

            $pt[] = (int) PtSubscription::where('payment_status', 'paid')
                ->whereMonth('pt_subscriptions.updated_at', $month->month)
                ->whereYear('pt_subscriptions.updated_at', $month->year)
                ->join('pt_packages', 'pt_subscriptions.pt_package_id', '=', 'pt_packages.id')
                ->sum('pt_packages.price');
        }

        return [
            'labels'     => $months,
            'membership' => $membership,
            'product'    => $product,
            'kelas'      => $kelas,
            'pt'         => $pt,
        ];
    }

    // Chart: Tren Member Terdaftar vs Member Aktif per bulan (6 bulan)
    private function getMemberActiveTrendChart()
    {
        $months = [];
        $registered = [];
        $active = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            $registered[] = Member::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            // Member aktif = yang hadir di bulan tersebut
            $active[] = Presence::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->distinct('member_id')
                ->count('member_id');
        }

        return [
            'labels'     => $months,
            'registered' => $registered,
            'active'     => $active,
        ];
    }

    // Data Personal Trainer untuk Dashboard
    private function getPtData()
    {
        // Jumlah langganan PT aktif saat ini
        $totalPtActive = PtSubscription::where('status', 'active')->count();

        // Jumlah langganan PT pending (menunggu konfirmasi)
        $totalPtPending = PtSubscription::where('status', 'pending')->count();

        // Total pendapatan dari PT (yang sudah dibayar)
        $totalPtIncome = PtSubscription::where('payment_status', 'paid')
            ->join('pt_packages', 'pt_subscriptions.pt_package_id', '=', 'pt_packages.id')
            ->sum('pt_packages.price');

        // Pendapatan PT bulan ini
        $thisMonthPtIncome = PtSubscription::where('payment_status', 'paid')
            ->whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->join('pt_packages', 'pt_subscriptions.pt_package_id', '=', 'pt_packages.id')
            ->sum('pt_packages.price');

        // Daftar PT member - tidak dipakai di owner dashboard

        return [
            'totalPtActive'      => $totalPtActive,
            'totalPtPending'     => $totalPtPending,
            'totalPtIncome'      => (float) $totalPtIncome,
            'thisMonthPtIncome'  => (float) $thisMonthPtIncome,
        ];
    }
}
