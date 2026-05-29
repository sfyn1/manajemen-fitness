@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold mb-1">Manajemen Produk / Suplemen</h2>
                <p class="text-muted mb-0">Kelola stok, harga, dan daftar produk yang dijual di kasir</p>
            </div>
            <div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm fw-bold">
                    <i class="feather-plus me-1"></i> Tambah Produk
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-hover mb-0">
                <thead class="text-center">
                    <tr>
                        <th class="px-4">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <td class="px-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" width="48" height="48" class="rounded object-fit-cover shadow-sm">
                            @else
                                <div class="avatar avatar-sm bg-secondary text-white rounded">
                                    <i class="feather-package"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold text-dark">{{ $product->name }}</td>
                        <td>
                            <span class="badge bg-purple-lt text-purple">{{ $product->category ?? 'Lainnya' }}</span>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="badge bg-danger-lt text-danger border border-danger">{{ $product->stock }} (Menipis)</span>
                            @else
                                <span class="badge bg-success-lt text-success">{{ $product->stock }} Tersedia</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Produk">
                                    <i class="feather-edit-2"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus Produk"><i class="feather-trash-2"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="feather-package" style="font-size: 48px; opacity: 0.3;"></i>
                                <h5 class="mt-3 text-muted">Belum Ada Produk</h5>
                                <p class="mb-0">Klik tombol "Tambah Produk" untuk menambahkan barang jualan pertama Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
            <div class="text-muted" style="font-size:13px;">
                Menampilkan
                <strong>{{ $products->firstItem() ?? 0 }}</strong>
                –
                <strong>{{ $products->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $products->total() }}</strong>
                data produk
            </div>
            <div>
                {{ $products->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== PAGINATION ===== */
    .card-footer .pagination {
        margin: 0 !important;
    }
    .card-footer .pagination .page-item .page-link {
        font-size: 13px;
        padding: 5px 10px;
        border-radius: 6px !important;
        margin: 0 2px;
        border-color: #e2e8f0;
        color: #4e73df;
    }
    .card-footer .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4e73df, #224abe);
        border-color: #4e73df;
        color: #fff;
    }
    .card-footer .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        background: transparent;
        border: none;
    }
</style>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}", timer: 4000, showConfirmButton: false });
    });
</script>
@endif
@endsection