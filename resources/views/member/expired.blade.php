<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masa Aktif Habis</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f8f9fa; }
        .expired-card { max-width: 500px; margin: 80px auto; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card expired-card shadow-lg border-0 text-center">
            <div class="card-body p-5">
                <div class="mb-4">
                    <img src="{{ asset('template/assets/images/logo-abbr.png') }}" alt="Logo" width="60" class="mb-3">
                    <h2 class="text-danger fw-bold">Masa Aktif Habis!</h2>
                </div>
                
                <p class="text-muted mb-4">
                    Halo <strong>{{ Auth::user()->name }}</strong>,<br>
                    Keanggotaan (Membership) Anda telah berakhir pada tanggal:<br>
                    <span class="badge bg-danger fs-6 mt-2">
                        {{ \Carbon\Carbon::parse(Auth::user()->member->expiry_date)->format('d F Y') }}
                    </span>
                </p>

                <div class="alert alert-warning fs-13 text-start">
                    <i class="feather-info me-1"></i> 
                    Anda tidak dapat mengakses Dashboard latihan. Silakan hubungi Admin atau lakukan pembayaran (Billing) untuk memperpanjang akses.
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-secondary" disabled>Modul Billing (Coming Soon)</button>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">Keluar Aplikasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>