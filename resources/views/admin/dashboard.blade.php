@extends('layouts.admin')

@section('content')
<div class="nxl-content">
    <!-- Main Content -->
    <div class="main-content">
        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Members Card -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Member</span>
                                <h4 class="m-0">{{ number_format($totalMembers) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-info">
                                <i class="feather-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">+{{ $newMembersThisMonth }} bulan ini</small>
                    </div>
                </div>
            </div>

            <!-- Active Members This Week -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Aktif Minggu Ini</span>
                                <h4 class="m-0">{{ number_format($activeMembersThisWeek) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-success">
                                <i class="feather-activity"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">Member aktif</small>
                    </div>
                </div>
            </div>

            <!-- Member PT Aktif -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full" style="border-top: 3px solid #a855f7;">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Member PT Aktif</span>
                                <h4 class="m-0">{{ $ptData['totalPtActive'] }}</h4>
                            </div>
                            <div class="badge badge-lg" style="background:#a855f7;color:#fff;">
                                <i class="feather-user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">{{ $ptData['totalPtPending'] }} menunggu konfirmasi</small>
                    </div>
                </div>
            </div>

            <!-- Total Coaches -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Coach</span>
                                <h4 class="m-0">{{ number_format($totalCoaches) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-warning">
                                <i class="feather-award"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">{{ $activeCoachesThisMonth }} aktif bulan ini</small>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Kelas</span>
                                <h4 class="m-0">{{ number_format($totalSchedules) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-danger">
                                <i class="feather-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">{{ $totalClassTypes }} tipe kelas</small>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Produk</span>
                                <h4 class="m-0">{{ number_format($totalProducts) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-primary">
                                <i class="feather-shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">Produk terdaftar</small>
                    </div>
                </div>
            </div>

            <!-- Total Income (termasuk PT) -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Income</span>
                                <h4 class="m-0">Rp{{ number_format($totalIncome + $ptData['totalPtIncome'], 0, ',', '.') }}</h4>
                            </div>
                            <div class="badge badge-lg bg-success">
                                <i class="feather-trending-up"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-dark d-block">Bulan ini: <strong>Rp{{ number_format($thisMonthIncome + $ptData['thisMonthPtIncome'], 0, ',', '.') }}</strong></small>
                        <small class="text-dark">PT: <strong>Rp{{ number_format($ptData['thisMonthPtIncome'], 0, ',', '.') }}</strong></small>
                    </div>
                </div>
            </div>
        </div>




        <style>
            .apex-card {
                background: #fff;
                border-radius: 14px;
                border: 1px solid #e8ecf0;
                padding: 1.25rem 1.4rem 0.75rem;
                position: relative;
                overflow: hidden;
                transition: box-shadow 0.25s, border-color 0.25s;
            }
            .apex-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 3px;
                background: var(--ac, linear-gradient(90deg,#3b82f6,#06b6d4));
                border-radius: 14px 14px 0 0;
            }
            .apex-card:hover {
                box-shadow: 0 8px 32px rgba(0,0,0,0.10);
                border-color: #c8d0da;
            }
            .apex-card.ac-purple { --ac: linear-gradient(90deg,#6366f1,#a855f7); }
            .apex-card.ac-blue   { --ac: linear-gradient(90deg,#3b82f6,#6366f1); }
            .apex-card.ac-green  { --ac: linear-gradient(90deg,#10b981,#06b6d4); }
            .apex-card.ac-rose   { --ac: linear-gradient(90deg,#ef4444,#f97316); }
            .apex-card.ac-amber  { --ac: linear-gradient(90deg,#f59e0b,#f97316); }
            .apex-card.ac-cyan   { --ac: linear-gradient(90deg,#06b6d4,#3b82f6); }
            .apex-card-title { font-weight: 700; font-size: 0.95rem; color: #1e293b; line-height: 1.3; }
            .apex-card-sub   { font-size: 0.72rem; color: #94a3b8; margin-top: 2px; }
            .apex-badge {
                font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
                letter-spacing: 0.06em; color: #94a3b8;
                background: #f1f5f9; border: 1px solid #e2e8f0;
                border-radius: 6px; padding: 3px 8px;
            }
            .apex-legend { display:flex; gap:.85rem; flex-wrap:wrap; margin: 4px 0 2px; }
            .apex-legend-item { display:flex; align-items:center; gap:5px; font-size:0.72rem; color:#64748b; }
            .apex-legend-dot  { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
            .chart-row-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:1.1rem; }
            @media(max-width:1100px){ .chart-row-3{grid-template-columns:1fr 1fr;} }
            @media(max-width:700px) { .chart-row-3{grid-template-columns:1fr;} }
        </style>

        <!-- ══ ROW 1: Revenue Breakdown full-width ══ -->
        <div class="mt-4">
            <div class="apex-card ac-purple">
                <div class="d-flex align-items-start justify-content-between mb-1">
                    <div>
                        <div class="apex-card-title">Revenue Breakdown</div>
                        <div class="apex-card-sub">Income per kategori — 12 bulan terakhir</div>
                    </div>
                    <span class="apex-badge">Stacked</span>
                </div>
                <div class="apex-legend">
                    <span class="apex-legend-item"><span class="apex-legend-dot" style="background:#6366f1"></span>Membership</span>
                    <span class="apex-legend-item"><span class="apex-legend-dot" style="background:#10b981"></span>Produk</span>
                    <span class="apex-legend-item"><span class="apex-legend-dot" style="background:#f59e0b"></span>Kelas</span>
                    <span class="apex-legend-item"><span class="apex-legend-dot" style="background:#a855f7"></span>PT Coach</span>
                </div>
                <div id="adm-chart-breakdown"></div>
            </div>
        </div>

        <!-- ══ ROW 2: Member Trend + Attendance ══ -->
        <div class="row mt-3 g-3">
            <div class="col-xl-6 col-12">
                <div class="apex-card ac-blue" style="height:100%;">
                    <div class="d-flex align-items-start justify-content-between mb-1">
                        <div>
                            <div class="apex-card-title">Pendaftaran vs Aktif Member</div>
                            <div class="apex-card-sub">6 bulan terakhir</div>
                        </div>
                        <span class="apex-badge">Trend</span>
                    </div>
                    <div class="apex-legend">
                        <span class="apex-legend-item"><span class="apex-legend-dot" style="background:#3b82f6"></span>Daftar</span>
                        <span class="apex-legend-item"><span class="apex-legend-dot" style="background:#10b981"></span>Aktif</span>
                    </div>
                    <div id="adm-chart-member-trend"></div>
                </div>
            </div>
            <div class="col-xl-6 col-12">
                <div class="apex-card ac-green" style="height:100%;">
                    <div class="d-flex align-items-start justify-content-between mb-1">
                        <div>
                            <div class="apex-card-title">Kehadiran Harian</div>
                            <div class="apex-card-sub">7 hari terakhir</div>
                        </div>
                        <span class="apex-badge">Area</span>
                    </div>
                    <div id="adm-chart-attendance"></div>
                </div>
            </div>
        </div>

        <!-- ══ ROW 3: Kelas Populer (kiri) + Coach & Income atas-bawah (kanan) ══ -->
        <div class="row mt-3 g-3">
            <!-- Kelas Populer - kiri -->
            <div class="col-xl-4 col-12">
                <div class="apex-card ac-rose" style="height:100%;">
                    <div class="d-flex align-items-start justify-content-between mb-1">
                        <div>
                            <div class="apex-card-title">Kelas Populer</div>
                            <div class="apex-card-sub">Top 5 berdasarkan jadwal</div>
                        </div>
                        <span class="apex-badge">Donut</span>
                    </div>
                    <div id="adm-chart-popular"></div>
                </div>
            </div>
            <!-- Coach Performance + Income atas-bawah - kanan -->
            <div class="col-xl-8 col-12 d-flex flex-column gap-3">
                <div class="apex-card ac-amber">
                    <div class="d-flex align-items-start justify-content-between mb-1">
                        <div>
                            <div class="apex-card-title">Performa Coach</div>
                            <div class="apex-card-sub">Top 5 — bulan ini</div>
                        </div>
                        <span class="apex-badge">Bar</span>
                    </div>
                    <div id="adm-chart-coach"></div>
                </div>
                <div class="apex-card ac-cyan">
                    <div class="d-flex align-items-start justify-content-between mb-1">
                        <div>
                            <div class="apex-card-title">Total Income Bulanan</div>
                            <div class="apex-card-sub">12 bulan terakhir</div>
                        </div>
                        <span class="apex-badge">Bar</span>
                    </div>
                    <div id="adm-chart-income"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>
<script>
const D = {
    breakdown: {
        labels:     {!! json_encode($incomeBreakdownChart['labels']) !!},
        membership: {!! json_encode($incomeBreakdownChart['membership']) !!},
        product:    {!! json_encode($incomeBreakdownChart['product']) !!},
        kelas:      {!! json_encode($incomeBreakdownChart['kelas']) !!},
        pt:         {!! json_encode($incomeBreakdownChart['pt']) !!},
    },
    trend: {
        labels:     {!! json_encode($memberActiveTrendChart['labels']) !!},
        registered: {!! json_encode($memberActiveTrendChart['registered']) !!},
        active:     {!! json_encode($memberActiveTrendChart['active']) !!},
    },
    attendance: {
        labels: {!! json_encode($attendanceChart['labels']) !!},
        data:   {!! json_encode($attendanceChart['data']) !!},
    },
    popular: {
        labels: {!! json_encode($popularClassesChart['labels']) !!},
        data:   {!! json_encode($popularClassesChart['data']) !!},
    },
    coach: {
        labels: {!! json_encode($coachPerformanceChart['labels']) !!},
        data:   {!! json_encode($coachPerformanceChart['data']) !!},
    },
    income: {
        labels: {!! json_encode($incomeChart['labels']) !!},
        data:   {!! json_encode($incomeChart['data']) !!},
    },
};

const C = { blue:'#3b82f6', indigo:'#6366f1', green:'#10b981', amber:'#f59e0b',
            rose:'#ef4444', cyan:'#06b6d4', purple:'#a855f7', text:'#64748b', grid:'rgba(0,0,0,0.05)' };

const base = {
    chart: { background:'transparent', fontFamily:"'Plus Jakarta Sans','DM Sans',sans-serif",
             foreColor: C.text, toolbar:{ show:false }, animations:{ enabled:true, easing:'easeinout', speed:550 } },
    grid:  { borderColor: C.grid, strokeDashArray: 4 },
    tooltip: { theme:'light', style:{ fontSize:'12px' } },
};

function fmtRp(v){
    if(v>=1e9) return 'Rp '+(v/1e9).toFixed(1)+' M';
    if(v>=1e6) return 'Rp '+(v/1e6).toFixed(1)+' Jt';
    if(v>=1e3) return 'Rp '+(v/1e3).toFixed(0)+' Rb';
    return 'Rp '+Math.round(v);
}
const fmtFull = v => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v);

// 1. Revenue Breakdown (Stacked) - termasuk PT
new ApexCharts(document.getElementById('adm-chart-breakdown'), {
    ...base,
    chart: { ...base.chart, type:'bar', height:290, stacked:true },
    series: [
        { name:'Membership', data: D.breakdown.membership, color: C.indigo },
        { name:'Produk',     data: D.breakdown.product,    color: C.green  },
        { name:'Kelas',      data: D.breakdown.kelas,      color: C.amber  },
        { name:'PT Coach',   data: D.breakdown.pt,         color: C.purple },
    ],
    xaxis: { categories: D.breakdown.labels, axisBorder:{show:false}, axisTicks:{show:false} },
    yaxis: { labels:{ formatter: fmtRp } },
    plotOptions: { bar:{ borderRadius:4, columnWidth:'55%' } },
    legend:  { show:false },
    fill:    { opacity:1 },
    dataLabels: { enabled:false },
    tooltip: { ...base.tooltip, y:{ formatter: fmtFull } },
}).render();

// 2. Member Trend (Dual Area)
new ApexCharts(document.getElementById('adm-chart-member-trend'), {
    ...base,
    chart: { ...base.chart, type:'area', height:260 },
    series: [
        { name:'Daftar', data: D.trend.registered, color: C.blue  },
        { name:'Aktif',  data: D.trend.active,     color: C.green },
    ],
    xaxis: { categories: D.trend.labels, axisBorder:{show:false}, axisTicks:{show:false} },
    yaxis: { labels:{ formatter: v => Math.round(v) }, tickAmount:4 },
    stroke: { curve:'smooth', width:3 },
    fill:   { type:'gradient', gradient:{ shadeIntensity:1, opacityFrom:0.25, opacityTo:0.02, stops:[0,100] } },
    markers:{ size:4, strokeWidth:2, strokeColors:'#fff' },
    dataLabels: { enabled:false },
    legend: { show:false },
}).render();

// 3. Attendance (Area + Peak annotation)
new ApexCharts(document.getElementById('adm-chart-attendance'), {
    ...base,
    chart: { ...base.chart, type:'area', height:260 },
    series: [{ name:'Kehadiran', data: D.attendance.data, color: C.green }],
    xaxis: { categories: D.attendance.labels, axisBorder:{show:false}, axisTicks:{show:false} },
    yaxis: { labels:{ formatter: v => Math.round(v) }, tickAmount:4 },
    stroke: { curve:'smooth', width:3 },
    fill:   { type:'gradient', gradient:{ shadeIntensity:1, opacityFrom:0.30, opacityTo:0.02, stops:[0,100] } },
    markers:{ size:5, strokeWidth:2, strokeColors:'#fff', colors:[C.green] },
    dataLabels: { enabled:false },
    legend: { show:false },
    annotations: { yaxis:[{ y: Math.max(...D.attendance.data), borderColor: C.green, borderWidth:1, strokeDashArray:4,
        label:{ text:'Peak', style:{ color:'#fff', background: C.green, fontSize:'10px', fontWeight:700 } } }] },
}).render();

// 4. Kelas Populer (Donut)
new ApexCharts(document.getElementById('adm-chart-popular'), {
    ...base,
    chart: { ...base.chart, type:'donut', height:280 },
    series: D.popular.data,
    labels: D.popular.labels,
    colors: [C.rose, C.amber, C.blue, C.green, C.cyan],
    plotOptions: { pie:{ donut:{ size:'72%', labels:{ show:true,
        total:{ show:true, label:'Total', color: C.text, fontSize:'12px',
                formatter: w => w.globals.seriesTotals.reduce((a,b)=>a+b,0) }
    } } } },
    legend: { position:'bottom', fontSize:'11px', offsetY:4, markers:{width:7,height:7,radius:7} },
    dataLabels: { enabled:false },
    stroke: { width:0 },
    tooltip: { ...base.tooltip, y:{ formatter: v => v+' jadwal' } },
}).render();

// 5. Coach Performance (Horizontal Bar)
new ApexCharts(document.getElementById('adm-chart-coach'), {
    ...base,
    chart: { ...base.chart, type:'bar', height:200 },
    series: [{ name:'Kelas', data: D.coach.data }],
    xaxis: { categories: D.coach.labels, axisBorder:{show:false}, axisTicks:{show:false},
             labels:{ style:{ colors: C.text, fontSize:'11px' } } },
    yaxis: { show:false },
    plotOptions: { bar:{ borderRadius:6, horizontal:true, barHeight:'55%', distributed:true } },
    colors: [C.amber, C.rose, C.blue, C.green, C.purple],
    fill: { type:'gradient', gradient:{ shade:'light', type:'horizontal',
        gradientToColors:['#f97316','#f59e0b','#06b6d4','#22c55e','#c084fc'], stops:[0,100] } },
    dataLabels: { enabled:true, offsetX:6, style:{ fontSize:'10px', fontWeight:700, colors:['#1e293b'] },
                  formatter: v => v+' kls' },
    legend:  { show:false },
    tooltip: { ...base.tooltip, y:{ formatter: v => v+' kelas' } },
}).render();

// 6. Total Income Bulanan (Column) - termasuk PT
new ApexCharts(document.getElementById('adm-chart-income'), {
    ...base,
    chart: { ...base.chart, type:'bar', height:200 },
    series: [{ name:'Total Income', data: D.income.data }],
    xaxis: { categories: D.income.labels, axisBorder:{show:false}, axisTicks:{show:false} },
    yaxis: { labels:{ formatter: v => {
        if(v>=1e9) return 'Rp '+(v/1e9).toFixed(1)+' M';
        if(v>=1e6) return 'Rp '+(v/1e6).toFixed(1)+' Jt';
        if(v>=1e3) return 'Rp '+(v/1e3).toFixed(0)+' Rb';
        return 'Rp '+Math.round(v);
    } }, min:0 },
    plotOptions: { bar:{ borderRadius:5, columnWidth:'60%' } },
    fill: { type:'gradient', gradient:{ shade:'dark', type:'vertical',
        gradientToColors:[C.blue], colorStops:[[
            { offset:0, color: C.cyan, opacity:1 },
            { offset:100, color: C.blue, opacity:1 }
        ]] } },
    dataLabels: { enabled:false },
    legend:  { show:false },
    tooltip: { ...base.tooltip, y:{ formatter: fmtFull } },
}).render();
</script>
@endsection

