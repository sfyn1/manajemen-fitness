@extends('layouts.member')

@section('title', 'Jadwal Kelas')

@push('styles')
<style>
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
@endpush

@section('content')
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

                <div class="time-row" style="margin-top: -0.5rem;">
                    <div class="time-icon" style="background: rgba(34,197,94,0.12); color: #22c55e; font-weight: 800; font-family: 'Syne', sans-serif; font-size: 0.85rem;">Rp</div>
                    <div>
                        <span class="time-label">Biaya Sesi Kelas</span>
                        <span class="time-value" style="color: #4ade80;">
                            @if($class['price'] > 0)
                                Rp {{ number_format($class['price'], 0, ',', '.') }}
                                <span style="display:block; font-size:0.68rem; color:var(--text-muted); font-weight:normal;">Bayar di tempat setelah sesi selesai</span>
                            @else
                                Gratis (Sudah Termasuk Membership)
                            @endif
                        </span>
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
@endsection