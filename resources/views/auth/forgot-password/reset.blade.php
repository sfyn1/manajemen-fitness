<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | Gintung Master Fitness</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark:        #0a0f1e;
            --dark-mid:    #0f172a;
            --accent:      #f59e0b;
            --accent-2:    #fb923c;
            --accent-soft: rgba(245,158,11,0.12);
            --text-muted:  #94a3b8;
            --border:      rgba(255,255,255,0.08);
            --danger:      #f87171;
            --danger-soft: rgba(239,68,68,0.10);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            min-height: 100vh;
            background: var(--dark-mid);
            font-family: 'DM Sans', sans-serif;
            color: #e2e8f0;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 80% 10%, rgba(245,158,11,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 10% 90%, rgba(99,102,241,0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .page-center {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
        }

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

        /* Icon */
        .icon-wrap {
            width: 64px;
            height: 64px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.2);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        /* Titles */
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
            line-height: 1.65;
            margin-bottom: 2rem;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 2rem;
        }

        /* Field */
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

        .pw-wrap { position: relative; }

        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 13px 46px 13px 16px;
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
        .field-input.is-match {
            border-color: rgba(34,197,94,0.45);
            box-shadow: 0 0 0 3px rgba(34,197,94,0.08);
        }

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

        .field-error {
            display: block;
            font-size: 0.775rem;
            color: var(--danger);
            margin-top: 6px;
        }

        /* Password strength bar */
        .strength-bar-wrap {
            margin-top: 10px;
            display: flex;
            gap: 5px;
            align-items: center;
        }
        .strength-segments {
            display: flex;
            gap: 4px;
            flex: 1;
        }
        .strength-seg {
            height: 3px;
            flex: 1;
            border-radius: 3px;
            background: rgba(255,255,255,0.08);
            transition: background 0.3s;
        }
        .strength-seg.weak   { background: #f87171; }
        .strength-seg.fair   { background: var(--accent); }
        .strength-seg.strong { background: #22c55e; }
        .strength-label {
            font-size: 0.72rem;
            color: var(--text-muted);
            white-space: nowrap;
            min-width: 50px;
            text-align: right;
            transition: color 0.3s;
        }

        /* Match indicator */
        .match-hint {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.775rem;
            margin-top: 6px;
            color: var(--text-muted);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .match-hint.visible { opacity: 1; }
        .match-hint.ok  { color: #86efac; }
        .match-hint.bad { color: var(--danger); }

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
            margin-top: 0.5rem;
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

        /* Requirements list */
        .req-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 1.5rem;
            padding: 14px 16px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 10px;
        }
        .req-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--text-muted);
            transition: color 0.2s;
        }
        .req-item .req-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            flex-shrink: 0;
            transition: background 0.2s;
        }
        .req-item.met { color: #86efac; }
        .req-item.met .req-dot { background: #22c55e; box-shadow: 0 0 6px rgba(34,197,94,0.5); }

        /* Footer */
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        .form-footer a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.82rem;
            transition: color 0.2s;
        }
        .form-footer a:hover { color: #fff; }
        .form-footer a strong { color: var(--accent); font-weight: 700; }
    </style>
</head>
<body>

<div class="page-center">
    <div class="card-wrap">

        {{-- Back --}}
        <a href="{{ route('login') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Login
        </a>

        {{-- Icon --}}
        <div class="icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>

        {{-- Title --}}
        <h1 class="form-title">Buat Password Baru</h1>
        <p class="form-subtitle">Masukkan password baru Anda. Pastikan mudah diingat tapi sulit ditebak.</p>

        <div class="divider"></div>

        {{-- Form --}}
        <form action="{{ route('password.update') }}" method="POST" id="resetForm">
            @csrf

            {{-- Password baru --}}
            <div class="field-group">
                <label class="field-label" for="password">Password Baru</label>
                <div class="pw-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="field-input"
                        placeholder="Minimal 6 karakter"
                        required
                        autofocus>
                    <button type="button" class="pw-toggle" id="togglePw1" aria-label="Tampilkan password">
                        <svg id="eye1" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>

                {{-- Strength bar --}}
                <div class="strength-bar-wrap" id="strengthWrap" style="display:none">
                    <div class="strength-segments">
                        <div class="strength-seg" id="seg1"></div>
                        <div class="strength-seg" id="seg2"></div>
                        <div class="strength-seg" id="seg3"></div>
                        <div class="strength-seg" id="seg4"></div>
                    </div>
                    <span class="strength-label" id="strengthLabel"></span>
                </div>

                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Konfirmasi --}}
            <div class="field-group">
                <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
                <div class="pw-wrap">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="field-input"
                        placeholder="Ulangi password"
                        required>
                    <button type="button" class="pw-toggle" id="togglePw2" aria-label="Tampilkan password">
                        <svg id="eye2" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                <div class="match-hint" id="matchHint">
                    <svg id="matchIcon" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></svg>
                    <span id="matchText"></span>
                </div>
            </div>

            {{-- Syarat password --}}
            <div class="req-list">
                <div class="req-item" id="req-len"><div class="req-dot"></div>Minimal 6 karakter</div>
                <div class="req-item" id="req-num"><div class="req-dot"></div>Mengandung angka</div>
                <div class="req-item" id="req-upper"><div class="req-dot"></div>Mengandung huruf kapital</div>
            </div>

            <button type="submit" class="btn-submit" style="margin-top:1.5rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Password Baru
            </button>
        </form>

        <div class="form-footer">
            <a href="{{ route('login') }}">Kembali ke <strong>Login</strong></a>
        </div>

    </div>
