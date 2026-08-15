<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LokasiArsip;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LokasiArsipController extends Controller
{
    /**
     * Menampilkan lokasi arsip milik nasabah.
     *
     * Admin dan Petugas boleh melihat.
     */
    public function show(Nasabah $nasabah)
    {
        $lokasi = $nasabah->lokasiArsip;

        if (!$lokasi) {
            return response()->json([
                'message' => 'Lokasi arsip untuk nasabah ini belum tersedia.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'message' => 'Data lokasi arsip berhasil ditemukan.',
            'data' => [
                'nasabah' => [
                    'id' => $nasabah->id,
                    'nomor_nasabah' => $nasabah->nomor_nasabah,
                    'nama' => $nasabah->nama,
                ],
                'lokasi_arsip' => $lokasi,
            ],
        ]);
    }

    /**
     * Admin mengubah lokasi arsip.
     */
    public function update(Request $request, Nasabah $nasabah)
    {
        $validated = $request->validate([
            'rak' => [
                'required',
                'string',
                'max:50',
            ],
            'nomor_map' => [
                'required',
                'string',
                'max:50',
            ],
            'posisi' => [
                'required',
                'string',
                'max:50',
            ],
        ]);

        $lokasi = $nasabah->lokasiArsip;

        if (!$lokasi) {
            $lokasi = LokasiArsip::create([
                'nasabah_id' => $nasabah->id,
                'rak' => $validated['rak'],
                'nomor_map' => $validated['nomor_map'],
                'posisi' => $validated['posisi'],
            ]);
        } else {
            $lokasi->update([
                'rak' => $validated['rak'],
                'nomor_map' => $validated['nomor_map'],
                'posisi' => $validated['posisi'],
            ]);
        }

        return response()->json([
            'message' => 'Lokasi arsip berhasil diperbarui.',
            'data' => [
                'nasabah' => [
                    'id' => $nasabah->id,
                    'nomor_nasabah' => $nasabah->nomor_nasabah,
                    'nama' => $nasabah->nama,
                ],
                'lokasi_arsip' => $lokasi->fresh(),
            ],
        ]);
    }
}