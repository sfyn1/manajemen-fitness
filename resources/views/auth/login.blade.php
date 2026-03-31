<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Login | Gintung Master Fitness</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/images/favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark:        #0a0f1e;
            --dark-mid:    #0f172a;
            --dark-card:   #1a2540;
            --accent:      #f59e0b;
            --accent-2:    #fb923c;
            --accent-soft: rgba(245,158,11,0.12);
            --text-muted:  #94a3b8;
            --border:      rgba(255,255,255,0.08);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            background: var(--dark);
            font-family: 'DM Sans', sans-serif;
            color: #e2e8f0;
            overflow: hidden;
        }

        /* ══ LAYOUT ══ */
        .login-page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ══ LEFT PANEL ══ */
        .left-panel {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
        }

        .left-bg {
            position: absolute; inset: 0;
            background: url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80") no-repeat center center / cover;
            filter: brightness(0.2) saturate(0.7);
            transform: scale(1.04);
            animation: bgZoom 14s ease infinite alternate;
        }
        @keyframes bgZoom {
            from { transform: scale(1.04); }
            to   { transform: scale(1.10); }
        }

        .left-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(
                160deg,
                rgba(10,15,30,0.2) 0%,
                rgba(10,15,30,0.55) 45%,
                rgba(10,15,30,0.97) 100%
            );
        }

        .left-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: linear-gradient(180deg, transparent 0%, black 40%, black 80%, transparent 100%);
        }

        /* Accent orb */
        .left-orb {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(245,158,11,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        /* Brand */
        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 0.02em;
            color: #fff;
            margin-bottom: 2.75rem;
        }
        .brand-mark .a { color: var(--accent); }

        /* Eyebrow badge */
        .left-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.2);
            color: var(--accent);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 1.25rem;
            animation: fadeUp 0.5s 0.1s ease both;
        }
        .eyebrow-dot {
            width: 5px; height: 5px;
            background: var(--accent);
            border-radius: 50%;
            box-shadow: 0 0 6px var(--accent);
            animation: pulse 2s ease infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.4; transform: scale(0.7); }
        }

        .left-headline {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 2.5rem;
            color: #fff;
            line-height: 1.12;
            margin-bottom: 1rem;
            animation: fadeUp 0.5s 0.15s ease both;
        }
        .left-headline .hl {
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .left-sub {
            color: rgba(255,255,255,0.48);
            font-size: 0.88rem;
            line-height: 1.7;
            margin-bottom: 2.25rem;
            max-width: 340px;
            animation: fadeUp 0.5s 0.2s ease both;
        }

        /* Motivational pills */
        .feat-pills {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .feat-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 13px;
            padding: 12px 16px;
            backdrop-filter: blur(10px);
            animation: slideInLeft 0.5s ease both;
            transition: background 0.2s, border-color 0.2s;
        }
        .feat-pill:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(245,158,11,0.18);
        }
        .feat-pill:nth-child(1) { animation-delay: 0.25s; }
        .feat-pill:nth-child(2) { animation-delay: 0.38s; }
        .feat-pill:nth-child(3) { animation-delay: 0.51s; }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-16px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .pill-icon {
            width: 36px; height: 36px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.18);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .pill-text strong {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.25;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .pill-text span {
            font-size: 0.74rem;
            color: rgba(255,255,255,0.38);
        }

        /* Divider with quote */
        .left-quote {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.3);
            font-size: 0.8rem;
            font-style: italic;
            line-height: 1.6;
            animation: fadeUp 0.5s 0.6s ease both;
        }
        .left-quote span { color: var(--accent); font-style: normal; font-weight: 700; }

        /* ══ RIGHT PANEL ══ */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 3rem;
            background: var(--dark-mid);
            position: relative;
            overflow: hidden;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(245,158,11,0.05) 0%, transparent 70%);
            pointer-events: none;
        }
        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(99,102,241,0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .form-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            animation: fadeUp 0.5s 0.1s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 2.25rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: #fff; }
        .back-link svg { transition: transform 0.2s; }
        .back-link:hover svg { transform: translateX(-3px); }

        /* Welcome badge */
        .form-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.18);
            color: var(--accent);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 5px 13px;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        /* Title */
        .form-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.85rem;
            color: #fff;
            margin-bottom: 5px;
            line-height: 1.18;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 1.75rem;
            line-height: 1.55;
        }
        .form-subtitle strong { color: var(--accent); font-weight: 700; }

        /* Divider */
        .form-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 1.75rem;
        }

        /* Alerts */
        .alert-custom {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            font-size: 0.855rem;
            line-height: 1.5;
        }
        .alert-err { background: rgba(239,68,68,0.10); border: 1px solid rgba(239,68,68,0.22); color: #fca5a5; }
        .alert-ok  { background: rgba(34,197,94,0.10);  border: 1px solid rgba(34,197,94,0.22);  color: #86efac; }
        .alert-custom ul { margin: 0; padding-left: 1rem; }

        /* Form fields */
        .field-group { margin-bottom: 1.2rem; }

        .field-label {
            display: block;
            font-size: 0.77rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 13px 16px;
            color: #e2e8f0;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .field-input::placeholder { color: rgba(148,163,184,0.4); }
        .field-input:focus {
            border-color: rgba(245,158,11,0.45);
            background: rgba(255,255,255,0.07);
            box-shadow: 0 0 0 3px rgba(245,158,11,0.08);
        }

        /* Password wrapper */
        .pw-wrap { position: relative; }
        .pw-toggle {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--text-muted);
            cursor: pointer; padding: 0; line-height: 1;
            transition: color 0.2s;
        }
        .pw-toggle:hover { color: #fff; }

        /* Remember row */
        .form-row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem;
            margin-top: 0.25rem;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.82rem;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }
        .remember-label input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--accent);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 0.82rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        .forgot-link:hover { opacity: 0.75; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e;
            border: none;
            border-radius: 11px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(245,158,11,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(245,158,11,0.35);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Form footer */
        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
        }
        .form-footer p {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.6;
        }
        .form-footer a {
            color: #e2e8f0;
            text-decoration: none;
            transition: color 0.2s;
        }
        .form-footer a:hover { color: #fff; }

        /* Trust badge row */
        .trust-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }
        .trust-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            color: rgba(148,163,184,0.55);
        }
        .trust-item svg { color: rgba(245,158,11,0.5); }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 900px) {
            html, body { overflow: auto; }
            .login-page { grid-template-columns: 1fr; min-height: 100vh; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; align-items: flex-start; padding-top: 4rem; }
        }
    </style>
