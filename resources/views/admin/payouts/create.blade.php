@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Hitung & Bayar Gaji Coach</h2>

    <div class="row">
        {{-- PANEL KIRI: Form Parameter --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="feather-settings me-2"></i>Parameter Gaji</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payouts.create') }}" method="GET">
                        {{-- Pilih Tipe Coach --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipe Payroll</label>
                            <select name="coach_type_filter" class="form-select" id="coachTypeFilter"
                                onchange="filterCoaches(this.value)">
                                <option value="all" {{ request('coach_type_filter','all') === 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="personal_trainer" {{ request('coach_type_filter') === 'personal_trainer' ? 'selected' : '' }}>
                                    Personal Trainer (Gaji Bulanan)
                                </option>
                                <option value="group_coach" {{ request('coach_type_filter') === 'group_coach' ? 'selected' : '' }}>
                                    Group Coach (Per Sesi)
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Coach / PT</label>
                            <select name="coach_id" class="form-select" required id="coachSelect">
                                <option value="">-- Pilih --</option>

                                @if($personalTrainers->isNotEmpty())
                                <optgroup label="👤 Personal Trainer (Gaji Bulanan)">
                                    @foreach($personalTrainers as $c)
                                        <option value="{{ $c->id }}" data-type="personal_trainer"
                                            {{ request('coach_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }} — Rp {{ number_format($c->base_salary, 0, ',', '.') }}/bln
                                        </option>
                                    @endforeach
                                </optgroup>
                                @endif

                                @if($groupCoaches->isNotEmpty())
                                <optgroup label="👥 Group Coach (Per Sesi)">
                                    @foreach($groupCoaches as $c)
                                        <option value="{{ $c->id }}" data-type="group_coach"
                                            {{ request('coach_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }} — Rp {{ number_format($c->session_rate, 0, ',', '.') }}/sesi
                                        </option>
                                    @endforeach
                                </optgroup>
                                @endif
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Periode Bulan</label>
                            <input type="month" name="month" class="form-control"
                                value="{{ $selectedMonth }}" required>
                        </div>

                        <button type="submit" class="btn btn-info w-100 fw-bold text-white mb-2">
                            <i class="feather-search me-1"></i> CEK HITUNGAN
                        </button>
                        <a href="{{ route('admin.payouts.create') }}" class="btn btn-light w-100 border">Reset</a>
                    </form>
                </div>
            </div>
        </div>

        {{-- PANEL KANAN: Hasil Kalkulasi --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="feather-dollar-sign me-2"></i>Rincian Gaji</h5>
                </div>
                <div class="card-body">
                    @if($selectedCoach && $result)
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="fw-bold mb-1">{{ $selectedCoach->name }}</h4>
                                <span class="badge bg-{{ $selectedCoach->isPersonalTrainer() ? 'purple' : 'blue' }}-lt 
                                    text-{{ $selectedCoach->isPersonalTrainer() ? 'purple' : 'blue' }}">
                                    {{ $selectedCoach->coach_type_label }}
                                </span>
                                <p class="text-muted mb-0 mt-1">
                                    Periode: {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Total Gaji</small>
                                <h2 class="fw-bold text-success">Rp {{ number_format($result['total'], 0, ',', '.') }}</h2>
                            </div>
                        </div>

                        {{-- ===== PERSONAL TRAINER: Gaji Flat ===== --}}
                        @if($result['type'] === 'monthly_salary')
                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <i class="feather-info fs-3 text-info"></i>
                                <div>
                                    <strong>Gaji Pokok Bulanan (Personal Trainer)</strong><br>
                                    Gaji PT bersifat <b>flat</b> setiap bulan sesuai kontrak. 
                                    Tidak tergantung jumlah sesi yang diajarkan.
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold bg-light" width="200">Gaji Pokok</td>
                                        <td class="fw-bold text-success fs-5">
                                            Rp {{ number_format($selectedCoach->base_salary, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold bg-light">Masa Kontrak</td>
                                        <td>
                                            {{ $selectedCoach->contract_start_date?->format('d/m/Y') ?? '-' }}
                                            s/d
                                            {{ $selectedCoach->contract_end_date?->format('d/m/Y') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold bg-light">Bonus (opsional)</td>
                                        <td>
                                            <input type="number" id="bonusInput" class="form-control form-control-sm" 
                                                placeholder="0" min="0" style="width:180px;"
                                                onchange="updatePTTotal()">
                                        </td>
                                    </tr>
                                    <tr class="table-success">
                                        <td class="fw-bold">Total Dibayarkan</td>
                                        <td class="fw-bold fs-5" id="ptTotalDisplay">
                                            Rp {{ number_format($selectedCoach->base_salary, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <form action="{{ route('admin.payouts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="coach_id" value="{{ $selectedCoach->id }}">
                            <input type="hidden" name="month" value="{{ $selectedMonth }}">
                            <input type="hidden" name="payout_type" value="monthly_salary">
                            <input type="hidden" name="base_salary" value="{{ $selectedCoach->base_salary }}">
                            <input type="hidden" name="bonus" id="bonusHidden" value="0">
                            <input type="hidden" name="total_amount" id="ptTotalInput" value="{{ $selectedCoach->base_salary }}">
                            <input type="text" name="notes" class="form-control mb-3" placeholder="Catatan (opsional)">
                            <button type="submit" class="btn btn-success w-100 fw-bold py-3"
                                onclick="return confirm('Simpan slip gaji PT ini?')">
                                <i class="feather-check-circle me-2"></i> BAYAR & SIMPAN SLIP GAJI
                            </button>
                        </form>

                        {{-- ===== GROUP COACH: Hitung Per Sesi ===== --}}
                        @else
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
                                    @forelse($result['presences'] as $p)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($p->schedule)
                                                {{ $p->schedule->classType->name ?? '-' }}<br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($p->schedule->start_time)->format('H:i') }} WIB</small>
                                            @else
                                                <span class="text-danger fst-italic">Data Jadwal Terhapus</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td class="text-end fw-bold">{{ number_format($p->coach_fee, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="feather-alert-circle d-block fs-3 mb-2"></i>
                                            Belum ada sesi yang <b>APPROVED</b> admin pada bulan ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="3" class="text-end">Total ({{ count($result['presences']) }} sesi)</th>
                                        <th class="text-end">Rp {{ number_format($result['total'], 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($result['total'] > 0)
                        <form action="{{ route('admin.payouts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="coach_id" value="{{ $selectedCoach->id }}">
                            <input type="hidden" name="month" value="{{ $selectedMonth }}">
                            <input type="hidden" name="payout_type" value="session_fee">
                            <input type="hidden" name="total_sessions" value="{{ count($result['presences']) }}">
                            <input type="hidden" name="total_amount" value="{{ $result['total'] }}">
                            <input type="text" name="notes" class="form-control mb-3" placeholder="Catatan (opsional)">
                            <button type="submit" class="btn btn-success w-100 fw-bold py-3"
                                onclick="return confirm('Simpan pembayaran gaji ini?')">
                                <i class="feather-check-circle me-2"></i> BAYAR & SIMPAN DATA
                            </button>
                        </form>
                        @endif
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

<script>
function updatePTTotal() {
    const base = {{ $selectedCoach?->base_salary ?? 0 }};
    const bonus = parseFloat(document.getElementById('bonusInput')?.value || 0);
    const total = base + bonus;
    document.getElementById('bonusHidden').value = bonus;
    document.getElementById('ptTotalInput').value = total;
    document.getElementById('ptTotalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
@endsection