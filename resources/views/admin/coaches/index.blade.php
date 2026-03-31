@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Data Instruktur Coach</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pelatih</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>Profil</th>
                                <th>Nama Lengkap</th>
                                <th>Mengajar Kelas (Spesialis)</th>
                                <th>No. HP</th>
                                <th class="w-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coaches as $coach)
                            <tr id="coach-{{ $coach->id }}">
                                <td>
                                    <span class="avatar bg-blue-lt">{{ substr($coach->name, 0, 1) }}</span>
                                </td>
                                <td class="fw-bold">{{ $coach->name }}</td>
                                <td>
                                    @if($coach->classType)
                                        <span class="fw-bold text-dark">{{ $coach->classType->name }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Belum ada kelas</span>
                                    @endif
                                </td>
                                <td>{{ $coach->phone_number ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.coaches.destroy', $coach->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pelatih ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-ghost-danger btn-sm" title="Hapus">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="feather-users fs-1 d-block mb-2"></i>
                                    Belum ada data pelatih.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
    <div class="card bg-light border-0 shadow-none">
        <div class="card-header bg-transparent border-0">
            <h4 class="card-title">
                <i class="feather-plus-circle me-2"></i>Tambah Pelatih Baru
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.coaches.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="mb-3">
        <label class="form-label fw-bold">Pilih Akun Coach <span class="text-danger">*</span></label>
        <select name="user_id" class="form-select" required>
            <option value="">-- Pilih Akun --</option>
            
            {{-- Logic: Ambil User role 'coach' yg belum ada di tabel coaches --}}
            @php
                $availableUsers = \App\Models\User::where('role', 'coach')->doesntHave('coachProfile')->get();
            @endphp

            @foreach($availableUsers as $u)
                {{-- Tampilkan Nama & No HP di opsi agar Admin yakin --}}
                <option value="{{ $u->id }}">
                    {{ $u->name }} ({{ $u->phone_number ?? 'No HP Kosong' }})
                </option>
            @endforeach
        </select>
        
        @if($availableUsers->isEmpty())
            <div class="alert alert-warning mt-2 small">
                <i class="feather-alert-triangle"></i> Tidak ada akun coach tersedia. 
                <a href="{{ route('admin.users.index') }}" class="fw-bold text-dark">Buat akun dulu disini.</a>
            </div>
        @else
            <small class="text-muted d-block mt-1">
                <i class="feather-info"></i> Nama & No. HP akan diambil otomatis dari akun yang dipilih.
            </small>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Spesialis Kelas <span class="text-danger">*</span></label>
        <select name="class_type_id" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($classTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100 fw-bold">
        <i class="feather-save me-1"></i> SIMPAN & HUBUNGKAN
    </button>
</form>
        </div>
    </div>
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
@endsection