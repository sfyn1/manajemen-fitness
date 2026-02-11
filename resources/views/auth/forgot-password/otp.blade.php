<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h4 class="mb-3">Verifikasi OTP</h4>
                        <div class="alert alert-info py-2 fs-14">
                            Kode OTP telah dikirim ke <strong>{{ session('reset_email') }}</strong>.
                            <br> (Cek file <code>storage/logs/laravel.log</code>)
                        </div>
                        
                        <form action="{{ route('password.otp.verify') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="number" name="otp" class="form-control text-center fs-20 fw-bold letter-spacing-2" placeholder="X X X X X X" required>
                                @error('otp') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <button type="submit" class="btn btn-success w-100">Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>