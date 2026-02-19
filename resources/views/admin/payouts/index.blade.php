@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Riwayat Penggajian Coach</h2>
        <a href="{{ route('admin.payouts.create') }}" class="btn btn-primary">
            <i class="feather-plus"></i> Bayar Gaji Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">No. Slip</th>
                        <th>Coach</th>
                        <th>Periode</th>
                        <th>Total Sesi</th>
                        <th>Total Dibayar</th>
                        <th>Tanggal Bayar</th>
                        <th class="text-end px-4">Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payouts as $p)
                    <tr>
                        <td class="px-4 fw-bold">{{ $p->payout_number }}</td>
                        <td>{{ $p->coach->name }}</td>
                        <td>{{ \Carbon\Carbon::create(null, $p->month)->translatedFormat('F') }} {{ $p->year }}</td>
                        <td><span class="badge bg-secondary">{{ $p->total_sessions }} Sesi</span></td>
                        <td class="fw-bold text-success">Rp {{ number_format($p->total_amount, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->paid_at)->format('d/m/Y H:i') }}</td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.payouts.print', $p->id) }}" class="btn btn-sm btn-danger" target="_blank">
                                <i class="feather-printer"></i> Slip PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat penggajian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection