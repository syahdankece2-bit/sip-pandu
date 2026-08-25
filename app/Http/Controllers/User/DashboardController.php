<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Dokumen;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard petugas.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik Nasabah
        |--------------------------------------------------------------------------
        */

        $totalNasabah = Nasabah::count();


        /*
        |--------------------------------------------------------------------------
        | Statistik Dokumen
        |--------------------------------------------------------------------------
        */

        $dokumenDigitalTersedia = Dokumen::where(
            'status_digital',
            'tersedia'
        )->count();

        $dokumenBelumTersedia = Dokumen::where(
            'status_digital',
            'belum_tersedia'
        )->count();

        $dokumenHariIni = Dokumen::whereDate(
            'uploaded_at',
            today()
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Nasabah Terbaru
        |--------------------------------------------------------------------------
        |
        | Karena saat ini belum ada tabel riwayat pencarian,
        | kita tampilkan 3 nasabah terbaru dari database.
        |
        */

        $nasabahTerbaru = Nasabah::with('lokasiArsip')
            ->latest()
            ->take(3)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dokumen Terbaru
        |--------------------------------------------------------------------------
        */

        $dokumenTerbaru = Dokumen::with([
            'nasabah',
            'jenisDokumen',
            'uploader',
        ])
            ->latest('uploaded_at')
            ->take(3)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('user.dashboard', compact(
            'totalNasabah',
            'dokumenDigitalTersedia',
            'dokumenBelumTersedia',
            'dokumenHariIni',
            'nasabahTerbaru',
            'dokumenTerbaru'
        ));
    }
}