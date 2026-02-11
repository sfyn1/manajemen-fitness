<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganti Password - Gintung Master Fitness</title>
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/theme.min.css') }}">
</head>
<body>
    <div class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    
                    <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('template/assets/images/logo-abbr.png') }}" alt="" class="img-fluid">
                    </div>

                    <div class="card-body p-sm-5">
                        <div class="text-center mt-4">
                            <h4 class="fw-bold fs-20">Keamanan Akun</h4>
                            <p class="fs-12 text-muted">Halo <strong>{{ auth()->user()->name }}</strong>, karena Anda baru pertama kali login, silakan buat password baru demi keamanan.</p>
                        </div>

                        @if(session('warning'))
                            <div class="alert alert-warning fs-12">{{ session('warning') }}</div>
                        @endif

                        <form action="{{ route('member.change-password.update') }}" method="POST" class="mt-4">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ulangi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password..." required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold">SIMPAN PASSWORD</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-muted fs-12 text-decoration-none">Batal & Logout</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>