@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Riwayat Penjualan Produk</h2>
        <div>
            <a href="{{ route('admin.product-sales.pdf') }}" class="btn btn-danger me-2" target="_blank">
                <i class="feather-printer"></i> Download PDF
            </a>

            <a href="{{ route('admin.product-sales.create') }}" class="btn btn-success">
                <i class="feather-shopping-cart"></i> Jual Produk Baru
            </a>
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
                <tbody>
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
    </div>
</div>
@endsection