@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Tambah Member Baru</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm">
                        <i class="feather-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.members.store') }}" method="POST">
                        @csrf <h5 class="mb-3 text-uppercase bg-light p-2"><i class="feather-user"></i> Informasi Akun</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="budi@email.com" value="{{ old('email') }}" required>
                                <small class="text-muted">Email ini akan digunakan untuk login member.</small>
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="feather-info"></i> Detail Anggota</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="number" name="phone_number" class="form-control" placeholder="0812xxxx" value="{{ old('phone_number') }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Gender --</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat domisili...">{{ old('address') }}</textarea>
                        </div>

                        <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="feather-calendar"></i> Paket & Masa Aktif</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                                <input type="date" name="join_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Durasi Paket (Bulan) <span class="text-danger">*</span></label>
                                <select name="duration" class="form-select" required>
                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">12 Bulan (1 Tahun)</option>
                                </select>
                                <small class="text-muted">Sistem akan otomatis menghitung tanggal expired.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="reset" class="btn btn-light-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan Member</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection