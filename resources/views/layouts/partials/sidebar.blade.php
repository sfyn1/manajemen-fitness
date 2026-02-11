<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ url('/') }}" class="b-brand">
                <img src="{{ asset('template/assets/images/logo-full.png') }}" alt="" class="logo logo-lg"/>
                <img src="{{ asset('template/assets/images/logo-abbr.png') }}" alt="" class="logo logo-sm"/>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboards</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ url('/admin/dashboard') }}">Dashboard Admin</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-caption">
                    <label>Modul Skripsi</label>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Member</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.members.index') }}">Manajemen Member</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-maximize"></i></span>
                        <span class="nxl-mtext">Presensi (QR)</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
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
                        <span class="nxl-micon"><i class="feather-calendar"></i></span>
                        <span class="nxl-mtext">Manajemen Jadwal</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.coaches.index') }}">Data Pelatih (PT)</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.classtypes.index') }}">Jenis Kelas</a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('admin.schedules.index') }}">Atur Jadwal</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-caption">
                    <label>Settings</label>
                </li>
                <li class="nxl-item">
                    <a class="nxl-link" href="{{ route('admin.users.index') }}">
                        <span class="nxl-micon"><i class="feather-user-check"></i></span>
                        <span class="nxl-mtext">Kelola Staff & Admin</span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>