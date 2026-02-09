@extends('layouts.admin')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div style="height: 100px;"></div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <form id="pdfForm" action="{{ route('admin.members.print-pdf-image') }}" method="POST" style="display:none;">
                @csrf
                <input type="hidden" name="image" id="imageInput">
                <input type="hidden" name="name" value="{{ str_replace(' ', '-', $user->name) }}">
            </form>

            <div id="card-capture-area" style="background-color: #ffffff; padding: 20px; border-radius: 10px; width: fit-content; margin: 0 auto;">
                <div class="id-card">
                    <div class="card-bg"></div>
                    <div class="card-header-custom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="m-0 fw-bold text-white tracking-wide" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">GINTUNG FITNESS</h5>
                                <p class="text-white-50 fs-10 m-0 text-uppercase ls-1">Official Member Card</p>
                            </div>
                            <i class="feather-activity text-white fs-2" style="opacity: 0.8;"></i>
                        </div>
                    </div>
                    <div class="card-body-custom d-flex align-items-center">
                        <div class="text-center pe-4 border-end" style="border-color: #eee !important;">
                            <div class="avatar-box mb-3">
                                <img src="{{ $user->member->photo ? asset('storage/' . $user->member->photo) : asset('template/assets/images/avatar/1.png') }}"
                                     class="img-fluid rounded-circle"
                                     style="width: 100px; height: 100px; object-fit: cover; border: 3px solid white;">
                            </div>
                            <div class="qr-box bg-white p-1 border rounded">
                                {!! QrCode::size(140)->margin(1)->generate($qrData) !!}
                            </div>
                        </div>
                        <div class="ps-4 flex-grow-1 position-relative">
                            <h3 class="fw-bolder text-dark mb-1 text-uppercase">{{ $user->name }}</h3>
                            <span class="badge bg-primary px-3 py-2 mb-4">{{ ucfirst($user->role) }}</span>
                            <div class="info-group mb-1">
                                <label class="fs-10 text-muted d-block mb-0 text-uppercase">ID Member</label>
                                <span class="fw-bold fs-12 font-monospace text-dark">#{{ sprintf('%05d', $user->member->id ?? 0) }}</span>
                            </div>
                            <div class="info-group mb-1">
                                <label class="fs-10 text-muted d-block mb-0 text-uppercase">No. HP</label>
                                <span class="fw-bold fs-12 text-dark">{{ $user->member->phone_number }}</span>
                            </div>
                            <div class="info-group p-2 bg-light rounded border mt-2">
                                <label class="fs-10 text-muted d-block mb-0 text-uppercase">Masa Aktif</label>
                                <span class="fw-bold text-success">{{ date('d M Y', strtotime($user->member->expiry_date)) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 d-print-none">
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('admin.members.index') }}" class="btn btn-light border px-4 py-2">
                        <i class="feather-arrow-left me-2"></i> Kembali
                    </a>

                    <button type="button" id="btn-download-pdf" class="btn btn-danger px-4 py-2">
                        <i class="feather-file-text me-2"></i> Download PDF
                    </button>

                    <button type="button" id="btn-download-jpg" class="btn btn-success px-4 py-2">
                        <i class="feather-image me-2"></i> Download JPG
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // FUNGSI UMUM: KONVERSI HTML KE GAMBAR
        function captureCard(callback) {
            // Tampilkan Loading
            Swal.fire({
                title: 'Memproses Kartu...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            const element = document.querySelector("#card-capture-area");

            html2canvas(element, {
                scale: 3, // Resolusi tinggi
                backgroundColor: "#ffffff",
                useCORS: true
            })
            .then(canvas => {
                callback(canvas);
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
            });
        }

        // 1. LOGIKA DOWNLOAD PDF (Via Image)
        document.getElementById('btn-download-pdf').addEventListener('click', function() {
            captureCard(function(canvas) {
                // Masukkan data gambar ke input form tersembunyi
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                document.getElementById('imageInput').value = imgData;

                // Submit form ke Laravel untuk jadi PDF
                document.getElementById('pdfForm').submit();

                // Tutup loading setelah 1 detik (asumsi submit berhasil)
                setTimeout(() => {
                    Swal.close();
                    Swal.fire({
                        icon: 'success', 
                        title: 'PDF Siap!', 
                        text: 'File PDF sedang didownload.', 
                        timer: 2000, 
                        showConfirmButton: false
                    });
                }, 1000);
            });
        });

        // 2. LOGIKA DOWNLOAD JPG (Langsung Browser)
        document.getElementById('btn-download-jpg').addEventListener('click', function() {
            captureCard(function(canvas) {
                var link = document.createElement('a');
                link.download = 'Kartu-Member-{{ str_replace(" ", "-", $user->name) }}.jpg';
                link.href = canvas.toDataURL("image/jpeg", 1.0);
                link.click();

                Swal.fire({
                    icon: 'success', 
                    title: 'Selesai!', 
                    text: 'Foto kartu berhasil disimpan.', 
                    timer: 2000, 
                    showConfirmButton: false
                });
            });
        });

    });
</script>

<style>
    /* UKURAN KARTU - SAMA PERSIS DENGAN ASLI */
    .id-card {
        width: 600px;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #eef2f6;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* HEADER - GRADIENT MODERN */
    .card-header-custom {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        padding: 20px 30px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    /* PATTERN BACKGROUND */
    .card-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(rgba(255,255,255,0.15) 0.5px, transparent 0.5px);
        background-size: 10px 10px;
        opacity: 0.6;
        pointer-events: none;
    }
    
    /* BODY - SAMA DENGAN ASLI */
    .card-body-custom {
        padding: 25px 30px;
    }
    
    /* HELPER CLASSES */
    .fs-10 {
        font-size: 10px;
    }
    
    .fs-12 {
        font-size: 12px;
    }
    
    .ls-1 {
        letter-spacing: 1px;
    }
    
    .tracking-wide {
        letter-spacing: 0.5px;
    }
    
    /* MODERN BUTTON STYLING */
    .btn {
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-light {
        background: white;
        color: #495057;
    }
    
    .btn-light:hover {
        background: #f8f9fa;
        color: #212529;
    }
</style>
@endsection