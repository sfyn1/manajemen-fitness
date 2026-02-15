@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Perpanjang Membership</h4>
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form action="{{ route('admin.billing.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Member</label>
                    <select name="user_id" class="form-select select2" required>
                        <option value="">-- Cari Member --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} (Exp: {{ \Carbon\Carbon::parse($m->member->expiry_date)->format('d M Y') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilih Paket</label>
                    <select name="package_id" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($packages as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} - Rp {{ number_format($p->price) }} ({{ $p->duration_in_days }} Hari)</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Proses Perpanjangan</button>
            </form>
        </div>
    </div>
</div>
@endsection