</div>

<script>
    // ── Toggle show/hide password ──
    function makeToggle(btnId, inputId, eyeId) {
        document.getElementById(btnId).addEventListener('click', function () {
            const inp = document.getElementById(inputId);
            const showing = inp.type === 'text';
            inp.type = showing ? 'password' : 'text';
            document.getElementById(eyeId).innerHTML = showing
                ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
                : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        });
    }
    makeToggle('togglePw1', 'password', 'eye1');
    makeToggle('togglePw2', 'password_confirmation', 'eye2');

    // ── Strength meter ──
    const pwInput   = document.getElementById('password');
    const segs      = [document.getElementById('seg1'), document.getElementById('seg2'), document.getElementById('seg3'), document.getElementById('seg4')];
    const strLabel  = document.getElementById('strengthLabel');
    const strWrap   = document.getElementById('strengthWrap');

    const reqLen   = document.getElementById('req-len');
    const reqNum   = document.getElementById('req-num');
    const reqUpper = document.getElementById('req-upper');

    pwInput.addEventListener('input', function () {
        const v = this.value;
        strWrap.style.display = v ? 'flex' : 'none';

        // Requirements
        reqLen.classList.toggle('met',   v.length >= 6);
        reqNum.classList.toggle('met',   /\d/.test(v));
        reqUpper.classList.toggle('met', /[A-Z]/.test(v));

        // Strength score 0-4
        let score = 0;
        if (v.length >= 6)  score++;
        if (v.length >= 10) score++;
        if (/\d/.test(v) && /[A-Z]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;

        const cls   = score <= 1 ? 'weak' : score <= 2 ? 'fair' : 'strong';
        const label = score <= 1 ? 'Lemah' : score <= 2 ? 'Sedang' : score === 3 ? 'Kuat' : 'Sangat Kuat';
        const colors = { weak: '#f87171', fair: '#f59e0b', strong: '#22c55e' };

        segs.forEach((s, i) => {
            s.className = 'strength-seg';
            if (i < score) s.classList.add(cls);
        });
        strLabel.textContent = label;
        strLabel.style.color = colors[cls] || '#22c55e';

        checkMatch();
    });

    // ── Match check ──
    const confInput = document.getElementById('password_confirmation');
    const matchHint = document.getElementById('matchHint');
    const matchIcon = document.getElementById('matchIcon');
    const matchText = document.getElementById('matchText');

    const iconOk  = '<polyline points="20 6 9 17 4 12"/>';
    const iconBad = '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>';

    function checkMatch() {
        const pw   = pwInput.value;
        const conf = confInput.value;
        if (!conf) { matchHint.classList.remove('visible'); return; }
        matchHint.classList.add('visible');
        if (pw === conf) {
            matchHint.className = 'match-hint visible ok';
            matchIcon.innerHTML = iconOk;
            matchText.textContent = 'Password cocok';
            confInput.classList.add('is-match');
        } else {
            matchHint.className = 'match-hint visible bad';
            matchIcon.innerHTML = iconBad;
            matchText.textContent = 'Password tidak cocok';
            confInput.classList.remove('is-match');
        }
    }
    confInput.addEventListener('input', checkMatch);
</script>

</body>
</html>