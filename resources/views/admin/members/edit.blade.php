@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Edit Member</h4>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.members.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No HP / WhatsApp</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->member->phone_number) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-select" required>
                                    <option value="Laki-Laki" {{ $user->member->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $user->member->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $user->member->address) }}</textarea>
                        </div>

                        <!-- SUBMIT BUTTONS -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.members.index') }}" class="btn btn-light px-4">
                                <i class="feather-x me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="feather-save me-2"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection