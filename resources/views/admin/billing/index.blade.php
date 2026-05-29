@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">Data Billing & Transaksi</h2>
                
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.billing.index') }}" method="GET" class="d-flex align-items-center">
                        <span class="fw-bold me-2 text-muted small">Filter Bulan:</span>
                        <input type="month" name="month" class="form-control form-control-sm" 
                            value="{{ $selectedMonth }}" 
                            onchange="this.form.submit()" style="width: auto;">
                    </form>

                    <a href="{{ route('admin.billing.create') }}" class="btn btn-sm btn-primary fw-bold shadow-sm">
                        <i class="feather-plus me-1"></i> Perpanjang Membership
                    </a>

                    <a href="{{ route('admin.billing.pdf', ['month' => $selectedMonth]) }}" class="btn btn-sm btn-danger fw-bold shadow-sm">
                        <i class="feather-printer me-1"></i> Cetak Laporan
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
                        <th>Member</th>
                        <th>Paket Diambil</th>
                        <th>Total Bayar</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($transactions as $trx)
                    <tr>
                        <td class="px-4 fw-bold">{{ $trx->invoice_number }}</td>
                        <td>{{ $trx->user->name ?? 'User Terhapus' }}</td>
                        <td>
                            @foreach($trx->items as $item)
                                <span class="badge bg-info text-dark">{{ $item->name }}</span>
                            @endforeach
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($trx->grand_total) }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4">Belum ada data billing.</td></tr>
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