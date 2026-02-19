<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password | Gintung Master Fitness</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
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
            min-height: 100vh;
            background: var(--dark-mid);
            font-family: 'DM Sans', sans-serif;
            color: #e2e8f0;
        }

        /* Radial bg effects */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 80% 10%,  rgba(245,158,11,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 10% 90%,  rgba(99,102,241,0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Page center ── */
        .page-center {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
        }

        /* ── Card ── */
        .card-wrap {
            width: 100%;
            max-width: 420px;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
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
            margin-bottom: 2rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: #fff; }
        .back-link svg { transition: transform 0.2s; }
        .back-link:hover svg { transform: translateX(-3px); }

        /* Icon lockup */
        .icon-wrap {
            width: 60px;
            height: 60px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        /* Title */
        .form-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            color: #fff;
            margin-bottom: 8px;
            line-height: 1.15;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 2rem;
        }

        /* Field */
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
        .field-input::placeholder { color: rgba(148,163,184,0.45); }
        .field-input:focus {
            border-color: rgba(245,158,11,0.45);
            background: rgba(255,255,255,0.07);
            box-shadow: 0 0 0 3px rgba(245,158,11,0.08);
        }

        .field-error {
            display: block;
            font-size: 0.775rem;
            color: #fca5a5;
            margin-top: 6px;
        }

        /* Submit */
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
            margin-top: 1.25rem;
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

        /* Info note */
        .info-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            margin-top: 1.25rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
        }
        .info-note svg { flex-shrink: 0; margin-top: 1px; color: var(--accent); }

        /* Footer link */
        .form-footer {
            text-align: center;
            margin-top: 1.75rem;
        }
        .form-footer a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.82rem;
            transition: color 0.2s;
        }
        .form-footer a:hover { color: #fff; }
        .form-footer a strong { color: var(--accent); font-weight: 700; }

        /* Success alert */
        .alert-ok {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(34,197,94,0.10);
            border: 1px solid rgba(34,197,94,0.22);
            color: #86efac;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.855rem;
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>

<div class="page-center">
    <div class="card-wrap">

        {{-- Back link --}}
        <a href="{{ route('login') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Login
        </a>

        {{-- Icon --}}
        <div class="icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>

        {{-- Title --}}
        <h1 class="form-title">Lupa Password?</h1>
        <p class="form-subtitle">
            Masukkan email terdaftar Anda. Kami akan mengirimkan kode OTP untuk mereset password.
        </p>

        <div class="divider"></div>

        {{-- Session success --}}
        @if(session('status'))
            <div class="alert-ok">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('status') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <label class="field-label" for="email">Email Terdaftar</label>
            <input
                type="email"
                id="email"
                name="email"
                class="field-input"
                placeholder="nama@email.com"
                value="{{ old('email') }}"
                required
                autofocus>
            @error('email')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Kirim Kode OTP
            </button>
        </form>

        {{-- Info note --}}
        <div class="info-note">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Pastikan email yang dimasukkan adalah email yang terdaftar di sistem GMF. Cek folder spam jika email tidak masuk.
        </div>

        {{-- Footer --}}
        <div class="form-footer">
            <a href="{{ route('login') }}">Sudah ingat password? <strong>Masuk di sini</strong></a>
        </div>

    </div>
</div>

</body>
</html>