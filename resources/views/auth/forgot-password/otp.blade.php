<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP | Gintung Master Fitness</title>
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
            position: relative;
        }
        /* Pulse ring */
        .icon-wrap::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 22px;
            border: 1px solid rgba(245,158,11,0.15);
            animation: ringPulse 2.5s ease infinite;
        }
        @keyframes ringPulse {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50%       { opacity: 0;   transform: scale(1.1); }
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
            line-height: 1.65;
            margin-bottom: 0.5rem;
        }

        /* Email chip */
        .email-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.18);
            color: var(--accent);
            font-size: 0.82rem;
            font-weight: 600;
            padding: 5px 13px;
            border-radius: 999px;
            margin-bottom: 2rem;
            word-break: break-all;
        }
        .email-chip svg { flex-shrink: 0; }

        .divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 2rem;
        }

        /* ── OTP input boxes ── */
        .otp-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 14px;
            text-align: center;
        }

        .otp-boxes {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .otp-box {
            width: 52px;
            height: 60px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: #fff;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            text-align: center;
            outline: none;
            caret-color: var(--accent);
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s, transform 0.15s;
            -moz-appearance: textfield;
        }
        .otp-box::-webkit-outer-spin-button,
        .otp-box::-webkit-inner-spin-button { -webkit-appearance: none; }

        .otp-box:focus {
            border-color: var(--accent);
            background: rgba(245,158,11,0.08);
            box-shadow: 0 0 0 3px rgba(245,158,11,0.12);
            transform: scale(1.06);
        }
        .otp-box.filled {
            border-color: rgba(245,158,11,0.4);
            background: rgba(245,158,11,0.07);
        }

        /* Hidden real input */
        .otp-hidden {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: 0;
            height: 0;
        }

        .field-error {
            display: block;
            font-size: 0.775rem;
            color: #fca5a5;
            margin-top: 8px;
            text-align: center;
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
            margin-top: 1.5rem;
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
        .btn-submit:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
        }

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
        .info-note code {
            background: rgba(245,158,11,0.1);
            color: var(--accent);
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        /* Footer */
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

        /* Countdown timer */
        .resend-row {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .resend-row .timer { color: var(--accent); font-weight: 700; font-variant-numeric: tabular-nums; }
    </style>
</head>
<body>

<div class="page-center">
    <div class="card-wrap">

        {{-- Back --}}
        <a href="{{ route('password.request') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>

        {{-- Icon --}}
        <div class="icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>

        {{-- Title --}}
        <h1 class="form-title">Masukkan Kode OTP</h1>
        <p class="form-subtitle">Kode 6 digit telah dikirimkan ke:</p>

        <div class="email-chip">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            {{ session('reset_email') }}
        </div>

        <div class="divider"></div>

        {{-- OTP Form --}}
        <form action="{{ route('password.otp.verify') }}" method="POST" id="otpForm">
            @csrf

            <label class="otp-label">Kode OTP</label>

            {{-- 6 visual boxes --}}
            <div class="otp-boxes" id="otpBoxes">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
            </div>

            {{-- Hidden input that actually submits --}}
            <input type="hidden" name="otp" id="otpValue">

            @error('otp')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn-submit" id="submitBtn" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Verifikasi Kode
            </button>
        </form>

        {{-- Info note --}}
        <div class="info-note">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Tidak menerima email? Cek folder spam atau lihat di
        </div>

        {{-- Resend countdown --}}
        <div class="resend-row">
            Kirim ulang kode dalam <span class="timer" id="countdown">02:00</span>
        </div>

        {{-- Footer --}}
        <div class="form-footer">
            <a href="{{ route('login') }}">Kembali ke <strong>Login</strong></a>
        </div>

    </div>
</div>

<script>
    // ── OTP boxes logic ──
    const boxes     = document.querySelectorAll('.otp-box');
    const otpValue  = document.getElementById('otpValue');
    const submitBtn = document.getElementById('submitBtn');

    function syncValue() {
        const val = [...boxes].map(b => b.value).join('');
        otpValue.value = val;
        submitBtn.disabled = val.length < 6;
        boxes.forEach((b, i) => {
            b.classList.toggle('filled', b.value !== '');
        });
    }

    boxes.forEach((box, idx) => {
        box.addEventListener('input', e => {
            const v = e.target.value.replace(/\D/g, '');
            box.value = v.slice(-1); // only last digit
            syncValue();
            if (v && idx < boxes.length - 1) boxes[idx + 1].focus();
        });

        box.addEventListener('keydown', e => {
            if (e.key === 'Backspace') {
                if (!box.value && idx > 0) {
                    boxes[idx - 1].value = '';
                    boxes[idx - 1].focus();
                }
                syncValue();
            }
            if (e.key === 'ArrowLeft'  && idx > 0)               boxes[idx - 1].focus();
            if (e.key === 'ArrowRight' && idx < boxes.length - 1) boxes[idx + 1].focus();
        });

        // Handle paste
        box.addEventListener('paste', e => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            [...pasted].slice(0, 6).forEach((ch, i) => {
                if (boxes[i]) boxes[i].value = ch;
            });
            const next = Math.min(pasted.length, 5);
            boxes[next].focus();
            syncValue();
        });
    });

    // Auto-focus first
    boxes[0].focus();

    // ── Countdown ──
    const resendUrl = "{{ route('password.request') }}";
    let secs = 120;
    const el = document.getElementById('countdown');
    const tick = setInterval(() => {
        secs--;
        const m = String(Math.floor(secs / 60)).padStart(2, '0');
        const s = String(secs % 60).padStart(2, '0');
        el.textContent = m + ':' + s;
        if (secs <= 0) {
            clearInterval(tick);
            el.textContent = '';
            el.parentElement.innerHTML = '<a href="' + resendUrl + '" style="color:var(--accent);font-weight:700;text-decoration:none;">Kirim ulang kode OTP</a>';
        }
    }, 1000);
</script>

</body>
</html>