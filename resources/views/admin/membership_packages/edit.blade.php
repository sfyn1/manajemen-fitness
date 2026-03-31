@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Edit Paket & Harga</h4>
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form action="{{ route('admin.membership-packages.update', $package->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Nama Paket</label>
                    <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Durasi (Hari)</label>
                    <input type="number" name="duration_in_days" class="form-control" value="{{ $package->duration_in_days }}" required>
                </div>
                <div class="mb-3">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ $package->price }}" required>
                    <small class="text-muted">Ubah angka ini untuk mengganti harga.</small>
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="description" class="form-control">{{ $package->description }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn w-100 fw-bold"
                        style="background-color: #3454d1; border-color: #3454d1; color: #ffffff;">
                        Update Harga
                    </button>

                    <a href="{{ route('admin.membership-packages.index') }}" class="btn btn-outline-secondary w-100 fw-bold">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection