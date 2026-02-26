@extends('layouts.admin')

@section('content')
<div class="nxl-content">
    <!-- Main Content -->
    <div class="main-content">
        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Members Card -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Member</span>
                                <h4 class="m-0">{{ number_format($totalMembers) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-info">
                                <i class="feather-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">+{{ $newMembersThisMonth }} bulan ini</small>
                    </div>
                </div>
            </div>

            <!-- Active Members This Week -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Aktif Minggu Ini</span>
                                <h4 class="m-0">{{ number_format($activeMembersThisWeek) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-success">
                                <i class="feather-activity"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">Member aktif</small>
                    </div>
                </div>
            </div>

            <!-- Total Coaches -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Coach</span>
                                <h4 class="m-0">{{ number_format($totalCoaches) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-warning">
                                <i class="feather-award"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">{{ $activeCoachesThisMonth }} aktif bulan ini</small>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Kelas</span>
                                <h4 class="m-0">{{ number_format($totalSchedules) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-danger">
                                <i class="feather-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">{{ $totalClassTypes }} tipe kelas</small>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Produk</span>
                                <h4 class="m-0">{{ number_format($totalProducts) }}</h4>
                            </div>
                            <div class="badge badge-lg bg-primary">
                                <i class="feather-shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">Produk terdaftar</small>
                    </div>
                </div>
            </div>

            <!-- Total Income -->
            <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="d-block text-muted fs-13 fw-medium mb-2">Total Income</span>
                                <h4 class="m-0">Rp{{ number_format($totalIncome, 0, ',', '.') }}</h4>
                            </div>
                            <div class="badge badge-lg bg-success">
                                <i class="feather-trending-up"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <small class="text-muted">Rp{{ number_format($thisMonthIncome, 0, ',', '.') }} bulan ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row mt-4">
            <!-- Member Registration Chart -->
            <div class="col-xl-6 col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pendaftaran Member (12 Bulan)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="memberRegistrationChart" height="60"></canvas>
                    </div>
                </div>
            </div>

            <!-- Income Chart -->
            <div class="col-xl-6 col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Income (12 Bulan Terakhir)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="incomeChart" height="60"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row mt-4">
            <!-- Attendance Chart -->
            <div class="col-xl-4 col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Kehadiran (7 Hari Terakhir)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <!-- Popular Classes Chart -->
            <div class="col-xl-4 col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Kelas Populer (Top 5)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="popularClassesChart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <!-- Coach Performance Chart -->
            <div class="col-xl-4 col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Coach Performance (Top 5)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="coachPerformanceChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Color Palette
    const primaryColor = '#3b82f6';
    const successColor = '#10b981';
    const dangerColor = '#ef4444';
    const warningColor = '#f59e0b';
    const infoColor = '#06b6d4';

    // 1. Member Registration Chart (Line Chart)
    const memberRegistrationCtx = document.getElementById('memberRegistrationChart').getContext('2d');
    new Chart(memberRegistrationCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($memberRegistrationChart['labels']) !!},
            datasets: [{
                label: 'Pendaftaran Member',
                data: {!! json_encode($memberRegistrationChart['data']) !!},
                borderColor: primaryColor,
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: primaryColor,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 2. Income Chart (Bar Chart)
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    new Chart(incomeCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($incomeChart['labels']) !!},
            datasets: [{
                label: 'Income (Rp)',
                data: {!! json_encode($incomeChart['data']) !!},
                backgroundColor: [
                    primaryColor,
                    successColor,
                    dangerColor,
                    warningColor,
                    infoColor,
                    primaryColor,
                    successColor,
                    dangerColor,
                    warningColor,
                    infoColor,
                    primaryColor,
                    successColor
                ],
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 3. Attendance Chart (Area Chart)
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($attendanceChart['labels']) !!},
            datasets: [{
                label: 'Kehadiran',
                data: {!! json_encode($attendanceChart['data']) !!},
                borderColor: successColor,
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: successColor,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 4. Popular Classes Chart (Horizontal Bar)
    const popularClassesCtx = document.getElementById('popularClassesChart').getContext('2d');
    new Chart(popularClassesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($popularClassesChart['labels']) !!},
            datasets: [{
                label: 'Jumlah Jadwal',
                data: {!! json_encode($popularClassesChart['data']) !!},
                backgroundColor: dangerColor,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 5. Coach Performance Chart (Horizontal Bar)
    const coachPerformanceCtx = document.getElementById('coachPerformanceChart').getContext('2d');
    new Chart(coachPerformanceCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($coachPerformanceChart['labels']) !!},
            datasets: [{
                label: 'Jumlah Kelas',
                data: {!! json_encode($coachPerformanceChart['data']) !!},
                backgroundColor: warningColor,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endsection
