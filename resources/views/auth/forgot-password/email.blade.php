<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h4 class="mb-3">Lupa Password?</h4>
                        <p class="text-muted fs-14">Masukkan email Anda, kami akan mengirimkan kode OTP.</p>
                        
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-3 text-start">
                                <label class="form-label">Email Terdaftar</label>
                                <input type="email" name="email" class="form-control" required placeholder="nama@email.com">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim Kode OTP</button>
                        </form>
                        <div class="mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none text-muted">Kembali ke Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>