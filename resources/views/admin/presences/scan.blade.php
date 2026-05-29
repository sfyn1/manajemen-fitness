@extends('layouts.admin')

@section('content')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">

    {{-- PAGE HEADER - SAMA DENGAN HALAMAN LAIN (contoh: history, presence-history) --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Scan Presensi Member</h2>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge scan-status-badge px-3 py-2" id="scanner-status-badge">
                        <span class="status-dot-inline"></span> Scanner Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="row g-4">

        {{-- SCANNER AREA - LEBIH LEBAR --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card scan-camera-card border-0 shadow-sm h-100">
                <div class="card-body p-0">
                    {{-- QR Reader --}}
                    <div id="reader" class="scan-reader-wrapper"></div>

                    {{-- Loading Indicator --}}
                    <div id="loading-indicator" class="d-none text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-3 fw-semibold text-muted">Memproses data kehadiran...</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RESULT AREA --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card scan-result-card border-0 shadow-sm mb-4 h-auto">
                <div class="card-body text-center p-4">
                    <div id="result-area">
                        <div class="waiting-state">
                            <div class="waiting-icon-wrapper mb-3">
                                <i class="feather-monitor"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Menunggu Scan...</h5>
                            <p class="text-white-50 mb-0 small">Silakan scan kartu member untuk mencatat presensi.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Live Stats Mini --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-semibold text-dark" style="font-size:13px;">
                            <i class="feather-bar-chart-2 me-1 text-primary"></i> Statistik Hari Ini
                        </span>
                    </div>
                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <div class="p-2 rounded-2" style="background:#eef2ff;">
                                <div class="fw-bold fs-5" style="color:#3d5af1;" id="stat-total">{{ $recentPresences->total() }}</div>
                                <div style="font-size:11px; color:#6b7280;">Total Hadir</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-2" style="background:#ecfdf5;">
                                <div class="fw-bold fs-5" style="color:#16a34a;" id="stat-last-time">—</div>
                                <div style="font-size:11px; color:#6b7280;">Scan Terakhir</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KEHADIRAN HARI INI - BAWAH FULL WIDTH --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center justify-content-between border-bottom py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:6px; height:20px; background: linear-gradient(180deg, #4e73df, #224abe); border-radius:3px;"></div>
                        <h6 class="fw-bold mb-0" id="presence-header-title">Kehadiran Hari Ini ({{ $recentPresences->total() }})</h6>
                    </div>
                    <span class="badge bg-primary-subtle text-primary px-3 py-2" style="font-size:12px;">
                        <i class="feather-clock me-1" style="font-size:11px;"></i>Live Update
                    </span>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="presence-list">
                        @forelse($recentPresences as $presence)
                        <li class="list-group-item presence-item d-flex align-items-center px-4 py-3"
                            data-time="{{ strtotime($presence->check_in_time) }}">
                            <img
                                src="{{ $presence->member->photo ? asset('storage/' . $presence->member->photo) : asset('template/assets/images/avatar/1.png') }}"
                                class="rounded-circle me-3 border border-2"
                                width="42" height="42"
                                style="object-fit: cover;">
                            <div class="flex-fill">
                                <h6 class="mb-0 fw-bold" style="font-size:14px;">{{ $presence->member->user->name }}</h6>
                                <small class="text-muted time-display">{{ date('H:i', strtotime($presence->check_in_time)) }} WIB</small>
                            </div>
                            <span class="badge bg-success px-3 py-2">Hadir</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted py-5">
                            <i class="feather-users mb-2 d-block" style="font-size: 28px; opacity: 0.3;"></i>
                            Belum ada yang hadir hari ini.
                        </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
                    <div class="text-muted" style="font-size:13px;">
                        Menampilkan
                        <strong>{{ $recentPresences->firstItem() ?? 0 }}</strong>
                        –
                        <strong>{{ $recentPresences->lastItem() ?? 0 }}</strong>
                        dari
                        <strong>{{ $recentPresences->total() }}</strong>
                        kehadiran hari ini
                    </div>
                    <div>
                        {{ $recentPresences->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>{{-- END CONTAINER --}}

<style>
/* ===== PAGE HEADER BADGE ===== */
.scan-status-badge {
    background: linear-gradient(135deg, #28a745, #20c74a);
    color: white;
    font-size: 12px;
    font-weight: 600;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.status-dot-inline {
    width: 8px;
    height: 8px;
    background: #fff;
    border-radius: 50%;
    display: inline-block;
    animation: pulse-dot 1.5s infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}

/* ===== CAMERA CARD ===== */
.scan-camera-card {
    border-radius: 16px !important;
    overflow: hidden;
}
.scan-card-header {
    background: #f8faff;
    padding: 16px 20px;
    border-bottom: 1px solid #eef2f6 !important;
}
.scan-icon-circle {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #4e73df, #224abe);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}

/* ===== QR READER WRAPPER ===== */
.scan-reader-wrapper {
    width: 100%;
    min-height: 380px;
    background: #0d0d0d;
    border-radius: 12px;
    overflow: hidden;
}

/* Override html5-qrcode default styling */
#reader {
    border: none !important;
}
#reader video {
    border-radius: 12px;
}
#reader__scan_region {
    background: transparent !important;
}
#reader__dashboard {
    background: #f8faff !important;
    border-top: 1px solid #eef2f6 !important;
    padding: 10px !important;
    border-radius: 0 0 12px 12px;
}
#reader__dashboard_section_swaplink {
    display: none !important;
}
#reader__status_span {
    font-size: 12px !important;
    color: #6c757d !important;
}
#reader__dashboard button {
    background: linear-gradient(135deg, #4e73df, #224abe) !important;
    color: white !important;
    border: none !important;
    padding: 8px 20px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
}
#reader__dashboard button:hover {
    opacity: 0.9 !important;
    transform: translateY(-1px) !important;
}
#html5-qrcode-anchor-scan-type-change {
    display: none !important;
}

/* ===== RESULT CARD ===== */
.scan-result-card {
    border-radius: 16px !important;
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: white;
    min-height: 220px;
}
.waiting-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 28px;
    color: rgba(255, 255, 255, 0.7);
}

/* ===== INFO BOX (dalam result) ===== */
.info-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: rgba(255, 255, 255, 0.75);
    font-weight: 600;
    margin-bottom: 4px;
}
.info-value {
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;
}
.info-box {
    background: rgba(255, 255, 255, 0.15);
    padding: 14px;
    border-radius: 10px;
    margin-top: 14px;
    backdrop-filter: blur(4px);
}

