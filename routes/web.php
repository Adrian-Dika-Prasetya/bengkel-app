<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\SparepartController;
use Illuminate\Support\Facades\Route;

// 1. Redirect Halaman Utama langsung ke Halaman Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Route Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Group Route yang Membutuhkan Login (Auth Middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 4. Data Sparepart: khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('spareparts', SparepartController::class);
    });

    // 5. Data Pelanggan & Kendaraan: Admin & Kasir
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('pelanggans/create', [PelangganController::class, 'create'])->name('pelanggans.create');
        Route::post('pelanggans', [PelangganController::class, 'store'])->name('pelanggans.store');
        Route::delete('pelanggans/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggans.destroy');
        Route::resource('kendaraans', KendaraanController::class);
    });

    // 6. Transaksi Servis: semua role boleh melihat,
    //    mencatat transaksi khusus Admin & Kasir,
    //    update status diperbolehkan sesuai peran di controller
    Route::get('servises', [ServisController::class, 'index'])
        ->middleware('role:admin,kasir,mekanik')
        ->name('servises.index');
    Route::get('servises/create', [ServisController::class, 'create'])
        ->middleware('role:admin,kasir')
        ->name('servises.create');
    Route::post('servises', [ServisController::class, 'store'])
        ->middleware('role:admin,kasir')
        ->name('servises.store');
    Route::get('servises/{servis}', [ServisController::class, 'show'])
        ->middleware('role:admin,kasir,mekanik')
        ->name('servises.show');
    Route::get('servises/{servis}/nota', [ServisController::class, 'nota'])
        ->middleware('role:admin,kasir')
        ->name('servises.nota');
    Route::patch('servises/{servis}/status', [ServisController::class, 'updateStatus'])
        ->middleware('role:admin,kasir,mekanik')
        ->name('servises.status');
    Route::post('servises/{servis}/lunasi', [PembayaranController::class, 'lunasi'])
        ->middleware('role:admin,kasir')
        ->name('servises.lunasi');
    Route::post('servises/{servis}/pembayaran', [PembayaranController::class, 'store'])
        ->middleware('role:admin,kasir')
        ->name('servises.pembayaran');
});

// 7. Import Route Autentikasi Bawaan Breeze (Login, Register, Logout, dll)
require __DIR__.'/auth.php';
