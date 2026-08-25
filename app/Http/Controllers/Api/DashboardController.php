<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Dokumen;
use App\Models\JenisDokumen;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Mengembalikan statistik dashboard secara real-time untuk polling JS.
     */
    public function stats(): JsonResponse
    {
        $totalNasabah    = Nasabah::count();
        $totalDokumen    = Dokumen::count();
        // status_digital enum: 'tersedia' | 'belum_tersedia'
        $dokumenDigital  = Dokumen::where('status_digital', 'tersedia')->count();
        $belumDigital    = Dokumen::where('status_digital', 'belum_tersedia')->count();
        $persenDigital   = $totalDokumen > 0
            ? round(($dokumenDigital / $totalDokumen) * 100, 1)
            : 0;
        $totalJenis      = JenisDokumen::count();
        $petugasAktif    = User::where('role', 'petugas')
                               ->where('status', 'aktif')
                               ->count();

        return response()->json([
            'total_nasabah'    => $totalNasabah,
            'total_dokumen'    => $totalDokumen,
            'dokumen_digital'  => $dokumenDigital,
            'belum_digital'    => $belumDigital,
            'persen_digital'   => $persenDigital,
            'total_jenis'      => $totalJenis,
            'petugas_aktif'    => $petugasAktif,
            'refreshed_at'     => now()->translatedFormat('H:i:s'),
        ]);
    }
}
