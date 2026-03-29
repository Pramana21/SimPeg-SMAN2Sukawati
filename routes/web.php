<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AuditLogController;

use App\Http\Controllers\SuratController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\InventarisController;

use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\PegawaiController;

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login',[LoginController::class,'showLogin'])->name('login');
Route::post('/login',[LoginController::class,'login']);
Route::get('/logout',[LoginController::class,'logout']);


/*
|--------------------------------------------------------------------------
| HARUS LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/roles/{id?}', [RoleController::class, 'index'])->name('roles.index');

    Route::get('/audit-log', [AuditLogController::class, 'index']);

    Route::get('/audit-log/export', [AuditLogController::class, 'export']);

    // Route::get('/users', [UserManagementController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | ROLE & USER MANAGEMENT (SUPER ADMIN)
    |--------------------------------------------------------------------------
    */

    Route::resource('role', RoleController::class)
        ->middleware('permission:role,view');

    Route::resource('user', UserController::class)
        ->middleware('permission:user,view');

    Route::resource('audit-log', AuditLogController::class)
        ->middleware('permission:user,view');



    /*
    |--------------------------------------------------------------------------
    | PEGAWAI & DATA
    |--------------------------------------------------------------------------
    */

    Route::resource('siswa', SiswaController::class)
        ->middleware('permission:siswa,view');

    Route::resource('kelas', KelasController::class)
        ->middleware('permission:kelas,view');


    /*
    |--------------------------------------------------------------------------
    | DOKUMEN
    |--------------------------------------------------------------------------
    */
    //penyuratan
    Route::get('/penyuratan/export/pdf', [SuratController::class, 'exportPdf'])
        ->name('penyuratan.export.pdf')
        ->middleware('permission:penyuratan,view');
    Route::post('/penyuratan/bulk-delete', [SuratController::class, 'bulkDelete'])
        ->name('penyuratan.bulk-delete')
        ->middleware('permission:penyuratan,view');
    Route::resource('penyuratan', SuratController::class)
        ->middleware('permission:penyuratan,view');

    // KEUANGAN
    Route::prefix('keuangan')
        ->middleware('permission:keuangan,view')
        ->group(function () {

        Route::get('/', [KeuanganController::class, 'index'])->name('keuangan.index');

        Route::get('/{slug}', [KeuanganController::class, 'show'])->name('keuangan.kategori');

        Route::get('/{slug}/create', [KeuanganController::class, 'create'])->name('keuangan.create');
        Route::post('/{slug}', [KeuanganController::class, 'store'])->name('keuangan.store');

        // 🔥 EDIT
        Route::get('/{slug}/edit/{id}', [KeuanganController::class, 'edit'])->name('keuangan.edit');
        Route::put('/{slug}/update/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');

        // 🔥 DELETE
        Route::delete('/{slug}/delete/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.delete');

    });
    
    //inventaris
    Route::post('/inventaris/bulk-delete', [InventarisController::class, 'bulkDelete'])
        ->name('inventaris.bulk-delete')
        ->middleware('permission:inventaris,view');
    Route::resource('inventaris', InventarisController::class)
        ->middleware('permission:inventaris,view');

    //Data Center 
    Route::prefix('data-center')->group(function () {

    // 🔥 DASHBOARD DATA CENTER
    Route::get('/', [DataCenterController::class, 'index'])
        ->name('data-center.index');

    // 🔥 MURID (FULL CRUD)
    Route::resource('murid', MuridController::class);

    // 🔥 PEGAWAI (FULL CRUD)
    Route::resource('pegawai', PegawaiController::class);

});

    
    //administrasi
    Route::resource('administrasi', AdministrasiController::class)
        ->middleware('permission:administrasi,view');
    // halaman utama administrasi
    Route::get('/administrasi', [AdministrasiController::class, 'index']);
    // create
    Route::get('/administrasi/create', [AdministrasiController::class, 'create']);
    Route::post('/administrasi/store', [AdministrasiController::class, 'store']);
    // delete
    Route::delete('/administrasi/{id}', [AdministrasiController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/test', function () {
        return 'OK';
    });
    
});
