<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Kelas - Gintung Master Fitness</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/feather.min.css') }}">
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

        .page-header { margin-bottom: 2rem; }
        .page-header h1 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 4px;
        }
        .page-header p { color: var(--text-muted); font-size: 0.9rem; }

        /* Alerts */
        .alert-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }
        .alert-ok  { background: rgba(34,197,94,0.10);  border: 1px solid rgba(34,197,94,0.22);  color: #86efac; }
        .alert-err { background: rgba(239,68,68,0.10);  border: 1px solid rgba(239,68,68,0.22);  color: #fca5a5; }

        /* ══ GRID ══ */
        .classes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 1.1rem;
        }

        .class-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
            animation: fadeUp 0.4s ease both;
        }
        .class-card:hover {
            transform: translateY(-4px);
            border-color: rgba(245,158,11,0.28);
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .class-card:nth-child(1) { animation-delay: 0.04s; }
        .class-card:nth-child(2) { animation-delay: 0.08s; }
        .class-card:nth-child(3) { animation-delay: 0.12s; }
        .class-card:nth-child(4) { animation-delay: 0.16s; }
        .class-card:nth-child(5) { animation-delay: 0.20s; }
        .class-card:nth-child(6) { animation-delay: 0.24s; }

        .card-stripe {
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #fb923c);
        }

        .card-body-inner {
            padding: 1.35rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .date-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--accent-soft);
            color: var(--accent);
            border: 1px solid rgba(245,158,11,0.18);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.76rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 0.01em;
        }
        .date-badge i { font-size: 10px; }

        .class-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 4px;
        }

        .coach-row {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 1.1rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .coach-row i { color: var(--accent); font-size: 12px; }

        .time-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            background: rgba(255,255,255,0.04);
            border-radius: 10px;
            margin-bottom: 1.1rem;
        }
        .time-icon {
            width: 32px;
            height: 32px;
            background: var(--accent-soft);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 13px;
            flex-shrink: 0;
        }
        .time-label { font-size: 0.72rem; color: var(--text-muted); display: block; }
        .time-value { font-weight: 600; color: #fff; font-size: 0.875rem; }

        .btn-book {
            background: linear-gradient(135deg, var(--accent), #fb923c);
            color: #0f172a;
            border: none;
            padding: 11px;
            border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            width: 100%;
            margin-top: auto;
            transition: opacity 0.2s, transform 0.15s;
            letter-spacing: 0.01em;
        }
        .btn-book:hover { opacity: 0.88; transform: scale(1.01); }

        .btn-booked {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: rgba(255,255,255,0.05);
            color: var(--text-muted);
            border: 1px solid var(--border);
            padding: 11px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: not-allowed;
            width: 100%;
            margin-top: auto;
        }

        /* Empty */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            grid-column: 1 / -1;
        }
        .empty-icon { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
        .empty-state h5 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 8px;
        }
        .empty-state p { color: var(--text-muted); font-size: 0.9rem; }

        @media (max-width: 580px) {
            .page-header h1 { font-size: 1.6rem; }
            .classes-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('booking.index') }}"    class="dd-link active"><i class="feather-calendar"></i> Booking Kelas</a>
            <a href="{{ route('booking.history') }}"  class="dd-link"><i class="feather-list"></i> Kelas Saya</a>
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
        <h1>Jadwal Kelas</h1>
        <p>Pilih dan booking kelas untuk latihan minggu ini.</p>
    </div>

    @if(session('success'))
        <div class="alert-custom alert-ok"><i class="feather-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-custom alert-err"><i class="feather-alert-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="classes-grid">
        @forelse($upcomingClasses as $class)
        <div class="class-card">
            <div class="card-stripe"></div>
            <div class="card-body-inner">

                <div class="date-badge">
                    <i class="feather-calendar"></i>
                    {{ $class['real_date']->translatedFormat('l, d F Y') }}
                </div>

                <div class="class-name">{{ $class['class_name'] }}</div>

                <div class="coach-row">
                    <i class="feather-user"></i> Coach {{ $class['coach_name'] }}
                </div>

                <div class="time-row">
                    <div class="time-icon"><i class="feather-clock"></i></div>
                    <div>
                        <span class="time-label">Waktu Latihan</span>
                        <span class="time-value">{{ $class['time'] }} WIB</span>
                    </div>
                </div>

                @if($class['is_booked'])
                    <div class="btn-booked"><i class="feather-check-circle"></i> Sudah Terdaftar</div>
                @else
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $class['schedule_id'] }}">
                        <input type="hidden" name="date" value="{{ $class['real_date']->format('Y-m-d') }}">
                        <button type="submit" class="btn-book">Booking Sekarang</button>
                    </form>
                @endif

            </div>
        </div>
        @empty
        <div class="empty-state">
            <span class="empty-icon">📅</span>
            <h5>Tidak Ada Jadwal</h5>
            <p>Belum ada jadwal kelas yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>

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