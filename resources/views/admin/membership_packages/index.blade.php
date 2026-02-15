@extends('layouts.admin')
@section('content')
<div class="container-fluid">

        <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Paket Membership</h2>
                    <p class="text-muted mb-0">Kelola paket membership</p>
                </div>
                <div>
                    <a href="{{ route('admin.members.create') }}" class="btn btn-primary shadow-sm">
                        <i class="feather-user-plus me-2"></i>
                        Tambah Paket Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Nama Paket</th>
                        <th>Durasi</th>
                        <th>Harga (IDR)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                    <tr>
                        <td class="px-4 fw-bold">{{ $package->name }}</td>
                        <td>{{ $package->duration_in_days }} Hari</td>
                        <td class="fw-bold text-success">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.membership-packages.edit', $package->id) }}" class="btn btn-sm btn-warning">
                                <i class="feather-edit"></i> Edit Harga
                            </a>
                            <form action="{{ route('admin.membership-packages.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="feather-trash-2"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4">Belum ada paket membership.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection