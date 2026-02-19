<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Gintung Master Fitness | Management System</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/images/favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/feather.min.css') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark:        #0a0f1e;
            --dark-mid:    #0f172a;
            --dark-card:   #1e293b;
            --dark-hover:  #253044;
            --accent:      #f59e0b;
            --accent-2:    #fb923c;
            --accent-soft: rgba(245,158,11,0.12);
            --text-muted:  #94a3b8;
            --border:      rgba(255,255,255,0.07);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--dark);
            font-family: 'DM Sans', sans-serif;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        /* ══════════════════════════════════
           NAVBAR
        ══════════════════════════════════ */
        .top-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 500;
            padding: 0 1.5rem;
            transition: background 0.3s, border-bottom 0.3s;
        }

        .top-nav.scrolled {
            background: rgba(10,15,30,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
        }

        .nav-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: 0.05em;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-logo .a { color: var(--accent); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link-item {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 7px 14px;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }
        .nav-link-item:hover { color: #fff; background: rgba(255,255,255,0.06); }

        .btn-cta-nav {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 9px 20px;
            border-radius: 999px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            white-space: nowrap;
        }
        .btn-cta-nav:hover { opacity: 0.88; transform: scale(1.03); color: #0a0f1e; }

        /* Mobile nav toggle */
        .nav-mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            padding: 8px 7px;
        }
        .nav-mobile-toggle span {
            display: block;
            height: 2px;
            background: #e2e8f0;
            border-radius: 2px;
            transition: transform 0.25s, opacity 0.2s;
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-mobile-toggle { display: flex; }
        }

        /* ══════════════════════════════════
           HERO
        ══════════════════════════════════ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Background image with overlay */
        .hero-bg {
            position: absolute;
            inset: 0;
            background: url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80") no-repeat center center / cover;
            filter: brightness(0.25) saturate(0.8);
            transform: scale(1.05);
            animation: heroZoom 12s ease infinite alternate;
        }
        @keyframes heroZoom {
            from { transform: scale(1.05); }
            to   { transform: scale(1.12); }
        }

        /* Gradient overlays */
        .hero-overlay-1 {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, var(--dark) 0%, transparent 30%, transparent 60%, var(--dark) 100%);
        }
        .hero-overlay-2 {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(245,158,11,0.07) 0%, transparent 70%);
        }

        /* Animated grid lines */
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 0%, transparent 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .hero-inner {
            max-width: 760px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.22);
            color: var(--accent);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 1.75rem;
            animation: fadeUp 0.6s 0.1s ease both;
        }
        .eyebrow-dot {
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--accent);
            animation: pulse 2s ease infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.7); }
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: clamp(2.6rem, 6vw, 4.5rem);
            line-height: 1.08;
            color: #fff;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s 0.2s ease both;
        }

        .hero-title .line-accent {
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            animation: fadeUp 0.6s 0.3s ease both;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-btns {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            animation: fadeUp 0.6s 0.4s ease both;
            margin-bottom: 4rem;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            padding: 14px 32px;
            border-radius: 999px;
            text-decoration: none;
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 0 30px rgba(245,158,11,0.25);
        }
        .btn-hero-primary:hover { transform: translateY(-2px) scale(1.03); box-shadow: 0 8px 40px rgba(245,158,11,0.4); color: #0a0f1e; }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.06);
            color: #e2e8f0;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 14px 32px;
            border-radius: 999px;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.12);
            transition: background 0.2s, border-color 0.2s;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,0.10); border-color: rgba(255,255,255,0.22); color: #fff; }

        /* Stats row */
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 2px;
            animation: fadeUp 0.6s 0.5s ease both;
        }

        .stat-item {
            padding: 14px 28px;
            text-align: center;
            border-right: 1px solid var(--border);
        }
        .stat-item:last-child { border-right: none; }
        .stat-num {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: #fff;
            line-height: 1;
        }
        .stat-num .accent { color: var(--accent); }
        .stat-lbl { font-size: 0.75rem; color: var(--text-muted); margin-top: 3px; }

        /* Scroll indicator */
        .scroll-hint {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: 0.72rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            animation: fadeIn 1s 1s ease both;
        }
        .scroll-line {
            width: 1px;
            height: 40px;
            background: linear-gradient(180deg, var(--accent), transparent);
            animation: scrollPulse 2s ease infinite;
        }
        @keyframes scrollPulse {
            0%   { opacity: 0; transform: scaleY(0) translateY(-50%); }
            50%  { opacity: 1; transform: scaleY(1) translateY(0%); }
            100% { opacity: 0; transform: scaleY(1) translateY(100%); }
        }

        /* ══════════════════════════════════
           FEATURES
        ══════════════════════════════════ */
        .features-section {
            padding: 7rem 1.5rem;
            position: relative;
        }

        .features-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245,158,11,0.3), transparent);
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }
        .section-label::before {
            content: '';
            display: block;
            width: 24px;
            height: 2px;
            background: var(--accent);
            border-radius: 2px;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .section-sub {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.7;
            max-width: 520px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.1rem;
            margin-top: 4rem;
        }

        .feat-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
            animation: fadeUp 0.5s ease both;
        }
        .feat-card:nth-child(1) { animation-delay: 0.1s; }
        .feat-card:nth-child(2) { animation-delay: 0.18s; }
        .feat-card:nth-child(3) { animation-delay: 0.26s; }

        .feat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .feat-card:hover {
            border-color: rgba(245,158,11,0.25);
            transform: translateY(-6px);
            box-shadow: 0 16px 50px rgba(0,0,0,0.4);
        }
        .feat-card:hover::before { opacity: 1; }

        /* Glow orb in card bg */
        .feat-card::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: var(--accent-soft);
            top: -60px;
            right: -60px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .feat-card:hover::after { opacity: 1; }

        .feat-icon {
            width: 52px;
            height: 52px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.2);
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 20px;
            margin-bottom: 1.5rem;
            transition: transform 0.3s;
        }
        .feat-card:hover .feat-icon { transform: scale(1.1) rotate(-5deg); }

        .feat-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            color: #fff;
            margin-bottom: 10px;
        }

        .feat-desc {
            color: var(--text-muted);
            font-size: 0.875rem;
            line-height: 1.7;
        }

        .feat-tag {
            display: inline-block;
            margin-top: 1.25rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: var(--accent);
            text-transform: uppercase;
        }

        /* ══════════════════════════════════
           HOW IT WORKS  (simple 3-step)
        ══════════════════════════════════ */
        .how-section {
            padding: 6rem 1.5rem;
            position: relative;
        }

        .how-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
        }

        .steps-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3.5rem;
            position: relative;
        }

        /* connecting line */
        .steps-row::before {
            content: '';
            position: absolute;
            top: 28px;
            left: 16.5%;
            right: 16.5%;
            height: 1px;
            background: linear-gradient(90deg, var(--accent), rgba(245,158,11,0.2), var(--accent));
        }

        .step-item {
            text-align: center;
            animation: fadeUp 0.5s ease both;
        }
        .step-item:nth-child(1) { animation-delay: 0.1s; }
        .step-item:nth-child(2) { animation-delay: 0.2s; }
        .step-item:nth-child(3) { animation-delay: 0.3s; }

        .step-num {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 0 24px rgba(245,158,11,0.3);
            position: relative;
            z-index: 1;
        }

        .step-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
            margin-bottom: 8px;
        }

        .step-desc { color: var(--text-muted); font-size: 0.85rem; line-height: 1.6; }

        /* ══════════════════════════════════
           CTA SECTION
        ══════════════════════════════════ */
        .cta-section {
            padding: 5rem 1.5rem 7rem;
        }

        .cta-box {
            max-width: 700px;
            margin: 0 auto;
            background: var(--dark-card);
            border: 1px solid rgba(245,158,11,0.15);
            border-radius: 24px;
            padding: 3.5rem 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: -80px; left: 50%; transform: translateX(-50%);
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            color: #fff;
            margin-bottom: 12px;
        }
        .cta-sub {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        /* ══════════════════════════════════
           FOOTER
        ══════════════════════════════════ */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem 1.5rem;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            color: #fff;
        }
        .footer-logo .a { color: var(--accent); }

        .footer-copy { font-size: 0.8rem; color: var(--text-muted); }

        /* ══ Utilities ══ */
        .container-max {
            max-width: 1200px;
            margin: 0 auto;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        /* ── Scroll-reveal class (added via JS) ── */
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) {
            .features-grid { grid-template-columns: 1fr; }
            .steps-row { grid-template-columns: 1fr; }
            .steps-row::before { display: none; }
        }

        @media (max-width: 580px) {
            .hero-stats { flex-direction: column; gap: 0; }
            .stat-item { border-right: none; border-bottom: 1px solid var(--border); padding: 10px 20px; }
            .stat-item:last-child { border-bottom: none; }
            .cta-box { padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>

{{-- ══════════ NAVBAR ══════════ --}}
<nav class="top-nav" id="navbar">
    <div class="nav-inner">
        <a href="#" class="nav-logo">⚡ <span class="a">GMF</span></a>

        <div class="nav-links">
            <a href="#beranda" class="nav-link-item">Beranda</a>
            <a href="#fitur"   class="nav-link-item">Fitur</a>
            <a href="#cara"    class="nav-link-item">Cara Kerja</a>

            @if(Route::has('login'))
                @auth
                    <a href="{{ url('dashboard') }}" class="btn-cta-nav" style="margin-left:8px;">
                        <i class="feather-grid"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-cta-nav" style="margin-left:8px;">
                        <i class="feather-log-in"></i> Masuk Sistem
                    </a>
                @endauth
            @endif
        </div>

        <button class="nav-mobile-toggle" id="mobileToggle" type="button">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- ══════════ HERO ══════════ --}}
