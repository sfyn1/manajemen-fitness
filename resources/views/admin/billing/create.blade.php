@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 fw-bold">Perpanjang Membership</h2>
            <small class="text-muted">Total Members: {{ $members->count() }}</small>
        </div>
    </div>
    
    @if($members->count() === 0)
        <div class="alert alert-warning" role="alert">
            <strong>⚠️ Tidak ada member ditemukan!</strong><br>
            Pastikan sudah ada member yang terdaftar di sistem sebelum dapat memperpanjang membership.
            <a href="{{ route('admin.members.index') }}" class="btn btn-sm btn-primary mt-2">
                Lihat Daftar Member
            </a>
        </div>
    @endif
    
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            @if($members->count() > 0)
            <form action="{{ route('admin.billing.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Member</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">-- Pilih Member --</option>
                        @foreach($members as $m)
                            @if($m->member)
                                <option value="{{ $m->id }}">
                                    @if($m->member->isExpired())
                                        ⚠️ [EXPIRED] 
                                    @endif
                                    {{ $m->name }} - Exp: {{ \Carbon\Carbon::parse($m->member->expiry_date)->format('d M Y') }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <small class="d-block mt-2 text-muted">
                        {{ $members->count() }} member(s) tersedia
                    </small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Paket</label>
                    <select name="package_id" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($packages as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->name }} - Rp {{ number_format($p->price) }} ({{ $p->duration_in_days }} Hari)
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="feather-save me-2"></i> Proses Perpanjangan
                </button>
                <a href="{{ route('admin.billing.index') }}" class="btn btn-secondary w-100 mt-2">
                    <i class="feather-arrow-left me-2"></i> Kembali
                </a>
            </form>
            @else
            <div class="text-center py-4">
                <p class="text-muted mb-3">Tidak ada member untuk diperpanjang</p>
                <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                    <i class="feather-user-plus me-2"></i> Daftarkan Member Baru
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection