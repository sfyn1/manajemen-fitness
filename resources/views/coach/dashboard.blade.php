<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Coach - GMF</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            --warning:     #f59e0b;
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

        /* Coach pill */
        .coach-pill {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .coach-avatar {
            width: 34px;
            height: 34px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 0.8rem;
            color: var(--accent);
            flex-shrink: 0;
        }
        .coach-name-wrap { line-height: 1.2; display: none; }
        .coach-name-wrap .cname { font-weight: 600; font-size: 0.875rem; color: #fff; }
        .coach-name-wrap .crole { font-size: 0.72rem; color: var(--text-muted); }

        @media (min-width: 640px) { .coach-name-wrap { display: block; } }

        .btn-logout-nav {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(239,68,68,0.10);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.22);
            padding: 6px 13px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-logout-nav:hover { background: rgba(239,68,68,0.2); color: #fff; }

        /* ══ PAGE ══ */
        .page-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.25rem 4rem;
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.75rem;
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

        /* Date Picker */
        .date-picker-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 8px 14px;
        }
        .date-picker-wrap label {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
            white-space: nowrap;
        }
        .date-picker-wrap input[type="date"] {
            background: transparent;
            border: none;
            color: var(--accent);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            outline: none;
            cursor: pointer;
            color-scheme: dark;
        }

        /* ── Date Banner ── */
        .date-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.1rem 1.5rem;
            margin-bottom: 2rem;
            animation: fadeUp 0.4s ease both;
        }

        .date-banner-left { display: flex; align-items: center; gap: 14px; }

        .date-icon {
            width: 46px;
            height: 46px;
            background: var(--accent-soft);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 18px;
            flex-shrink: 0;
        }

        .date-day {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: #fff;
            line-height: 1.2;
        }
        .date-full { font-size: 0.82rem; color: var(--text-muted); margin-top: 2px; }

        .class-count-wrap { text-align: right; }
        .class-count {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--accent);
            line-height: 1;
        }
        .class-count-label { font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; }

        /* ══ SCHEDULE GRID ══ */
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.1rem;
        }

        .sch-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
            animation: fadeUp 0.4s ease both;
        }
        .sch-card:hover {
            border-color: rgba(245,158,11,0.28);
            transform: translateY(-4px);
            box-shadow: 0 12px 36px rgba(0,0,0,0.3);
        }
        .sch-card:nth-child(1) { animation-delay: 0.04s; }
        .sch-card:nth-child(2) { animation-delay: 0.08s; }
        .sch-card:nth-child(3) { animation-delay: 0.12s; }
        .sch-card:nth-child(4) { animation-delay: 0.16s; }
        .sch-card:nth-child(5) { animation-delay: 0.20s; }
        .sch-card:nth-child(6) { animation-delay: 0.24s; }

        .card-stripe { height: 3px; background: linear-gradient(90deg, var(--accent), #fb923c); }

        .sch-body { padding: 1.35rem; flex: 1; display: flex; flex-direction: column; }

        /* Top row: badge + time */
        .sch-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .class-badge {
            background: var(--accent-soft);
            color: var(--accent);
            border: 1px solid rgba(245,158,11,0.18);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.76rem;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .class-time {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
        }

        .class-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            color: #fff;
            margin-bottom: 8px;
        }

        .member-row {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 1.25rem;
            padding-bottom: 1.1rem;
            border-bottom: 1px solid var(--border);
        }
        .member-row i { color: var(--accent); font-size: 13px; }
        .member-row b { color: #fff; font-weight: 700; }

        /* Status states */
        .sch-action { margin-top: auto; }

        .btn-lapor {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, var(--accent), #fb923c);
            color: #0f172a;
            border: none;
            border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-lapor:hover { opacity: 0.88; transform: scale(1.01); }

        .btn-hint {
            text-align: center;
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-top: 7px;
        }

        .status-box {
            border-radius: 10px;
            padding: 14px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        .status-box i { font-size: 1.6rem; margin-bottom: 2px; }
        .status-box .status-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.9rem; }
        .status-box .status-sub  { font-size: 0.75rem; color: var(--text-muted); }

        .status-pending {
            background: rgba(245,158,11,0.08);
            border: 1px solid rgba(245,158,11,0.2);
        }
        .status-pending i, .status-pending .status-title { color: var(--warning); }

        .status-approved {
            background: rgba(34,197,94,0.08);
            border: 1px solid rgba(34,197,94,0.2);
        }
        .status-approved i, .status-approved .status-title { color: var(--success); }

        /* ══ EMPTY ══ */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 5rem 1.5rem;
        }
        .empty-icon { font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.4; }
        .empty-state h5 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }
        .empty-state p { color: var(--text-muted); font-size: 0.9rem; }

        /* ══ MODAL ══ */
        .modal-content {
            background: #1a2844 !important;
            border: 1px solid rgba(255,255,255,0.10) !important;
            border-radius: 18px !important;
            color: #e2e8f0;
        }
        .modal-header {
            border-bottom: 1px solid var(--border) !important;
            padding: 1.25rem 1.5rem !important;
        }
        .modal-title { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.1rem; color: #fff; }
        .btn-close { filter: invert(1) opacity(0.5); }
        .btn-close:hover { filter: invert(1) opacity(1); }

        .modal-body { padding: 1.5rem !important; }

        .upload-preview {
            background: rgba(255,255,255,0.04);
            border: 2px dashed rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 2rem 1rem;
            text-align: center;
            margin-bottom: 1.25rem;
            transition: border-color 0.2s;
        }
        .upload-preview:hover { border-color: rgba(245,158,11,0.3); }
        .upload-preview i { font-size: 2.5rem; color: var(--text-muted); display: block; margin-bottom: 8px; }
        .upload-preview p { font-size: 0.82rem; color: var(--text-muted); margin: 0; }

        .form-label-custom {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: block;
        }

        .form-control-dark {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid var(--border) !important;
            border-radius: 10px !important;
            color: #e2e8f0 !important;
            font-size: 0.875rem;
            padding: 10px 14px;
        }
        .form-control-dark:focus {
            border-color: rgba(245,158,11,0.4) !important;
            box-shadow: 0 0 0 3px rgba(245,158,11,0.08) !important;
            background: rgba(255,255,255,0.07) !important;
        }
        .form-control-dark::file-selector-button {
            background: var(--accent-soft);
            color: var(--accent);
            border: 1px solid rgba(245,158,11,0.2);
            border-radius: 7px;
            padding: 5px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            margin-right: 10px;
            transition: background 0.2s;
        }
        .form-control-dark::file-selector-button:hover { background: rgba(245,158,11,0.2); }

        .btn-submit-modal {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--accent), #fb923c);
            color: #0f172a;
            border: none;
            border-radius: 11px;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            cursor: pointer;
            letter-spacing: 0.02em;
            transition: opacity 0.2s, transform 0.15s;
            margin-top: 1rem;
        }
        .btn-submit-modal:hover { opacity: 0.88; transform: scale(1.01); }

        /* ══ TOAST ══ */
        .toast-custom {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            background: rgba(34,197,94,0.15);
            border: 1px solid rgba(34,197,94,0.3);
            border-radius: 12px;
            padding: 13px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            color: #86efac;
            backdrop-filter: blur(12px);
            animation: toastIn 0.3s ease;
        }
        @keyframes toastIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 580px) {
            .page-header { flex-direction: column; align-items: flex-start; }
            .page-header h1 { font-size: 1.6rem; }
            .schedule-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- ══ NAV ══ --}}
