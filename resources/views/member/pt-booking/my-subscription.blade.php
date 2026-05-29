@extends('layouts.member')

@section('title', 'Langganan PT Saya')

@push('styles')
<style>
    .page-header { margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; }
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
    .alert-ok   { background: rgba(34,197,94,0.10);  border: 1px solid rgba(34,197,94,0.22);  color: #86efac; }
    .alert-err  { background: rgba(239,68,68,0.10);  border: 1px solid rgba(239,68,68,0.22);  color: #fca5a5; }

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

    .btn-outline-custom {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: transparent;
        color: var(--accent);
        border: 1px solid var(--accent);
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .btn-outline-custom:hover { background: rgba(245,158,11,0.1); }

    /* Cards */
    .sub-card {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .sub-header {
        background: rgba(255,255,255,0.03);
        border-bottom: 1px solid var(--border);
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .coach-info { display: flex; align-items: center; gap: 1rem; }
    .coach-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(99,102,241,0.15);
        color: #818cf8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 800;
        font-family: 'Syne', sans-serif;
    }
    .coach-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.2rem; color: #fff; margin-bottom: 2px; }
    .pkg-meta { font-size: 0.85rem; color: var(--text-muted); }

    .sub-badges { display: flex; gap: 8px; flex-wrap: wrap; }
    .status-badge { padding: 6px 14px; border-radius: 999px; font-size: 0.8rem; font-weight: 600; white-space: nowrap; display: inline-block; text-align: center; }
    .sb-active { background: rgba(34,197,94,0.1); color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }
    .sb-pending { background: rgba(245,158,11,0.1); color: #fbbf24; border: 1px solid rgba(245,158,11,0.2); }
    .sb-expired { background: rgba(255,255,255,0.05); color: var(--text-muted); border: 1px solid var(--border); }
    .sb-unpaid { background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
    .sb-paid { background: rgba(34,197,94,0.1); color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }

    .sub-body { padding: 1.5rem; }
    
    .panel-box {
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.25rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .panel-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.9rem; color: #fff; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px; }
    
    .prog-num { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 2.5rem; color: var(--accent); line-height: 1; text-align: center; margin-bottom: 5px; }
    .prog-txt { text-align: center; color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem; }
    
    .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.85rem; }
    .info-row:last-child { margin-bottom: 0; }
    .info-lbl { color: var(--text-muted); }
    .info-val { color: #fff; font-weight: 600; }

    .table-sessions { width: 100%; font-size: 0.875rem; border-collapse: separate; border-spacing: 0; }
    .table-sessions th { padding: 12px; background: rgba(255,255,255,0.03); color: var(--text-muted); font-weight: 600; text-align: left; border-bottom: 1px solid var(--border); }
    .table-sessions td { padding: 12px; border-bottom: 1px solid var(--border); color: #e2e8f0; }
    .table-sessions tr:last-child td { border-bottom: none; }

    .btn-action {
        background: rgba(255,255,255,0.05);
        color: #e2e8f0;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        padding: 0;
    }
    .btn-action:hover { background: rgba(255,255,255,0.1); color: #fff; transform: translateY(-1px); }
    .btn-action.text-warning:hover { background: rgba(245,158,11,0.1); color: #fbbf24 !important; border-color: rgba(245,158,11,0.3); }
    .btn-action.text-danger:hover { background: rgba(239,68,68,0.1); color: #f87171 !important; border-color: rgba(239,68,68,0.3); }
    .action-group { display: flex; gap: 6px; justify-content: flex-end; }

    /* Empty */
    .empty-state { text-align: center; padding: 5rem 1.5rem; }
    .empty-icon  { font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.5; }
    .empty-state h5 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.2rem; color: #fff; margin-bottom: 8px; }
    .empty-state p { color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem; }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div>
            <h1>Langganan PT Saya</h1>
            <p>Riwayat dan status langganan Personal Trainer Anda</p>
        </div>
        <a href="{{ route('member.pt.index') }}" class="btn-outline-custom">
            <i class="feather-plus"></i> Daftar PT Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert-custom alert-ok"><i class="feather-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-custom alert-err"><i class="feather-x-circle"></i> {{ session('error') }}</div>
    @endif

    @forelse($subscriptions as $sub)
    <div class="sub-card">
        <div class="sub-header">
            <div class="coach-info">
                <div class="coach-avatar">{{ substr($sub->coach->name, 0, 1) }}</div>
                <div>
                    <div class="coach-name">{{ $sub->coach->name }}</div>
                    <div class="pkg-meta">{{ $sub->package->name }} · {{ $sub->package->duration_minutes }} menit/sesi</div>
                </div>
            </div>
            <div class="sub-badges">
                <span class="status-badge {{ $sub->status === 'active' ? 'sb-active' : ($sub->status === 'pending' ? 'sb-pending' : 'sb-expired') }}">
                    {{ $sub->status_label }}
                </span>
                @if($sub->payment_status === 'unpaid')
                    <span class="status-badge sb-unpaid"><i class="feather-alert-circle me-1"></i>Belum Bayar</span>
                @else
                    <span class="status-badge sb-paid"><i class="feather-check me-1"></i>Lunas</span>
                @endif
            </div>
        </div>

        <div class="sub-body">
            <div class="row g-3 mb-4">
                {{-- Progress Sesi --}}
                <div class="col-md-4">
                    <div class="panel-box">
                        <div class="prog-num">{{ $sub->sessions_used }}</div>
                        <div class="prog-txt">dari {{ $sub->sessions_total }} sesi selesai</div>
                        <div class="progress mb-2" style="height: 8px; border-radius: 10px; background: rgba(255,255,255,0.1);">
                            <div class="progress-bar" style="width: {{ $sub->progress_percent }}%; background: var(--accent); border-radius: 10px;"></div>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size:0.8rem;">
                            <span class="text-muted">Progress</span>
                            <span style="color:var(--accent); font-weight:600;">Sisa: {{ $sub->sessions_left }} sesi</span>
                        </div>
                    </div>
                </div>

                {{-- Info Periode --}}
                <div class="col-md-4">
                    <div class="panel-box">
                        <div class="panel-title"><i class="feather-calendar text-primary"></i> Periode Aktif</div>
                        @if($sub->start_date)
                            <div class="info-row">
                                <span class="info-lbl">Mulai</span>
                                <span class="info-val">{{ $sub->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-lbl">Berakhir</span>
                                <span class="info-val">{{ $sub->end_date?->format('d M Y') ?? '-' }}</span>
                            </div>
                        @else
                            <p class="text-muted small fst-italic mb-0">Menunggu konfirmasi admin untuk mengatur periode aktif</p>
                        @endif
                        <hr style="border-color:var(--border); margin:12px 0;">
                        <div class="info-row">
                            <span class="info-lbl">Harga Paket</span>
                            <span class="info-val text-success">Rp {{ number_format($sub->package->price, 0, ',', '.') }}</span>
                        </div>
                        @if($sub->payment_status === 'unpaid')
                            <div class="mt-2" style="font-size:0.75rem; color:#fcd34d;"><i class="feather-alert-circle me-1"></i>Bayar saat sesi pertama di admin</div>
                        @endif
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-md-4">
                    <div class="panel-box text-center" style="background:rgba(255,255,255,0.01);">
                        @if($sub->status === 'active' && $sub->sessions_left > 0)
                            <a href="{{ route('member.pt.sessions.create', $sub->id) }}" class="btn-new w-100 justify-content-center mb-2">
                                <i class="feather-plus-circle"></i> Book Sesi Baru
                            </a>
                            <small class="text-muted">Pilih tanggal & jam latihan Anda</small>
                        @elseif($sub->status === 'pending')
                            <i class="feather-clock d-block mb-2 text-warning fs-3"></i>
                            <div class="text-warning fw-bold mb-1" style="font-size:0.9rem;">Menunggu konfirmasi admin</div>
                            <small class="text-muted">Anda belum bisa booking sesi</small>
                        @elseif($sub->sessions_left === 0)
                            <i class="feather-award d-block mb-2 text-success fs-3"></i>
                            <div class="text-success fw-bold" style="font-size:0.9rem;">Semua sesi telah selesai! 🎉</div>
                        @else
                            <i class="feather-x-circle d-block mb-2 opacity-25 fs-3 text-muted"></i>
                            <small class="text-muted">Langganan tidak aktif</small>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Daftar Sesi --}}
            @if($sub->sessions->isNotEmpty())
            <div class="panel-title"><i class="feather-list text-primary"></i> Riwayat & Jadwal Sesi</div>
            <div style="overflow-x:auto; border:1px solid var(--border); border-radius:12px;">
                <table class="table-sessions">
                    <thead>
                        <tr>
                            <th style="width:50px; text-align:center;">#</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sub->sessions->sortBy('session_number') as $session)
                        <tr>
                            <td style="text-align:center;"><span style="background:rgba(255,255,255,0.1); padding:2px 8px; border-radius:4px; font-weight:700;">{{ $session->session_number }}</span></td>
                            <td>
                                <div class="fw-bold" style="white-space: nowrap;">{{ \Carbon\Carbon::parse($session->session_date)->locale('id')->translatedFormat('l, d M Y') }}</div>
                                @if($session->rescheduled_at)
                                    <div style="font-size:0.75rem; color:#fbbf24;"><i class="feather-refresh-cw me-1"></i>Diubah dari {{ $session->rescheduled_from_date?->format('d/m') }}</div>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $session->time_range }}</td>
                            <td>
                                <span class="status-badge {{ $session->status === 'scheduled' ? 'sb-pending' : ($session->status === 'completed' ? 'sb-paid' : 'sb-expired') }}">{{ $session->status_label }}</span>
                            </td>
                            <td><span class="text-muted" style="font-size:0.8rem;">{{ $session->notes ?: '-' }}</span></td>
                            <td style="text-align:right;">
                                @if($session->isReschedulable())
                                    <div class="action-group">
                                        <button class="btn-action text-warning" title="Ubah Jadwal" onclick="openReschedule({{ $session->id }}, '{{ $session->session_date->format('Y-m-d') }}', '{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}')"><i class="feather-refresh-cw"></i></button>
                                        <button class="btn-action text-danger" title="Batalkan Sesi" onclick="cancelSession({{ $session->id }})"><i class="feather-x"></i></button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 text-muted border border-dashed rounded-3 mt-3" style="border-color:var(--border) !important;">
                <i class="feather-calendar d-block mb-2 opacity-50 fs-3"></i>
                <small>Belum ada sesi yang dijadwalkan</small>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <span class="empty-icon">🏋️</span>
        <h5>Belum ada langganan PT</h5>
        <p>Pilih Personal Trainer dan mulai perjalanan fitness Anda!</p>
        <a href="{{ route('member.pt.index') }}" class="btn-new" style="display:inline-flex;">
            <i class="feather-plus"></i> Daftar PT Sekarang
        </a>
    </div>
    @endforelse

@endsection

@push('modals')
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="feather-x-circle me-2 text-danger"></i>Batalkan Sesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="cancelForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning border-0" style="background: rgba(245,158,11,0.1); color: #fbbf24; font-size:0.85rem;">
                        <i class="feather-alert-triangle me-2"></i>
                        Pembatalan hanya bisa dilakukan <strong>H-1 (sehari sebelum sesi)</strong>. Sesi yang dibatalkan tetap dihitung dari kuota Anda.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan Pembatalan</label>
                        <textarea name="cancel_reason" class="form-control" rows="3" placeholder="Tuliskan alasan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger">Batalkan Sesi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rescheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="feather-refresh-cw me-2 text-warning"></i>Ubah Jadwal Sesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rescheduleForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0 mb-4" style="background: rgba(14,165,233,0.1); color: #7dd3fc; font-size:0.85rem;">
                        Perubahan jadwal hanya bisa dilakukan <strong>H-1</strong> sebelum sesi. Jam operasional: <strong>07:00 – 22:00</strong> (Senin–Sabtu).
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Baru</label>
                        <input type="date" name="session_date" id="rescheduleDate" class="form-control" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" onchange="loadRescheduleSlots()" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam Mulai Baru</label>
                        <select name="start_time" id="rescheduleTime" class="form-select" required>
                            <option value="">-- Pilih tanggal dulu --</option>
                        </select>
                    </div>
                    <div id="reschedulePreview" class="alert alert-success border-0 mt-3" style="display:none; background:rgba(34,197,94,0.1); color:#86efac; font-size:0.85rem;">
                        <span id="previewRescheduleText"></span>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush


@push('scripts')
<script>
function cancelSession(sessionId) {
    document.getElementById('cancelForm').action = '/member/personal-trainer/cancel-session/' + sessionId;
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}

function openReschedule(sessionId, currentDate, currentTime) {
    document.getElementById('rescheduleForm').action = '/member/personal-trainer/reschedule-session/' + sessionId;
    document.getElementById('rescheduleDate').value = '';
    document.getElementById('rescheduleTime').innerHTML = '<option value="">-- Pilih tanggal dulu --</option>';
    document.getElementById('reschedulePreview').style.display = 'none';
    new bootstrap.Modal(document.getElementById('rescheduleModal')).show();
}

function loadRescheduleSlots() {
    const date = document.getElementById('rescheduleDate').value;
    if (!date) return;
    const d = new Date(date + 'T00:00:00');
    if (d.getDay() === 0) {
        document.getElementById('rescheduleTime').innerHTML = '<option value="">Gym tutup Minggu</option>';
        return;
    }
    let html = '<option value="">-- Pilih Jam --</option>';
    for (let h = 7; h <= 21; h++) {
        const hour = h.toString().padStart(2, '0') + ':00';
        html += `<option value="${hour}">${hour}</option>`;
    }
    document.getElementById('rescheduleTime').innerHTML = html;
    document.getElementById('rescheduleTime').addEventListener('change', function() {
        if (this.value) {
            const dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            document.getElementById('previewRescheduleText').textContent =
                `Jadwal baru: ${dayNames[d.getDay()]}, ${d.getDate()} ${monthNames[d.getMonth()]} ${d.getFullYear()} pukul ${this.value}`;
            document.getElementById('reschedulePreview').style.display = 'block';
        }
    });
}
</script>
@endpush
