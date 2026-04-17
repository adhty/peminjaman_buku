<?php

use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;


use App\Http\Controllers\Siswa\BukuController as SiswaBukuController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfilController;
use App\Http\Controllers\Siswa\TransaksiController as SiswaTransaksiController;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfileController;

// 🔥 TAMBAHAN CONTROLLER STATISTIK
use App\Http\Controllers\Siswa\StatistikController;

use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', fn() => redirect()->route('login'));


// ======================
// AUTH
// ======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('login.verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('login.verify-otp.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================
// PASSWORD RESET (OTP)
// ======================
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetOtp'])->name('password.email');

Route::get('/reset-password/verify', [PasswordResetController::class, 'showVerifyOtp'])->name('password.verify-otp');
Route::post('/reset-password/verify', [PasswordResetController::class, 'verifyOtp'])->name('password.verify-otp.post');

Route::get('/reset-password/new', [PasswordResetController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password/new', [PasswordResetController::class, 'resetPassword'])->name('password.update');



// ======================
// ADMIN
// ======================
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Buku
    Route::resource('buku', BukuController::class);
    Route::post('/buku/import', [BukuController::class, 'importExcel'])->name('buku.import');
    Route::get('/buku/template/download', [BukuController::class, 'downloadTemplate'])->name('buku.template');

    // Anggota
    Route::resource('anggota', AnggotaController::class)->parameters([
        'anggota' => 'anggota'
    ]);

    // User
    Route::resource('user', UserController::class);

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/{id}/approve', [TransaksiController::class, 'approve'])->name('transaksi.approve');
    Route::post('/transaksi/{id}/reject', [TransaksiController::class, 'reject'])->name('transaksi.reject');
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::post('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    Route::get('/transaksi/export/{type}', [TransaksiController::class, 'exportTransaksi'])->name('transaksi.export');

    // Pengembalian
    Route::get('/pengembalian', [TransaksiController::class, 'pengembalian'])->name('pengembalian.index');
    Route::get('/pengembalian/export/{type}', [TransaksiController::class, 'exportPengembalian'])->name('pengembalian.export');
});


// ======================
// SISWA
// ======================
Route::prefix('siswa')->middleware(['auth', 'siswa'])->name('siswa.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // 🔥 LENGKAPI PROFIL (ANGGOTA)
    Route::get('/profil/lengkapi', [SiswaProfilController::class, 'create'])->name('profil.create');
    Route::post('/profil/lengkapi', [SiswaProfilController::class, 'store'])->name('profil.store');

    // 🔥 PROFILE SIDEBAR (EDIT USER)
    Route::get('/profile', [SiswaProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [SiswaProfileController::class, 'update'])->name('profile.update');

    // 📊 STATISTIK PEMINJAMAN (TAMBAHAN)
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    // Buku
    Route::get('/buku', [SiswaBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [SiswaBukuController::class, 'show'])->name('buku.show');
    Route::post('/buku/{id}/pinjam', [SiswaBukuController::class, 'pinjam'])->name('buku.pinjam');

    // Transaksi
    Route::get('/transaksi', [SiswaTransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/{id}/kembalikan', [SiswaTransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
});