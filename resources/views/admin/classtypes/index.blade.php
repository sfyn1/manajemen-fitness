@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Jenis Kelas Olahraga</h2>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassTypeModal">
                    <i class="feather-plus me-1"></i> Tambah Jenis Kelas
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Kelas Tersedia</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Durasi</th>
                                <th>Harga (Per Sesi)</th>
                                <th class="w-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($classTypes as $class)
                            <tr id="classtype-{{ $class->id }}">
                                <td>
                                    <div class="fw-bold fs-15">{{ $class->name }}</div>
                                    <div class="text-muted fs-12 text-truncate" style="max-width: 250px;">
                                        {{ $class->description ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="feather-clock me-1"></i> {{ $class->duration_minutes }} Menit
                                    </span>
                                </td>
                                <td>
                                    @if($class->price > 0)
                                        <span class="text-success fw-bold">Rp {{ number_format($class->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="badge bg-success">Gratis (Member)</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.classtypes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini? Jadwal terkait mungkin akan error.');">
                                        @csrf
                                        @method('DELETE')
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-icon btn-ghost-danger btn-sm" title="Hapus">
                                                <i class="feather-trash-2"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="feather-layers fs-1 d-block mb-2"></i>
                                    Belum ada jenis kelas.
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

{{-- ===== MODAL TAMBAH JENIS KELAS ===== --}}
<div class="modal fade" id="addClassTypeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="feather-plus-circle me-2"></i>Tambah Jenis Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.classtypes.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Cth: Zumba Sore" required>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Durasi (Menit)</label>
                                <input type="number" name="duration_minutes" class="form-control" value="60">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" value="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Penjelasan tentang kelas ini..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="feather-save me-1"></i> Simpan Kelas
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
@endsection