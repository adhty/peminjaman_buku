<?php

use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Siswa\BukuController as SiswaBukuController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfilController;
use App\Http\Controllers\Siswa\TransaksiController as SiswaTransaksiController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', fn() => redirect()->route('login'));

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Buku CRUD
    Route::resource('buku', BukuController::class);

    // Anggota CRUD
    Route::resource('anggota', AnggotaController::class)->parameters([
        'anggota' => 'anggota'
    ]);

    // User CRUD
    Route::resource('user', UserController::class);

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    Route::get('/transaksi/export/{type}', [TransaksiController::class, 'exportTransaksi'])->name('transaksi.export');

    // Pengembalian
    Route::get('/pengembalian', [TransaksiController::class, 'pengembalian'])->name('pengembalian.index');
    Route::get('/pengembalian/export/{type}', [TransaksiController::class, 'exportPengembalian'])->name('pengembalian.export');
});

// Siswa Routes
Route::prefix('siswa')->middleware(['auth', 'siswa'])->name('siswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Lengkapi Profil
    Route::get('/profil/lengkapi', [SiswaProfilController::class, 'create'])->name('profil.create');
    Route::post('/profil/lengkapi', [SiswaProfilController::class, 'store'])->name('profil.store');

    // Katalog Buku
    Route::get('/buku', [SiswaBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [SiswaBukuController::class, 'show'])->name('buku.show');
    Route::post('/buku/{id}/pinjam', [SiswaBukuController::class, 'pinjam'])->name('buku.pinjam');

    // Riwayat Pinjaman
    Route::get('/transaksi', [SiswaTransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/{id}/kembalikan', [SiswaTransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
});
