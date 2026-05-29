@extends('layouts.coach')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-1">🏋️ Jadwal Sesi PT Saya</h3>
            <p class="text-muted mb-0">Kelola sesi Personal Training hari ini</p>
        </div>
        <div>
            <form method="GET" action="{{ route('coach.pt.sessions') }}" class="d-flex gap-2">
                <input type="date" name="date" class="form-control"
                    value="{{ $targetDate->format('Y-m-d') }}"
                    max="{{ \Carbon\Carbon::today()->addDays(30)->format('Y-m-d') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="feather-search"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- Navigasi Tanggal --}}
    <div class="row g-2 mb-4">
        @for($i = 0; $i <= 6; $i++)
            @php
                $d = \Carbon\Carbon::today()->addDays($i);
                $isActive = $d->format('Y-m-d') === $targetDate->format('Y-m-d');
                $isSunday = $d->isSunday();
            @endphp
            <div class="col">
                <a href="{{ route('coach.pt.sessions', ['date' => $d->format('Y-m-d')]) }}"
                    class="card text-center py-2 px-1 text-decoration-none {{ $isActive ? 'bg-primary text-white' : ($isSunday ? 'bg-light opacity-50' : 'bg-white') }}"
                    style="border-radius: 10px; {{ $isSunday ? 'pointer-events:none;' : '' }}">
                    <small class="{{ $isActive ? 'text-white' : 'text-muted' }}">{{ $d->translatedFormat('D') }}</small>
                    <strong class="{{ $isActive ? 'text-white' : '' }}">{{ $d->format('d') }}</strong>
                    @if($isSunday)<br><small class="text-danger" style="font-size:10px;">Libur</small>@endif
                </a>
            </div>
        @endfor
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="feather-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Sesi Hari Ini --}}
    <h5 class="fw-bold mb-3">
        Sesi {{ $targetDate->translatedFormat('l, d F Y') }}
        <span class="badge bg-primary ms-2">{{ $sessions->count() }} sesi</span>
    </h5>

    @forelse($sessions as $session)
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                {{-- Info Sesi --}}
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar bg-blue-lt text-blue" style="width:48px;height:48px;font-size:1.2rem;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            {{ substr($session->member->user->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <strong>{{ $session->member->user->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ $session->member->user->phone_number ?? '-' }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 text-center">
                    <div class="fw-bold fs-5">{{ $session->time_range }}</div>
                    <small class="text-muted">Sesi #{{ $session->session_number }}</small>
                </div>

                <div class="col-md-2 text-center">
                    <span class="badge bg-{{ $session->status_color }} fs-6">{{ $session->status_label }}</span>
                </div>

                <div class="col-md-5">
                    @if($session->status === 'scheduled')
                    <div class="d-flex gap-2 justify-content-end">
                        {{-- Tandai Selesai --}}
                        <button class="btn btn-success" onclick="completeSession({{ $session->id }})">
                            <i class="feather-check me-1"></i> Selesai
                        </button>
                        {{-- No Show --}}
                        <form action="{{ route('coach.pt.sessions.noshow', $session->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning"
                                onclick="return confirm('Tandai member tidak hadir?')">
                                <i class="feather-user-x me-1"></i> No Show
                            </button>
                        </form>
                    </div>
                    @elseif($session->status === 'completed' && $session->notes)
                    <div class="bg-light rounded p-2">
                        <small class="text-muted">Catatan: </small>
                        <small>{{ $session->notes }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="feather-calendar d-block mb-3 opacity-25" style="font-size:3rem;"></i>
            <h5>Tidak ada sesi pada hari ini</h5>
            <p>Member akan memesan slot sesi melalui aplikasi mereka</p>
        </div>
    </div>
    @endforelse

    {{-- Sesi Mendatang (7 hari ke depan) --}}
    @if($upcomingSessions->isNotEmpty())
    <div class="mt-4">
        <h5 class="fw-bold mb-3">📅 Jadwal Mendatang (7 Hari)</h5>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Member</th>
                            <th>Waktu</th>
                            <th class="text-center">Sesi #</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingSessions as $s)
                        <tr>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($s->session_date)->translatedFormat('D, d M') }}</strong>
                            </td>
                            <td>{{ $s->member->user->name ?? 'N/A' }}</td>
                            <td>{{ $s->time_range }}</td>
                            <td class="text-center"><span class="badge bg-blue-lt text-blue">#{{ $s->session_number }}</span></td>
                            <td class="text-center"><span class="badge bg-{{ $s->status_color }}">{{ $s->status_label }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Modal Selesai Sesi --}}
<div class="modal fade" id="completeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="feather-check-circle me-2 text-success"></i>Tandai Sesi Selesai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="completeForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan Latihan (opsional)</label>
                        <textarea name="notes" class="form-control" rows="4"
                            placeholder="Tuliskan catatan latihan untuk member, misal: fokus pada squat, tambah beban 5kg, dll."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold">
                        <i class="feather-check me-1"></i> Simpan & Tandai Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function completeSession(id) {
    document.getElementById('completeForm').action = '/coach/pt-sessions/' + id + '/complete';
    new bootstrap.Modal(document.getElementById('completeModal')).show();
}
</script>
@endsection
