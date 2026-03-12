<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;

use App\Http\Controllers\PenyuratanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\InventarisController;

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;

use App\Http\Controllers\AdministrasiController;

use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Sistem
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('audit-log', AuditLogController::class);

    // Dokumen
    Route::resource('penyuratan', PenyuratanController::class);
    Route::resource('keuangan', KeuanganController::class);
    Route::resource('inventaris', InventarisController::class);

    // Data Center
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class);

    // Administrasi
    Route::resource('administrasi', AdministrasiController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


require __DIR__.'/auth.php';