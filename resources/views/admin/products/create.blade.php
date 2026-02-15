@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Tambah Produk Baru</h4>
    <div class="card border-0 shadow-sm col-md-8">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Whey Protein Gold">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-select">
                            <option value="Suplemen">Suplemen</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Aksesoris">Aksesoris Gym</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stok Awal</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Foto Produk (Opsional)</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Format: JPG, PNG. Max 2MB.</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Simpan Produk</button>
            </form>
        </div>
    </div>
</div>
@endsection