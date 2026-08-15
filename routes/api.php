<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NasabahController;
use App\Http\Controllers\Api\LokasiArsipController;
use App\Http\Controllers\Api\JenisDokumenController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\UserController;


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

// Login
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication User
    |--------------------------------------------------------------------------
    */

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Data user yang sedang login
    Route::get('/me', [AuthController::class, 'me']);


    /*
    |--------------------------------------------------------------------------
    | Nasabah - Admin & Petugas
    |--------------------------------------------------------------------------
    |
    | Admin dan Petugas sama-sama boleh:
    | - Melihat daftar nasabah
    | - Mencari nasabah
    | - Melihat detail nasabah
    |
    */

    Route::middleware('role:admin,petugas')->group(function () {

        // Daftar dan pencarian nasabah
        Route::get('/nasabah', [
            NasabahController::class,
            'index'
        ]);

        // Detail nasabah
        Route::get('/nasabah/{nasabah}', [
            NasabahController::class,
            'show'
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Nasabah - Khusus Admin
    |--------------------------------------------------------------------------
    |
    | Admin boleh:
    | - Menambah nasabah
    | - Mengedit data nasabah
    | - Menonaktifkan nasabah
    |
    */

    Route::middleware('role:admin')->group(function () {

        // Tambah nasabah
        Route::post('/nasabah', [
            NasabahController::class,
            'store'
        ]);

        // Edit data nasabah
        Route::put('/nasabah/{nasabah}', [
            NasabahController::class,
            'update'
        ]);

        // Nonaktifkan nasabah
        Route::patch('/nasabah/{nasabah}/nonaktifkan', [
            NasabahController::class,
            'deactivate'
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Lokasi Arsip - Admin & Petugas
    |--------------------------------------------------------------------------
    |
    | Admin dan Petugas boleh melihat:
    | - Rak
    | - Nomor Map
    | - Posisi
    |
    */

    Route::middleware('role:admin,petugas')->group(function () {

        // Lihat lokasi arsip
        Route::get('/nasabah/{nasabah}/lokasi-arsip', [
            LokasiArsipController::class,
            'show'
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Lokasi Arsip - Khusus Admin
    |--------------------------------------------------------------------------
    |
    | Hanya Admin yang boleh mengubah:
    | - Rak
    | - Nomor Map
    | - Posisi
    |
    */

    Route::middleware('role:admin')->group(function () {

        // Edit lokasi arsip
        Route::put('/nasabah/{nasabah}/lokasi-arsip', [
            LokasiArsipController::class,
            'update'
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Jenis Dokumen - Admin & Petugas
    |--------------------------------------------------------------------------
    |
    | Admin dan Petugas boleh melihat:
    | - Daftar jenis dokumen
    | - Detail jenis dokumen
    |
    */

    Route::middleware('role:admin,petugas')->group(function () {

        // Daftar jenis dokumen
        Route::get('/jenis-dokumen', [
            JenisDokumenController::class,
            'index'
        ]);

        // Detail jenis dokumen
        Route::get('/jenis-dokumen/{jenisDokumen}', [
            JenisDokumenController::class,
            'show'
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Jenis Dokumen - Khusus Admin
    |--------------------------------------------------------------------------
    |
    | Hanya Admin yang boleh:
    | - Menambah jenis dokumen
    | - Mengedit jenis dokumen
    | - Menonaktifkan jenis dokumen
    |
    */

    Route::middleware('role:admin')->group(function () {

        // Tambah jenis dokumen
        Route::post('/jenis-dokumen', [
            JenisDokumenController::class,
            'store'
        ]);

        // Edit jenis dokumen
        Route::put('/jenis-dokumen/{jenisDokumen}', [
            JenisDokumenController::class,
            'update'
        ]);

        // Nonaktifkan jenis dokumen
        Route::patch('/jenis-dokumen/{jenisDokumen}/nonaktifkan', [
            JenisDokumenController::class,
            'deactivate'
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Dokumen - Admin & Petugas
    |--------------------------------------------------------------------------
    |
    | Admin dan Petugas sama-sama boleh:
    | - Melihat daftar dokumen nasabah
    | - Upload dokumen
    | - Melihat detail dokumen
    | - Preview dokumen
    | - Download dokumen
    |
    */

    Route::middleware('role:admin,petugas')->group(function () {

        // Daftar dokumen milik nasabah
        Route::get('/nasabah/{nasabah}/dokumen', [
            DokumenController::class,
            'index'
        ]);

        // Upload dokumen
        Route::post('/nasabah/{nasabah}/dokumen', [
            DokumenController::class,
            'store'
        ]);

        // Detail dokumen
        Route::get('/dokumen/{dokumen}', [
            DokumenController::class,
            'show'
        ]);

        // Preview dokumen
        Route::get('/dokumen/{dokumen}/preview', [
            DokumenController::class,
            'preview'
        ]);

        // Download dokumen
        Route::get('/dokumen/{dokumen}/download', [
            DokumenController::class,
            'download'
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Kelola User / Petugas - Khusus Admin
    |--------------------------------------------------------------------------
    |
    | Hanya Admin yang boleh:
    | - Melihat daftar user
    | - Melihat detail user
    | - Menambah Petugas
    | - Mengedit Petugas
    | - Menonaktifkan Petugas
    | - Mengaktifkan kembali Petugas
    |
    | Petugas tidak mempunyai akses ke endpoint ini.
    |
    */

    Route::middleware('role:admin')->group(function () {

        // Daftar user
        Route::get('/users', [
            UserController::class,
            'index'
        ]);

        // Detail user
        Route::get('/users/{user}', [
            UserController::class,
            'show'
        ]);

        // Tambah Petugas
        Route::post('/users', [
            UserController::class,
            'store'
        ]);

        // Edit Petugas
        Route::put('/users/{user}', [
            UserController::class,
            'update'
        ]);

        // Nonaktifkan Petugas
        Route::patch('/users/{user}/nonaktifkan', [
            UserController::class,
            'deactivate'
        ]);

        // Aktifkan kembali Petugas
        Route::patch('/users/{user}/aktifkan', [
            UserController::class,
            'activate'
        ]);

    });

});