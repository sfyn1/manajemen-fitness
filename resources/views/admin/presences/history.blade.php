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
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#table-history').DataTable({
            "order": [[ 1, "desc" ]], // Default urutkan berdasarkan kehadiran hari ini
            "language": {
                "search": "Cari Member:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ member"
            }
        });
    });
</script>
@endsection