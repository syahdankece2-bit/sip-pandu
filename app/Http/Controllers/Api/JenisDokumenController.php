<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisDokumenController extends Controller
{
    /**
     * Menampilkan daftar jenis dokumen.
     *
     * Admin dan Petugas boleh melihat.
     */
    public function index(Request $request)
    {
        $query = JenisDokumen::query();

        // Pencarian berdasarkan nama dokumen
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama_dokumen', 'like', "%{$search}%");
        }

        // Secara default hanya menampilkan jenis dokumen aktif
        if ($request->boolean('semua') === false) {
            $query->where('status', 'aktif');
        }

        $jenisDokumen = $query
            ->orderBy('nama_dokumen')
            ->get();

        return response()->json([
            'message' => 'Daftar jenis dokumen berhasil ditemukan.',
            'data' => $jenisDokumen,
        ]);
    }

    /**
     * Menampilkan detail jenis dokumen.
     *
     * Admin dan Petugas boleh melihat.
     */
    public function show(JenisDokumen $jenisDokumen)
    {
        return response()->json([
            'message' => 'Detail jenis dokumen berhasil ditemukan.',
            'data' => $jenisDokumen,
        ]);
    }

    /**
     * Admin menambahkan jenis dokumen baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokumen' => [
                'required',
                'string',
                'max:100',
                'unique:jenis_dokumen,nama_dokumen',
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);

        $jenisDokumen = JenisDokumen::create([
            'nama_dokumen' => $validated['nama_dokumen'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => 'aktif',
        ]);

        return response()->json([
            'message' => 'Jenis dokumen berhasil ditambahkan.',
            'data' => $jenisDokumen,
        ], 201);
    }

    /**
     * Admin mengubah jenis dokumen.
     */
    public function update(Request $request, JenisDokumen $jenisDokumen)
    {
        $validated = $request->validate([
            'nama_dokumen' => [
                'required',
                'string',
                'max:100',
                Rule::unique('jenis_dokumen', 'nama_dokumen')
                    ->ignore($jenisDokumen->id),
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);

        $jenisDokumen->update([
            'nama_dokumen' => $validated['nama_dokumen'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return response()->json([
            'message' => 'Jenis dokumen berhasil diperbarui.',
            'data' => $jenisDokumen->fresh(),
        ]);
    }

    /**
     * Admin menonaktifkan jenis dokumen.
     */
    public function deactivate(JenisDokumen $jenisDokumen)
    {
        $jenisDokumen->update([
            'status' => 'nonaktif',
        ]);

        return response()->json([
            'message' => 'Jenis dokumen berhasil dinonaktifkan.',
            'data' => $jenisDokumen->fresh(),
        ]);
    }
}