@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Manajemen Akun Staff</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Akun Terdaftar</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role & Kontak</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr id="user-{{ $user->id }}">
                                <td class="fw-bold">{{ $user->name }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-primary text-white">ADMIN</span>
                                    @elseif($user->role == 'owner')
                                        <span class="badge bg-warning text-white">OWNER</span>
                                    @else
                                        <span class="badge bg-info text-white">COACH</span>
                                    @endif
                                    
                                    <div class="small text-muted mt-1">
                                        <i class="feather-phone me-1"></i> {{ $user->phone_number }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(auth()->id() != $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-ghost-danger btn-sm" title="Hapus">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>
                                    @else
                                        <span class="badge bg-light text-muted">Akun Saya</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="feather-users fs-1 d-block mb-2"></i>
                                    Belum ada data staff lain.
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
                    <h4 class="card-title"><i class="feather-user-plus me-2"></i>Buat Akun Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Cth: Coach Budi">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role (Hak Akses) <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="owner">Owner (Pemilik)</option>
                                <option value="coach">Coach (Pelatih)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Login <span class="text-danger">*</span></label>
                            
                            {{-- Tambahkan class is-invalid jika ada error --}}
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}" placeholder="email@gym.com" required>
                            
                            {{-- MENAMPILKAN PESAN ERROR DI BAWAH INPUT --}}
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                                value="{{ old('phone_number') }}" placeholder="0812...">
                            
                            {{-- MENAMPILKAN PESAN ERROR --}}
                            @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                            <small class="text-muted">Untuk keperluan verifikasi OTP.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required placeholder="******">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="feather-save me-2"></i> Simpan Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}",
    });
</script>
@endif
@endsection