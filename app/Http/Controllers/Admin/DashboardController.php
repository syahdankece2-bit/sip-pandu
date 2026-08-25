<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Dokumen;
use App\Models\JenisDokumen;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now     = Carbon::now();
        $bulanIni = $now->month;
        $tahunIni = $now->year;
        $bulanLalu = $now->copy()->subMonth();

        /*
        |----------------------------------------------------------------------
        | STAT CARDS
        |----------------------------------------------------------------------
        */

        // Total Nasabah
        $totalNasabah = Nasabah::count();
        $nasabahBulanIni  = Nasabah::whereMonth('created_at', $bulanIni)
                                   ->whereYear('created_at', $tahunIni)
                                   ->count();
        $nasabahBulanLalu = Nasabah::whereMonth('created_at', $bulanLalu->month)
                                   ->whereYear('created_at', $bulanLalu->year)
                                   ->count();
        $pertumbuhanNasabah = $nasabahBulanLalu > 0
            ? round((($nasabahBulanIni - $nasabahBulanLalu) / $nasabahBulanLalu) * 100, 1)
            : ($nasabahBulanIni > 0 ? 100 : 0);

        // Total Dokumen
        $totalDokumen = Dokumen::count();
        $dokumenBulanIni  = Dokumen::whereMonth('created_at', $bulanIni)
                                   ->whereYear('created_at', $tahunIni)
                                   ->count();
        $dokumenBulanLalu = Dokumen::whereMonth('created_at', $bulanLalu->month)
                                   ->whereYear('created_at', $bulanLalu->year)
                                   ->count();
        $pertumbuhanDokumen = $dokumenBulanLalu > 0
            ? round((($dokumenBulanIni - $dokumenBulanLalu) / $dokumenBulanLalu) * 100, 1)
            : ($dokumenBulanIni > 0 ? 100 : 0);

        // Dokumen Digital vs Belum Digital
        // status_digital enum: 'tersedia' | 'belum_tersedia'
        $dokumenDigital      = Dokumen::where('status_digital', 'tersedia')->count();
        $dokumenBelumDigital = Dokumen::where('status_digital', 'belum_tersedia')->count();
        $persenDigital = $totalDokumen > 0
            ? round(($dokumenDigital / $totalDokumen) * 100, 1)
            : 0;

        // Jenis Dokumen
        $totalJenisDokumen = JenisDokumen::count();

        // Petugas Aktif
        $petugasAktif = User::where('role', 'petugas')
                            ->where('status', 'aktif')
                            ->count();

        /*
        |----------------------------------------------------------------------
        | TABEL NASABAH TERBARU
        |----------------------------------------------------------------------
        */
        $nasabahTerbaru = Nasabah::with('lokasiArsip')
                                 ->latest()
                                 ->take(5)
                                 ->get();

        /*
        |----------------------------------------------------------------------
        | DAFTAR DOKUMEN TERBARU
        |----------------------------------------------------------------------
        */
        $dokumenTerbaru = Dokumen::with(['nasabah', 'jenisDokumen'])
                                 ->latest('uploaded_at')
                                 ->take(5)
                                 ->get();

        return view('admin.dashboard', compact(
            'totalNasabah',
            'pertumbuhanNasabah',
            'nasabahBulanIni',
            'totalDokumen',
            'pertumbuhanDokumen',
            'dokumenBulanIni',
            'dokumenDigital',
            'dokumenBelumDigital',
            'persenDigital',
            'totalJenisDokumen',
            'petugasAktif',
            'nasabahTerbaru',
            'dokumenTerbaru',
        ));
    }
}
