@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Hitung Gaji Coach</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Parameter Gaji</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payouts.create') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Coach</label>
                            <select name="coach_id" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @foreach($coaches as $c)
                                    <option value="{{ $c->id }}" {{ request('coach_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Periode Bulan</label>
                            <input type="month" name="month" class="form-control" value="{{ $selectedMonth }}" required>
                        </div>

                        <button type="submit" class="btn btn-info w-100 fw-bold text-white mb-2">
                            <i class="feather-search me-1"></i> CEK HITUNGAN
                        </button>
                        <a href="{{ route('admin.payouts.create') }}" class="btn btn-light w-100 border">Reset</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Rincian Pendapatan</h5>
                </div>
                <div class="card-body">
                    @if($selectedCoach)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="fw-bold mb-0">{{ $selectedCoach->name }}</h4>
                                <p class="text-muted mb-0">Periode: {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}</p>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Total Gaji</small>
                                <h2 class="fw-bold text-success">Rp {{ number_format($totalSalary, 0, ',', '.') }}</h2>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                        <th class="text-end">Fee (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($presences as $p)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</td>
                                        <td>
                                            {{-- CEK APAKAH JADWAL MASIH ADA? --}}
                                            @if($p->schedule)
                                                {{ $p->schedule->classType->name ?? 'Jenis Kelas Terhapus' }} <br>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($p->schedule->start_time)->format('H:i') }} WIB
                                                </small>
                                            @else
                                                <span class="text-danger fst-italic">Data Jadwal Terhapus</span> <br>
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td class="text-end fw-bold">{{ number_format($p->coach_fee, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="feather-alert-circle d-block fs-3 mb-2"></i>
                                            Belum ada sesi yang <b>DI-APPROVE</b> admin pada bulan ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="3" class="text-end">Total</th>
                                        <th class="text-end">Rp {{ number_format($totalSalary, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($totalSalary > 0)
                        <form action="{{ route('admin.payouts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="coach_id" value="{{ $selectedCoach->id }}">
                            <input type="hidden" name="month" value="{{ $selectedMonth }}">
                            <input type="hidden" name="total_sessions" value="{{ $presences->count() }}">
                            <input type="hidden" name="total_amount" value="{{ $totalSalary }}">
                            
                            <button type="submit" class="btn btn-success w-100 fw-bold py-3" onclick="return confirm('Simpan pembayaran gaji ini?')">
                                <i class="feather-check-circle me-2"></i> BAYAR & SIMPAN DATA
                            </button>
                        </form>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="feather-dollar-sign" style="font-size: 64px;"></i>
                            </div>
                            <h5 class="text-muted">Pilih Coach & Bulan, lalu klik "Cek Hitungan"</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection