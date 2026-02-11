<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-center">Buat Password Baru</h4>
                        
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan Password Baru</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>