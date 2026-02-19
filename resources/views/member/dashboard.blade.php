<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Gintung Master Fitness</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/feather.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

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
            --success:     #22c55e;
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
                radial-gradient(ellipse 80% 50% at 70% -5%,  rgba(245,158,11,0.09) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at -5% 85%,  rgba(99,102,241,0.06) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* ══════════════════════════
           TOP NAV
        ══════════════════════════ */
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

        /* ══════════════════════════
           PAGE
        ══════════════════════════ */
        .page-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.25rem 4rem;
        }

        /* ── Greeting ── */
        .greeting {
            margin-bottom: 2rem;
            animation: fadeUp 0.4s ease both;
        }
        .greeting-sub { color: var(--text-muted); font-size: 0.875rem; margin-bottom: 4px; }
        .greeting h1 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.9rem;
            color: #fff;
            line-height: 1.2;
        }
        .greeting h1 .accent { color: var(--accent); }

        /* ── Two-col layout ── */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 1.25rem;
            align-items: start;
        }

        /* ══════════════════════════
           MEMBER CARD
        ══════════════════════════ */
        .member-card-wrap {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            animation: fadeUp 0.4s 0.05s ease both;
        }

        .card-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 18px 0;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        /* The actual dark ID card */
        .id-card {
            margin: 12px;
            background: linear-gradient(135deg, #1e293b 0%, #0f1f38 100%);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        .id-card::before,
        .id-card::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .id-card::before {
            width: 180px;
            height: 180px;
            background: rgba(245,158,11,0.06);
            top: -60px;
            right: -60px;
        }
        .id-card::after {
            width: 100px;
            height: 100px;
            background: rgba(99,102,241,0.06);
            bottom: -30px;
            left: -30px;
        }

        .id-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .id-name {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            color: #fff;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .id-member-id {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
            font-family: 'Courier New', monospace;
            letter-spacing: 0.04em;
        }

        .id-dates {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.25rem;
        }
        .id-date-item { line-height: 1.3; }
        .id-date-label { font-size: 0.7rem; color: rgba(255,255,255,0.4); margin-bottom: 2px; }
        .id-date-value { font-weight: 600; font-size: 0.85rem; color: #fff; }
        .id-date-value.warn { color: var(--accent); }

        /* QR box */
        .qr-box {
            background: #fff;
            padding: 6px;
            border-radius: 10px;
            flex-shrink: 0;
        }
        .qr-box img { display: block; border-radius: 6px; }

        .id-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .id-hint {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.35);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .id-hint i { font-size: 11px; }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        /* ── Menu Kelas ── */
        .menu-section {
            padding: 14px 18px 18px;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-section-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .menu-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .menu-btn .menu-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            transition: transform 0.2s;
        }

        .menu-btn:hover .menu-icon { transform: scale(1.1); }

        .menu-btn-primary {
            background: linear-gradient(135deg, var(--accent), #fb923c);
            color: #0f172a;
        }
        .menu-btn-primary:hover { opacity: 0.9; transform: translateY(-1px); color: #0f172a; box-shadow: 0 6px 20px rgba(245,158,11,0.3); }
        .menu-btn-primary .menu-icon { background: rgba(0,0,0,0.15); color: #0f172a; }

        .menu-btn-secondary {
            background: rgba(255,255,255,0.04);
            color: #e2e8f0;
            border-color: var(--border);
        }
        .menu-btn-secondary:hover { background: var(--dark-hover); border-color: rgba(255,255,255,0.12); color: #fff; }
        .menu-btn-secondary .menu-icon { background: rgba(255,255,255,0.07); color: var(--text-muted); }

        .menu-btn-text { flex: 1; }
        .menu-btn-text span { display: block; font-size: 0.75rem; font-weight: 400; opacity: 0.65; margin-top: 1px; }

        .menu-btn-arrow { font-size: 13px; opacity: 0.5; }

        /* ══════════════════════════
           VISIT HISTORY
        ══════════════════════════ */
        .history-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            animation: fadeUp 0.4s 0.10s ease both;
        }

        .history-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
        }

        .history-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .visit-count {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .visit-dot {
            width: 6px;
            height: 6px;
            background: var(--success);
            border-radius: 50%;
            box-shadow: 0 0 6px var(--success);
        }

        .history-list { padding: 8px; }

        .visit-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 12px;
            border-radius: 10px;
            transition: background 0.15s;
            animation: slideIn 0.3s ease both;
        }
        .visit-item:hover { background: rgba(255,255,255,0.04); }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .visit-item:nth-child(1) { animation-delay: 0.10s; }
        .visit-item:nth-child(2) { animation-delay: 0.14s; }
        .visit-item:nth-child(3) { animation-delay: 0.18s; }
        .visit-item:nth-child(4) { animation-delay: 0.22s; }
        .visit-item:nth-child(5) { animation-delay: 0.26s; }

        .visit-icon-wrap {
            width: 38px;
            height: 38px;
            background: rgba(34,197,94,0.10);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--success);
            font-size: 14px;
            flex-shrink: 0;
        }

        .visit-info { flex: 1; min-width: 0; }
        .visit-date {
            font-weight: 600;
            font-size: 0.875rem;
            color: #fff;
            margin-bottom: 2px;
        }
        .visit-time {
            font-size: 0.775rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .visit-time i { font-size: 10px; color: var(--accent); }

        .visit-badge {
            background: rgba(34,197,94,0.10);
            color: var(--success);
            border: 1px solid rgba(34,197,94,0.18);
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Divider between visit items */
        .visit-item + .visit-item {
            border-top: 1px solid var(--border);
            border-radius: 0;
            padding-top: 12px;
            margin-top: 0;
        }
        .visit-item + .visit-item { border-radius: 10px; }

        .empty-visits {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        .empty-visits i { font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.4; }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .dashboard-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 580px) {
            .greeting h1 { font-size: 1.5rem; }
            .id-dates { gap: 1rem; }
        }
    </style>
</head>
<body>

{{-- ══ NAV ══ --}}
<nav class="top-nav">
    <div class="nav-inner">
        <a href="{{ route('member.dashboard') }}" class="nav-logo">
            ⚡ <span class="a">GMF</span> MEMBER
        </a>

        <button class="hamburger" id="hmb" type="button" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-dropdown" id="navDrop">
            <a href="{{ route('member.dashboard') }}" class="dd-link active"><i class="feather-home"></i> Dashboard</a>
            <a href="{{ route('booking.index') }}"    class="dd-link"><i class="feather-calendar"></i> Booking Kelas</a>
            <a href="{{ route('booking.history') }}"  class="dd-link"><i class="feather-list"></i> Kelas Saya</a>
            <div class="dd-divider"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dd-logout" type="submit"><i class="feather-log-out"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>

{{-- ══ PAGE ══ --}}
<div class="page-wrapper">

    {{-- Greeting --}}
    <div class="greeting">
        <div class="greeting-sub">Selamat datang kembali 👋</div>
        <h1>Halo, <span class="accent">{{ $user->name }}</span></h1>
    </div>

    <div class="dashboard-grid">

        {{-- ── LEFT: Member Card + Menu ── --}}
        <div>
            <div class="member-card-wrap">

                {{-- Label --}}
                <div class="card-section-title">
                    <i class="feather-credit-card" style="font-size:13px;"></i>
                    Kartu Member Anda
                </div>

                {{-- ID Card --}}
                <div class="id-card">
                    <div class="id-top">
                        <div>
                            <div class="id-name">{{ $user->name }}</div>
                            <div class="id-member-id">ID: {{ $member->id }}</div>
                            <div class="id-dates">
                                <div class="id-date-item">
                                    <div class="id-date-label">Bergabung</div>
                                    <div class="id-date-value">{{ \Carbon\Carbon::parse($member->join_date)->format('d M Y') }}</div>
                                </div>
                                <div class="id-date-item">
                                    <div class="id-date-label">Masa Aktif</div>
                                    <div class="id-date-value warn">{{ \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="qr-box">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $member->id }}" width="90" alt="QR">
                        </div>
                    </div>

                    <div class="id-footer">
                        <div class="id-hint">
                            <i class="feather-info"></i>
                            Tunjukkan ke Admin / Scanner
                        </div>
                        <span class="status-badge {{ $statusBadge }}">{{ $statusText }}</span>
                    </div>
                </div>

                {{-- Menu --}}
                <div class="menu-section">
                    <div class="menu-section-title">Menu Kelas</div>

                    <a href="{{ route('booking.index') }}" class="menu-btn menu-btn-primary">
                        <div class="menu-icon"><i class="feather-calendar"></i></div>
                        <div class="menu-btn-text">
                            Booking Kelas
                            <span>Daftar jadwal latihan baru</span>
                        </div>
                        <i class="feather-arrow-right menu-btn-arrow"></i>
                    </a>

                    <a href="{{ route('booking.history') }}" class="menu-btn menu-btn-secondary">
                        <div class="menu-icon"><i class="feather-list"></i></div>
                        <div class="menu-btn-text">
                            Kelas Saya
                            <span>Lihat semua booking Anda</span>
                        </div>
                        <i class="feather-arrow-right menu-btn-arrow"></i>
                    </a>
                </div>

            </div>
        </div>

        {{-- ── RIGHT: Visit History ── --}}
        <div class="history-card">
            <div class="history-header">
                <div class="history-title">
                    <i class="feather-activity" style="margin-right:6px;font-size:13px;"></i>
                    Riwayat Kunjungan
                </div>
                <div class="visit-count">
                    <div class="visit-dot"></div>
                    {{ $recentPresences->count() }} kunjungan
                </div>
            </div>

            <div class="history-list">
                @forelse($recentPresences as $presence)
                <div class="visit-item">
                    <div class="visit-icon-wrap">
                        <i class="feather-check"></i>
                    </div>
                    <div class="visit-info">
                        <div class="visit-date">
                            {{ \Carbon\Carbon::parse($presence->created_at)->translatedFormat('d F Y') }}
                        </div>
                        <div class="visit-time">
                            <i class="feather-clock"></i>
                            {{ \Carbon\Carbon::parse($presence->created_at)->format('H:i') }} WIB
                        </div>
                    </div>
                    <div class="visit-badge">Hadir</div>
                </div>
                @empty
                <div class="empty-visits">
                    <i class="feather-calendar"></i>
                    Belum ada data kunjungan latihan.
                </div>
                @endforelse
            </div>
        </div>

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