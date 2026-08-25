<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NasabahController extends Controller
{
    /**
     * Menampilkan halaman data nasabah.
     */
    public function index()
    {
        $nasabah = Nasabah::with('lokasiArsip')
            ->withCount('dokumen')
            ->orderBy('nomor_nasabah')
            ->paginate(10);

        return view('admin.nasabah.index', compact('nasabah'));
    }


    /**
     * Menampilkan halaman tambah nasabah.
     */
    public function create()
    {
        return view('admin.nasabah.create');
    }


    /**
     * Menampilkan halaman detail nasabah.
     */
    public function show($id)
    {
        $nasabah = Nasabah::with([
            'lokasiArsip',
            'dokumen.jenisDokumen',
            'dokumen.uploader',
        ])->findOrFail($id);

        return view('admin.nasabah.show', compact('nasabah'));
    }


    /**
     * Menampilkan halaman edit nasabah.
     */
    public function edit($id)
    {
        $nasabah = Nasabah::with('lokasiArsip')
            ->findOrFail($id);

        return view('admin.nasabah.edit', compact('nasabah'));
    }


    /**
     * Menyimpan data nasabah baru.
     *
     * Data nasabah:
     * - Nomor nasabah
     * - Nama lengkap
     *
     * Status otomatis aktif.
     *
     * Lokasi arsip:
     * - Rak
     * - Nomor map
     * - Posisi
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

            'rak' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nomor_map' => [
                'nullable',
                'string',
                'max:50',
            ],

            'posisi' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);


        DB::transaction(function () use ($validated) {

            /*
             * Membuat data nasabah.
             */
            $nasabah = Nasabah::create([
                'nomor_nasabah' => $validated['nomor_nasabah'],
                'nama' => $validated['nama'],
                'status' => 'aktif',
            ]);


            /*
             * Menyimpan lokasi arsip jika ada
             * minimal satu data yang diisi.
             */
            if (
                !empty($validated['rak']) ||
                !empty($validated['nomor_map']) ||
                !empty($validated['posisi'])
            ) {
                $nasabah->lokasiArsip()->create([
                    'rak' => $validated['rak'] ?? null,
                    'nomor_map' => $validated['nomor_map'] ?? null,
                    'posisi' => $validated['posisi'] ?? null,
                ]);
            }
        });


        return redirect()
            ->route('admin.nasabah.index')
            ->with(
                'success',
                'Nasabah berhasil ditambahkan.'
            );
    }


    /**
     * Mengubah data nasabah dan lokasi arsip.
     */
    public function update(
        Request $request,
        $id
    ) {
        $nasabah = Nasabah::with('lokasiArsip')
            ->findOrFail($id);


        $validated = $request->validate([
            'nomor_nasabah' => [
                'required',
                'string',
                'max:50',
                Rule::unique(
                    'nasabah',
                    'nomor_nasabah'
                )->ignore($nasabah->id),
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'rak' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nomor_map' => [
                'nullable',
                'string',
                'max:50',
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
             * Update data nasabah.
             */
            $nasabah->update([
                'nomor_nasabah' =>
                    $validated['nomor_nasabah'],

                'nama' =>
                    $validated['nama'],
            ]);


            /*
             * Data lokasi arsip.
             */
            $lokasiData = [
                'rak' =>
                    $validated['rak'] ?? null,

                'nomor_map' =>
                    $validated['nomor_map'] ?? null,

                'posisi' =>
                    $validated['posisi'] ?? null,
            ];


            /*
             * Jika nasabah sudah memiliki lokasi arsip,
             * update lokasi tersebut.
             */
            if ($nasabah->lokasiArsip) {

                $nasabah->lokasiArsip->update(
                    $lokasiData
                );

            } else {

                /*
                 * Jika belum memiliki lokasi arsip,
                 * buat jika ada data yang diisi.
                 */
                if (
                    !empty($lokasiData['rak']) ||
                    !empty($lokasiData['nomor_map']) ||
                    !empty($lokasiData['posisi'])
                ) {
                    $nasabah->lokasiArsip()->create(
                        $lokasiData
                    );
                }
            }
        });


        return redirect()
            ->route(
                'admin.nasabah.show',
                $nasabah->id
            )
            ->with(
                'success',
                'Data nasabah dan lokasi arsip berhasil diperbarui.'
            );
    }


    /**
     * Menampilkan halaman upload dokumen
     * untuk nasabah.
     */
    public function uploadDokumen($id)
    {
        $nasabah = Nasabah::findOrFail($id);

        return view(
            'admin.nasabah.upload-dokumen',
            compact('nasabah')
        );
    }


    /**
     * Menampilkan halaman untuk mengganti
     * file dokumen.
     */
    public function gantiDokumen(
        $nasabahId,
        $dokumenId
    ) {
        $nasabah = Nasabah::findOrFail(
            $nasabahId
        );

        $dokumen = $nasabah->dokumen()
            ->with('jenisDokumen')
            ->findOrFail($dokumenId);

        return view(
            'admin.nasabah.ganti-dokumen',
            compact(
                'nasabah',
                'dokumen'
            )
        );
    }
}