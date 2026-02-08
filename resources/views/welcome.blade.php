<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gintung Master Fitness | Management System</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/images/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/vendors/css/feather.min.css') }}" />
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar Transparan */
        .navbar-landing {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #3454d1 !important; /* Warna Utama Duralux */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(32, 54, 150, 0.9) 0%, rgba(13, 20, 60, 0.8) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 40px;
            font-weight: 300;
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background-color: #fff;
        }

        .feature-card {
            border: none;
            border-radius: 15px;
            padding: 30px;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(52, 84, 209, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: #eef2ff;
            color: #3454d1;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Footer */
        .footer {
            background-color: #0b1120;
            color: rgba(255, 255, 255, 0.7);
            padding: 50px 0 30px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-landing">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="feather-activity me-2"></i>Gintung Fitness
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('admin.members.index') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
                            <i class="feather-log-in me-2"></i> Masuk Sistem
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="beranda" class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center hero-content">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">Sistem Informasi Manajemen Gym</span>
                    <h1 class="hero-title">Kelola Kebugaran dengan <br> Teknologi Modern</h1>
                    <p class="hero-subtitle">
                        Solusi digital untuk manajemen membership, presensi QR Code, dan penjadwalan latihan di Gintung Master Fitness. Efisien, Akurat, dan Real-time.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('admin.members.index') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold">
                            Mulai Sekarang
                        </a>
                        <a href="#fitur" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h6 class="text-primary fw-bold text-uppercase ls-2">Keunggulan Sistem</h6>
                    <h2 class="fw-bold display-5 mb-3">Apa yang Bisa Dilakukan?</h2>
                    <p class="text-muted lead">Sistem ini dirancang untuk mengatasi masalah manual yang sering terjadi di operasional gym sehari-hari.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="feather-users"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Manajemen Anggota</h4>
                        <p class="text-muted">
                            Pencatatan data member yang terpusat. Monitoring masa aktif, perpanjangan paket, dan status keanggotaan secara otomatis.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="feather-maximize"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Presensi Scan QR</h4>
                        <p class="text-muted">
                            Proses check-in yang cepat hanya dengan scan QR Code. Mengurangi antrian dan memastikan data kunjungan yang akurat.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="feather-calendar"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Jadwal & Kelas</h4>
                        <p class="text-muted">
                            Atur jadwal Personal Trainer dan kelas latihan (Muaythai, Boxing) dengan mudah tanpa bentrok jadwal manual.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <h5 class="text-white fw-bold mb-1">Gintung Master Fitness</h5>
                    <p class="fs-12 mb-0">Sistem Informasi Manajemen Berbasis Web</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="mb-0 fs-12">&copy; {{ date('Y') }} Sufyan Dzaki. Skripsi UIN Jakarta.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('template/assets/js/bootstrap.min.js') }}"></script>
</body>
</html>