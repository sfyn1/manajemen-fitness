<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Gintung Master Fitness</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/images/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/vendors/css/feather.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/theme.min.css') }}" />
</head>

<body class="bg-white">
    <div class="row align-items-center justify-content-center g-0 min-vh-100">
        
        <div class="col-lg-6 col-md-8 col-sm-10 d-none d-lg-block">
            <div class="position-relative h-100 min-vh-100 d-flex flex-column justify-content-center bg-light">
                <img src="{{ asset('template/assets/images/auth/auth-cover-login-bg.svg') }}" alt="Login Image" class="img-fluid" />
                <div class="text-center mt-4">
                    <h3 class="fw-bold">Gintung Master Fitness</h3>
                    <p class="text-muted">Kelola kebugaran Anda dengan sistem manajemen modern.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-4">Silakan Masuk</h2>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="w-100">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="********" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary fw-bold">Login Sekarang</button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-muted mb-0">Lupa password? <a href="#" class="fw-bold text-primary">Hubungi Admin</a></p>
                    <p class="text-muted mt-3 fs-12">Kembali ke <a href="{{ url('/') }}" class="fw-bold text-dark">Halaman Utama</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('template/assets/vendors/js/vendors.min.js') }}"></script>
</body>
</html>