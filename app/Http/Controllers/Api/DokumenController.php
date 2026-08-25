<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    /**
     * Menampilkan semua dokumen milik nasabah.
     *
     * Admin dan Petugas boleh melihat.
     */
    public function index(Nasabah $nasabah)
    {
        $dokumen = $nasabah->dokumen()
            ->with([
                'jenisDokumen',
                'uploader'
            ])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Daftar dokumen nasabah berhasil diambil.',
            'data' => $dokumen,
        ]);
    }


    /**
     * Upload dokumen baru untuk nasabah.
     *
     * Admin dan Petugas boleh upload.
     */
    public function store(Request $request, Nasabah $nasabah)
    {
        $validated = $request->validate([
            'jenis_dokumen_id' => [
                'required',
                'exists:jenis_dokumen,id',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],

            'status_fisik' => [
                'nullable',
                'in:tersedia,tidak_tersedia',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan File
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $path = $file->store(
            'dokumen',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Simpan Data Dokumen ke Database
        |--------------------------------------------------------------------------
        */

        $dokumen = Dokumen::create([
            'nasabah_id' => $nasabah->id,

            'jenis_dokumen_id' => $validated['jenis_dokumen_id'],

            'uploaded_by' => Auth::id(),

            'nama_file' => $file->getClientOriginalName(),

            'path_file' => $path,

            'status_fisik' => $validated['status_fisik'] ?? 'tersedia',

            'status_digital' => 'tersedia',

            'uploaded_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Load Relasi
        |--------------------------------------------------------------------------
        */

        $dokumen->load([
            'jenisDokumen',
            'uploader'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'message' => 'Dokumen berhasil diupload.',
            'data' => $dokumen,
        ], 201);
    }


    /**
     * Menampilkan detail sebuah dokumen.
     *
     * Admin dan Petugas boleh melihat.
     */
    public function show(Dokumen $dokumen)
    {
        $dokumen->load([
            'nasabah',
            'jenisDokumen',
            'uploader'
        ]);

        return response()->json([
            'message' => 'Detail dokumen berhasil diambil.',
            'data' => $dokumen,
        ]);
    }


    /**
     * Preview dokumen.
     *
     * Admin dan Petugas boleh preview.
     */
    public function preview(Dokumen $dokumen)
    {
        /*
        |--------------------------------------------------------------------------
        | Cek Apakah File Ada
        |--------------------------------------------------------------------------
        */

        if (!Storage::disk('public')->exists($dokumen->path_file)) {

            return response()->json([
                'message' => 'File dokumen tidak ditemukan.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Path File
        |--------------------------------------------------------------------------
        */

        $path = Storage::disk('public')
            ->path($dokumen->path_file);


        /*
        |--------------------------------------------------------------------------
        | Tampilkan File
        |--------------------------------------------------------------------------
        */

        return response()->file($path);
    }


    /**
     * Download dokumen.
     *
     * Admin dan Petugas boleh download.
     */
    public function download(Dokumen $dokumen)
    {
        /*
        |--------------------------------------------------------------------------
        | Cek Apakah File Ada
        |--------------------------------------------------------------------------
        */

        if (!Storage::disk('public')->exists($dokumen->path_file)) {

            return response()->json([
                'message' => 'File dokumen tidak ditemukan.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Path File
        |--------------------------------------------------------------------------
        */

        $path = Storage::disk('public')
            ->path($dokumen->path_file);


        /*
        |--------------------------------------------------------------------------
        | Download File
        |--------------------------------------------------------------------------
        |
        | Menggunakan response()->download()
        | agar tidak terkena warning method download()
        | dari PHP/Intelephense.
        |
        */

        return response()->download(
            $path,
            $dokumen->nama_file
        );
    }


    /**
     * Mengganti file digital dari dokumen yang sudah ada.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        $file = $validated['file'];
        $oldPath = $dokumen->path_file;
        $newPath = $file->store('dokumen', 'public');

        try {
            $dokumen->update([
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $newPath,
                'status_digital' => 'tersedia',
                'uploaded_by' => Auth::id(),
                'uploaded_at' => now(),
            ]);

            if ($oldPath && $oldPath !== $newPath) {
                Storage::disk('public')->delete($oldPath);
            }

        } catch (\Throwable $error) {
            Storage::disk('public')->delete($newPath);
            throw $error;
        }

        $dokumen->load(['jenisDokumen', 'uploader']);

        return response()->json([
            'message' => 'Dokumen berhasil diganti.',
            'data' => $dokumen,
        ]);
    }


    /**
     * Menghapus data dokumen beserta file digitalnya.
     */
    public function destroy(Dokumen $dokumen)
    {
        $pathFile = $dokumen->path_file;

        $dokumen->delete();

        if ($pathFile) {
            Storage::disk('public')->delete($pathFile);
        }

        return response()->json([
            'message' => 'Dokumen berhasil dihapus.',
        ]);
    }

}