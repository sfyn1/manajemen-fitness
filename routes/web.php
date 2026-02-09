<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresenceController;

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

// --- GRUP ROUTE ADMIN ---
Route::prefix('admin')->name('admin.')->group(function () {
    // 1. MODUL MEMBERSHIP
    // Semua route ini akan bernama: admin.members.xxx
    Route::name('members.')->group(function () {
        Route::get('/members', [MemberController::class, 'index'])->name('index');
        Route::get('/members/create', [MemberController::class, 'create'])->name('create');
        Route::post('/members', [MemberController::class, 'store'])->name('store');
        Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('edit');
        Route::put('/members/{id}', [MemberController::class, 'update'])->name('update');
        Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('destroy');
        Route::get('/members/{id}/card', [MemberController::class, 'card'])->name('card');
        Route::post('/members/print-pdf-image', [MemberController::class, 'printPdfImage'])->name('print-pdf-image');
    });

    // 2. MODUL PRESENSI (SCANNER)
    Route::name('presences.')->group(function () {
        // Halaman Scan
        Route::get('/scan', [PresenceController::class, 'index'])->name('scan');
        // Proses Simpan Data Scan
        Route::post('/scan', [PresenceController::class, 'store'])->name('store');
        // HALAMAN BARU: Kehadiran Member (Statistik)
        Route::get('/presence-history', [PresenceController::class, 'history'])->name('history');
        // --- TAMBAHAN BARU: ROUTE LAPORAN ---
        Route::get('/presences/report', [PresenceController::class, 'report'])->name('report');
    });
});