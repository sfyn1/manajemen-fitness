<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Member</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body text-center p-5">
                <h1 class="mb-3">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="lead text-muted">Selamat datang di Dashboard Member Gintung Master Fitness.</p>
                <div class="alert alert-success d-inline-block">
                    Status Akun: <strong>Aktif</strong>
                </div>

                <hr class="my-4">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">
                        Keluar (Logout)
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>