<section id="beranda" class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay-1"></div>
    <div class="hero-overlay-2"></div>
    <div class="hero-grid"></div>

    <div class="hero-content">
        <div class="hero-inner">

            <div class="hero-eyebrow">
                <span class="eyebrow-dot"></span>
                
            </div>

            <h1 class="hero-title">
                Kelola Kebugaran<br>
                dengan <span class="line-accent">Teknologi Modern</span>
            </h1>

            <p class="hero-sub">
                Solusi digital untuk manajemen membership, presensi QR Code, dan penjadwalan latihan
                di Gintung Master Fitness. Efisien, akurat, dan real-time.
            </p>

            <div class="hero-btns">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('dashboard') }}" class="btn-hero-primary">
                            <i class="feather-grid"></i> Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-hero-primary">
                            <i class="feather-zap"></i> Mulai Sekarang
                        </a>
                    @endauth
                @endif
                <a href="#fitur" class="btn-hero-secondary">
                    Pelajari Fitur ↓
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-num">QR <span class="accent">✓</span></div>
                    <div class="stat-lbl">Presensi Scan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num"><span class="accent">∞</span></div>
                    <div class="stat-lbl">Data Real-time</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">3 <span class="accent">+</span></div>
                    <div class="stat-lbl">Jenis Kelas</div>
                </div>
            </div>

        </div>
    </div>

    <div class="scroll-hint">
        <div class="scroll-line"></div>
        Scroll
    </div>
