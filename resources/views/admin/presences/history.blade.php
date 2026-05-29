@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Statistik Kehadiran Member</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-vcenter card-table" id="table-history">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th class="text-center">Hari Ini</th>
                            <th class="text-center">Minggu Ini</th>
                            <th class="text-center">Bulan Ini</th>
                            <th class="text-center">Total Kunjungan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr id="presence-{{ $member->id }}">
                            <td>
                                <div class="d-flex py-1 align-items-center">
                                    <span class="avatar me-2" style="background-image: url({{ asset('template/assets/images/avatar/1.png') }})"></span>
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">{{ $member->user->name }}</div>
                                        <div class="text-muted fs-12">ID: #{{ sprintf('%05d', $member->id) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($member->visits_today > 0)
                                    <span class="badge bg-success">{{ $member->visits_today }}x</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold">{{ $member->visits_week }}x</td>
                            <td class="text-center">{{ $member->visits_month }}x</td>
                            <td class="text-center fs-14 fw-bold text-primary">{{ $member->visits_total }}x</td>
                            
                            <td>
                                @if($member->expiry_date >= date('Y-m-d'))
                                    <span class="status-dot status-dot-animated bg-success d-block"></span>
                                @else
                                    <span class="status-dot bg-danger d-block"></span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
            <div class="text-muted" style="font-size:13px;">
                Menampilkan
                <strong>{{ $members->firstItem() ?? 0 }}</strong>
                –
                <strong>{{ $members->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $members->total() }}</strong>
                data
            </div>
            <div>
                {{ $members->appends(request()->query())->links() }}
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#table-history').DataTable({
            "order": [[ 1, "desc" ]], // Default urutkan berdasarkan kehadiran hari ini
            "paging": false,
            "info": false,
            "searching": false // Search Laravel akan butuh form pencarian server-side
        });
    });
</script>
@endsection