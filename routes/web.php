
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CekStatusController;

use App\Http\Controllers\Wadir\PersetujuanController;

use App\Http\Controllers\UPA\LaporanController as UpaLaporanController;
use App\Http\Controllers\UPA\PenugasanController;

use App\Http\Controllers\Teknisi\TugasController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\KategoriKerusakanController;
use App\Http\Controllers\Admin\UnitController;


/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing.index');
})->name('landing');


/*
|--------------------------------------------------------------------------
| Cek Status Tiket
|--------------------------------------------------------------------------
*/

Route::get('/cek-status', [CekStatusController::class, 'index'])
    ->name('cek-status');

Route::post('/cek-status', [CekStatusController::class, 'search'])
    ->name('cek-status.search');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');

});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| Pelapor
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pelapor'])
    ->prefix('pelapor')
    ->name('pelapor.')
    ->group(function () {

        // Dashboard pelapor
        Route::get('/dashboard', [LaporanController::class, 'index'])
            ->name('dashboard');

        // Form laporan
        Route::get('/laporan/create', [LaporanController::class, 'create'])
            ->name('laporan.create');

        // Simpan laporan
        Route::post('/laporan', [LaporanController::class, 'store'])
            ->name('laporan.store');

        // Detail laporan
        Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])
            ->name('laporan.show');

    });


/*
|--------------------------------------------------------------------------
| Wadir II
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:wadir_ii'])
    ->prefix('wadir')
    ->name('wadir.')
    ->group(function () {

        // Dashboard persetujuan
        Route::get('/dashboard', [PersetujuanController::class, 'index'])
            ->name('dashboard');

        // Daftar seluruh laporan
        Route::get('/laporan', [PersetujuanController::class, 'list'])
            ->name('laporan.index');

        // Detail laporan
        Route::get('/laporan/{laporan}', [PersetujuanController::class, 'show'])
            ->name('laporan.show');

        // Setujui laporan
        Route::post('/laporan/{laporan}/setujui', [PersetujuanController::class, 'approve'])
            ->name('laporan.setujui');

        // Tolak laporan
        Route::post('/laporan/{laporan}/tolak', [PersetujuanController::class, 'reject'])
            ->name('laporan.tolak');

    });


/*
|--------------------------------------------------------------------------
| UPA Perawatan dan Perbaikan
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:upa'])
    ->prefix('upa')
    ->name('upa.')
    ->group(function () {

        // Dashboard UPA
        Route::get('/dashboard', [UpaLaporanController::class, 'index'])
            ->name('dashboard');

        // Daftar laporan yang ditangani UPA
        Route::get('/laporan', [UpaLaporanController::class, 'list'])
            ->name('laporan.index');

        // Detail laporan
        Route::get('/laporan/{laporan}', [UpaLaporanController::class, 'show'])
            ->name('laporan.show');

        // Penugasan teknisi
        Route::post('/laporan/{laporan}/tugaskan', [PenugasanController::class, 'store'])
            ->name('laporan.tugaskan');

        // Verifikasi hasil pekerjaan teknisi
        Route::post('/laporan/{laporan}/verifikasi', [UpaLaporanController::class, 'verify'])
            ->name('laporan.verifikasi');

    });


/*
|--------------------------------------------------------------------------
| Teknisi
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teknisi'])
    ->prefix('teknisi')
    ->name('teknisi.')
    ->group(function () {

        // Dashboard teknisi
        Route::get('/dashboard', [TugasController::class, 'index'])
            ->name('dashboard');

        // Daftar seluruh tugas teknisi
        Route::get('/tugas', [TugasController::class, 'list'])
            ->name('tugas.index');

        // Detail tugas
        Route::get('/tugas/{laporan}', [TugasController::class, 'show'])
            ->name('tugas.show');

        // Mulai pengerjaan
        Route::post('/tugas/{laporan}/mulai', [TugasController::class, 'start'])
            ->name('tugas.mulai');

        // Kirim hasil pekerjaan
        Route::post('/tugas/{laporan}/selesai', [TugasController::class, 'complete'])
            ->name('tugas.selesai');

    });


/*
|--------------------------------------------------------------------------
| Administrator
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard administrator
        Route::view('/dashboard', 'admin.dashboard')
            ->name('dashboard');

        // Manajemen pengguna
        Route::resource('users', UserController::class);

        // Manajemen gedung
        Route::resource('gedungs', GedungController::class);

        // Manajemen kategori kerusakan
        Route::resource(
            'kategori-kerusakan',
            KategoriKerusakanController::class
        );

        // Manajemen unit / bagian
        Route::resource('units', UnitController::class);

    });
