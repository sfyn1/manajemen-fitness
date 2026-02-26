<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ClassTypeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// --- 1. ROUTE TAMU (Hanya bisa diakses jika BELUM Login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // === LUPA PASSWORD ===
    Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    
    Route::get('/verify-otp', [App\Http\Controllers\ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
    Route::post('/verify-otp', [App\Http\Controllers\ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
    
    Route::get('/reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'updatePassword'])->name('password.update');
});

// --- 2. ROUTE TERAUTENTIKASI (Hanya bisa diakses jika SUDAH Login) ---
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Pintu Masuk Pintar (Redirect)
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Dashboard Owner (Bebas)
    Route::get('/owner/dashboard', function () { return "<h1>Halo Owner!</h1>"; })->name('owner.dashboard');
    
    // Dashboard PT/Coach (Bebas) - Redirect lama
    Route::get('/pt/dashboard', function () { return "<h1>Halo PT!</h1>"; })->name('pt.dashboard');
    
    // ==========================================
    // KHUSUS COACH
    // ==========================================
    Route::prefix('coach')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\CoachDashboardController::class, 'index'])->name('coach.dashboard');
        Route::post('/presence', [\App\Http\Controllers\CoachDashboardController::class, 'storePresence'])->name('coach.presence.store');
    });

    // ==========================================
    // KHUSUS MEMBER
    // ==========================================
    Route::prefix('member')->group(function () {
        // 1. Route Ganti Password (BEBAS AKSES)
        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('member.change-password.form');
        Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('member.change-password.update');

        // 2. Route Halaman Expired (BEBAS AKSES)
        Route::get('/expired', [AuthController::class, 'showExpiredPage'])->name('member.expired');

        // 3. Route Dashboard & Fitur Inti (DILINDUNGI)
        Route::middleware(['force.change.password', 'check.expiry'])->group(function () {
            
            // Dashboard
            Route::get('/dashboard', [App\Http\Controllers\MemberDashboardController::class, 'index'])->name('member.dashboard');
    
            // MODUL BOOKING KELAS
            // Nama route: booking.index, booking.store, booking.history
            Route::get('/booking', [\App\Http\Controllers\MemberBookingController::class, 'index'])->name('booking.index');
            Route::post('/booking', [\App\Http\Controllers\MemberBookingController::class, 'store'])->name('booking.store');
            Route::get('/my-classes', [\App\Http\Controllers\MemberBookingController::class, 'history'])->name('booking.history');
            Route::delete('/booking/{id}', [\App\Http\Controllers\MemberBookingController::class, 'destroy'])->name('booking.cancel');        });
    });
});

// --- 3. GRUP ROUTE ADMIN ---
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // DASHBOARD ADMIN
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // ROUTE GLOBAL SEARCH
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    
    // MODUL MEMBERSHIP
    Route::name('members.')->group(function () {
        Route::get('/members', [MemberController::class, 'index'])->name('index');
        Route::get('/members/create', [MemberController::class, 'create'])->name('create');
        Route::post('/members', [MemberController::class, 'store'])->name('store');
        Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('edit');
        Route::put('/members/{id}', [MemberController::class, 'update'])->name('update');
        Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('destroy');
        Route::get('/members/{id}/show', [MemberController::class, 'show'])->name('show');
        Route::get('/members/{id}/card', [MemberController::class, 'card'])->name('card');
        Route::post('/members/print-pdf-image', [MemberController::class, 'printPdfImage'])->name('print-pdf-image');
    });

    // MODUL PRESENSI MEMBER
    Route::name('presences.')->group(function () {
        Route::get('/scan', [PresenceController::class, 'index'])->name('scan');
        Route::post('/scan', [PresenceController::class, 'store'])->name('store');
        Route::get('/presence-history', [PresenceController::class, 'history'])->name('history');
        Route::get('/presences/report', [PresenceController::class, 'report'])->name('report');
        Route::get('/coach-approval', [\App\Http\Controllers\CoachPresenceController::class, 'index'])->name('coach'); // admin.presences.coach
        Route::post('/coach-approval/{id}/approve', [\App\Http\Controllers\CoachPresenceController::class, 'approve'])->name('approve'); // admin.presences.approve
    });

    // MODUL JADWAL
    Route::name('coaches.')->group(function () {
        Route::get('/coaches', [CoachController::class, 'index'])->name('index');
        Route::post('/coaches', [CoachController::class, 'store'])->name('store');
        Route::delete('/coaches/{id}', [CoachController::class, 'destroy'])->name('destroy');
    });
    Route::name('classtypes.')->group(function () {
        Route::get('/classtypes', [ClassTypeController::class, 'index'])->name('index');
        Route::post('/classtypes', [ClassTypeController::class, 'store'])->name('store');
        Route::delete('/classtypes/{id}', [ClassTypeController::class, 'destroy'])->name('destroy');
    });
    Route::name('schedules.')->group(function () {
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('index');
        Route::post('/schedules', [ScheduleController::class, 'store'])->name('store');
        Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('destroy');
    });

    // MANAJEMEN USER
    Route::name('users.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('index');
        Route::post('/users', [UserController::class, 'store'])->name('store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // MODUL BILLING (DATA MASTER)
    Route::resource('membership-packages', \App\Http\Controllers\MembershipPackageController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    
    // 1. Billing Membership
    Route::get('billing', [\App\Http\Controllers\MembershipTransactionController::class, 'index'])->name('billing.index');
    Route::get('billing/create', [\App\Http\Controllers\MembershipTransactionController::class, 'create'])->name('billing.create');
    Route::post('billing', [\App\Http\Controllers\MembershipTransactionController::class, 'store'])->name('billing.store');
    Route::get('billing/pdf', [\App\Http\Controllers\MembershipTransactionController::class, 'printPdf'])->name('billing.pdf');
    
    // 2. Penjualan Produk
    Route::get('product-sales', [\App\Http\Controllers\ProductTransactionController::class, 'index'])->name('product-sales.index');
    Route::get('product-sales/create', [\App\Http\Controllers\ProductTransactionController::class, 'create'])->name('product-sales.create');
    Route::post('product-sales', [\App\Http\Controllers\ProductTransactionController::class, 'store'])->name('product-sales.store');
    Route::get('product-sales/pdf', [\App\Http\Controllers\ProductTransactionController::class, 'printPdf'])->name('product-sales.pdf');

    // MODUL PENGGAJIAN (PAYROLL)
    Route::get('payouts/calculate', [\App\Http\Controllers\CoachPayoutController::class, 'calculate'])->name('payouts.calculate');
    Route::get('payouts/{id}/print', [\App\Http\Controllers\CoachPayoutController::class, 'print'])->name('payouts.print');
    Route::resource('payouts', \App\Http\Controllers\CoachPayoutController::class);
});