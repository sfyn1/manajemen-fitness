@extends('layouts.admin')

@section('content')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="row mt-4">
        
        <!-- SCANNER AREA -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pt-3 pb-0 border-0">
                    <h5 class="fw-bold text-primary"><i class="feather-maximize me-1"></i> Scan QR Code Member</h5>
                </div>
                <div class="card-body text-center">
                    
                    <div id="reader" style="width: 100%; border-radius: 10px; overflow: hidden;"></div>
                    
                    <div class="mt-3">
                        <small class="text-muted">Arahkan QR Code kartu member ke kamera.</small>
                    </div>

                    <div id="loading-indicator" class="d-none mt-3">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 fw-bold">Memproses data...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULT AREA - KANAN ATAS -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white mb-3">
                <div class="card-body text-center p-4">
                    <div id="result-area">
                        <i class="feather-monitor fs-1 mb-3" style="opacity: 0.5;"></i>
                        <h4 class="fw-bold">Menunggu Scan...</h4>
                        <p class="text-white-50">Silakan scan kartu member untuk presensi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KEHADIRAN HARI INI - BAWAH FULL WIDTH -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="max-height: 400px; overflow-y: auto;">
                <div class="card-header bg-white sticky-top">
                    <h6 class="fw-bold mb-0">Kehadiran Hari Ini ({{ count($recentPresences) }})</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="presence-list">
                        @forelse($recentPresences as $presence)
                            <li class="list-group-item d-flex align-items-center" data-time="{{ strtotime($presence->check_in_time) }}">
                                <img src="{{ asset('template/assets/images/avatar/1.png') }}" class="rounded-circle me-3" width="40" height="40">
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $presence->member->user->name }}</h6>
                                    <small class="text-muted time-display">{{ date('H:i', strtotime($presence->check_in_time)) }} WIB</small>
                                </div>
                                <span class="badge bg-success ms-auto">Hadir</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-4">Belum ada yang hadir hari ini.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling untuk teks yang lebih jelas */
    .info-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.8) !important;
        font-weight: 600;
        margin-bottom: 4px;
    }
    
    .info-value {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff !important;
    }
    
    .info-box {
        background: rgba(255, 255, 255, 0.15);
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }
</style>

<script>
    // Token CSRF untuk AJAX
    const csrfToken = "{{ csrf_token() }}";
    
    // --- KONFIGURASI AUDIO (FILE LOKAL) ---
    // Menggunakan helper asset() agar mengarah ke folder public/audio
    const successSound = new Audio("{{ asset('audio/success.mp3') }}"); 
    const errorSound = new Audio("{{ asset('audio/error.mp3') }}");   
    
    // Preload audio agar saat diputar tidak ada delay (loading)
    successSound.preload = 'auto';
    errorSound.preload = 'auto';
    
    // --- UPDATE WAKTU REALTIME ---
    function updateTimeDisplays() {
        const now = Math.floor(Date.now() / 1000); // Unix timestamp sekarang
        
        document.querySelectorAll('.time-display').forEach(element => {
            const listItem = element.closest('li');
            const checkInTime = parseInt(listItem.getAttribute('data-time'));
            const diffSeconds = now - checkInTime;
            
            if (diffSeconds < 60) {
                element.textContent = 'Baru saja';
                element.classList.add('text-success');
                element.classList.remove('text-muted');
            } else if (diffSeconds < 300) { // Kurang dari 5 menit
                const minutes = Math.floor(diffSeconds / 60);
                element.textContent = minutes + ' menit yang lalu';
                element.classList.add('text-success');
                element.classList.remove('text-muted');
            } else {
                // Tampilkan jam normal
                const date = new Date(checkInTime * 1000);
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                element.textContent = hours + ':' + minutes + ' WIB';
                element.classList.remove('text-success');
                element.classList.add('text-muted');
            }
        });
    }
    
    // Update waktu setiap 10 detik
    setInterval(updateTimeDisplays, 10000);
    document.addEventListener('DOMContentLoaded', updateTimeDisplays);
    
    // --- FUNGSI SAAT SCAN ---
    function onScanSuccess(decodedText, decodedResult) {
        
        // Matikan scanner sementara
        html5QrcodeScanner.pause();
        
        // Tampilkan loading
        document.getElementById('loading-indicator').classList.remove('d-none');
        document.getElementById('reader').classList.add('d-none');

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
            // Kita panggil handleResponse untuk menentukan suara mana yang keluar
            handleResponse(data);
        })
        .catch(error => {
            console.error('Error:', error);
            // Putar suara error jika sistem crash/internet putus
            errorSound.play();
            Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
        })
        .finally(() => {
            // Nyalakan scanner lagi setelah 3 detik
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
            // 1. PUTAR SUARA SUKSES
            successSound.play();

            // 2. UPDATE TAMPILAN
            resultArea.innerHTML = `
                <div class="animate__animated animate__zoomIn">
                    <img src="${data.photo}" class="rounded-circle border border-3 border-white mb-3" width="80">
                    <h3 class="fw-bold text-white mb-1">${data.member}</h3>
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
            
            // 3. UPDATE LIST KEHADIRAN
            const list = document.getElementById('presence-list');
            const currentTimestamp = Math.floor(Date.now() / 1000);
            
            const newItem = `
                <li class="list-group-item d-flex align-items-center bg-light animate__animated animate__fadeIn" data-time="${currentTimestamp}">
                    <img src="${data.photo}" class="rounded-circle me-3" width="40">
                    <div>
                        <h6 class="mb-0 fw-bold">${data.member}</h6>
                        <small class="text-success time-display">Baru saja</small>
                    </div>
                    <span class="badge bg-success ms-auto">Hadir</span>
                </li>
            `;
            list.insertAdjacentHTML('afterbegin', newItem);
            
            // Update counter header
            const headerText = document.querySelector('.card-header h6');
            const currentCount = list.querySelectorAll('li:not(.text-center)').length;
            headerText.textContent = `Kehadiran Hari Ini (${currentCount})`;
            
            updateTimeDisplays();
            
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false });

        } else {
            // 1. PUTAR SUARA ERROR (Gagal / Expired)
            errorSound.play();

            // 2. TAMPILKAN ERROR
            if (data.status === 'error') {
                Swal.fire({ icon: 'error', title: 'Akses Ditolak!', text: data.message });
                resultArea.innerHTML = `
                    <div class="animate__animated animate__shakeX">
                        <i class="feather-x-circle fs-1 mb-3 text-warning"></i>
                        <h4 class="fw-bold">Gagal!</h4>
                        <p class="text-white-50">${data.message}</p>
                    </div>
                `;
            } else {
                // Warning (opsional jika dipakai)
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: data.message });
            }
        }
    }

    // Inisialisasi Scanner
    let config = { fps: 10, qrbox: { width: 300, height: 300 } };
    let html5QrcodeScanner = new Html5QrcodeScanner("reader", config, /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess);

</script>
@endsection