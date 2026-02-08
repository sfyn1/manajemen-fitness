<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


// --- ROUTE UNTUK LOGIN & LOGOUT ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- GROUP ROUTE BERDASARKAN ROLE (Middleware Auth) ---
// Artinya: Hanya user yang sudah login yang bisa akses ini
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard OWNER (Placeholder)
    Route::get('/owner/dashboard', function () {
        return "<h1>Halo Owner! Ini halaman Laporan & Statistik.</h1>";
    })->name('owner.dashboard');

    // 2. Dashboard MEMBER (Placeholder)
    Route::get('/member/dashboard', function () {
        return "<h1>Halo Member! Ini halaman profil & jadwal latihan Anda.</h1>";
    })->name('member.dashboard');

    // 3. Dashboard PERSONAL TRAINER (Placeholder)
    Route::get('/pt/dashboard', function () {
        return "<h1>Halo Coach/PT! Ini halaman jadwal melatih Anda.</h1>";
    })->name('pt.dashboard');
    
    // 4. Dashboard COACH (Placeholder) - Bisa disatukan dengan PT kalau mirip
    Route::get('/coach/dashboard', function () {
        return "<h1>Halo Coach Kelas! Ini halaman jadwal kelas besar.</h1>";
    })->name('coach.dashboard');

});



// ... kode route lainnya ...

// Grup Route khusus untuk Admin
// (Nanti kita tambahkan middleware 'auth' & 'admin' di sini agar aman)
Route::prefix('admin')->name('admin.members.')->group(function () {
    
    // URL: /admin/members (Daftar Member)
    Route::get('/members', [MemberController::class, 'index'])->name('index');

    // URL: /admin/members/create (Form Tambah)
    Route::get('/members/create', [MemberController::class, 'create'])->name('create');

    // URL: /admin/members/store (Proses Simpan)
    Route::post('/members', [MemberController::class, 'store'])->name('store');

    // URL: /admin/members/{id}/edit (Form Edit)
    Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('edit');

    // URL: /admin/members/{id} (Proses Update - method PUT)
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('update');

    // URL: /admin/members/{id} (Proses Hapus - method DELETE)
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('destroy');
}); 

