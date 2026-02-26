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
                <tbody>
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
    </div>
</div>
@endsection