<nav class="top-nav">
    <div class="nav-inner">
        <span class="nav-logo">⚡ <span class="a">GMF</span> COACH</span>

        <div class="coach-pill">
            <div class="coach-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="coach-name-wrap">
                <div class="cname">{{ Auth::user()->name }}</div>
                <div class="crole">Coach</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn-logout-nav" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ══ PAGE ══ --}}
<div class="page-wrapper">

    {{-- Header + Date picker --}}
    <div class="page-header">
        <div>
            <h1>Jadwal Mengajar</h1>
            <p>Kelola dan laporan sesi latihan Anda.</p>
        </div>
        <form action="{{ route('coach.dashboard') }}" method="GET">
            <div class="date-picker-wrap">
                <label>📅 Tanggal:</label>
                <input type="date" name="date"
                       value="{{ $targetDate->format('Y-m-d') }}"
                       onchange="this.form.submit()">
            </div>
        </form>
    </div>

    {{-- Date Banner --}}
    <div class="date-banner">
        <div class="date-banner-left">
            <div class="date-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="date-day">{{ $targetDayName }}</div>
                <div class="date-full">{{ $targetDate->format('d F Y') }}</div>
            </div>
        </div>
        <div class="class-count-wrap">
            <div class="class-count">{{ $schedules->count() }}</div>
            <div class="class-count-label">Kelas</div>
        </div>
    </div>

    {{-- Schedule Grid --}}
    <div class="schedule-grid">
        @forelse($schedules as $sch)

        <div class="sch-card">
            <div class="card-stripe"></div>
            <div class="sch-body">

                <div class="sch-top">
                    <span class="class-badge">{{ $sch->classType->name }}</span>
                    <span class="class-time">{{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }}</span>
                </div>

                <div class="class-title">Kelas {{ $sch->classType->name }}</div>

                <div class="member-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--accent)"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <b>{{ $sch->total_members }}</b> Member Booking
                </div>

                <div class="sch-action">

    @if(!$sch->presence)

        <button type="button"
                class="btn-lapor"
                onclick="toggleUpload({{ $sch->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                 viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                <circle cx="12" cy="13" r="4"/>
            </svg>
            Lapor Selesai
        </button>

        <div class="btn-hint">Upload foto bukti sesi.</div>

        {{-- Inline Upload Form --}}
        <div id="uploadForm{{ $sch->id }}"
             style="display:none; margin-top:15px;">

            <form action="{{ route('coach.presence.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                <input type="hidden"
                       name="schedule_id"
                       value="{{ $sch->id }}">

                <div class="upload-preview">
                    <p style="font-size:13px;">
                        Pilih foto bukti sesi kelas
                    </p>
                </div>

                <input type="file"
                       name="photo"
                       class="form-control form-control-dark"
                       required
                       accept="image/*">

                <button type="submit"
                        class="btn-submit-modal"
                        style="margin-top:10px;">
                    KIRIM LAPORAN →
                </button>

            </form>
        </div>

    @elseif($sch->presence->status == 'pending')

        <div class="status-box status-pending">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                 viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            <div class="status-title">Menunggu Verifikasi</div>
            <div class="status-sub">Admin sedang mengecek laporan.</div>
        </div>

    @elseif($sch->presence->status == 'approved')

        <div class="status-box status-approved">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                 viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <div class="status-title">Sesi Disetujui</div>
            <div class="status-sub">Gaji telah dihitung.</div>
        </div>

    @endif

</div>


            </div>
        </div>

        

        @empty
        <div class="empty-state">
            <span class="empty-icon">📅</span>
            <h5>Tidak Ada Jadwal</h5>
            <p>Tidak ada jadwal mengajar pada<br><b style="color:#fff">{{ $targetDate->format('d M Y') }}</b>.</p>
        </div>
        @endforelse
    </div>

</div>

{{-- Toast --}}
@if(session('success'))
<div class="toast-custom" id="toastMsg">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    {{ session('success') }}
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide toast after 4s
    const toast = document.getElementById('toastMsg');
    if (toast) {
        setTimeout(() => {
            toast.style.transition = 'opacity 0.4s';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }
</script>

<script>
function toggleUpload(id) {
    const el = document.getElementById('uploadForm' + id);

    if (el.style.display === 'none') {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}
</script>


</body>
</html>