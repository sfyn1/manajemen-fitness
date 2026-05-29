@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-1">Manajemen Coach & Personal Trainer</h2>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs mb-4" id="coachTab">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-pt">
                <i class="feather-user me-1"></i> Personal Trainer
                <span class="badge bg-blue ms-1">{{ $personalTrainers->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-group">
                <i class="feather-users me-1"></i> Group Class Coach
                <span class="badge bg-blue ms-1">{{ $groupCoaches->count() }}</span>
            </a>
        </li>
        <li class="nav-item ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoachModal">
                <i class="feather-plus me-1"></i> Tambah Coach
            </button>
        </li>
    </ul>

    <div class="tab-content">
        {{-- ===== TAB: PERSONAL TRAINER ===== --}}
        <div class="tab-pane fade show active" id="tab-pt">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">👤 Personal Trainer — Gaji Bulanan Flat</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th>Profil</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th class="text-end">Gaji Pokok/Bln</th>
                                <th class="text-center">Kontrak</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($personalTrainers as $coach)
                            <tr id="coach-{{ $coach->id }}">
                                <td>
                                    <span class="avatar bg-purple-lt text-purple">{{ substr($coach->name, 0, 1) }}</span>
                                </td>
                                <td>
                                    <strong>{{ $coach->name }}</strong>
                                    <br><small class="badge bg-purple-lt text-purple">Personal Trainer</small>
                                </td>
                                <td>{{ $coach->phone_number ?? '-' }}</td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($coach->base_salary, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($coach->contract_start_date && $coach->contract_end_date)
                                        <small>{{ $coach->contract_start_date->format('d/m/Y') }}</small><br>
                                        <small>s/d {{ $coach->contract_end_date->format('d/m/Y') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.coaches.destroy', $coach->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus PT ini? Pastikan tidak ada member aktif.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-ghost-danger btn-sm" title="Hapus">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="feather-user-plus d-block mb-2 fs-2 opacity-25"></i>
                                    Belum ada Personal Trainer.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== TAB: GROUP COACH ===== --}}
        <div class="tab-pane fade" id="tab-group">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">👥 Group Class Coach — Bayaran Per Sesi</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th>Profil</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th class="text-center">Spesialisasi Kelas</th>
                                <th class="text-end">Rate/Sesi</th>
                                <th class="text-center">Jadwal Aktif</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($groupCoaches as $coach)
                            <tr id="coach-{{ $coach->id }}">
                                <td>
                                    <span class="avatar bg-blue-lt text-blue">{{ substr($coach->name, 0, 1) }}</span>
                                </td>
                                <td>
                                    <strong>{{ $coach->name }}</strong>
                                    <br><small class="badge bg-blue-lt text-blue">Group Coach</small>
                                </td>
                                <td>{{ $coach->phone_number ?? '-' }}</td>
                                <td class="text-center">
                                    @if($coach->classType)
                                        <span class="badge bg-teal-lt text-teal border">{{ $coach->classType->name }}</span>
                                    @else
                                        <span class="text-danger small"><i class="feather-alert-circle me-1"></i>Belum diset</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold text-info">
                                    Rp {{ number_format($coach->session_rate, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $coach->schedules->count() }} jadwal</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.coaches.destroy', $coach->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus coach ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-ghost-danger btn-sm" title="Hapus">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="feather-users d-block mb-2 fs-2 opacity-25"></i>
                                    Belum ada Group Class Coach.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL TAMBAH COACH ===== --}}
<div class="modal fade" id="addCoachModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Coach / Personal Trainer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.coaches.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Pilih Akun --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Akun <span class="text-danger">*</span></label>
                        @php
                            $availableUsers = \App\Models\User::where('role', 'coach')->doesntHave('coachProfile')->get();
                        @endphp
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Pilih Akun User (role: coach) --</option>
                            @foreach($availableUsers as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->phone_number ?? 'No HP Kosong' }})</option>
                            @endforeach
                        </select>
                        @if($availableUsers->isEmpty())
                            <div class="alert alert-warning mt-2 small">
                                <i class="feather-alert-triangle me-1"></i>Tidak ada akun coach tersedia.
                                <a href="{{ route('admin.users.index') }}" class="fw-bold">Buat akun dulu</a>
                            </div>
                        @endif
                    </div>

                    {{-- Pilih Tipe --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe Coach <span class="text-danger">*</span></label>
                        <select name="coach_type" class="form-select" id="modalCoachType" required
                            onchange="toggleCoachTypeFields()">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="personal_trainer">👤 Personal Trainer (Gaji Bulanan)</option>
                            <option value="group_coach">👥 Group Class Coach (Per Sesi)</option>
                        </select>
                    </div>

                    {{-- FIELD PT --}}
                    <div id="ptFields" style="display:none;">
                        <hr><small class="text-muted fw-bold d-block mb-3">INFO PERSONAL TRAINER</small>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Gaji Pokok Bulanan (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="base_salary" class="form-control" placeholder="cth: 3000000" min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mulai Kontrak <span class="text-danger">*</span></label>
                                <input type="date" name="contract_start_date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Akhir Kontrak <span class="text-danger">*</span></label>
                                <input type="date" name="contract_end_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- FIELD GROUP COACH --}}
                    <div id="groupFields" style="display:none;">
                        <hr><small class="text-muted fw-bold d-block mb-3">INFO GROUP CLASS COACH</small>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Spesialisasi Kelas <span class="text-danger">*</span></label>
                            <select name="class_type_id" class="form-select">
                                <option value="">-- Pilih Jenis Kelas --</option>
                                @foreach($classTypes as $ct)
                                <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Coach hanya bisa mengajar kelas ini</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Bayaran per Sesi (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="session_rate" class="form-control" placeholder="cth: 50000" min="1">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="feather-save me-1"></i> Simpan Coach
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

<script>
function toggleCoachTypeFields() {
    const type = document.getElementById('modalCoachType').value;
    document.getElementById('ptFields').style.display    = type === 'personal_trainer' ? 'block' : 'none';
    document.getElementById('groupFields').style.display = type === 'group_coach' ? 'block' : 'none';
}
</script>
@endsection