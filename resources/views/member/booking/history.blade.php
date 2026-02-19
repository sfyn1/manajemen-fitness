<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelas Saya - Gintung Master Fitness</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/feather.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark:         #0f172a;
            --dark-card:    #1e293b;
            --dark-hover:   #253044;
            --accent:       #f59e0b;
            --accent-soft:  rgba(245,158,11,0.12);
            --text-muted:   #94a3b8;
            --border:       rgba(255,255,255,0.07);
            --success:      #22c55e;
            --success-soft: rgba(34,197,94,0.10);
            --danger-soft:  rgba(239,68,68,0.10);
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
            max-width: 1200px;
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

        /* Hamburger */
        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 9px;
            cursor: pointer;
            padding: 9px 8px;
            transition: background 0.2s;
        }
        .hamburger:hover { background: rgba(255,255,255,0.10); }
        .hamburger span {
            display: block;
            height: 2px;
            background: #e2e8f0;
            border-radius: 2px;
            transition: transform 0.28s ease, opacity 0.2s;
            transform-origin: center;
        }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Dropdown */
        .nav-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 1.25rem;
            width: 210px;
            background: #1a2844;
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 14px;
            padding: 8px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.55);
            display: none;
            flex-direction: column;
            gap: 2px;
            animation: dropIn 0.2s ease;
        }
        .nav-dropdown.open { display: flex; }

        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }

        .dd-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 9px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
        }
        .dd-link:hover  { background: rgba(255,255,255,0.07); color: #fff; }
        .dd-link.active { background: var(--accent-soft); color: var(--accent); }
        .dd-link i { font-size: 15px; width: 18px; text-align: center; }

        .dd-divider { height: 1px; background: var(--border); margin: 4px 0; }

        .dd-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 9px;
            background: transparent;
            color: #f87171;
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
            font-family: 'DM Sans', sans-serif;
        }
        .dd-logout:hover { background: var(--danger-soft); }
        .dd-logout i { font-size: 15px; width: 18px; text-align: center; }

        /* ══ PAGE ══ */
        .page-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.25rem 4rem;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .page-header h1 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 4px;
        }

        .page-header p { color: var(--text-muted); font-size: 0.9rem; }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, var(--accent), #fb923c);
            color: #0f172a;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            white-space: nowrap;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-new:hover { opacity: 0.88; transform: scale(1.02); color: #0f172a; }

        /* ══ STATS — compact pill row ══ */
        .stats-strip {
            display: flex;
            gap: 10px;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .stat-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 7px 16px 7px 7px;
            transition: border-color 0.2s, background 0.2s;
        }
        .stat-pill:hover { border-color: rgba(245,158,11,0.25); background: var(--dark-hover); }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }
        .si-total  { background: rgba(255,255,255,0.07); color: #e2e8f0; }
        .si-active { background: var(--accent-soft);     color: var(--accent); }
        .si-done   { background: rgba(148,163,184,0.10); color: var(--text-muted); }

        .stat-text { line-height: 1.2; }
        .stat-num  {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            color: #fff;
        }
        .stat-lbl { font-size: 0.72rem; color: var(--text-muted); }
        .stat-pill.hl .stat-num { color: var(--accent); }

        /* ══ BOOKING LIST ══ */
        .booking-list { display: flex; flex-direction: column; gap: 10px; }

        .booking-item {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: border-color 0.2s, background 0.2s, transform 0.2s;
            animation: slideIn 0.35s ease both;
        }
        .booking-item:hover { border-color: rgba(245,158,11,0.22); background: var(--dark-hover); transform: translateX(2px); }
        .booking-item.finished { opacity: 0.6; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .booking-item:nth-child(1) { animation-delay: 0.04s; }
        .booking-item:nth-child(2) { animation-delay: 0.08s; }
        .booking-item:nth-child(3) { animation-delay: 0.12s; }
        .booking-item:nth-child(4) { animation-delay: 0.16s; }
        .booking-item:nth-child(5) { animation-delay: 0.20s; }

        .b-bar {
            width: 3px;
            min-height: 44px;
            align-self: stretch;
            border-radius: 4px;
            flex-shrink: 0;
        }
        .b-bar.act  { background: linear-gradient(180deg, var(--accent), #fb923c); }
        .b-bar.done { background: rgba(148,163,184,0.22); }

        .b-code {
            font-family: 'Courier New', monospace;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 4px 10px;
            border-radius: 6px;
            flex-shrink: 0;
            white-space: nowrap;
        }
        .b-code.act  { background: var(--accent-soft); color: var(--accent); border: 1px solid rgba(245,158,11,0.18); }
        .b-code.done { background: rgba(255,255,255,0.04); color: var(--text-muted); border: 1px solid var(--border); }

        .b-info { flex: 1; min-width: 0; }
        .b-class {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 4px;
        }
        .b-meta { display: flex; flex-wrap: wrap; gap: 10px; }
        .b-meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.775rem;
            color: var(--text-muted);
        }
        .b-meta-item i { font-size: 10px; color: var(--accent); }

        .b-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .badge-pill {
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.73rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .bp-active { background: var(--success-soft); color: var(--success); border: 1px solid rgba(34,197,94,0.18); }
        .bp-done   { background: rgba(255,255,255,0.05); color: var(--text-muted); border: 1px solid var(--border); }

        .btn-cancel {
            display: flex;
            align-items: center;
            gap: 4px;
            background: var(--danger-soft);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            padding: 5px 11px;
            border-radius: 7px;
            font-size: 0.775rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            white-space: nowrap;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-cancel:hover { background: rgba(239,68,68,0.22); color: #fff; }

        /* Empty */
        .empty-state { text-align: center; padding: 5rem 1.5rem; }
        .empty-icon  { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
        .empty-state h5 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 8px;
        }
        .empty-state p { color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem; }

        @media (max-width: 580px) {
            .page-header h1 { font-size: 1.6rem; }
            .b-code { display: none; }
            .b-right { flex-direction: column; align-items: flex-end; gap: 5px; }
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav class="top-nav">
    <div class="nav-inner">
        <a href="{{ route('member.dashboard') }}" class="nav-logo">
            ⚡ <span class="a">GMF</span> MEMBER
        </a>

        <button class="hamburger" id="hmb" type="button" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-dropdown" id="navDrop">
            <a href="{{ route('member.dashboard') }}" class="dd-link"><i class="feather-home"></i> Dashboard</a>
            <a href="{{ route('booking.index') }}"    class="dd-link"><i class="feather-calendar"></i> Booking Kelas</a>
            <a href="{{ route('booking.history') }}"  class="dd-link active"><i class="feather-list"></i> Kelas Saya</a>
            <div class="dd-divider"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dd-logout" type="submit"><i class="feather-log-out"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>

{{-- PAGE --}}
<div class="page-wrapper">

    <div class="page-header">
        <div>
            <h1>Kelas Saya</h1>
            <p>Semua booking kelas latihan Anda.</p>
        </div>
        <a href="{{ route('booking.index') }}" class="btn-new">
            <i class="feather-plus"></i> Booking Kelas Baru
        </a>
    </div>

    {{-- Stats --}}
    @php
        $totalBookings  = $bookings->count();
        $activeBookings = $bookings->filter(fn($b) => !\Carbon\Carbon::parse($b->date)->isPast())->count();
        $doneBookings   = $totalBookings - $activeBookings;
    @endphp

    <div class="stats-strip">
        <div class="stat-pill">
            <div class="stat-icon si-total"><i class="feather-layers"></i></div>
            <div class="stat-text">
                <div class="stat-num">{{ $totalBookings }}</div>
                <div class="stat-lbl">Total Booking</div>
            </div>
        </div>
        <div class="stat-pill hl">
            <div class="stat-icon si-active"><i class="feather-calendar"></i></div>
            <div class="stat-text">
                <div class="stat-num">{{ $activeBookings }}</div>
                <div class="stat-lbl">Terjadwal</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-icon si-done"><i class="feather-check-circle"></i></div>
            <div class="stat-text">
                <div class="stat-num">{{ $doneBookings }}</div>
                <div class="stat-lbl">Selesai</div>
            </div>
        </div>
    </div>

    {{-- List --}}
    @if($bookings->isEmpty())
        <div class="empty-state">
            <span class="empty-icon">🏋️</span>
            <h5>Belum Ada Kelas</h5>
            <p>Anda belum memiliki jadwal latihan.<br>Yuk mulai booking kelas pertama!</p>
            <a href="{{ route('booking.index') }}" class="btn-new" style="display:inline-flex;">
                <i class="feather-plus"></i> Cari Kelas
            </a>
        </div>
    @else
        <div class="booking-list">
            @foreach($bookings as $booking)
            @php $isPast = \Carbon\Carbon::parse($booking->date)->isPast(); @endphp
            <div class="booking-item {{ $isPast ? 'finished' : '' }}">
                <div class="b-bar {{ $isPast ? 'done' : 'act' }}"></div>
                <div class="b-code {{ $isPast ? 'done' : 'act' }}">{{ $booking->booking_code }}</div>
                <div class="b-info">
                    <div class="b-class">{{ $booking->schedule->classType->name }}</div>
                    <div class="b-meta">
                        <div class="b-meta-item"><i class="feather-user"></i> Coach {{ $booking->schedule->coach->name }}</div>
                        <div class="b-meta-item"><i class="feather-calendar"></i> {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('l, d F Y') }}</div>
                        <div class="b-meta-item"><i class="feather-clock"></i> {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} WIB</div>
                    </div>
                </div>
                <div class="b-right">
                    @if($isPast)
                        <span class="badge-pill bp-done">Selesai</span>
                    @else
                        <span class="badge-pill bp-active">Terjadwal</span>
                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin membatalkan booking ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-cancel"><i class="feather-x"></i> Batal</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

<script>
    const hmb  = document.getElementById('hmb');
    const drop = document.getElementById('navDrop');
    hmb.addEventListener('click', e => {
        e.stopPropagation();
        hmb.classList.toggle('open');
        drop.classList.toggle('open');
    });
    document.addEventListener('click', () => {
        hmb.classList.remove('open');
        drop.classList.remove('open');
    });
    drop.addEventListener('click', e => e.stopPropagation());
</script>

</body>
</html>