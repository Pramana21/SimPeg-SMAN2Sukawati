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
use Illuminate\Http\Request;


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

    Route::post('/notifications/read', function (Request $request) {
        $request->user()->update([
            'last_seen_notification' => now(),
        ]);

        return response()->json(['success' => true]);
    })->name('notifications.read');
    
    Route::get('/roles/{id?}', [RoleController::class, 'index'])->name('roles.index');

    Route::get('/audit-log', [AuditLogController::class, 'index']);

    Route::get('/audit-log/export', [AuditLogController::class, 'export']);

    Route::delete('/audit-log/bulk-delete', [AuditLogController::class, 'bulkDelete'])
        ->name('audit-log.bulk-delete')
        ->middleware('permission:user,view');

    // Route::get('/users', [UserManagementController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | ROLE & USER MANAGEMENT (SUPER ADMIN)
    |--------------------------------------------------------------------------
    */

    Route::resource('role', RoleController::class)
        ->middleware('permission:role,view');

    Route::prefix('user')
        ->middleware('permission:user,view')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->whereNumber('id')->name('users.edit');
            Route::put('/{id}', [UserController::class, 'update'])->whereNumber('id')->name('users.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->whereNumber('id')->name('users.destroy');
            Route::get('/{id}', [UserController::class, 'show'])->whereNumber('id')->name('users.show');
            Route::patch('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->whereNumber('id')->name('users.toggle-status');
        });

    Route::resource('audit-log', AuditLogController::class)
        ->middleware('permission:user,view');



    /*
    |--------------------------------------------------------------------------
    | PEGAWAI & DATA
    |--------------------------------------------------------------------------
    */

    // Legacy routes below referenced controllers that are not present in the codebase.
    // Guard them so route registration and diagnostics stay healthy.
    if (class_exists(\App\Http\Controllers\SiswaController::class)) {
        Route::resource('siswa', \App\Http\Controllers\SiswaController::class)
            ->middleware('permission:siswa,view');
    }

    if (class_exists(\App\Http\Controllers\KelasController::class)) {
        Route::resource('kelas', \App\Http\Controllers\KelasController::class)
            ->middleware('permission:kelas,view');
    }


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
        Route::post('/bulk-delete', [KeuanganController::class, 'bulkDelete'])->name('keuangan.bulk-delete');

        Route::get('/{slug}/preview/{id}', [KeuanganController::class, 'preview'])->name('keuangan.preview');
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
    Route::prefix('administrasi')
        ->name('administrasi.')
        ->group(function () {
            Route::get('/', [AdministrasiController::class, 'index'])
                ->middleware('permission:administrasi,view')
                ->name('index');

            Route::post('/bulk-delete', [AdministrasiController::class, 'bulkDelete'])
                ->middleware('permission:administrasi,delete')
                ->name('bulk-delete');

            Route::get('/pegawai', [AdministrasiController::class, 'pegawai'])
                ->middleware('permission:administrasi,view')
                ->name('pegawai.index');

            Route::get('/siswa', [AdministrasiController::class, 'siswa'])
                ->middleware('permission:administrasi,view')
                ->name('siswa.index');

            Route::get('/pegawai/create', [AdministrasiController::class, 'createPegawai'])
                ->middleware('permission:administrasi,create')
                ->name('pegawai.create');

            Route::get('/siswa/create', [AdministrasiController::class, 'createSiswa'])
                ->middleware('permission:administrasi,create')
                ->name('siswa.create');

            Route::post('/store', [AdministrasiController::class, 'store'])
                ->middleware('permission:administrasi,create')
                ->name('store');

            Route::get('/{id}', [AdministrasiController::class, 'show'])
                ->middleware('permission:administrasi,view')
                ->whereNumber('id')
                ->name('show');

            Route::get('/{id}/edit', [AdministrasiController::class, 'edit'])
                ->middleware('permission:administrasi,edit')
                ->whereNumber('id')
                ->name('edit');

            Route::put('/{id}', [AdministrasiController::class, 'update'])
                ->middleware('permission:administrasi,edit')
                ->whereNumber('id')
                ->name('update');

            Route::delete('/{id}', [AdministrasiController::class, 'destroy'])
                ->middleware('permission:administrasi,delete')
                ->whereNumber('id')
                ->name('destroy');
        });

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
