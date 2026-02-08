@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Daftar Member</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.members.create') }}" class="btn btn-primary btn-sm">
                        + Tambah Member Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Gender</th>
                                    <th>Tgl Gabung</th>
                                    <th>Masa Aktif</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->member->phone_number ?? '-' }}</td>
                                    <td>{{ $user->member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $user->member->join_date }}</td>
                                    <td>
                                        {{ $user->member->expiry_date }}
                                        @if($user->member->expiry_date < date('Y-m-d'))
                                            <span class="badge bg-danger">Expired</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($user->member->status) }}</td>
                                    <td>
                                        <a href="{{ route('admin.members.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.members.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus member ini? Data yang dihapus tidak bisa dikembalikan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection