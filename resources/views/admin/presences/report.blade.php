@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-print-none">
        <!-- PAGE HEADER - MODERN DESIGN -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 fw-bold">Laporan Kunjungan</h2>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" onclick="window.print();">
                        <i class="feather-printer me-2"></i> Cetak PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.presences.report') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark w-100">
                                <i class="feather-filter me-2"></i> Tampilkan
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.presences.report') }}" class="btn btn-light w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-none print-area">
        <div class="card-body">
            
            <div class="d-none d-print-block text-center mb-5">
                <h2 class="fw-bold text-uppercase">GINTUNG MASTER FITNESS</h2>
                <p class="mb-0">Laporan Riwayat Kunjungan Member</p>
                <small class="text-muted">Periode: {{ date('d M Y', strtotime($startDate)) }} s/d {{ date('d M Y', strtotime($endDate)) }}</small>
                <hr class="my-4 border-dark">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Waktu Check-in</th>
                            <th>Nama Member</th>
                            <th width="15%">ID Member</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presences as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center fw-bold">{{ date('d M Y H:i', strtotime($row->check_in_time)) }}</td>
                            <td>
                                <div>{{ $row->member->user->name }}</div>
                                <small class="text-muted d-print-none">{{ $row->member->address }}</small>
                            </td>
                            <td class="text-center font-monospace">#{{ sprintf('%05d', $row->member->id) }}</td>
                            <td class="text-center">
                                <span class="badge bg-success text-white">HADIR</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Tidak ada data kunjungan pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h5>Total Kunjungan: <span class="fw-bold text-primary">{{ count($presences) }}</span> Orang</h5>
            </div>

            <div class="d-none d-print-block mt-5">
                <div class="row">
                    <div class="col-4 ms-auto text-center">
                        <p class="mb-5">Tangerang Selatan, {{ date('d M Y') }}<br>Mengetahui,</p>
                        <br><br>
                        <p class="fw-bold text-decoration-underline mb-0">Manager Operasional</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @media print {
        /* Sembunyikan sidebar, header, dan elemen yang tidak perlu */
        .d-print-none, header, nav, footer, .theme-customizer {
            display: none !important;
        }
        /* Atur margin halaman */
        @page { margin: 20px; }
        body { background: white !important; -webkit-print-color-adjust: exact; }
        .card { border: none !important; box-shadow: none !important; }
        .badge { border: 1px solid #000; color: black !important; background: transparent !important; }
    }
</style>
@endsection