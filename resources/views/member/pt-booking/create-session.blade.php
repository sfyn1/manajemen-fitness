@extends('layouts.member')

@section('title', 'Book Sesi PT')

@push('styles')
<style>
    .page-header { margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; }
    .page-header h1 { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.8rem; color: #fff; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
    .page-header p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0; }

    .btn-back { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.05); color: #e2e8f0; padding: 8px 14px; border-radius: 8px; border: 1px solid var(--border); text-decoration: none; font-size: 0.85rem; transition: all 0.2s; }
    .btn-back:hover { background: rgba(255,255,255,0.1); color: #fff; }

    /* Info Cards */
    .info-card { background: var(--dark-card); border: 1px solid var(--border); border-radius: 14px; padding: 1.25rem; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; }
    .info-card.primary { background: linear-gradient(135deg, var(--accent), #fb923c); color: #0f172a; border: none; }
    .info-val { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.8rem; margin-bottom: 2px; }
    .info-lbl { font-size: 0.8rem; opacity: 0.8; }
    
    .info-card:not(.primary) .info-val { color: #fff; font-size: 1.3rem; }
    .info-card:not(.primary) .info-lbl { color: var(--text-muted); }

    /* Form Cards */
    .form-card { background: var(--dark-card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; height: 100%; }
    .fc-header { background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border); padding: 1.25rem 1.5rem; font-family: 'Syne', sans-serif; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px; }
    .fc-body { padding: 1.5rem; }

    .form-label { color: #e2e8f0; font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; display: block; }
    .form-control { background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: #fff; border-radius: 8px; padding: 10px 12px; width: 100%; font-family: 'DM Sans', sans-serif; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: var(--accent); background: rgba(255,255,255,0.08); }

    /* Slot Buttons */
    .slot-btn { background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: #e2e8f0; border-radius: 8px; padding: 10px; width: 100%; cursor: pointer; transition: all 0.2s; text-align: center; }
    .slot-btn:hover:not(:disabled) { border-color: var(--accent); color: var(--accent); }
    .slot-btn.selected { background: var(--accent-soft); border-color: var(--accent); color: var(--accent); }
    
    .slot-btn.disabled-booked { background: rgba(239,68,68,0.05); border-color: rgba(239,68,68,0.2); color: #f87171; cursor: not-allowed; opacity: 0.7; }
    .slot-btn.disabled-past { background: rgba(255,255,255,0.02); border-color: var(--border); color: var(--text-muted); cursor: not-allowed; opacity: 0.5; }

    .slot-time { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; margin-bottom: 2px; }
    .slot-end { font-size: 0.7rem; opacity: 0.8; }

    .btn-submit { background: linear-gradient(135deg, var(--accent), #fb923c); color: #0f172a; border: none; padding: 14px; border-radius: 10px; font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; width: 100%; cursor: pointer; transition: opacity 0.2s, transform 0.15s; }
    .btn-submit:hover:not(:disabled) { opacity: 0.9; transform: scale(1.01); }
    .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; background: rgba(255,255,255,0.1); color: var(--text-muted); }

    .alert-preview { background: rgba(14,165,233,0.1); border: 1px solid rgba(14,165,233,0.2); color: #38bdf8; padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 1rem; }

    .rules-list { padding-left: 1.2rem; color: var(--text-muted); font-size: 0.85rem; margin-top: 1rem; }
    .rules-list li { margin-bottom: 6px; }
    .rules-list strong { color: #e2e8f0; }

    .booked-list { list-style: none; padding: 0; margin: 0; font-size: 0.85rem; }
    .booked-list li { color: #f87171; padding: 6px 0; border-bottom: 1px dashed var(--border); }
    .booked-list li:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('member.pt.my-subscription') }}" class="btn-back"><i class="feather-arrow-left"></i></a>
            <div>
                <h1>📅 Book Sesi PT</h1>
                <p>{{ $subscription->coach->name }} · {{ $subscription->package->name }}</p>
            </div>
        </div>
    </div>

    {{-- Info Sisa Sesi --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="info-card primary">
                <div class="info-val">{{ $subscription->sessions_left }}</div>
                <div class="info-lbl">Sesi tersisa</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card">
                <div class="info-val">{{ $subscription->package->duration_minutes }}</div>
                <div class="info-lbl">Menit / sesi</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card">
                <div class="info-val" style="font-size:1.1rem;">{{ $subscription->member->expiry_date ? \Carbon\Carbon::parse($subscription->member->expiry_date)->format('d M Y') : '-' }}</div>
                <div class="info-lbl">Berlaku sampai</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card">
                <div class="info-val" style="font-size:1rem;">07:00 – 22:00</div>
                <div class="info-lbl">Senin – Sabtu</div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; padding: 12px 16px; border-radius: 10px; margin-bottom: 1.5rem; display:flex; align-items:center; gap:8px; font-size:0.875rem;">
        <i class="feather-x-circle"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Form Booking Sesi --}}
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="form-card">
                <div class="fc-header"><i class="feather-calendar text-primary"></i> Pilih Jadwal Sesi</div>
                <div class="fc-body">
                    <form action="{{ route('member.pt.sessions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

                        <div class="mb-4">
                            <label class="form-label">Tanggal Sesi <span style="color:#f87171;">*</span></label>
                            <input type="date" name="session_date" id="sessionDate" class="form-control"
                                min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                                max="{{ $subscription->member->expiry_date ? \Carbon\Carbon::parse($subscription->member->expiry_date)->format('Y-m-d') : '' }}"
                                onchange="loadAvailableSlots()"
                                value="{{ old('session_date') }}" required>
                            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:6px;"><i class="feather-info me-1"></i>Pilih hari Senin – Sabtu. Minggu libur.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Jam Mulai <span style="color:#f87171;">*</span></label>
                            <div id="timeSlots" class="row g-2">
                                <div class="col-12 text-center text-muted py-4 border border-dashed rounded" style="border-color:var(--border) !important; background:rgba(255,255,255,0.01);">
                                    <i class="feather-clock d-block mb-2 opacity-50 fs-3"></i>
                                    <span style="font-size:0.85rem;">Pilih tanggal terlebih dahulu</span>
                                </div>
                            </div>
                            <input type="hidden" name="start_time" id="selectedTime" required>
                        </div>

                        <div id="timePreview" class="alert-preview" style="display:none;">
                            <i class="feather-map-pin me-1"></i> <strong>Jadwal Dipilih:</strong> <span id="previewText"></span>
                        </div>

                        <button type="submit" class="btn-submit" id="bookBtn" disabled>
                            <i class="feather-check-circle me-1"></i> KONFIRMASI BOOKING
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="form-card">
                <div class="fc-header"><i class="feather-info text-primary"></i> Info & Aturan</div>
                <div class="fc-body">
                    <div id="bookedSlotsInfo" style="background:rgba(255,255,255,0.02); border:1px solid var(--border); padding:1rem; border-radius:10px; margin-bottom:1.5rem;">
                        <p class="text-muted small mb-0" style="text-align:center;"><i class="feather-calendar d-block mb-1 fs-4 opacity-50"></i>Pilih tanggal untuk melihat slot PT yang sudah terisi.</p>
                    </div>

                    <h6 style="color:#fff; font-size:0.95rem; font-weight:700;">Aturan Booking:</h6>
                    <ul class="rules-list">
                        <li>Jam operasional: <strong>07:00 – 22:00</strong></li>
                        <li>Durasi sesi: <strong>{{ $subscription->package->duration_minutes }} menit</strong></li>
                        <li>Gym buka: <strong>Senin – Sabtu</strong> (Minggu libur)</li>
                        <li>Pembatalan: <strong>H-1 sebelum sesi</strong></li>
                        <li>1 sesi = 1 anggota, PT eksklusif untuk Anda</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const bookedSlots = @json($bookedSlots);
const durationMinutes = {{ $subscription->package->duration_minutes }};

function generateHours() {
    const hours = [];
    for (let h = 7; h <= 21; h++) {
        hours.push(h.toString().padStart(2, '0') + ':00');
    }
    return hours;
}

function loadAvailableSlots() {
    const dateInput = document.getElementById('sessionDate').value;
    if (!dateInput) return;

    const date = new Date(dateInput + 'T00:00:00');
    if (date.getDay() === 0) { 
        document.getElementById('timeSlots').innerHTML = `
            <div class="col-12" style="background:rgba(239,68,68,0.1); color:#fca5a5; padding:12px; border-radius:8px; border:1px solid rgba(239,68,68,0.2); font-size:0.85rem; text-align:center;">
                <i class="feather-x-circle me-1"></i> Gym tutup hari Minggu. Pilih hari lain.
            </div>`;
        document.getElementById('bookBtn').disabled = true;
        document.getElementById('bookedSlotsInfo').innerHTML = '<p class="text-muted small mb-0 text-center">Tutup</p>';
        return;
    }

    const hours = generateHours();
    const booked = bookedSlots[dateInput] || [];
    const now = new Date();
    const isToday = dateInput === now.toISOString().split('T')[0];

    let html = '';
    hours.forEach(hour => {
        const [h, m] = hour.split(':').map(Number);
        
        let isPast = false;
        if (isToday) {
            const slotTime = new Date();
            slotTime.setHours(h, m, 0, 0);
            isPast = slotTime <= now;
        }

        let isBooked = false;
        const slotStart = h * 60 + m;
        const slotEnd = slotStart + durationMinutes;

        booked.forEach(b => {
            const [bStartH, bStartM] = b.start_time.split(':').map(Number);
            const [bEndH, bEndM] = b.end_time.split(':').map(Number);
            const bStart = bStartH * 60 + bStartM;
            const bEnd = bEndH * 60 + bEndM;

            if (slotStart < bEnd && slotEnd > bStart) {
                isBooked = true;
            }
        });

        const endHour = Math.floor(slotEnd / 60);
        const endMin = slotEnd % 60;
        const isOverLimit = endHour > 22 || (endHour === 22 && endMin > 0);

        const endTimeStr = endHour.toString().padStart(2, '0') + ':' + endMin.toString().padStart(2, '0');

        if (isBooked) {
            html += `<div class="col-4 col-sm-3 col-md-4 col-lg-3"><div class="slot-btn disabled-booked"><div class="slot-time">${hour}</div><div class="slot-end">Terisi</div></div></div>`;
        } else if (isPast) {
            html += `<div class="col-4 col-sm-3 col-md-4 col-lg-3"><div class="slot-btn disabled-past"><div class="slot-time">${hour}</div><div class="slot-end">Lewat</div></div></div>`;
        } else if (!isOverLimit) {
            html += `<div class="col-4 col-sm-3 col-md-4 col-lg-3"><div class="slot-btn selectable-slot" onclick="selectTime('${hour}', '${endTimeStr}', '${dateInput}', this)"><div class="slot-time">${hour}</div><div class="slot-end">s.d ${endTimeStr}</div></div></div>`;
        }
    });

    document.getElementById('timeSlots').innerHTML = html || '<div class="col-12 text-muted text-center py-3">Tidak ada slot tersedia</div>';

    updateBookedInfo(booked, dateInput);

    document.getElementById('selectedTime').value = '';
    document.getElementById('bookBtn').disabled = true;
    document.getElementById('timePreview').style.display = 'none';
}

function selectTime(start, end, date, el) {
    document.querySelectorAll('.selectable-slot').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');

    document.getElementById('selectedTime').value = start;
    document.getElementById('bookBtn').disabled = false;

    const dateObj = new Date(date + 'T00:00:00');
    const dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    document.getElementById('previewText').textContent =
        ` ${dayNames[dateObj.getDay()]}, ${dateObj.getDate()} ${monthNames[dateObj.getMonth()]} ${dateObj.getFullYear()} — ${start} s.d ${end}`;
    document.getElementById('timePreview').style.display = 'block';
}

function updateBookedInfo(booked, date) {
    const container = document.getElementById('bookedSlotsInfo');
    if (booked.length === 0) {
        container.innerHTML = '<div style="color:#4ade80; text-align:center; font-size:0.85rem;"><i class="feather-check-circle d-block mb-1 fs-4 opacity-75"></i>Semua slot tersedia untuk tanggal ini!</div>';
        return;
    }

    let html = `<div style="color:var(--text-muted); font-size:0.8rem; margin-bottom:8px;">Jadwal PT yang sudah terisi pada <strong>${date}</strong>:</div><ul class="booked-list">`;
    booked.forEach(b => {
        html += `<li><i class="feather-lock me-1" style="font-size:10px;"></i> ${b.start_time.substring(0,5)} – ${b.end_time.substring(0,5)}</li>`;
    });
    html += '</ul>';
    container.innerHTML = html;
}
</script>
@endpush
