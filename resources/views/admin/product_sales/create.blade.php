@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Jual Produk / Suplemen</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form action="{{ route('admin.product-sales.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Produk</label>
                    <select name="product_id" class="form-select select2" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} (Stok: {{ $p->stock }}) - Rp {{ number_format($p->price) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah (Qty)</label>
                    <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Proses Penjualan</button>
            </form>
        </div>
    </div>
</div>
@endsection