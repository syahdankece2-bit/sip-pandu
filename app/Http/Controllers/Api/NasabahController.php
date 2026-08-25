<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NasabahController extends Controller
{
    /**
     * Menampilkan daftar nasabah.
     *
     * Fitur:
     * - Pencarian berdasarkan nomor nasabah dan nama
     * - Filter status
     * - Pagination
     * - Informasi lokasi arsip
     * - Jumlah dokumen
     */
    public function index(Request $request)
    {
        $query = Nasabah::query()
            ->with('lokasiArsip')
            ->withCount('dokumen');

        /*
        |--------------------------------------------------------------------------
        | Pencarian
        |--------------------------------------------------------------------------
        |
        | Pencarian berdasarkan:
        | - nomor_nasabah
        | - nama
        |
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nomor_nasabah',
                    'like',
                    "%{$search}%"
                )->orWhere(
                    'nama',
                    'like',
                    "%{$search}%"
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status') &&
            $request->status !== 'semua'
        ) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $nasabah = $query
            ->orderBy('nomor_nasabah')
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json($nasabah);
    }


    /**
     * Menampilkan detail nasabah.
     *
     * Data yang dimuat:
     * - Lokasi arsip
     * - Dokumen
     * - Jenis dokumen
     * - User yang mengupload dokumen
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
     *
     * Data:
     * - Nomor nasabah
     * - Nama
     * - NIK
     * - Nomor KK
     * - NPWP
     *
     * Status otomatis aktif.
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

            'nik' => [
                'nullable',
                'string',
                'size:16',
                'unique:nasabah,nik',
            ],

            'no_kk' => [
                'nullable',
                'string',
                'size:16',
            ],

            'npwp' => [
                'nullable',
                'string',
                'max:32',
            ],
        ]);

        $nasabah = Nasabah::create([
            'nomor_nasabah' => $validated['nomor_nasabah'],
            'nama' => $validated['nama'],
            'nik' => $validated['nik'] ?? null,
            'no_kk' => $validated['no_kk'] ?? null,
            'npwp' => $validated['npwp'] ?? null,
            'status' => 'aktif',
        ]);

        return response()->json([
            'message' => 'Nasabah berhasil ditambahkan.',
            'data' => $nasabah->fresh(),
        ], 201);
    }


    /**
     * Admin mengubah data nasabah.
     *
     * Nomor nasabah tidak diubah melalui halaman Edit.
     *
     * Data yang dapat diubah:
     * - Nama
     * - NIK
     * - Nomor KK
     * - NPWP
     * - Status
     * - Lokasi arsip
     */
    public function update(
        Request $request,
        Nasabah $nasabah
    ) {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'nik' => [
                'nullable',
                'string',
                'size:16',
                Rule::unique(
                    'nasabah',
                    'nik'
                )->ignore($nasabah->id),
            ],

            'no_kk' => [
                'nullable',
                'string',
                'size:16',
            ],

            'npwp' => [
                'nullable',
                'string',
                'max:32',
            ],

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'nonaktif',
                ]),
            ],

            'rak' => [
                'nullable',
                'string',
                'max:100',
            ],

            'nomor_map' => [
                'nullable',
                'string',
                'max:100',
            ],

            'posisi' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        DB::transaction(function () use (
            $nasabah,
            $validated
        ) {
            /*
            |--------------------------------------------------------------------------
            | Update Data Nasabah
            |--------------------------------------------------------------------------
            */

            $nasabah->update([
                'nama' => $validated['nama'],
                'nik' => $validated['nik'] ?? null,
                'no_kk' => $validated['no_kk'] ?? null,
                'npwp' => $validated['npwp'] ?? null,
                'status' => $validated['status'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Update / Create Lokasi Arsip
            |--------------------------------------------------------------------------
            */

            $adaLokasi = collect([
                $validated['rak'] ?? null,
                $validated['nomor_map'] ?? null,
                $validated['posisi'] ?? null,
            ])->contains(
                fn ($value) =>
                    $value !== null &&
                    trim((string) $value) !== ''
            );


            if ($adaLokasi) {
                $nasabah->lokasiArsip()->updateOrCreate(
                    [
                        'nasabah_id' => $nasabah->id,
                    ],
                    [
                        'rak' => $validated['rak'] ?? null,
                        'nomor_map' => $validated['nomor_map'] ?? null,
                        'posisi' => $validated['posisi'] ?? null,
                    ]
                );
            } else {
                /*
                |--------------------------------------------------------------------------
                | Jika semua lokasi dikosongkan
                |--------------------------------------------------------------------------
                |
                | Hapus data lokasi lama agar status lokasi menjadi
                | "Belum Diatur".
                |
                */

                $nasabah->lokasiArsip()->delete();
            }
        });


        /*
        |--------------------------------------------------------------------------
        | Ambil Data Terbaru
        |--------------------------------------------------------------------------
        */

        $nasabah->refresh();

        $nasabah->load([
            'lokasiArsip',
            'dokumen.jenisDokumen',
            'dokumen.uploader',
        ]);


        return response()->json([
            'message' => 'Data nasabah berhasil diperbarui.',
            'data' => $nasabah,
        ]);
    }


    /**
     * Admin menonaktifkan nasabah.
     *
     * Data nasabah tidak dihapus.
     * Hanya status yang diubah menjadi nonaktif.
     */
    public function deactivate(Nasabah $nasabah)
    {
        /*
        |--------------------------------------------------------------------------
        | Cegah Request Jika Sudah Nonaktif
        |--------------------------------------------------------------------------
        */

        if ($nasabah->status === 'nonaktif') {
            return response()->json([
                'message' => 'Nasabah sudah dalam status nonaktif.',
                'data' => $nasabah->fresh(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Update Status
        |--------------------------------------------------------------------------
        */

        $nasabah->update([
            'status' => 'nonaktif',
        ]);


        return response()->json([
            'message' => 'Nasabah berhasil dinonaktifkan.',
            'data' => $nasabah->fresh(),
        ]);
    }
}