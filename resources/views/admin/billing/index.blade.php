@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Riwayat Billing Membership</h2>
                </div>
                <div>
                    <a href="{{ route('admin.billing.create') }}" class="btn btn-primary shadow-sm">
                        <i class="feather-plus-circle"></i>
                        Transaksi Baru
                    </a>
                    <a href="{{ route('admin.billing.pdf') }}" class="btn btn-danger me-2" target="_blank">
                        <i class="feather-printer"></i> Download PDF
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
                <thead class="bg-light">
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