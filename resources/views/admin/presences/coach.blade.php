@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 fw-bold">Approval Absensi Coach</h2>
                    </div>
                    <div>
                        <form action="{{ route('admin.presences.coach') }}" method="GET" class="d-flex gap-2">
                            <input type="date" name="date" class="form-control" value="{{ $date->format('Y-m-d') }}" onchange="this.form.submit()">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Jadwal: <span class="text-primary">{{ $date->translatedFormat('l, d F Y') }}</span></h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="text-center">
                    <tr>
                        <th class="px-4">Jam</th>
                        <th>Kelas & Coach</th>
                        <th>Bukti Foto</th>
                        <th>Status</th>
                        <th class="text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        {{-- Cari data laporan coach untuk jadwal ini & tanggal ini --}}
                        @php
                            $presence = \App\Models\CoachPresence::where('schedule_id', $schedule->id)
                                        ->whereDate('date', $date)
                                        ->first();
                        @endphp

                    <tr>
                        <td class="px-4 fw-bold">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $schedule->classType->name }}</div>
                            <div class="text-muted small"><i class="feather-user me-1"></i> {{ $schedule->coach->name }}</div>
                        </td>
                        <td class="text-center">
                            @if($presence && $presence->evidence_photo)
                                {{-- Tombol Biru Kecil --}}
                                <a href="{{ asset('storage/'.$presence->evidence_photo) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold" title="Lihat Foto Full">
                                    <i class="feather-image me-1"></i> LIHAT FOTO
                                </a>
                            @else
                                {{-- Jika Kosong --}}
                                <span class="badge bg-light text-secondary border">Belum Upload</span>
                            @endif
                        </td>
                        <td>
                            @if(!$presence)
                                <span class="badge bg-secondary">Menunggu Coach</span>
                            @elseif($presence->status == 'pending')
                                <span class="badge bg-warning text-dark">Butuh Approval</span>
                            @elseif($presence->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($presence->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            @if($presence && $presence->status == 'pending')
                                <form action="{{ route('admin.presences.approve', $presence->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success fw-bold shadow-sm">
                                        <i class="feather-check-circle me-1"></i> Approve
                                    </button>
                                </form>
                            @elseif($presence && $presence->status == 'approved')
                                <button class="btn btn-sm btn-light text-success border" disabled>
                                    <i class="feather-check"></i> Done
                                </button>
                            @else
                                <button class="btn btn-sm btn-light text-muted" disabled>
                                    Wait..
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Tidak ada jadwal latihan pada tanggal ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection