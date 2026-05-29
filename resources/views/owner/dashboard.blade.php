<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - GMF</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark:        #0f172a;
            --dark-card:   #1e293b;
            --dark-hover:  #253044;
            --accent:      #f59e0b;
            --accent-soft: rgba(245,158,11,0.12);
            --text-muted:  #94a3b8;
            --border:      rgba(255,255,255,0.07);
            --danger-soft: rgba(239,68,68,0.10);
            --danger:      #ef4444;
            --success:     #22c55e;
            --warning:     #f59e0b;
            --info:        #06b6d4;
            --primary:     #3b82f6;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--dark);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            color: #e2e8f0;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 50% at 70% -5%,  rgba(245,158,11,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at -5% 85%,  rgba(99,102,241,0.06) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* ══ NAV ══ */
        .top-nav {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(15,23,42,0.92);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            position: relative;
        }

        .nav-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 0.06em;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .nav-logo .a { color: var(--accent); }

        /* Owner pill */
        .owner-pill {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .owner-avatar {
            width: 34px;
            height: 34px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 0.8rem;
            color: var(--accent);
            flex-shrink: 0;
        }
        .owner-name-wrap { line-height: 1.2; display: none; }
        .owner-name-wrap .cname { font-weight: 600; font-size: 0.875rem; color: #fff; }
        .owner-name-wrap .crole { font-size: 0.72rem; color: var(--text-muted); }

        @media (min-width: 640px) { .owner-name-wrap { display: block; } }

        .btn-logout-nav {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(239,68,68,0.10);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.22);
            padding: 6px 13px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-logout-nav:hover { background: rgba(239,68,68,0.2); color: #fff; }

        /* ══ PAGE ══ */
        .page-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.25rem 4rem;
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .page-header h1 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 6px;
        }
        .page-header p { color: var(--text-muted); font-size: 0.95rem; }

        /* ══ STATS GRID ══ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: transform 0.25s, box-shadow 0.25s;
            animation: fadeUp 0.4s ease both;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 36px rgba(0,0,0,0.3);
            border-color: rgba(245,158,11,0.28);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-title {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .icon-blue { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
        .icon-green { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
        .icon-orange { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
        .icon-red { background: rgba(239, 68, 68, 0.15); color: #f87171; }
        .icon-purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            color: #fff;
            line-height: 1;
        }

        .stat-footer {
            font-size: 0.8rem;
            color: var(--text-muted);
            padding-top: 0.75rem;
            border-top: 1px solid var(--border);
        }
        
        .stat-footer strong {
            color: #fff;
            font-weight: 600;
        }

        /* ══ CHARTS SECTION ══ */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .charts-row-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1100px) {
            .charts-row-3 { grid-template-columns: 1fr 1fr; }
        }
        
        .chart-grid-custom {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1100px) {
            .chart-grid-custom { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .charts-row, .charts-row-3, .chart-grid-custom { grid-template-columns: 1fr; }
        }

        .chart-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.6rem 1.6rem 1rem;
            animation: fadeUp 0.5s ease both;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .chart-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--card-accent, linear-gradient(90deg, #3b82f6, #06b6d4));
            border-radius: 20px 20px 0 0;
        }

        .chart-card:hover {
            border-color: rgba(255,255,255,0.12);
            box-shadow: 0 16px 48px rgba(0,0,0,0.35);
        }

        .chart-card.accent-amber  { --card-accent: linear-gradient(90deg, #f59e0b, #f97316); }
        .chart-card.accent-blue   { --card-accent: linear-gradient(90deg, #3b82f6, #6366f1); }
        .chart-card.accent-green  { --card-accent: linear-gradient(90deg, #10b981, #06b6d4); }
        .chart-card.accent-purple { --card-accent: linear-gradient(90deg, #a855f7, #ec4899); }
        .chart-card.accent-rose   { --card-accent: linear-gradient(90deg, #ef4444, #f97316); }
        .chart-card.accent-cyan   { --card-accent: linear-gradient(90deg, #06b6d4, #3b82f6); }

        .chart-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 0.25rem;
            gap: 1rem;
        }

        .chart-title-wrap {}
        .chart-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: #f1f5f9;
            line-height: 1.3;
        }
        .chart-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 3px;
        }
        .chart-badge {
            flex-shrink: 0;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .chart-legend {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.74rem;
            color: var(--text-muted);
        }
        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        .chart-container {
            position: relative;
            min-height: 270px;
            width: 100%;
        }

        /* Apex chart override for dark */
        .apexcharts-tooltip {
            background: #1e293b !important;
            border: 1px solid rgba(255,255,255,0.10) !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4) !important;
            border-radius: 10px !important;
        }
        .apexcharts-tooltip-title {
            background: rgba(255,255,255,0.05) !important;
            border-bottom: 1px solid rgba(255,255,255,0.07) !important;
            color: #f1f5f9 !important;
            font-weight: 600 !important;
        }
        .apexcharts-tooltip-text { color: #cbd5e1 !important; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

    </style>
</head>
<body>

{{-- ══ NAV ══ --}}
<nav class="top-nav">
    <div class="nav-inner">
        <span class="nav-logo">
            <img src="{{ asset('template/assets/images/logo-abbr.png') }}" style="height:48px" alt="GMF">
            <span style="margin-left:8px;">OWNER</span>
        </span>

        <div class="owner-pill">
            <div class="owner-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="owner-name-wrap">
                <div class="cname">{{ Auth::user()->name }}</div>
                <div class="crole">Owner</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn-logout-nav" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ══ PAGE ══ --}}
<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Dashboard Overview</h1>
            <p>Pantau perkembangan dan performa Gym Fitness Anda.</p>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <!-- Total Members -->
        <div class="stat-card" style="animation-delay: 0.1s;">
            <div class="stat-card-header">
                <div class="stat-title">Total Member</div>
                <div class="stat-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalMembers) }}</div>
            <div class="stat-footer">
                <strong>+{{ $newMembersThisMonth }}</strong> Member baru bulan ini
            </div>
        </div>

        <!-- Active Members -->
        <div class="stat-card" style="animation-delay: 0.2s;">
            <div class="stat-card-header">
                <div class="stat-title">Member Aktif</div>
                <div class="stat-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($activeMembersThisWeek) }}</div>
            <div class="stat-footer">
                Hadir <strong>minggu ini</strong>
            </div>
        </div>

        <!-- Member PT Aktif -->
        <div class="stat-card" style="animation-delay: 0.25s;">
            <div class="stat-card-header">
                <div class="stat-title">Member Yang Menggunakan PT</div>
                <div class="stat-icon" style="background:rgba(168,85,247,0.15);color:#c084fc;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ $ptData['totalPtActive'] }}</div>
            <div class="stat-footer">
                <strong>{{ $ptData['totalPtPending'] }}</strong> Menunggu konfirmasi
            </div>
        </div>

        <!-- Total Coaches -->
        <div class="stat-card" style="animation-delay: 0.3s;">
            <div class="stat-card-header">
                <div class="stat-title">Total Coach</div>
                <div class="stat-icon icon-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalCoaches) }}</div>
            <div class="stat-footer">
                <strong>{{ $activeCoachesThisMonth }}</strong> Coach aktif bulan ini
            </div>
        </div>

        <!-- Total Classes -->
        <div class="stat-card" style="animation-delay: 0.4s;">
            <div class="stat-card-header">
                <div class="stat-title">Total Kelas</div>
                <div class="stat-icon icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalSchedules) }}</div>
            <div class="stat-footer">
                <strong>{{ $totalClassTypes }}</strong> Variasi tipe kelas
            </div>
        </div>
        
        <!-- Total Income (termasuk PT) -->
        <div class="stat-card" style="animation-delay: 0.5s;">
            <div class="stat-card-header">
                <div class="stat-title">Total Income</div>
                <div class="stat-icon icon-purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
            </div>
            <div class="stat-value" style="font-size: 1.5rem;">Rp{{ number_format($totalIncome + $ptData['totalPtIncome'], 0, ',', '.') }}</div>
            <div class="stat-footer" style="display:flex; flex-direction:column; gap:4px; font-size: 0.8rem;">
                <span>Bulan ini: <strong style="color:#fff;">Rp{{ number_format($thisMonthIncome + $ptData['thisMonthPtIncome'], 0, ',', '.') }}</strong></span>
                <span>PT: <strong style="color:#fff;">Rp{{ number_format($ptData['thisMonthPtIncome'], 0, ',', '.') }}</strong></span>
            </div>
        </div>
    </div>


    {{-- ══ CHARTS ROW 1: Income Overview (Full Width) ══ --}}
    <div class="charts-row" style="grid-template-columns: 1fr;" style="animation-delay:0.6s;">
        <div class="chart-card accent-purple" style="animation-delay:0.6s;">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-title">Revenue Breakdown</div>
                    <div class="chart-subtitle">Income per kategori – 12 bulan terakhir</div>
                </div>
                <span class="chart-badge">Stacked</span>
            </div>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-dot" style="background:#6366f1"></span>Membership</span>
                <span class="legend-item"><span class="legend-dot" style="background:#10b981"></span>Produk</span>
                <span class="legend-item"><span class="legend-dot" style="background:#f59e0b"></span>Kelas</span>
                <span class="legend-item"><span class="legend-dot" style="background:#a855f7"></span>PT Coach</span>
            </div>
            <div class="chart-container" id="chart-income-breakdown"></div>
        </div>
    </div>

    {{-- ══ CHARTS ROW 2: Member Registration + Attendance ══ --}}
    <div class="charts-row" style="animation-delay:0.7s;">
        <div class="chart-card accent-blue" style="animation-delay:0.7s;">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-title">Pendaftaran vs Aktif Member</div>
                    <div class="chart-subtitle">6 bulan terakhir</div>
                </div>
                <span class="chart-badge">Trend</span>
            </div>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-dot" style="background:#3b82f6"></span>Daftar</span>
                <span class="legend-item"><span class="legend-dot" style="background:#10b981"></span>Aktif</span>
            </div>
            <div class="chart-container" id="chart-member-trend"></div>
        </div>

        <div class="chart-card accent-green" style="animation-delay:0.8s;">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-title">Kehadiran Harian</div>
                    <div class="chart-subtitle">7 hari terakhir</div>
                </div>
                <span class="chart-badge">Area</span>
            </div>
            <div class="chart-container" id="chart-attendance"></div>
        </div>
    </div>

    {{-- ══ CHARTS ROW 3: Kelas Populer + Coach Performance + Income Total ══ --}}
    <div class="chart-grid-custom" style="animation-delay:0.9s;">
        <!-- Kelas Populer - kiri -->
        <div class="chart-card accent-rose" style="height: 100%;">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-title">Kelas Populer</div>
                    <div class="chart-subtitle">Top 5 berdasarkan jadwal</div>
                </div>
                <span class="chart-badge">Donut</span>
            </div>
            <div class="chart-container" id="chart-popular-classes"></div>
        </div>

        <!-- Coach Performance + Income atas-bawah - kanan -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="chart-card accent-amber">
                <div class="chart-header">
                    <div class="chart-title-wrap">
                        <div class="chart-title">Performa Coach</div>
                        <div class="chart-subtitle">Top 5 – bulan ini</div>
                    </div>
                    <span class="chart-badge">Bar</span>
                </div>
                <div class="chart-container" id="chart-coach-performance"></div>
            </div>

            <div class="chart-card accent-cyan">
                <div class="chart-header">
                    <div class="chart-title-wrap">
                        <div class="chart-title">Total Income Bulanan</div>
                        <div class="chart-subtitle">12 bulan terakhir</div>
                    </div>
                    <span class="chart-badge">Bar</span>
                </div>
                <div class="chart-container" id="chart-income-total"></div>
            </div>
        </div>
    </div>

</div>

{{-- ApexCharts CDN --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>

<script>
// ══ PHP DATA ══
const phpData = {
    incomeBreakdown: {
        labels:     {!! json_encode($incomeBreakdownChart['labels']) !!},
        membership: {!! json_encode($incomeBreakdownChart['membership']) !!},
        product:    {!! json_encode($incomeBreakdownChart['product']) !!},
        kelas:      {!! json_encode($incomeBreakdownChart['kelas']) !!},
        pt:         {!! json_encode($incomeBreakdownChart['pt']) !!},
    },
    memberTrend: {
        labels:     {!! json_encode($memberActiveTrendChart['labels']) !!},
        registered: {!! json_encode($memberActiveTrendChart['registered']) !!},
        active:     {!! json_encode($memberActiveTrendChart['active']) !!},
    },
    attendance: {
        labels: {!! json_encode($attendanceChart['labels']) !!},
        data:   {!! json_encode($attendanceChart['data']) !!},
    },
    popularClasses: {
        labels: {!! json_encode($popularClassesChart['labels']) !!},
        data:   {!! json_encode($popularClassesChart['data']) !!},
    },
    coachPerformance: {
        labels: {!! json_encode($coachPerformanceChart['labels']) !!},
        data:   {!! json_encode($coachPerformanceChart['data']) !!},
    },
    incomeTotal: {
        labels: {!! json_encode($incomeChart['labels']) !!},
        data:   {!! json_encode($incomeChart['data']) !!},
    },
};

// ══ THEME DEFAULTS ══
const C = {
    blue:   '#3b82f6', indigo: '#6366f1', green:  '#10b981',
    amber:  '#f59e0b', rose:   '#ef4444', cyan:   '#06b6d4',
    purple: '#a855f7', slate:  '#94a3b8', bg:     '#1e293b',
    grid:   'rgba(255,255,255,0.05)', text: '#94a3b8',
};

const baseOpts = {
    chart: { background: 'transparent', fontFamily: "'DM Sans', sans-serif", foreColor: C.text, toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 600 } },
    grid:  { borderColor: C.grid, strokeDashArray: 4 },
    tooltip: { theme: 'dark', style: { fontSize: '13px' } },
};

function fmtRp(v) {
    if (v >= 1e9) return 'Rp ' + (v/1e9).toFixed(1) + ' M';
    if (v >= 1e6) return 'Rp ' + (v/1e6).toFixed(1) + ' Jt';
    if (v >= 1e3) return 'Rp ' + (v/1e3).toFixed(0) + ' Rb';
    return 'Rp ' + v;
}

// ══════════════════════════════════
// 1. Revenue Breakdown (Stacked Bar)
// ══════════════════════════════════
new ApexCharts(document.getElementById('chart-income-breakdown'), {
    ...baseOpts,
    chart: { ...baseOpts.chart, type: 'bar', height: 300, stacked: true },
    series: [
        { name: 'Membership', data: phpData.incomeBreakdown.membership, color: C.indigo },
        { name: 'Produk',     data: phpData.incomeBreakdown.product,    color: C.green  },
        { name: 'Kelas',      data: phpData.incomeBreakdown.kelas,      color: C.amber  },
        { name: 'PT Coach',   data: phpData.incomeBreakdown.pt,         color: C.purple },
    ],
    xaxis: { categories: phpData.incomeBreakdown.labels, axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { labels: { formatter: fmtRp } },
    plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } },
    legend: { show: false },
    fill: { opacity: 1 },
    dataLabels: { enabled: false },
    tooltip: { ...baseOpts.tooltip, y: { formatter: v => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v) } },
}).render();

// ══════════════════════════════════
// 2. Member Trend (Dual Area)
// ══════════════════════════════════
new ApexCharts(document.getElementById('chart-member-trend'), {
    ...baseOpts,
    chart: { ...baseOpts.chart, type: 'area', height: 280 },
    series: [
        { name: 'Daftar', data: phpData.memberTrend.registered, color: C.blue   },
        { name: 'Aktif',  data: phpData.memberTrend.active,     color: C.green  },
    ],
    xaxis: { categories: phpData.memberTrend.labels, axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { labels: { formatter: v => Math.round(v) }, tickAmount: 4 },
    stroke: { curve: 'smooth', width: 3 },
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.02, stops: [0, 100] } },
    markers: { size: 4, strokeWidth: 2, strokeColors: C.bg },
    dataLabels: { enabled: false },
    legend: { show: false },
}).render();

// ══════════════════════════════════
// 3. Attendance (Area)
// ══════════════════════════════════
new ApexCharts(document.getElementById('chart-attendance'), {
    ...baseOpts,
    chart: { ...baseOpts.chart, type: 'area', height: 280 },
    series: [{ name: 'Kehadiran', data: phpData.attendance.data, color: C.green }],
    xaxis: { categories: phpData.attendance.labels, axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { labels: { formatter: v => Math.round(v) }, tickAmount: 4 },
    stroke: { curve: 'smooth', width: 3 },
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02, stops: [0, 100] } },
    markers: { size: 5, strokeWidth: 2, strokeColors: C.bg, colors: [C.green] },
    dataLabels: { enabled: false },
    legend: { show: false },
    annotations: {
        yaxis: [{ y: Math.max(...phpData.attendance.data), borderColor: C.green, borderWidth: 1, strokeDashArray: 4,
            label: { text: 'Peak', style: { color: '#fff', background: C.green, fontSize: '11px', fontWeight: 600 } } }]
    },
}).render();

// ══════════════════════════════════
// 4. Kelas Populer (Donut)
// ══════════════════════════════════
new ApexCharts(document.getElementById('chart-popular-classes'), {
    ...baseOpts,
    chart: { ...baseOpts.chart, type: 'donut', height: 280 },
    series: phpData.popularClasses.data,
    labels: phpData.popularClasses.labels,
    colors: [C.rose, C.amber, C.blue, C.green, C.cyan],
    plotOptions: { pie: { donut: { size: '72%', labels: { show: true,
        total: { show: true, label: 'Total Jadwal', color: C.text, fontSize: '12px',
            formatter: w => w.globals.seriesTotals.reduce((a,b) => a+b, 0) }
    } } } },
    legend: { position: 'bottom', fontSize: '12px', offsetY: 4, markers: { width: 8, height: 8, radius: 8 } },
    dataLabels: { enabled: false },
    stroke: { width: 0 },
    tooltip: { ...baseOpts.tooltip, y: { formatter: v => v + ' jadwal' } },
}).render();

// ══════════════════════════════════
// 5. Coach Performance (Horizontal Bar)
// ══════════════════════════════════
new ApexCharts(document.getElementById('chart-coach-performance'), {
    ...baseOpts,
    chart: { ...baseOpts.chart, type: 'bar', height: 280 },
    series: [{ name: 'Kelas', data: phpData.coachPerformance.data }],
    xaxis: { categories: phpData.coachPerformance.labels, axisBorder: { show: false }, axisTicks: { show: false },
        labels: { style: { colors: C.text, fontSize: '12px' } }
    },
    yaxis: { show: false },
    plotOptions: { bar: { borderRadius: 6, horizontal: true, barHeight: '55%', distributed: true } },
    colors: [C.amber, C.rose, C.blue, C.green, C.purple],
    fill: { type: 'gradient', gradient: { shade: 'dark', type: 'horizontal',
        gradientToColors: ['#f97316', '#f59e0b', '#06b6d4', '#22c55e', '#c084fc'], stops: [0, 100]
    } },
    dataLabels: { enabled: true, offsetX: 6, style: { fontSize: '11px', fontWeight: 700, colors: ['#fff'] }, formatter: v => v + ' kls' },
    legend: { show: false },
    tooltip: { ...baseOpts.tooltip, y: { formatter: v => v + ' kelas' } },
}).render();

// ══════════════════════════════════
// 6. Total Income Bulanan (Column)
// ══════════════════════════════════
new ApexCharts(document.getElementById('chart-income-total'), {
    ...baseOpts,
    chart: { ...baseOpts.chart, type: 'bar', height: 280 },
    series: [{ name: 'Income', data: phpData.incomeTotal.data }],
    xaxis: { categories: phpData.incomeTotal.labels, axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { labels: { formatter: v => {
        if (v >= 1e9) return 'Rp ' + (v/1e9).toFixed(1) + ' M';
        if (v >= 1e6) return 'Rp ' + (v/1e6).toFixed(1) + ' Jt';
        if (v >= 1e3) return 'Rp ' + (v/1e3).toFixed(0) + ' Rb';
        return 'Rp ' + Math.round(v);
    } }, min: 0 },
    plotOptions: { bar: { borderRadius: 5, columnWidth: '60%' } },
    fill: { type: 'gradient', gradient: { shade: 'dark', type: 'vertical',
        gradientToColors: [C.blue], colorStops: [[{ offset: 0, color: C.cyan, opacity: 1 }, { offset: 100, color: C.blue, opacity: 1 }]]
    } },
    dataLabels: { enabled: false },
    legend: { show: false },
    tooltip: { ...baseOpts.tooltip, y: { formatter: v => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v) } },
}).render();
</script>

</body>
</html>
