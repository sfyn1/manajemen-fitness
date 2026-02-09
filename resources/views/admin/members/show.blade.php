@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Detail Biodata Member</h2>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('admin.members.index') }}" class="btn btn-light">
                    <i class="feather-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img src="{{ $user->member->photo ? asset('storage/' . $user->member->photo) : asset('template/assets/images/avatar/1.png') }}" 
                         class="rounded-circle mb-3 border border-3 border-primary" 
                         width="150" height="150" style="object-fit: cover;">
                    
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <div class="text-muted mb-2">{{ $user->email }}</div>
                    
                    @if($user->member->expiry_date >= date('Y-m-d'))
                        <span class="badge bg-success">Status: Aktif</span>
                    @else
                        <span class="badge bg-danger">Status: Expired</span>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Info Membership</h4>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted d-block">Tanggal Bergabung</small>
                        <span class="fw-bold">{{ date('d M Y', strtotime($user->member->join_date)) }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Berlaku Hingga</small>
                        <span class="fw-bold text-primary">{{ date('d M Y', strtotime($user->member->expiry_date)) }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block">ID Member</small>
                        <span class="font-monospace">#{{ sprintf('%05d', $user->member->id) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title"><i class="feather-user me-2"></i>Informasi Pribadi</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold text-muted">Nomor WhatsApp</div>
                        <div class="col-md-8">{{ $user->member->phone_number }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold text-muted">Jenis Kelamin</div>
                        <div class="col-md-8">{{ $user->member->gender }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold text-muted">Alamat Lengkap</div>
                        <div class="col-md-8">{{ $user->member->address ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="feather-image me-2"></i>Dokumen Foto</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted mb-2">Foto KTP</label>
                            @if($user->member->ktp_image)
                                <div class="border rounded p-1">
                                    <img src="{{ asset('storage/' . $user->member->ktp_image) }}" class="img-fluid rounded" alt="KTP">
                                </div>
                                <a href="{{ asset('storage/' . $user->member->ktp_image) }}" target="_blank" class="btn btn-sm btn-link mt-1">Lihat Ukuran Penuh</a>
                            @else
                                <div class="alert alert-light text-center">Tidak ada foto KTP</div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted mb-2">Foto Kartu Pelajar</label>
                            @if($user->member->student_card_image)
                                <div class="border rounded p-1">
                                    <img src="{{ asset('storage/' . $user->member->student_card_image) }}" class="img-fluid rounded" alt="Kartu Pelajar">
                                </div>
                                <a href="{{ asset('storage/' . $user->member->student_card_image) }}" target="_blank" class="btn btn-sm btn-link mt-1">Lihat Ukuran Penuh</a>
                            @else
                                <div class="alert alert-light text-center text-muted py-4">
                                    <i class="feather-slash d-block mb-2"></i>
                                    Bukan Pelajar / Tidak dilampirkan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection