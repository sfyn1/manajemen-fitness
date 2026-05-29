@extends('layouts.admin') @section('content')
<div class="container-fluid">

    <!-- PAGE HEADER - MODERN DESIGN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 fw-bold">Daftar Member</h2>
                </div>
                <div>
                    <a href="{{ route('admin.members.create') }}" class="btn btn-primary shadow-sm">
                        <i class="feather-user-plus me-2"></i>
                        Tambah Member
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS ALERT - MODERN STYLE -->
    @if(session('success'))
    <div class="row mb-3">
        <div class="col-12">
            <div
                class="alert alert-success alert-dismissible fade show border-0 shadow-sm"
                role="alert">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="feather-check-circle fs-3 text-success"></i>
                    </div>
                    <div class="grow">
                        <h5 class="alert-heading mb-2">Berhasil!</h5>
                        <p class="mb-0">{{ session('success') }}</p>

                        @if(session('new_password'))
                        <div class="mt-3 p-3 bg-white rounded border border-success">
                            <div class="d-flex align-items-center mb-2">
                                <i class="feather-lock text-success me-2"></i>
                                <strong class="text-dark">Password Member Baru</strong>
                            </div>
                            <div class="bg-light p-3 rounded mb-2">
                                <h3 class="text-success mb-0 text-center fw-bold">{{ session('new_password') }}</h3>
                            </div>
                            <small class="text-muted">
                                <i class="feather-alert-circle me-1"></i>
                                Harap catat password ini karena tidak akan muncul lagi.
                            </small>
                        </div>
                        @endif
                    </div>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MEMBER TABLE - MODERN CARD -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th class="px-4 py-3 text-muted fw-semibold" style="width: 50px;">NO</th>
                                    <th class="py-3 text-muted fw-semibold">NAMA</th>
                                    <th class="py-3 text-muted fw-semibold">NO HP</th>
                                    <th class="py-3 text-muted fw-semibold">GENDER</th>
                                    <th class="py-3 text-muted fw-semibold">TGL GABUNG</th>
                                    <th class="py-3 text-muted fw-semibold">MASA AKTIF</th>
                                    <th class="py-3 text-muted fw-semibold">STATUS</th>
                                    <th class="py-3 text-muted fw-semibold text-center" style="width: 220px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $index => $user)
                                <tr id="member-{{ $user->member?->id ?? '' }}">
                                    <td class="px-4">
                                        <span class="text-muted fw-semibold">{{ $members->firstItem() + $loop->iteration - 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $user->member?->phone_number ?? '-' }}</span>
                                    </td>
                                    <td>
                                        {{ $user->member?->gender ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $user->member?->join_date ? \Carbon\Carbon::parse($user->member->join_date)->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="text-dark d-block">{{ $user->member?->expiry_date ? \Carbon\Carbon::parse($user->member->expiry_date)->format('d M Y') : '-' }}</span>
                                            @if($user->member && $user->member->isExpired())
                                            <small class="text-danger fw-bold">Expired</small>
                                            @else
                                            <small class="text-success">Aktif</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->member && $user->member->isExpired())
                                            <span class="badge bg-danger text-white">Expired</span>
                                        @else
                                            <span class="badge bg-success text-white">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">

                                            <!-- TOMBOL SHOW -->
                                            <a
                                                href="{{ route('admin.members.show', $user->id) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="Show">
                                                <i class="feather-eye"></i>
                                            </a>

                                            <!-- TOMBOL EDIT -->
                                            <a
                                                href="{{ route('admin.members.edit', $user->id) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="Edit Member">
                                                <i class="feather-edit-2"></i>
                                            </a>

                                            <!-- TOMBOL KARTU -->
                                            <a
                                                href="{{ route('admin.members.card', $user->id) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="Lihat Kartu Member">
                                                <i class="feather-credit-card"></i>
                                            </a>

                                            <!-- TOMBOL HAPUS -->
                                            <form
                                                action="{{ route('admin.members.destroy', $user->id) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus member ini? Data yang dihapus tidak bisa dikembalikan.')">
                                                @csrf @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus Member">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="feather-users" style="font-size: 48px; opacity: 0.3;"></i>
                                            <h5 class="mt-3 text-muted">Belum Ada Member</h5>
                                            <p class="mb-0">Klik tombol "Tambah Member Baru" untuk menambahkan member pertama.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
                    <div class="text-muted" style="font-size:13px;">
                        Menampilkan
                        <strong>{{ $members->firstItem() ?? 0 }}</strong>
                        –
                        <strong>{{ $members->lastItem() ?? 0 }}</strong>
                        dari
                        <strong>{{ $members->total() }}</strong>
                        data member
                    </div>
                    <div>
                        {{ $members->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* Modern Table Styling */
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        border-bottom-width: 1px;
        border-bottom-color: #f0f0f0;
    }

    .table thead th {
        border-bottom: 2px solid #e9ecef;
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Avatar Styling */
    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    /* Modern Button Hover Effects */
    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }

    /* Badge Modern Styling */
    .badge {
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.3px;
    }

    /* Alert Modern Styling */
    .alert {
        border-radius: 0.5rem;
    }

    /* Pink color for female gender */
    .bg-pink {
        background-color: #ff69b4 !important;
    }

    .text-pink {
        color: #ff69b4 !important;
    }

    /* ===== PAGINATION ===== */
    .card-footer .pagination {
        margin: 0 !important;
    }
    .card-footer .pagination .page-item .page-link {
        font-size: 13px;
        padding: 5px 10px;
        border-radius: 6px !important;
        margin: 0 2px;
        border-color: #e2e8f0;
        color: #4e73df;
    }
    .card-footer .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4e73df, #224abe);
        border-color: #4e73df;
        color: #fff;
    }
    .card-footer .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        background: transparent;
        border: none;
    }
