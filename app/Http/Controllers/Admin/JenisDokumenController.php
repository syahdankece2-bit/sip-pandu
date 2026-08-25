<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisDokumen;

class JenisDokumenController extends Controller
{
    /**
     * Menampilkan halaman jenis dokumen.
     */
    public function index()
    {
        $jenisDokumen = JenisDokumen::orderBy('nama_dokumen')->get();

        return view('admin.jenis-dokumen.index', compact('jenisDokumen'));
    }

    /**
     * Menampilkan halaman tambah jenis dokumen.
     */
    public function create()
    {
        return view('admin.jenis-dokumen.create');
    }

    /**
     * Menampilkan halaman edit jenis dokumen.
     */
    public function edit(JenisDokumen $jenisDokumen)
    {
        return view('admin.jenis-dokumen.edit', compact('jenisDokumen'));
    }

    
}