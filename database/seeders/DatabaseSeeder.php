<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Nasabah;
use App\Models\LokasiArsip;
use App\Models\JenisDokumen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // ADMIN
        // =========================
        $admin = User::create([
            'name' => 'Admin SIP-PANDU',
            'id_pegawai' => 'ADM001',
            'username' => 'admin',
            'email' => 'admin@sip-pandu.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        // =========================
        // PETUGAS
        // =========================
        $petugas = User::create([
            'name' => 'Petugas Arsip',
            'id_pegawai' => 'PTG001',
            'username' => 'petugas',
            'email' => 'petugas@sip-pandu.test',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'status' => 'aktif',
        ]);

        // =========================
        // NASABAH
        // =========================
        $nasabah = Nasabah::create([
            'nomor_nasabah' => '00009',
            'nama' => 'Budi Santoso',
            'status' => 'aktif',
        ]);

        // =========================
        // LOKASI ARSIP
        // =========================
        LokasiArsip::create([
            'nasabah_id' => $nasabah->id,
            'rak' => 'Rak B',
            'nomor_map' => '027',
            'posisi' => '03',
        ]);

        // =========================
        // JENIS DOKUMEN
        // =========================
        $jenisDokumen = [
            [
                'nama_dokumen' => 'KTP',
                'deskripsi' => 'Kartu Tanda Penduduk',
                'status' => 'aktif',
            ],
            [
                'nama_dokumen' => 'KK',
                'deskripsi' => 'Kartu Keluarga',
                'status' => 'aktif',
            ],
            [
                'nama_dokumen' => 'NPWP',
                'deskripsi' => 'Nomor Pokok Wajib Pajak',
                'status' => 'aktif',
            ],
            [
                'nama_dokumen' => 'Slip Gaji',
                'deskripsi' => 'Dokumen slip gaji nasabah',
                'status' => 'aktif',
            ],
        ];

        foreach ($jenisDokumen as $data) {
            JenisDokumen::create($data);
        }
    }
}