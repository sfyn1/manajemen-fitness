@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Buat Paket Baru</h4>
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form action="{{ route('admin.membership-packages.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Paket</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Paket 1 Bulan" required>
                </div>
                <div class="mb-3">
                    <label>Durasi (Hari)</label>
                    <input type="number" name="duration_in_days" class="form-control" placeholder="30" required>
                </div>
                <div class="mb-3">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" placeholder="150000" required>
                </div>
                <div class="mb-3">
                    <label>Keterangan (Opsional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Simpan Paket</button>
            </form>
        </div>
    </div>
</div>
@endsection