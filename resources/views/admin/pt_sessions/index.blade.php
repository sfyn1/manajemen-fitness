@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-1">Monitoring Sesi Personal Trainer</h2>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Tanggal & Waktu</th>
                        <th>Member</th>
                        <th>Personal Trainer</th>
                        <th>Paket</th>
                        <th class="text-center">Sesi ke</th>
                        <th class="text-center">Status</th>
                        <th>Catatan PT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                    <tr>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('D, d M Y') }}</strong><br>
                            <small class="text-muted">{{ $session->time_range }}</small>
                        </td>
                        <td>{{ $session->member->user->name ?? 'N/A' }}</td>
                        <td>{{ $session->coach->name ?? 'N/A' }}</td>
                        <td>
                            <small>{{ $session->subscription->package->name ?? '-' }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-blue-lt text-body">Ke-{{ $session->session_number }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $session->status_color }}">{{ $session->status_label }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ Str::limit($session->notes, 50) ?: '-' }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="feather-calendar d-block mb-2 opacity-25 fs-2"></i>
                            Belum ada sesi PT yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
            <div class="text-muted" style="font-size:13px;">
                Menampilkan
                <strong>{{ $sessions->firstItem() ?? 0 }}</strong>
                –
                <strong>{{ $sessions->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $sessions->total() }}</strong>
                data
            </div>
            <div>
                {{ $sessions->appends(request()->query())->links() }}
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
