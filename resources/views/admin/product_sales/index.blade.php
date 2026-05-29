@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">Riwayat Penjualan Produ</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.product-sales.create') }}" class="btn btn-primary">
                        <i class="feather-shopping-cart"></i> Jual Produk Baru
                    </a>
                    <a href="{{ route('admin.product-sales.pdf') }}" class="btn btn-primary btn-danger">
                        <i class="feather-printer"></i> Cetak Laporan
                    </a>
                </div>    
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="text-center">
                    <tr>
                        <th class="px-4">Invoice</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($transactions as $trx)
                    <tr>
                        <td class="px-4 fw-bold">{{ $trx->invoice_number }}</td>
                        <td>
                            @foreach($trx->items as $item)
                                <div>{{ $item->name }}</div>
                            @endforeach
                        </td>
                        <td>
                            @foreach($trx->items as $item)
                                <div>x{{ $item->quantity }}</div>
                            @endforeach
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($trx->grand_total) }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4">Belum ada penjualan produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
            <div class="text-muted" style="font-size:13px;">
                Menampilkan
                <strong>{{ $transactions->firstItem() ?? 0 }}</strong>
                –
                <strong>{{ $transactions->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $transactions->total() }}</strong>
                data
            </div>
            <div>
                {{ $transactions->appends(request()->query())->links() }}
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
    }
</style>
@endsection