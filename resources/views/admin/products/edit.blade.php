@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Edit Produk</h4>
    <div class="card border-0 shadow-sm col-md-8">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-select">
                            <option value="Suplemen" {{ $product->category == 'Suplemen' ? 'selected' : '' }}>Suplemen</option>
                            <option value="Minuman" {{ $product->category == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Makanan" {{ $product->category == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Aksesoris" {{ $product->category == 'Aksesoris' ? 'selected' : '' }}>Aksesoris Gym</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stok</label>
                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
                        <input type="file" name="image" class="form-control mb-2">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" width="80" class="rounded border">
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-warning w-100 fw-bold">Update Produk</button>
            </form>
        </div>
    </div>
</div>
@endsection