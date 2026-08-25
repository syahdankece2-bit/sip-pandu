<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    /**
     * Menampilkan daftar seluruh dokumen.
     */
    public function index(Request $request)
    {
        $query = Dokumen::with([
            'nasabah',
            'jenisDokumen',
            'uploader',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                // Cari berdasarkan nama file
                $q->where(
                    'nama_file',
                    'like',
                    "%{$search}%"
                )

                // Cari berdasarkan nama / nomor nasabah
                ->orWhereHas('nasabah', function ($nasabah) use ($search) {

                    $nasabah
                        ->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'nomor_nasabah',
                            'like',
                            "%{$search}%"
                        );

                })

                // Cari berdasarkan jenis dokumen
                ->orWhereHas('jenisDokumen', function ($jenis) use ($search) {

                    $jenis->where(
                        'nama_dokumen',
                        'like',
                        "%{$search}%"
                    );

                });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $dokumen = $query
            ->latest('uploaded_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'user.dokumen.index',
            compact('dokumen')
        );
    }


    /**
     * Preview dokumen.
     */
    public function preview(Dokumen $dokumen)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi file
        |--------------------------------------------------------------------------
        */

        if (!$dokumen->path_file) {
            abort(404, 'File dokumen tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan file benar-benar ada
        |--------------------------------------------------------------------------
        */

        $disk = Storage::disk('public');

        if (!$disk->exists($dokumen->path_file)) {
            abort(404, 'File dokumen tidak ditemukan di storage.');
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil lokasi file
        |--------------------------------------------------------------------------
        */

        $path = $disk->path($dokumen->path_file);

        /*
        |--------------------------------------------------------------------------
        | Tentukan MIME Type
        |--------------------------------------------------------------------------
        */

        $mimeType = mime_content_type($path);

        /*
        |--------------------------------------------------------------------------
        | Tampilkan file di browser
        |--------------------------------------------------------------------------
        */

        return response()->file(
            $path,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' .
                    $dokumen->nama_file .
                    '"',
            ]
        );
    }


    /**
     * Download dokumen.
     */
    public function download(Dokumen $dokumen)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi file
        |--------------------------------------------------------------------------
        */

        if (!$dokumen->path_file) {
            abort(404, 'File dokumen tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan file benar-benar ada
        |--------------------------------------------------------------------------
        */

        $disk = Storage::disk('public');

        if (!$disk->exists($dokumen->path_file)) {
            abort(404, 'File dokumen tidak ditemukan di storage.');
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil lokasi file
        |--------------------------------------------------------------------------
        */

        $path = $disk->path($dokumen->path_file);

        /*
        |--------------------------------------------------------------------------
        | Nama file untuk download
        |--------------------------------------------------------------------------
        */

        $namaFile = $dokumen->nama_file
            ?: basename($dokumen->path_file);

        /*
        |--------------------------------------------------------------------------
        | Download
        |--------------------------------------------------------------------------
        */

        return response()->download(
            $path,
            $namaFile
        );
    }
}