</style>


{{-- SWEETALERT2 NOTIFICATIONS & WHATSAPP LOGIC --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Cek apakah ada notifikasi sukses biasa
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // 2. LOGIKA KIRIM WHATSAPP (Khusus setelah Create Member)
    @if(session('wa_data'))
        @php
            $waData = session('wa_data');
            // Format Nomor HP: Ganti 08... jadi 628...
            $phone = $waData['phone'];
            if (substr($phone, 0, 1) == '0') {
                $phone = '62' . substr($phone, 1);
            }
            
            // Pesan WhatsApp (Line break pakai %0a)
            $message = "Halo *{$waData['name']}*,%0a%0a"
                . "Selamat datang di *Gintung Master Fitness*%0a"
                . "Akun member Anda telah *berhasil diaktifkan* dan siap digunakan.%0a%0a"
                . "*Detail Login Aplikasi:*%0a"
                . "Email: {$waData['email']}%0a"
                . "Password: *{$waData['password']}*%0a%0a"
                . "Silakan login melalui link berikut:%0a"
                . "https://google.com%0a%0a"
                . "Demi keamanan akun, kami sangat menyarankan Anda untuk *segera mengganti password* setelah login.%0a%0a"
                . "Terima kasih atas kepercayaan Anda.%0a"
                . "*Gintung Master Fitness*";

        @endphp

        // Tampilkan Pop-up Konfirmasi Kirim WA
        Swal.fire({
            title: 'Kirimkan Akses Login',
            text: "Member baru berhasil dibuat. Kirim detail email & password ke WhatsApp member sekarang.",
            icon: 'question',
            confirmButtonColor: '#25D366', // Warna Hijau WA
            confirmButtonText: '<i class="feather-message-circle"></i> Kirim WhatsApp',
        }).then((result) => {
            if (result.isConfirmed) {
                // Buka Tab Baru ke API WhatsApp
                window.open("https://wa.me/{{ $phone }}?text={{ $message }}", "_blank");
            }
        });
    @endif
</script>
@endsection