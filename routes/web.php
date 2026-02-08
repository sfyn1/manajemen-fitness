<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
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

    // ... route index, create, store yang sudah ada ...

    // URL: /admin/members/{id}/edit (Form Edit)
    Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('edit');

    // URL: /admin/members/{id} (Proses Update - method PUT)
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('update');

    // URL: /admin/members/{id} (Proses Hapus - method DELETE)
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('destroy');
}); 

