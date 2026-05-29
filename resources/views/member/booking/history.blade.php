@extends('layouts.member')

@section('title', 'Kelas Saya')

@push('styles')
<style>
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            gap: 1rem;
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

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, var(--accent), #fb923c);
            color: #0f172a;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            white-space: nowrap;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-new:hover { opacity: 0.88; transform: scale(1.02); color: #0f172a; }

        /* ══ STATS — compact pill row ══ */
        .stats-strip {
            display: flex;
            gap: 10px;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .stat-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 7px 16px 7px 7px;
            transition: border-color 0.2s, background 0.2s;
        }
        .stat-pill:hover { border-color: rgba(245,158,11,0.25); background: var(--dark-hover); }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }
        .si-total  { background: rgba(255,255,255,0.07); color: #e2e8f0; }
        .si-active { background: var(--accent-soft);     color: var(--accent); }
        .si-done   { background: rgba(148,163,184,0.10); color: var(--text-muted); }

        .stat-text { line-height: 1.2; }
        .stat-num  {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            color: #fff;
        }
        .stat-lbl { font-size: 0.72rem; color: var(--text-muted); }
        .stat-pill.hl .stat-num { color: var(--accent); }

        /* ══ BOOKING LIST ══ */
        .booking-list { display: flex; flex-direction: column; gap: 10px; }

        .booking-item {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: border-color 0.2s, background 0.2s, transform 0.2s;
            animation: slideIn 0.35s ease both;
        }
        .booking-item:hover { border-color: rgba(245,158,11,0.22); background: var(--dark-hover); transform: translateX(2px); }
        .booking-item.finished { opacity: 0.6; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .booking-item:nth-child(1) { animation-delay: 0.04s; }
        .booking-item:nth-child(2) { animation-delay: 0.08s; }
        .booking-item:nth-child(3) { animation-delay: 0.12s; }
        .booking-item:nth-child(4) { animation-delay: 0.16s; }
        .booking-item:nth-child(5) { animation-delay: 0.20s; }

        .b-bar {
            width: 3px;
            min-height: 44px;
            align-self: stretch;
            border-radius: 4px;
            flex-shrink: 0;
        }
        .b-bar.act  { background: linear-gradient(180deg, var(--accent), #fb923c); }
        .b-bar.done { background: rgba(148,163,184,0.22); }

        .b-code {
            font-family: 'Courier New', monospace;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 4px 10px;
            border-radius: 6px;
            flex-shrink: 0;
            white-space: nowrap;
        }
        .b-code.act  { background: var(--accent-soft); color: var(--accent); border: 1px solid rgba(245,158,11,0.18); }
        .b-code.done { background: rgba(255,255,255,0.04); color: var(--text-muted); border: 1px solid var(--border); }

        .b-info { flex: 1; min-width: 0; }
        .b-class {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 4px;
        }
        .b-meta { display: flex; flex-wrap: wrap; gap: 10px; }
        .b-meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.775rem;
            color: var(--text-muted);
        }
        .b-meta-item i { font-size: 10px; color: var(--accent); }

        .b-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .badge-pill {
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.73rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .bp-active { background: rgba(34,197,94,0.10); color: var(--success); border: 1px solid rgba(34,197,94,0.18); }
        .bp-done   { background: rgba(255,255,255,0.05); color: var(--text-muted); border: 1px solid var(--border); }

        .btn-cancel {
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(239,68,68,0.10);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            padding: 5px 11px;
            border-radius: 7px;
            font-size: 0.775rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            white-space: nowrap;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-cancel:hover { background: rgba(239,68,68,0.22); color: #fff; }

        /* Empty */
        .empty-state { text-align: center; padding: 5rem 1.5rem; }
        .empty-icon  { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
        .empty-state h5 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 8px;
        }
        .empty-state p { color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem; }

        @media (max-width: 580px) {
            .page-header h1 { font-size: 1.6rem; }
            .b-code { display: none; }
            .b-right { flex-direction: column; align-items: flex-end; gap: 5px; }
        }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div>
            <h1>Kelas Saya</h1>
            <p>Semua booking kelas latihan Anda.</p>
        </div>
        <a href="{{ route('booking.index') }}" class="btn-new">
            <i class="feather-plus"></i> Booking Kelas Baru
        </a>
    </div>

    {{-- Stats --}}

    <div class="stats-strip">
        <div class="stat-pill">
            <div class="stat-icon si-total"><i class="feather-layers"></i></div>
            <div class="stat-text">
                <div class="stat-num">{{ $totalBookings }}</div>
                <div class="stat-lbl">Total Booking</div>
            </div>
        </div>
        <div class="stat-pill hl">
            <div class="stat-icon si-active"><i class="feather-calendar"></i></div>
            <div class="stat-text">
                <div class="stat-num">{{ $activeBookings }}</div>
                <div class="stat-lbl">Terjadwal</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-icon si-done"><i class="feather-check-circle"></i></div>
            <div class="stat-text">
                <div class="stat-num">{{ $doneBookings }}</div>
                <div class="stat-lbl">Selesai</div>
            </div>
        </div>
    </div>

    {{-- List --}}
    @if($bookings->isEmpty())
        <div class="empty-state">
            <span class="empty-icon">🏋️</span>
            <h5>Belum Ada Kelas</h5>
            <p>Anda belum memiliki jadwal latihan.<br>Yuk mulai booking kelas pertama!</p>
            <a href="{{ route('booking.index') }}" class="btn-new" style="display:inline-flex;">
                <i class="feather-plus"></i> Cari Kelas
            </a>
        </div>
    @else
        <div class="booking-list">
            @foreach($bookings as $booking)
            @php $isPast = \Carbon\Carbon::parse($booking->date)->isPast(); @endphp
            <div class="booking-item {{ $isPast ? 'finished' : '' }}">
                <div class="b-bar {{ $isPast ? 'done' : 'act' }}"></div>
                <div class="b-code {{ $isPast ? 'done' : 'act' }}">{{ $booking->booking_code }}</div>
                <div class="b-info">
                    <div class="b-class">{{ $booking->schedule->classType->name }}</div>
                    <div class="b-meta">
                        <div class="b-meta-item"><i class="feather-user"></i> Coach {{ $booking->schedule->coach->name }}</div>
                        <div class="b-meta-item"><i class="feather-calendar"></i> {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('l, d F Y') }}</div>
                        <div class="b-meta-item"><i class="feather-clock"></i> {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} WIB</div>
                    </div>
                </div>
                <div class="b-right">
                    @if($isPast)
                        <span class="badge-pill bp-done">Selesai</span>
                    @else
                        <span class="badge-pill bp-active">Terjadwal</span>
                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin membatalkan booking ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-cancel"><i class="feather-x"></i> Batal</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
@endsection