</section>

{{-- ══════════ FEATURES ══════════ --}}
<section id="fitur" class="features-section">
    <div class="container-max">

        <div class="text-center" style="margin-bottom:0">
            <div class="section-label" style="justify-content:center">Keunggulan Sistem</div>
            <h2 class="section-title">Apa yang Bisa Dilakukan?</h2>
            <p class="section-sub" style="margin:0 auto">
                Dirancang untuk mengatasi masalah manual yang sering terjadi di operasional gym sehari-hari.
            </p>
        </div>

        <div class="features-grid">

            <div class="feat-card reveal">
                <div class="feat-icon"><i class="feather-users"></i></div>
                <div class="feat-title">Manajemen Anggota</div>
                <p class="feat-desc">
                    Pencatatan data member terpusat. Monitoring masa aktif, perpanjangan paket,
                    dan status keanggotaan secara otomatis.
                </p>
                <span class="feat-tag">Member · Paket · Status</span>
            </div>

            <div class="feat-card reveal">
                <div class="feat-icon"><i class="feather-maximize"></i></div>
                <div class="feat-title">Presensi Scan QR</div>
                <p class="feat-desc">
                    Check-in cepat hanya dengan scan QR Code. Mengurangi antrian dan
                    memastikan data kunjungan yang akurat setiap saat.
                </p>
                <span class="feat-tag">QR Code · Real-time · Akurat</span>
            </div>

            <div class="feat-card reveal">
                <div class="feat-icon"><i class="feather-calendar"></i></div>
                <div class="feat-title">Jadwal & Kelas</div>
                <p class="feat-desc">
                    Atur jadwal Personal Trainer dan kelas latihan seperti Muaythai dan Boxing
                    tanpa risiko bentrok jadwal manual.
                </p>
                <span class="feat-tag">Booking · Coach · Jadwal</span>
            </div>

        </div>
    </div>
