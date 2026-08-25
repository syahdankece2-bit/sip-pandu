<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NasabahController;
use App\Http\Controllers\Admin\JenisDokumenController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\NasabahController as UserNasabahController;
use App\Http\Controllers\User\DokumenController as UserDokumenController;
use App\Http\Controllers\User\SettingsController as UserSettingsController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::get('/login/petugas', [LoginController::class, 'showLoginPetugas'])
    ->name('login.petugas');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Data Nasabah
        |--------------------------------------------------------------------------
        */

        Route::get('/nasabah', [NasabahController::class, 'index'])
            ->name('nasabah.index');

        Route::get('/nasabah/create', [NasabahController::class, 'create'])
            ->name('nasabah.create');

        Route::post('/nasabah', [NasabahController::class, 'store'])
            ->name('nasabah.store');

        Route::get('/nasabah/{nasabah}/dokumen/upload', [NasabahController::class, 'uploadDokumen'])
            ->name('nasabah.dokumen.create');

        Route::get('/nasabah/{nasabah}/dokumen/{dokumen}/ganti', [NasabahController::class, 'gantiDokumen'])
            ->name('nasabah.dokumen.replace');

        Route::get('/nasabah/{nasabah}', [NasabahController::class, 'show'])
            ->name('nasabah.show');

        Route::get('/nasabah/{nasabah}/edit', [NasabahController::class, 'edit'])
            ->name('nasabah.edit');

        Route::put('/nasabah/{nasabah}', [NasabahController::class, 'update'])
            ->name('nasabah.update');
            
        /*
        |--------------------------------------------------------------------------
        | Jenis Dokumen
        |--------------------------------------------------------------------------
        */

        // Halaman daftar jenis dokumen
        Route::get('/jenis-dokumen', [JenisDokumenController::class, 'index'])
            ->name('jenis-dokumen');

        // Halaman tambah jenis dokumen
        Route::get('/jenis-dokumen/create', [JenisDokumenController::class, 'create'])
            ->name('jenis-dokumen.create');

        // Halaman edit jenis dokumen
        Route::get('/jenis-dokumen/{jenisDokumen}/edit', [JenisDokumenController::class, 'edit'])
            ->name('jenis-dokumen.edit');


        /*
        |--------------------------------------------------------------------------
        | Kelola User / Petugas
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [UserController::class, 'index'])
            ->name('users');

        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');


        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [SettingsController::class, 'index'])
            ->name('settings');

        Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])
            ->name('settings.profile');

        Route::post('/settings/general', [SettingsController::class, 'updateGeneral'])
            ->name('settings.general');

        Route::post('/settings/password', [SettingsController::class, 'updatePassword'])
            ->name('settings.password');

    });



    /*
    |--------------------------------------------------------------------------
    | Petugas / User
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:petugas'])
        ->prefix('user')
        ->name('user.')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

            Route::get('/dashboard', [UserDashboardController::class, 'index'])
                ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Data Nasabah
        |--------------------------------------------------------------------------
        */

             Route::get('/nasabah', [UserNasabahController::class, 'index'])
                ->name('nasabah.index');

            Route::get('/nasabah/{nasabah}', [UserNasabahController::class, 'show'])
                ->name('nasabah.show');

            Route::get('/nasabah/{nasabah}/dokumen/upload', [UserNasabahController::class, 'uploadDokumen'])
                ->name('nasabah.dokumen.create');

            Route::post('/nasabah/{nasabah}/dokumen', [UserNasabahController::class, 'storeDokumen'])
                ->name('nasabah.dokumen.store');

        /*
        |--------------------------------------------------------------------------
        | Dokumen
        |--------------------------------------------------------------------------
        */

        Route::get('/dokumen', [UserDokumenController::class, 'index'])
            ->name('dokumen.index');

        Route::get('/dokumen/{dokumen}/preview', [UserDokumenController::class, 'preview'])
            ->name('dokumen.preview');

        Route::get('/dokumen/{dokumen}/download', [UserDokumenController::class, 'download'])
            ->name('dokumen.download');


        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [UserSettingsController::class, 'index'])
            ->name('settings');

        Route::post('/settings/profile', [UserSettingsController::class, 'updateProfile'])
            ->name('settings.profile');

        Route::post('/settings/password', [UserSettingsController::class, 'updatePassword'])
            ->name('settings.password');

        Route::post('/settings/preferences', [UserSettingsController::class, 'updatePreferences'])
            ->name('settings.preferences');

        });