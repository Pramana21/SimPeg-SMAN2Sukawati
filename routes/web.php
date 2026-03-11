<?php

use App\Http\Controllers\DokumenPegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware(['auth','role:admin'])->group(function () {

    Route::resource('pegawai', PegawaiController::class);
    Route::resource('dokumen', DokumenPegawaiController::class);
    Route::resource('inventaris', InventarisController::class);

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';