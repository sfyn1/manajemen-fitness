@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold mb-1">Langganan Personal Trainer</h2>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-warning-lt text-warning border border-warning fs-6">
                    {{ $subscriptions->where('status','pending')->count() }} Pending
                </span>
                <span class="badge bg-success-lt text-success border border-success fs-6">
                    {{ $subscriptions->where('status','active')->count() }} Aktif
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Personal Trainer</th>
                        <th>Paket</th>
                        <th class="text-center">Progress Sesi</th>
                        <th class="text-center">Pembayaran</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="avatar avatar-sm bg-blue-lt">{{ substr($sub->member->user->name ?? '?', 0, 1) }}</span>
                                <div>
                                    <strong>{{ $sub->member->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $sub->member->user->phone_number ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $sub->coach->name }}</strong><br>
                            <small class="badge bg-purple-lt text-purple">Personal Trainer</small>
                        </td>
                        <td>
                            <strong>{{ $sub->package->name }}</strong><br>
                            <small class="text-muted">{{ $sub->package->session_count }} sesi · {{ $sub->package->duration_minutes }} menit</small><br>
                            <small class="fw-bold text-success">Rp {{ number_format($sub->package->price, 0, ',', '.') }}</small>
                        </td>
                        <td class="text-center">
                            <div class="mb-1">
                                <small>{{ $sub->sessions_used }} / {{ $sub->sessions_total }} sesi</small>
                            </div>
                            <div class="progress" style="height: 8px; width: 120px; margin: 0 auto;">
                                <div class="progress-bar bg-success" style="width: {{ $sub->progress_percent }}%"></div>
                            </div>
                            <small class="text-muted">Sisa: {{ $sub->sessions_left }}</small>
                        </td>

                        <td class="text-center">
                            @if($sub->payment_status === 'paid')
                                <span class="badge bg-success">Lunas</span><br>
                                <small class="text-muted">{{ $sub->paid_at?->format('d/m/Y') }}</small>
                            @else
                                <span class="badge bg-danger">Belum Bayar</span>
                                @if($sub->status === 'active')
                                <form action="{{ route('admin.pt-subscriptions.paid', $sub->id) }}" method="POST" class="mt-1">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-success" 
                                        onclick="return confirm('Tandai sudah bayar?')">
                                        Tandai Lunas
                                    </button>
                                </form>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $sub->status_color }}">{{ $sub->status_label }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($sub->status === 'pending')
                                    <form action="{{ route('admin.pt-subscriptions.activate', $sub->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Aktifkan"
                                            onclick="return confirm('Aktifkan langganan PT ini?')">
                                            <i class="feather-check me-1"></i>Aktifkan
                                        </button>
                                    </form>
                                @endif

                                @if(in_array($sub->status, ['pending', 'active']))
                                    <form action="{{ route('admin.pt-subscriptions.cancel', $sub->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-ghost-danger" title="Batalkan"
                                            onclick="return confirm('Batalkan langganan ini?')">
                                            <i class="feather-x"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="feather-users d-block mb-2" style="font-size:2rem;"></i>
                            Belum ada member yang mendaftar PT.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
            <div class="text-muted" style="font-size:13px;">
                Menampilkan
                <strong>{{ $subscriptions->firstItem() ?? 0 }}</strong>
                –
                <strong>{{ $subscriptions->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $subscriptions->total() }}</strong>
                data
            </div>
            <div>
                {{ $subscriptions->appends(request()->query())->links() }}
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
