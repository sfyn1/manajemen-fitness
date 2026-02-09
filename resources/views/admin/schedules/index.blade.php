@extends('layouts.admin')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

<div class="container-fluid">
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Pengaturan Jadwal Mingguan</h2>
                <div class="text-muted">Susun jadwal kelas gym per hari.</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- FORM TAMBAH JADWAL - MODERN CLEAN DESIGN -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="feather-plus-circle me-2 text-primary"></i> Tambah Jadwal Baru
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hari <span class="text-danger">*</span></label>
                            <select name="day" class="form-select" required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Jam Mulai <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="feather-clock text-primary"></i>
                                    </span>
                                    <input type="text" name="start_time" class="form-control border-start-0 time-picker" placeholder="Pilih jam" required readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Jam Selesai <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="feather-clock text-primary"></i>
                                    </span>
                                    <input type="text" name="end_time" class="form-control border-start-0 time-picker" placeholder="Pilih jam" required readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelas <span class="text-danger">*</span></label>
                            <select name="class_type_id" class="form-select" id="classSelect" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($classTypes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Instruktur (Coach) <span class="text-danger">*</span></label>
                            <select name="coach_id" class="form-select" id="coachSelect" required>
                                <option value="">-- Pilih Coach --</option>
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}">
                                        {{ $coach->name }} 
                                        @if($coach->classType) ({{ $coach->classType->name }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            <i class="feather-save me-2"></i> Simpan Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- JADWAL MINGGUAN - MODERN CARD DESIGN -->
        <div class="col-md-8">
            @php
                $groupedSchedules = $schedules->groupBy('day');
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            @endphp

            @foreach($days as $day)
                @if(isset($groupedSchedules[$day]))
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary text-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-white">
                                <i class="feather-calendar me-2"></i>{{ strtoupper($day) }}
                            </h5>
                            <span class="badge bg-white text-primary px-3 py-2 fw-bold">{{ $groupedSchedules[$day]->count() }} Kelas</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($groupedSchedules[$day] as $schedule)
                            <div class="list-group-item border-0 border-bottom py-3 px-4">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="text-center bg-light rounded p-3" style="min-width: 120px;">
                                            <div class="fw-bold text-primary fs-4">{{ date('H:i', strtotime($schedule->start_time)) }}</div>
                                            <div class="text-muted small my-1">
                                                <i class="feather-arrow-down"></i>
                                            </div>
                                            <div class="fw-semibold text-dark fs-6">{{ date('H:i', strtotime($schedule->end_time)) }}</div>
                                            <div class="text-muted" style="font-size: 10px; margin-top: 4px;">
                                                @php
                                                    $start = strtotime($schedule->start_time);
                                                    $end = strtotime($schedule->end_time);
                                                    $diff = ($end - $start) / 60;
                                                @endphp
                                                {{ $diff }} menit
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-bold mb-1 text-dark">{{ $schedule->classType->name }}</h6>
                                        <div class="text-muted small">
                                            <i class="feather-user me-1"></i> {{ $schedule->coach->name }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger border" title="Hapus">
                                                <i class="feather-trash-2"></i>
                                            </button>
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
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="text-primary mb-3">
                            <i class="feather-calendar" style="font-size: 64px; opacity: 0.3;"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Jadwal</h5>
                        <p class="text-muted small">Silakan tambah jadwal di form sebelah kiri.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Gradient background untuk header hari */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    /* Hover effect untuk list item */
    .list-group-item:hover {
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }
    
    /* Form select styling */
    .form-select:focus,
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }
    
    /* Time picker modern styling */
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    .time-picker {
        cursor: pointer;
        background-color: white;
    }
    
    /* Flatpickr custom styling */
    .flatpickr-calendar {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
        border: none;
    }
    
    .flatpickr-time input:hover,
    .flatpickr-time input:focus {
        background: #f8f9fa;
    }
    
    .flatpickr-am-pm {
        background: #4e73df !important;
        color: white !important;
    }
</style>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr for time inputs
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.time-picker', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 15,
            defaultHour: 8,
            defaultMinute: 0,
            static: false,
            locale: {
                firstDayOfWeek: 1
            },
            onChange: function(selectedDates, dateStr, instance) {
                // Ensure the value is properly set
                instance.input.value = dateStr;
            }
        });
    });
</script>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({ 
            icon: 'success', 
            title: 'Berhasil', 
            text: "{{ session('success') }}", 
            timer: 2000, 
            showConfirmButton: false 
        });
    });
</script>
@endif
@endsection