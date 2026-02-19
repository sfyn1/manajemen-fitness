@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid">
    <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Pengaturan Jadwal Rutin</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="feather-plus-circle me-1"></i> Tambah Jadwal</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                
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

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold">Mulai</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Selesai</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
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

                <div class="mb-4">
                    <label class="form-label fw-bold">Coach (Sesuai Spesialis)</label>
                    <select name="coach_id" id="coachSelector" class="form-select bg-light" required disabled>
                        <option value="">-- Pilih Kelas Diatas Dulu --</option>
                    </select>
                    <small class="text-muted" id="coachHelpText">Pilih jenis kelas untuk melihat coach yang tersedia.</small>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    SIMPAN JADWAL
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. Ambil Data Coach dari Laravel ke JavaScript
    const allCoaches = @json($coaches);

    // 2. Ambil Elemen Dropdown
    const classSelector = document.getElementById('classSelector');
    const coachSelector = document.getElementById('coachSelector');
    const coachHelpText = document.getElementById('coachHelpText');

    // 3. Event Listener: Saat Kelas Dipilih
    classSelector.addEventListener('change', function() {
        const selectedClassId = this.value;

        // Reset Dropdown Coach
        coachSelector.innerHTML = '<option value="">-- Pilih Coach --</option>';
        
        if (selectedClassId) {
            // Aktifkan Dropdown Coach
            coachSelector.disabled = false;
            coachSelector.classList.remove('bg-light');

            // FILTER: Cari coach yang spesialisnya SAMA dengan kelas yang dipilih
            // (Pastikan di database kolomnya class_type_id)
            const filteredCoaches = allCoaches.filter(coach => coach.class_type_id == selectedClassId);

            if (filteredCoaches.length > 0) {
                // Masukkan coach yang cocok ke dropdown
                filteredCoaches.forEach(coach => {
                    const option = document.createElement('option');
                    option.value = coach.id;
                    option.textContent = coach.name; // Tampilkan nama coach
                    coachSelector.appendChild(option);
                });
                coachHelpText.textContent = `Ditemukan ${filteredCoaches.length} coach untuk kelas ini.`;
                coachHelpText.className = "text-success small";
            } else {
                // Jika tidak ada coach yang cocok
                const option = document.createElement('option');
                option.textContent = "Tidak ada coach untuk spesialis ini";
                coachSelector.appendChild(option);
                coachHelpText.textContent = "Silakan tambah coach dengan spesialis ini di menu Data Pelatih.";
                coachHelpText.className = "text-danger small";
            }
        } else {
            // Jika user memilih "-- Pilih Kelas Dulu --"
            coachSelector.disabled = true;
            coachSelector.classList.add('bg-light');
            coachSelector.innerHTML = '<option value="">-- Pilih Kelas Diatas Dulu --</option>';
            coachHelpText.textContent = "Pilih jenis kelas untuk melihat coach yang tersedia.";
            coachHelpText.className = "text-muted small";
        }
    });
</script>

        <div class="col-md-8">
            @php
                // Grouping jadwal berdasarkan Hari untuk ditampilkan per blok
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('.time-picker', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>
@endsection