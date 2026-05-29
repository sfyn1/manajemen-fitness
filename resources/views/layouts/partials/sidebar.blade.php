<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header" style="display: flex; justify-content: center; align-items: center; padding: 1rem 0;">
            <a href="{{ url('/') }}" class="b-brand" style="display: flex; justify-content: center; width: 100%;">
                <img
                    src="{{ asset('template/assets/images/logo-abbr.png') }}"
                    alt=""
                    class="logo logo-lg" style="height: 64px; width: auto;"/>
                <img
                    src="{{ asset('template/assets/images/logo-abbr.png') }}"
                    alt=""
                    class="logo logo-sm" style="height: 38px; width: auto;"/>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-airplay"></i>
                        </span>
                        <span class="nxl-mtext">Dashboards</span>
                        <span class="nxl-arrow">
                            <i class="feather-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ url('/admin/dashboard') }}">Dashboard Admin</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-caption">
                    <label>Modul</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-users"></i>
                        </span>
                        <span class="nxl-mtext">Member</span>
                        <span class="nxl-arrow">
                            <i class="feather-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.members.index') }}">Manajemen Member</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-maximize"></i>
                        </span>
                        <span class="nxl-mtext">Presensi (QR)</span>
                        <span class="nxl-arrow">
                            <i class="feather-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.presences.scan') }}">Scan Masuk</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.presences.history') }}">Kehadiran Member</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.presences.report') }}">Laporan Kunjungan</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-calendar"></i>
                        </span>
                        <span class="nxl-mtext">Pelatih</span>
                        <span class="nxl-arrow">
                            <i class="feather-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.coaches.index') }}">Data Pelatih & PT</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.classtypes.index') }}">Jenis Kelas Group</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.schedules.index') }}">Jadwal Kelas Group</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.presences.coach') }}">Approval Absensi</a>
                        </li>
                        <li class="nxl-item nxl-caption-inner" style="padding: 6px 16px;"><small class="text-muted opacity-50">Personal Trainer</small></li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.pt-packages.index') }}">Paket PT</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.pt-subscriptions.index') }}">Langganan PT Member</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.pt-sessions.index') }}">Monitoring Sesi PT</a>
                        </li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-credit-card"></i>
                        </span>
                        <span class="nxl-mtext">Billing</span>
                        <span class="nxl-arrow">
                            <i class="feather-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.membership-packages.index') }}">Paket & Harga Membership</a>
                        </li>
                    </ul>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.billing.index') }}">Perpanjang Membership</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-shopping-bag"></i>
                        </span>
                        <span class="nxl-mtext">Produk & Stok</span>
                        <span class="nxl-arrow">
                            <i class="feather-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.products.index') }}">Produk</a>
                        </li>
                    </ul>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.product-sales.index') }}">Penjualan Produk</a>
                        </li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-dollar-sign"></i>
                        </span>
                        <span class="nxl-mtext">Penggajian</span>
                        <span class="nxl-arrow">
                            <i class="feather-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.payouts.create') }}">Hitung Gaji</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.payouts.index') }}">Riwayat Slip Gaji</a>
                        </li>
                    </ul>
                </li>
                

                <li class="nxl-item nxl-caption">
                    <label>Settings</label>
                </li>
                <li class="nxl-item">
                    <a class="nxl-link" href="{{ route('admin.users.index') }}">
                        <span class="nxl-micon">
                            <i class="feather-user-check"></i>
                        </span>
                        <span class="nxl-mtext">Kelola Staff & Admin</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>