</section>

{{-- ══════════ HOW IT WORKS ══════════ --}}
<section id="cara" class="how-section">
    <div class="container-max">

        <div class="text-center">
            <div class="section-label" style="justify-content:center">Cara Kerja</div>
            <h2 class="section-title">Mudah dalam 3 Langkah</h2>
            <p class="section-sub" style="margin:0 auto">
                Dari registrasi hingga latihan, semua terkelola dalam satu sistem yang terintegrasi.
            </p>
        </div>

        <div class="steps-row">
            <div class="step-item reveal">
                <div class="step-num">1</div>
                <div class="step-title">Daftar & Dapatkan QR</div>
                <p class="step-desc">Admin mendaftarkan member dan sistem otomatis menghasilkan kartu digital dengan QR Code unik.</p>
            </div>
            <div class="step-item reveal">
                <div class="step-num">2</div>
                <div class="step-title">Booking & Jadwal</div>
                <p class="step-desc">Member memilih kelas dan melakukan booking. Coach melihat jadwal mengajar dan melaporkan sesi.</p>
            </div>
            <div class="step-item reveal">
                <div class="step-num">3</div>
                <div class="step-title">Scan & Absen</div>
                <p class="step-desc">Saat datang, member scan QR Code. Data kunjungan terekam otomatis dan bisa dilihat kapan saja.</p>
            </div>
        </div>

    </div>
</section>

{{-- ══════════ CTA ══════════ --}}
<section class="cta-section">
    <div class="container-max">
        <div class="cta-box reveal">
            <div class="hero-eyebrow" style="justify-content:center">
                <span class="eyebrow-dot"></span>
                Siap Digunakan
            </div>
            <h2 class="cta-title">Mulai Kelola Gym Anda<br>Sekarang Juga</h2>
            <p class="cta-sub">
                Masuk ke sistem dan nikmati kemudahan manajemen membership,
                presensi digital, dan jadwal kelas dalam satu platform.
            </p>
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('dashboard') }}" class="btn-hero-primary" style="display:inline-flex;">
                        <i class="feather-grid"></i> Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-hero-primary" style="display:inline-flex;">
                        <i class="feather-zap"></i> Masuk Sistem
                    </a>
                @endauth
            @endif
        </div>
    </div>
</section>

{{-- ══════════ FOOTER ══════════ --}}
<footer>
    <div class="footer-inner">
        <div class="footer-logo">⚡ <span class="a">GMF</span> — Gintung Master Fitness</div>
        <div class="footer-copy">
            &copy; {{ date('Y') }} Sufyan Dzaki · Skripsi UIN Jakarta
        </div>
    </div>
</footer>

<script src="{{ asset('template/assets/js/bootstrap.min.js') }}"></script>
<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 30);
    });

    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));
</script>

</body>
</html>