/* ===== PRESENCE LIST ===== */
.presence-item {
    transition: background 0.2s ease;
    border-bottom: 1px solid #f2f4f7 !important;
}
.presence-item:last-child {
    border-bottom: none !important;
}
.presence-item:hover {
    background: #f8faff;
}

/* ===== PAGINATION ===== */
.card-footer .pagination {
    margin: 0 !important;
}
.card-footer .pagination .page-item .page-link {
    font-size: 13px;
    padding: 5px 10px;
    border-radius: 6px !important;
    margin: 0 2px;
    border-color: #e2e8f0;
    color: #4e73df;
}
.card-footer .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4e73df, #224abe);
    border-color: #4e73df;
    color: #fff;
}
.card-footer .pagination .page-item.disabled .page-link {
    color: #adb5bd;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .scan-reader-wrapper {
        min-height: 280px;
    }
    .card-footer {
        flex-direction: column;
        align-items: flex-start !important;
    }
}
</style>

<script>
// Token CSRF untuk AJAX
const csrfToken = "{{ csrf_token() }}";

// --- KONFIGURASI AUDIO (FILE LOKAL) ---
const successSound = new Audio("{{ asset('audio/success.mp3') }}");
const errorSound = new Audio("{{ asset('audio/error.mp3') }}");
successSound.preload = 'auto';
errorSound.preload = 'auto';

// --- UPDATE WAKTU REALTIME ---
function updateTimeDisplays() {
    const now = Math.floor(Date.now() / 1000);
    document.querySelectorAll('.time-display').forEach(element => {
        const listItem = element.closest('li');
        const checkInTime = parseInt(listItem.getAttribute('data-time'));
        const diffSeconds = now - checkInTime;

        if (diffSeconds < 60) {
            element.textContent = 'Baru saja';
            element.classList.add('text-success');
            element.classList.remove('text-muted');
        } else if (diffSeconds < 300) {
            const minutes = Math.floor(diffSeconds / 60);
            element.textContent = minutes + ' menit yang lalu';
            element.classList.add('text-success');
            element.classList.remove('text-muted');
        } else {
            const date = new Date(checkInTime * 1000);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            element.textContent = hours + ':' + minutes + ' WIB';
            element.classList.remove('text-success');
            element.classList.add('text-muted');
        }
    });
}

