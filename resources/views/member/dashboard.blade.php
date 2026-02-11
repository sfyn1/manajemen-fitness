<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Member - Gintung Master Fitness</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/feather.min.css') }}">
    <style>
        body { background-color: #f3f4f6; }
        
        /* Desain Kartu Mirip Admin */
        .member-card {
            background-color: #1e293b; /* Warna Dasar Gelap */
            color: white;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Hiasan background agar estetik */
        .member-card::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 200px; height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .qr-container {
            background: white;
            padding: 8px;
            border-radius: 8px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <span class="navbar-brand fw-bold">
                <i class="feather-activity me-1"></i> GMF MEMBER
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-danger"><i class="feather-log-out"></i> Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            
            <div class="col-md-5 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">KARTU MEMBER ANDA</div>
                    <div class="card-body">
                        
                        <div class="member-card p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="fw-bold mb-0 text-uppercase">{{ $user->name }}</h5>
                                    <small class="text-white-50">Member ID: {{ $member->id }}</small> <div class="mt-4">
                                        <div class="small text-white-50">Bergabung</div>
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($member->join_date)->format('d M Y') }}</div>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <div class="small text-white-50">Masa Aktif</div>
                                        <div class="fw-bold text-warning">{{ \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') }}</div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="qr-container">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $member->id }}" 
                                             alt="QR Code" 
                                             width="100">
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted small mt-3 text-center mb-0">
                            <i class="feather-info"></i> Tunjukkan QR Code ini kepada Admin/Scanner untuk presensi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">RIWAYAT KUNJUNGAN TERAKHIR</div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPresences as $presence)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($presence->created_at)->translatedFormat('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($presence->created_at)->format('H:i') }} WIB</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada data latihan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>