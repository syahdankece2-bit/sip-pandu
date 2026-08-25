<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\JenisDokumen;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasabahController extends Controller
{
    /**
     * Menampilkan daftar data nasabah untuk petugas.
     */
    public function index(Request $request)
    {
        $query = Nasabah::with('lokasiArsip');

        /*
        |--------------------------------------------------------------------------
        | Pencarian Nasabah
        |--------------------------------------------------------------------------
        | Mencari berdasarkan nomor nasabah atau nama.
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nomor_nasabah',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'nama',
                    'like',
                    "%{$search}%"
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Status Nasabah
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
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'user.nasabah.index',
            compact('nasabah')
        );
    }


    /**
     * Menampilkan detail nasabah.
     */
    public function show(Nasabah $nasabah)
    {
        /*
        |--------------------------------------------------------------------------
        | Load Relasi
        |--------------------------------------------------------------------------
        */

        $nasabah->load([
            'lokasiArsip',
            'dokumen.jenisDokumen',
            'dokumen.uploader',
        ]);


        return view(
            'user.nasabah.show',
            compact('nasabah')
        );
    }


    /**
     * Menampilkan form upload dokumen.
     *
     * Petugas hanya dapat mengunggah dokumen
     * untuk nasabah yang masih aktif.
     */
    public function uploadDokumen(Nasabah $nasabah)
    {
        /*
        |--------------------------------------------------------------------------
        | Cek Status Nasabah
        |--------------------------------------------------------------------------
        */

        if ($nasabah->status !== 'aktif') {

            return redirect()
                ->route(
                    'user.nasabah.show',
                    $nasabah
                )
                ->with(
                    'error',
                    'Nasabah nonaktif tidak dapat menerima dokumen baru.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Jenis Dokumen Aktif
        |--------------------------------------------------------------------------
        */

        $jenisDokumen = JenisDokumen::where(
            'status',
            'aktif'
        )
            ->orderBy('nama_dokumen')
            ->get();


        return view(
            'user.nasabah.upload-dokumen',
            compact(
                'nasabah',
                'jenisDokumen'
            )
        );
    }


    /**
     * Menyimpan dokumen baru.
     *
     * Petugas hanya dapat mengunggah dokumen
     * untuk nasabah yang masih aktif.
     */
    public function storeDokumen(
        Request $request,
        Nasabah $nasabah
    ) {

        /*
        |--------------------------------------------------------------------------
        | Cek Status Nasabah
        |--------------------------------------------------------------------------
        |
        | Pengecekan dilakukan kembali di backend.
        | Jadi meskipun petugas mencoba mengakses
        | endpoint upload secara manual, proses tetap ditolak.
        |
        */

        if ($nasabah->status !== 'aktif') {

            return redirect()
                ->route(
                    'user.nasabah.show',
                    $nasabah
                )
                ->with(
                    'error',
                    'Nasabah nonaktif tidak dapat menerima dokumen baru.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi Data
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'jenis_dokumen_id' => [
                    'required',
                    'exists:jenis_dokumen,id',
                ],

                'file' => [
                    'required',
                    'file',
                    'mimes:pdf,jpg,jpeg,png',
                    'max:5120',
                ],
            ],
            [
                'jenis_dokumen_id.required' =>
                    'Jenis dokumen wajib dipilih.',

                'jenis_dokumen_id.exists' =>
                    'Jenis dokumen tidak valid.',

                'file.required' =>
                    'File dokumen wajib dipilih.',

                'file.file' =>
                    'File yang diunggah tidak valid.',

                'file.mimes' =>
                    'File harus berupa PDF, JPG, JPEG, atau PNG.',

                'file.max' =>
                    'Ukuran file maksimal 5 MB.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Ambil File
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $namaFile = $file->getClientOriginalName();


        /*
        |--------------------------------------------------------------------------
        | Simpan File ke Storage
        |--------------------------------------------------------------------------
        */

        $pathFile = $file->store(
            'dokumen/' . $nasabah->id,
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Simpan Data Dokumen ke Database
        |--------------------------------------------------------------------------
        */

        Dokumen::create([
            'nasabah_id' => $nasabah->id,

            'jenis_dokumen_id' =>
                $validated['jenis_dokumen_id'],

            'uploaded_by' =>
                Auth::id(),

            'nama_file' =>
                $namaFile,

            'path_file' =>
                $pathFile,

            'status_fisik' =>
                'tersedia',

            'status_digital' =>
                'tersedia',

            'uploaded_at' =>
                now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'user.nasabah.show',
                $nasabah
            )
            ->with(
                'success',
                'Dokumen berhasil diunggah.'
            );
    }
}