setInterval(updateTimeDisplays, 10000);
document.addEventListener('DOMContentLoaded', updateTimeDisplays);

// --- FUNGSI SAAT SCAN ---
function onScanSuccess(decodedText, decodedResult) {
    // Matikan scanner sementara
    html5QrcodeScanner.pause();

    // Tampilkan loading
    document.getElementById('loading-indicator').classList.remove('d-none');
    document.getElementById('reader').classList.add('d-none');

    // Update stat terakhir
    const now = new Date();
    const h = String(now.getHours()).padStart(2, '0');
    const m = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('stat-last-time').textContent = h + ':' + m;

    // Kirim ID ke Server via AJAX
    fetch("{{ route('admin.presences.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ member_id: decodedText })
    })
    .then(response => response.json())
    .then(data => {
        handleResponse(data);
    })
    .catch(error => {
        console.error('Error:', error);
        errorSound.play();
        Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
    })
    .finally(() => {
        setTimeout(() => {
            document.getElementById('loading-indicator').classList.add('d-none');
            document.getElementById('reader').classList.remove('d-none');
            html5QrcodeScanner.resume();
        }, 3000);
    });
}

// --- HANDLE RESPON DARI SERVER ---
function handleResponse(data) {
    const resultArea = document.getElementById('result-area');

    if (data.status === 'success') {
        successSound.play();

        resultArea.innerHTML = `
            <div class="animate__animated animate__zoomIn">
                <img src="${data.photo}" class="rounded-circle border border-3 border-white mb-3" width="80" height="80" style="object-fit:cover;">
                <h4 class="fw-bold text-white mb-1">${data.member}</h4>
                <span class="badge bg-success mb-3">Kunjungan ke-${data.visit_count} Hari Ini</span>
                <div class="info-box">
                    <div class="row text-start">
                        <div class="col-6 border-end border-light">
                            <div class="info-label">MEMBER SEJAK</div>
                            <div class="info-value">${data.join_date}</div>
                        </div>
                        <div class="col-6 ps-3">
                            <div class="info-label">BERLAKU HINGGA</div>
                            <div class="info-value text-warning">${data.expiry_date}</div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Update list kehadiran
        const list = document.getElementById('presence-list');
        const currentTimestamp = Math.floor(Date.now() / 1000);
        const newItem = `
            <li class="list-group-item presence-item d-flex align-items-center px-4 py-3 animate__animated animate__fadeIn" data-time="${currentTimestamp}">
                <img src="${data.photo}" class="rounded-circle me-3 border border-2" width="42" height="42" style="object-fit:cover;">
                <div class="flex-fill">
                    <h6 class="mb-0 fw-bold" style="font-size:14px;">${data.member}</h6>
                    <small class="text-success time-display">Baru saja</small>
                </div>
                <span class="badge bg-success px-3 py-2">Hadir</span>
            </li>
        `;
        list.insertAdjacentHTML('afterbegin', newItem);

        // Update counter
        const currentCount = list.querySelectorAll('li:not(.text-center)').length;
        document.getElementById('presence-header-title').textContent = `Kehadiran Hari Ini (${currentCount})`;
        document.getElementById('stat-total').textContent = currentCount;

        updateTimeDisplays();

        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false });

    } else {
        errorSound.play();

        if (data.status === 'error') {
            Swal.fire({ icon: 'error', title: 'Akses Ditolak!', text: data.message });
            resultArea.innerHTML = `
                <div class="animate__animated animate__shakeX">
                    <div class="waiting-icon-wrapper mb-3" style="background:rgba(220,53,69,0.2);">
                        <i class="feather-x-circle" style="color:#ff6b6b;font-size:28px;"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Gagal!</h5>
                    <p class="text-white-50 small mb-0">${data.message}</p>
                </div>
            `;
        } else {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: data.message });
        }
    }
}

// Inisialisasi Scanner
let config = {
    fps: 10,
    qrbox: { width: 300, height: 300 }
};
let html5QrcodeScanner = new Html5QrcodeScanner("reader", config, false);
html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection