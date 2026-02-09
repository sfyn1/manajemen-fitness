@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <!-- MODERN PAGE HEADER -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Pendaftaran Member Baru</h2>
                    <p class="text-muted mb-0">Lengkapi form di bawah untuk mendaftarkan member baru</p>
                </div>
                <a href="{{ route('admin.members.index') }}" class="btn btn-light">
                    <i class="feather-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- MODERN FORM CARD -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    
                    <!-- LEFT COLUMN - INFORMASI PRIBADI -->
                    <div class="col-lg-6">
                        <div class="section-header mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="feather-user text-primary fs-3 me-3"></i>
                                <div>
                                    <h5 class="mb-0 fw-bold">Informasi Pribadi</h5>
                                    <small class="text-muted">Data diri member</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="feather-user text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="name" 
                                       class="form-control border-start-0" 
                                       required 
                                       placeholder="Nama sesuai KTP">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="feather-mail text-muted"></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       class="form-control border-start-0" 
                                       required 
                                       placeholder="email@contoh.com">
                            </div>
                            <small class="text-muted">
                                <i class="feather-info me-1"></i>
                                Password akan digenerate otomatis oleh sistem
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                No. WhatsApp <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="feather-phone text-muted"></i>
                                </span>
                                <input type="number" 
                                       name="phone_number" 
                                       class="form-control border-start-0" 
                                       required 
                                       placeholder="0812...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="gender" id="gender-male" value="Laki-laki" required>
                                    <label class="btn btn-outline-primary w-100 py-3" for="gender-male">
                                        <i class="feather-user d-block fs-3 mb-2"></i>
                                        <span class="fw-semibold">Laki-laki</span>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="gender" id="gender-female" value="Perempuan" required>
                                    <label class="btn btn-outline-primary w-100 py-3" for="gender-female">
                                        <i class="feather-user d-block fs-3 mb-2"></i>
                                        <span class="fw-semibold">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="address" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN - DOKUMEN & MEMBERSHIP -->
                    <div class="col-lg-6">
                        
                        <!-- SECTION: DOKUMEN & FOTO -->
                        <div class="section-header mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="feather-image text-success fs-3 me-3"></i>
                                <div>
                                    <h5 class="mb-0 fw-bold">Dokumen & Foto</h5>
                                    <small class="text-muted">Upload dokumen yang diperlukan</small>
                                </div>
                            </div>
                        </div>

                        <!-- FOTO WAJAH -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Foto Wajah (Profil) <span class="text-danger">*</span>
                            </label>
                            <div class="upload-box border-2 border-dashed rounded p-4 text-center bg-light">
                                <i class="feather-camera text-primary fs-1 mb-2 d-block"></i>
                                <p class="mb-2 fw-semibold">Upload Foto Profil</p>
                                <input type="file" 
                                       name="photo" 
                                       class="form-control" 
                                       accept="image/*" 
                                       required
                                       id="photo-input">
                                <small class="text-muted d-block mt-2">
                                    <i class="feather-info me-1"></i>
                                    Foto ini akan dicetak di Kartu Member
                                </small>
                            </div>
                        </div>

                        <!-- FOTO KTP -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Foto KTP <span class="text-danger">*</span>
                            </label>
                            <div class="upload-box border-2 border-dashed rounded p-4 text-center bg-light">
                                <i class="feather-credit-card text-warning fs-1 mb-2 d-block"></i>
                                <p class="mb-2 fw-semibold">Upload Foto KTP</p>
                                <input type="file" 
                                       name="ktp_image" 
                                       class="form-control" 
                                       accept="image/*" 
                                       required
                                       id="ktp-input">
                                <small class="text-muted d-block mt-2">Format: JPG, PNG (Max 2MB)</small>
                            </div>
                        </div>

                        <!-- FOTO KARTU PELAJAR -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Foto Kartu Pelajar <span class="text-muted">(Opsional)</span>
                            </label>
                            <div class="upload-box border-2 border-dashed rounded p-4 text-center" style="background: #f0f9ff;">
                                <i class="feather-award text-info fs-1 mb-2 d-block"></i>
                                <p class="mb-2 fw-semibold">Upload Kartu Pelajar</p>
                                <input type="file" 
                                       name="student_card_image" 
                                       class="form-control" 
                                       accept="image/*"
                                       id="student-input">
                                <small class="text-muted d-block mt-2">
                                    Khusus untuk pelajar/mahasiswa
                                </small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- SECTION: PAKET MEMBERSHIP -->
                        <div class="section-header mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="feather-credit-card text-warning fs-3 me-3"></i>
                                <div>
                                    <h5 class="mb-0 fw-bold">Paket Membership</h5>
                                    <small class="text-muted">Pilih durasi keanggotaan</small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Durasi Paket <span class="text-danger">*</span>
                                </label>
                                <select name="duration" class="form-select" required>
                                    <option value="">Pilih Durasi</option>
                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">1 Tahun</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Mulai Tanggal <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       name="join_date" 
                                       class="form-control" 
                                       value="{{ date('Y-m-d') }}" 
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT BUTTONS -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2 border-top pt-4">
                            <a href="{{ route('admin.members.index') }}" class="btn btn-light px-4">
                                <i class="feather-x me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="feather-save me-2"></i> Simpan Member
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    /* Modern Section Headers */
    .section-header {
        position: relative;
    }
    
    /* Input Group Modern Styling */
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .input-group .form-control:focus {
        border-color: #4e73df;
        box-shadow: none;
    }
    
    .input-group .form-control:focus + .input-group-text,
    .input-group-text + .form-control:focus {
        border-color: #4e73df;
    }
    
    /* Upload Box Styling */
    .upload-box {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-box:hover {
        border-color: #4e73df !important;
        background-color: #f0f4ff !important;
    }
    
    .upload-box input[type="file"] {
        border: none;
        padding: 0.5rem;
        background: white;
        margin-top: 0.5rem;
    }
    
    /* Gender Radio Buttons */
    .btn-check:checked + .btn-outline-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    
    .btn-outline-primary {
        border-color: #dee2e6;
    }
    
    .btn-outline-primary:hover {
        background-color: #f0f4ff;
        border-color: #4e73df;
        color: #4e73df;
    }
    
    /* Form Control Focus */
    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .section-header h5 {
            font-size: 1.1rem;
        }
    }
</style>

<script>
    // Preview uploaded images (optional enhancement)
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const uploadBox = this.closest('.upload-box');
                const fileName = file.name;
                const fileSize = (file.size / 1024).toFixed(2) + ' KB';
                
                // Show file info
                const info = uploadBox.querySelector('small');
                if (info) {
                    info.innerHTML = `<i class="feather-check-circle text-success me-1"></i> ${fileName} (${fileSize})`;
                }
            }
        });
    });
</script>

@endsection