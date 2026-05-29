@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold mb-1">Paket Personal Trainer</h2>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Daftar Paket --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Daftar Paket</h5>
                    <span class="badge bg-primary-lt">{{ $packages->count() }} Paket</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Nama Paket</th>
                                <th class="text-center">Sesi</th>
                                <th class="text-center">Durasi/Sesi</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $pkg)
                            <tr>
                                <td>
                                    <strong>{{ $pkg->name }}</strong>
                                    @if($pkg->description)
                                        <br><small class="text-muted">{{ Str::limit($pkg->description, 50) }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-blue text-white fs-6">{{ $pkg->session_count }}x</span>
                                </td>
                                <td class="text-center">{{ $pkg->duration_minutes }} menit</td>
                                <td class="text-end fw-bold">Rp {{ number_format($pkg->price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($pkg->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        {{-- Toggle Aktif --}}
                                        <form action="{{ route('admin.pt-packages.toggle', $pkg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $pkg->is_active ? 'btn-ghost-warning' : 'btn-ghost-success' }}" 
                                                title="{{ $pkg->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="feather-{{ $pkg->is_active ? 'eye-off' : 'eye' }}"></i>
                                            </button>
                                        </form>
                                        {{-- Edit --}}
                                        <button class="btn btn-sm btn-ghost-info" 
                                            onclick="editPackage({{ $pkg->id }}, '{{ $pkg->name }}', {{ $pkg->price }}, {{ $pkg->duration_minutes }}, '{{ $pkg->description }}')"
                                            title="Edit">
                                            <i class="feather-edit-2"></i>
                                        </button>
                                        {{-- Hapus --}}
                                        <form action="{{ route('admin.pt-packages.destroy', $pkg->id) }}" method="POST" 
                                            onsubmit="return confirm('Hapus paket ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-ghost-danger" title="Hapus">
                                                <i class="feather-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="feather-package d-block mb-2" style="font-size:2rem;"></i>
                                    Belum ada paket PT. Tambahkan di sebelah kanan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Form Tambah Paket --}}
        <div class="col-lg-4">
            <div class="card" id="formCard">
                <div class="card-header">
                    <h5 class="card-title mb-0" id="formTitle">
                        <i class="feather-plus-circle me-2"></i>Tambah Paket Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form id="packageForm" action="{{ route('admin.pt-packages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <input type="hidden" name="package_id" id="packageId" value="">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="pkgName" class="form-control" 
                                placeholder="cth: Paket Starter 5 Sesi" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Sesi <span class="text-danger">*</span></label>
                            <select name="session_count" id="pkgSessionCount" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="5">5 Sesi</option>
                                <option value="10">10 Sesi</option>
                                <option value="20">20 Sesi</option>
                                <option value="30">30 Sesi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Durasi per Sesi <span class="text-danger">*</span></label>
                            <select name="duration_minutes" id="pkgDuration" class="form-select" required>
                                <option value="60">60 Menit (1 Jam)</option>
                                <option value="120">120 Menit (2 Jam)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Paket (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="pkgPrice" class="form-control" 
                                placeholder="cth: 500000" min="1" required>
                        </div>



                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" id="pkgDescription" class="form-control" rows="2" 
                                placeholder="Deskripsi singkat paket..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold" id="submitBtn">
                            <i class="feather-save me-1"></i> SIMPAN PAKET
                        </button>
                        <button type="button" class="btn btn-light w-100 mt-2" onclick="resetForm()" id="cancelBtn" style="display:none;">
                            Batal Edit
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
@if(session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}", timer: 4000, showConfirmButton: false });
    });
</script>
@endif

<script>
function editPackage(id, name, price, duration, description) {
    document.getElementById('formTitle').innerHTML = '<i class="feather-edit-2 me-2"></i>Edit Paket';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('packageId').value = id;
    document.getElementById('packageForm').action = '/admin/pt-packages/' + id;
    document.getElementById('pkgName').value = name;
    document.getElementById('pkgPrice').value = price;
    document.getElementById('pkgDuration').value = duration;
    document.getElementById('pkgDescription').value = description || '';
    document.getElementById('submitBtn').innerHTML = '<i class="feather-save me-1"></i> UPDATE PAKET';
    document.getElementById('cancelBtn').style.display = 'block';
    document.getElementById('formCard').scrollIntoView({ behavior: 'smooth' });
}

function resetForm() {
    document.getElementById('formTitle').innerHTML = '<i class="feather-plus-circle me-2"></i>Tambah Paket Baru';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('packageForm').action = '{{ route("admin.pt-packages.store") }}';
    document.getElementById('packageForm').reset();
    document.getElementById('submitBtn').innerHTML = '<i class="feather-save me-1"></i> SIMPAN PAKET';
    document.getElementById('cancelBtn').style.display = 'none';
}
</script>
@endsection
