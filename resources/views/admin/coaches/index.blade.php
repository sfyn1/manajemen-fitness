@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Data Instruktur (Coach / PT)</h2>
                <div class="text-muted">Kelola data pelatih dan spesialisasi kelasnya.</div>
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
                        <thead>
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
                            <tr>
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
                    <h4 class="card-title"><i class="feather-plus-circle me-2"></i>Tambah Pelatih Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coaches.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Cth: Ade Rai" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Spesialis Kelas <span class="text-danger">*</span></label>
                            <select name="class_type_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($classTypes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                Kelas tidak ada? <a href="{{ route('admin.classtypes.index') }}">Buat Jenis Kelas dulu.</a>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="number" name="phone_number" class="form-control" placeholder="0812...">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="feather-save me-2"></i> Simpan Data
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