</head>
<body>

<div class="login-page">

    {{-- ══ LEFT PANEL ══ --}}
    <div class="left-panel">
        <div class="left-bg"></div>
        <div class="left-overlay"></div>
        <div class="left-grid"></div>
        <div class="left-orb"></div>

        <div class="left-content">
            <div class="brand-mark">⚡ <span class="a">GINTUNG</span> MASTER FITNESS</div>

            <h2 class="left-headline">
                Setiap Rep<br>Membawamu Lebih<br>Dekat ke <span class="hl">Versi Terbaik</span>
            </h2>

            <p class="left-sub">
                Bergabunglah bersama ratusan member yang sudah membuktikan perubahan nyata. Trainer berpengalaman, fasilitas lengkap, harga terjangkau.
            </p>

            <div class="feat-pills">
                <div class="feat-pill">
                    <div class="pill-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                    <div class="pill-text">
                        <strong>Program Terstruktur</strong>
                        <span>Gym, Muaythai & Boxing setiap minggu</span>
                    </div>
                </div>
                <div class="feat-pill">
                    <div class="pill-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="pill-text">
                        <strong>Trainer Bersertifikat</strong>
                        <span>Siap membimbing dari level pemula</span>
                    </div>
                </div>
                <div class="feat-pill">
                    <div class="pill-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div class="pill-text">
                        <strong>Harga Mulai Rp 150.000</strong>
                        <span>Paket bulanan tanpa biaya tersembunyi</span>
                    </div>
                </div>
            </div>

            <div class="left-quote">
                "Tidak ada yang namanya terlambat untuk mulai. <span>Hari ini</span> adalah hari terbaik untuk berubah."
            </div>
        </div>
    </div>

    {{-- ══ RIGHT PANEL ══ --}}
    <div class="right-panel">
        <div class="form-wrapper">

            <a href="{{ url('/') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Beranda
            </a>

            <h1 class="form-title">Halo, Selamat<br>Datang Kembali!</h1>
            <p class="form-subtitle">
                Masuk untuk melanjutkan perjalanan fitness-mu.<br>
                Belum punya akun? <strong>Hubungi admin kami.</strong>
            </p>

            <div class="form-divider"></div>

            {{-- Alerts --}}
            @if($errors->any())
                <div class="alert-custom alert-err">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:2px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-custom alert-err">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert-custom alert-ok">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="field-input"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus>
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <div class="pw-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="field-input"
                            placeholder="••••••••"
                            required
                            style="padding-right: 46px;">
                        <button type="button" class="pw-toggle" id="pwToggle" aria-label="Toggle password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="form-row-between">
                    <label class="remember-label">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk Sekarang
                </button>
            </form>

            <div class="trust-row">
                <div class="trust-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Koneksi aman
                </div>
                <div class="trust-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Data terlindungi
                </div>
                <div class="trust-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Akses 24/7
                </div>
            </div>

            <div class="form-footer">
                <p>Belum punya akun member? <a href="https://wa.me/6281234567890" target="_blank" style="color:var(--accent);font-weight:700;">Daftar via WhatsApp →</a></p>
            </div>

        </div>
    </div>

</div>

<script>
    const pwToggle = document.getElementById('pwToggle');
    const pwInput  = document.getElementById('password');
    pwToggle.addEventListener('click', () => {
        const isHidden = pwInput.type === 'password';
        pwInput.type = isHidden ? 'text' : 'password';
        pwToggle.innerHTML = isHidden
            ? `<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
    });
</script>

</body>
</html>