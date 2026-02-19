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
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

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

        /* ══════════════════════════════
           FULL PAGE LAYOUT
        ══════════════════════════════ */
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
            position: absolute;
            inset: 0;
            background: url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80") no-repeat center center / cover;
            filter: brightness(0.22) saturate(0.7);
            transform: scale(1.04);
            animation: bgZoom 14s ease infinite alternate;
        }
        @keyframes bgZoom {
            from { transform: scale(1.04); }
            to   { transform: scale(1.10); }
        }

        .left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(10,15,30,0.3) 0%,
                rgba(10,15,30,0.6) 50%,
                rgba(10,15,30,0.95) 100%
            );
        }

        /* Grid texture */
        .left-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: linear-gradient(180deg, transparent 0%, black 40%, black 80%, transparent 100%);
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        /* Logo / Brand */
        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 0.06em;
            color: #fff;
            margin-bottom: 3rem;
        }
        .brand-mark .a { color: var(--accent); }

        .left-headline {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2.6rem;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 1rem;
        }
        .left-headline .hl {
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .left-sub {
            color: rgba(255,255,255,0.5);
            font-size: 0.9rem;
            line-height: 1.65;
            margin-bottom: 2.5rem;
            max-width: 360px;
        }

        /* Feature pills */
        .feat-pills {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .feat-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 11px 16px;
            backdrop-filter: blur(8px);
            animation: slideInLeft 0.5s ease both;
        }
        .feat-pill:nth-child(1) { animation-delay: 0.2s; }
        .feat-pill:nth-child(2) { animation-delay: 0.32s; }
        .feat-pill:nth-child(3) { animation-delay: 0.44s; }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-16px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .pill-icon {
            width: 34px;
            height: 34px;
            background: var(--accent-soft);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }
        .pill-text strong { display: block; font-size: 0.85rem; font-weight: 600; color: #fff; line-height: 1.2; }
        .pill-text span   { font-size: 0.75rem; color: rgba(255,255,255,0.4); }

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

        /* Subtle radial glow */
        .right-panel::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(245,158,11,0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99,102,241,0.05) 0%, transparent 70%);
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
            margin-bottom: 2.5rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: #fff; }
        .back-link svg { transition: transform 0.2s; }
        .back-link:hover svg { transform: translateX(-3px); }

        /* Title */
        .form-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.9rem;
            color: #fff;
            margin-bottom: 6px;
            line-height: 1.15;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 2rem;
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
        .field-group { margin-bottom: 1.25rem; }

        .field-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
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
        .field-input::placeholder { color: rgba(148,163,184,0.5); }
        .field-input:focus {
            border-color: rgba(245,158,11,0.45);
            background: rgba(255,255,255,0.07);
            box-shadow: 0 0 0 3px rgba(245,158,11,0.08);
        }

        /* Password wrapper (for show/hide) */
        .pw-wrap { position: relative; }
        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            line-height: 1;
            transition: color 0.2s;
        }
        .pw-toggle:hover { color: #fff; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e;
            border: none;
            border-radius: 11px;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(245,158,11,0.2);
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(245,158,11,0.35);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Links below form */
        .form-footer {
            margin-top: 1.75rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-footer a {
            color: var(--text-muted);
            font-size: 0.82rem;
            text-decoration: none;
            transition: color 0.2s;
        }
        .form-footer a:hover { color: #fff; }
        .form-footer a strong { color: var(--accent); font-weight: 700; }

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

        <div class="left-content">
            <div class="brand-mark">⚡ <span class="a">GMF</span> SYSTEM</div>

            <h2 class="left-headline">
                Sistem Digital<br>untuk <span class="hl">Gym Modern</span>
            </h2>

            <p class="left-sub">
                Kelola membership, presensi QR Code, jadwal kelas, dan laporan coach
                dalam satu platform terintegrasi.
            </p>

            <div class="feat-pills">
                <div class="feat-pill">
                    <div class="pill-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="pill-text">
                        <strong>Manajemen Member</strong>
                        <span>Status, paket, dan perpanjangan otomatis</span>
                    </div>
                </div>
                <div class="feat-pill">
                    <div class="pill-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    </div>
                    <div class="pill-text">
                        <strong>Presensi QR Code</strong>
                        <span>Check-in instan, akurat & real-time</span>
                    </div>
                </div>
                <div class="feat-pill">
                    <div class="pill-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div class="pill-text">
                        <strong>Jadwal & Booking Kelas</strong>
                        <span>Muaythai, Boxing, dan lainnya</span>
                    </div>
                </div>
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

            <h1 class="form-title">Selamat Datang</h1>

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
                    <label class="field-label" for="email">Email Address</label>
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

                <button type="submit" class="btn-submit">
                    Masuk Sekarang →
                </button>
            </form>

            <div class="form-footer">
                <a href="{{ route('password.request') }}">
                    Lupa password? <strong>Reset di sini</strong>
                </a>
                <a href="{{ url('/') }}">Kembali ke Halaman Utama</a>
            </div>

        </div>
    </div>

</div>

<script>
    // Password show/hide
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