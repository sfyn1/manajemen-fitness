<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Member') - Gintung Master Fitness</title>
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

        /* Bootstrap overrides for dark theme */
        .card { background-color: var(--dark-card); border: 1px solid var(--border); color: #e2e8f0; }
        .card-header { background-color: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border); color: #e2e8f0; }
        .card-footer { background-color: rgba(255,255,255,0.03); border-top: 1px solid var(--border); }
        .table { --bs-table-color: #e2e8f0; --bs-table-bg: transparent; --bs-table-border-color: rgba(255,255,255,0.07); }
        .table-light { --bs-table-bg: rgba(255,255,255,0.04); --bs-table-color: #94a3b8; }
        .table-hover>tbody>tr:hover>* { background-color: rgba(255,255,255,0.04); color: #e2e8f0; }
        .form-control, .form-select {
            background-color: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1);
            color: #e2e8f0; font-family: 'DM Sans', sans-serif;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255,255,255,0.09); border-color: var(--accent);
            color: #fff; box-shadow: 0 0 0 0.25rem rgba(245,158,11,0.15);
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }
        .form-select option { background-color: #1e293b; color: #e2e8f0; }
        .modal-content { background-color: #1a2844; border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0; }
        .modal-header { border-bottom-color: rgba(255,255,255,0.07); }
        .modal-footer { border-top-color: rgba(255,255,255,0.07); }
        .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        .alert { border-radius: 12px; }
        .bg-light { background-color: rgba(255,255,255,0.06) !important; color: #e2e8f0 !important; }
        .text-muted { color: var(--text-muted) !important; }
        hr { border-color: rgba(255,255,255,0.07); }
        h1,h2,h3,h4,h5,h6 { color: #f1f5f9; }
        .progress { background-color: rgba(255,255,255,0.07); }

        /* Page Layout */
        .page-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.25rem 4rem;
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="top-nav">
    <div class="nav-inner">
        <a href="{{ route('member.dashboard') }}" class="nav-logo">
            <img src="{{ asset('template/assets/images/logo-abbr.png') }}" style="height:48px" alt="GMF">
            <span style="margin-left:8px;">MEMBER</span>
        </a>

        <button class="hamburger" id="hmb" type="button" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-dropdown" id="navDrop">
            <a href="{{ route('member.dashboard') }}" class="dd-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"><i class="feather-home"></i> Dashboard</a>
            <a href="{{ route('booking.index') }}"    class="dd-link {{ request()->routeIs('booking.index') ? 'active' : '' }}"><i class="feather-calendar"></i> Booking Kelas</a>
            <a href="{{ route('booking.history') }}"  class="dd-link {{ request()->routeIs('booking.history') ? 'active' : '' }}"><i class="feather-list"></i> Kelas Saya</a>
            <a href="{{ route('member.pt.index') }}"  class="dd-link {{ request()->routeIs('member.pt.*') ? 'active' : '' }}"><i class="feather-user-check"></i> Personal Trainer</a>
            <div class="dd-divider"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dd-logout" type="submit"><i class="feather-log-out"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="page-wrapper">
    @yield('content')
</div>

@stack('modals')

<script src="{{ asset('template/assets/vendors/js/vendors.min.js') }}"></script>
<script>
    // Hamburger toggle
    const hmb = document.getElementById('hmb');
    const navDrop = document.getElementById('navDrop');
    if (hmb && navDrop) {
        hmb.addEventListener('click', () => {
            hmb.classList.toggle('open');
            navDrop.classList.toggle('open');
        });
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!hmb.contains(e.target) && !navDrop.contains(e.target)) {
                hmb.classList.remove('open');
                navDrop.classList.remove('open');
            }
        });
    }
</script>
@stack('scripts')
</body>
</html>
