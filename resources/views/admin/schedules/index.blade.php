@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid">
    <!-- PAGE HEADER -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Pengaturan Jadwal Rutin</h2>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                    <i class="feather-plus me-1"></i> Tambah Jadwal
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @php
                $groupedSchedules = $schedules->groupBy('day');
                $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            @endphp

            @foreach($daysOrder as $day)
                @if(isset($groupedSchedules[$day]))
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0 text-dark">
                            <span class="badge bg-primary me-2">{{ $day }}</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($groupedSchedules[$day] as $schedule)
                            <div class="list-group-item border-0 border-bottom py-3">
                                <div class="row align-items-center">
                                    <div class="col-auto text-center" style="min-width: 100px;">
                                        <div class="fw-bold text-dark fs-5">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</div>
                                        <div class="text-muted small">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</div>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-bold mb-1">{{ $schedule->classType->name }}</h6>
                                        <small class="text-muted">
                                            <i class="feather-user me-1"></i> {{ $schedule->coach->name }}
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal rutin ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-light text-danger"><i class="feather-trash-2"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endforeach

            @if($schedules->isEmpty())
                <div class="alert alert-info text-center">Belum ada jadwal rutin yang dibuat.</div>
            @endif
        </div>
    </div>
</div>

{{-- ===== MODAL TAMBAH JADWAL ===== --}}
<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="feather-plus-circle me-2"></i>Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hari Rutin</label>
                        <select name="day" class="form-select" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mulai</label>
                        <input type="text" name="start_time" class="form-control time-picker" required placeholder="Pilih Jam Mulai">
                        <small class="text-muted">Jam selesai otomatis mengikuti durasi kelas.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Kelas</label>
                        <select name="class_type_id" id="classSelector" class="form-select" required>
                            <option value="">-- Pilih Kelas Dulu --</option>
                            @foreach($classTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Coach (Sesuai Spesialis)</label>
                        <select name="coach_id" id="coachSelector" class="form-select bg-light" required disabled>
                            <option value="">-- Pilih Kelas Diatas Dulu --</option>
                        </select>
                        <small class="text-muted" id="coachHelpText">Pilih jenis kelas untuk melihat coach yang tersedia.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="feather-save me-1"></i> Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Inisialisasi time picker di dalam modal
    flatpickr('.time-picker', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    // Data coach dari Laravel
    const allCoaches = @json($coaches);

    const classSelector = document.getElementById('classSelector');
    const coachSelector = document.getElementById('coachSelector');
    const coachHelpText = document.getElementById('coachHelpText');

    classSelector.addEventListener('change', function() {
        const selectedClassId = this.value;

        coachSelector.innerHTML = '<option value="">-- Pilih Coach --</option>';

        if (selectedClassId) {
            coachSelector.disabled = false;
            coachSelector.classList.remove('bg-light');

            const filteredCoaches = allCoaches.filter(coach => coach.class_type_id == selectedClassId);

            if (filteredCoaches.length > 0) {
                filteredCoaches.forEach(coach => {
                    const option = document.createElement('option');
                    option.value = coach.id;
                    option.textContent = coach.name;
                    coachSelector.appendChild(option);
                });
                coachHelpText.textContent = `Ditemukan ${filteredCoaches.length} coach untuk kelas ini.`;
                coachHelpText.className = "text-success small";
            } else {
                const option = document.createElement('option');
                option.textContent = "Tidak ada coach untuk spesialis ini";
                coachSelector.appendChild(option);
                coachHelpText.textContent = "Silakan tambah coach dengan spesialis ini di menu Data Pelatih.";
                coachHelpText.className = "text-danger small";
            }
        } else {
            coachSelector.disabled = true;
            coachSelector.classList.add('bg-light');
            coachSelector.innerHTML = '<option value="">-- Pilih Kelas Diatas Dulu --</option>';
            coachHelpText.textContent = "Pilih jenis kelas untuk melihat coach yang tersedia.";
            coachHelpText.className = "text-muted small";
        }
    });
</script>
@endsection