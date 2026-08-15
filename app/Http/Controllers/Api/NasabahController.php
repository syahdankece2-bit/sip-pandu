<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NasabahController extends Controller
{
    /**
     * Menampilkan daftar nasabah dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Nasabah::with('lokasiArsip');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_nasabah', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $nasabah = $query
            ->orderBy('nomor_nasabah')
            ->paginate(10);

        return response()->json($nasabah);
    }

    /**
     * Menampilkan detail nasabah.
     */
    public function show(Nasabah $nasabah)
    {
        $nasabah->load([
            'lokasiArsip',
            'dokumen.jenisDokumen',
            'dokumen.uploader',
        ]);

        return response()->json([
            'data' => $nasabah,
        ]);
    }

    /**
     * Admin menambahkan nasabah.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_nasabah' => [
                'required',
                'string',
                'max:50',
                'unique:nasabah,nomor_nasabah',
            ],
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $nasabah = Nasabah::create([
            'nomor_nasabah' => $validated['nomor_nasabah'],
            'nama' => $validated['nama'],
            'status' => 'aktif',
        ]);

        return response()->json([
            'message' => 'Nasabah berhasil ditambahkan.',
            'data' => $nasabah,
        ], 201);
    }

    /**
     * Admin mengubah data nasabah.
     */
    public function update(Request $request, Nasabah $nasabah)
    {
        $validated = $request->validate([
            'nomor_nasabah' => [
                'required',
                'string',
                'max:50',
                Rule::unique('nasabah', 'nomor_nasabah')
                    ->ignore($nasabah->id),
            ],
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $nasabah->update([
            'nomor_nasabah' => $validated['nomor_nasabah'],
            'nama' => $validated['nama'],
        ]);

        return response()->json([
            'message' => 'Data nasabah berhasil diperbarui.',
            'data' => $nasabah->fresh(),
        ]);
    }

    /**
     * Admin menonaktifkan nasabah.
     */
    public function deactivate(Nasabah $nasabah)
    {
        $nasabah->update([
            'status' => 'nonaktif',
        ]);

        return response()->json([
            'message' => 'Nasabah berhasil dinonaktifkan.',
            'data' => $nasabah->fresh(),
        ]);
    }
}