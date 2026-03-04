<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RekapPraktikumController;
use App\Http\Controllers\DashboardController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/rekap-praktikum', [RekapPraktikumController::class, 'index'])
    ->name('rekap-praktikum.index');

Route::post('/rekap-praktikum/download', 
    [RekapPraktikumController::class, 'downloadPdf']
)->name('rekap-praktikum.download');

Route::post('/rekap-praktikum/preview',
    [RekapPraktikumController::class, 'preview']
)->name('rekap-praktikum.preview');




    // User Management
    Route::resource('users', UserController::class);

    // Lab Management
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::patch('/jadwal/{id}/move', [JadwalController::class, 'move'])->name('jadwal.move');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    
    // Inventaris
    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
    Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
    Route::get('/inventaris/{id}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
    Route::put('/inventaris/{id}', [InventarisController::class, 'update'])->name('inventaris.update');
    Route::patch('/inventaris/{id}/kondisi', [InventarisController::class, 'updateKondisi'])->name('inventaris.update-kondisi');
    Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');

    // Peminjaman (Borrowing Actions for Rooms)
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::patch('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

    // Peminjaman Inventaris (Tools/Materials)
    Route::get('/peminjaman-inventaris', [App\Http\Controllers\PeminjamanInventarisController::class, 'index'])->name('peminjaman-inventaris.index');
    Route::post('/peminjaman-inventaris', [App\Http\Controllers\PeminjamanInventarisController::class, 'store'])->name('peminjaman-inventaris.store');
    Route::patch('/peminjaman-inventaris/{id}/approve', [App\Http\Controllers\PeminjamanInventarisController::class, 'approve'])->name('peminjaman-inventaris.approve');
    Route::patch('/peminjaman-inventaris/{id}/reject', [App\Http\Controllers\PeminjamanInventarisController::class, 'reject'])->name('peminjaman-inventaris.reject');
    Route::patch('/peminjaman-inventaris/{id}/return', [App\Http\Controllers\PeminjamanInventarisController::class, 'returnItem'])->name('peminjaman-inventaris.return');
    
    // Profile Settings
    Route::get('/profile/settings', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.settings');
    Route::put('/profile/settings', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Global Settings (Admin Only)
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

});

