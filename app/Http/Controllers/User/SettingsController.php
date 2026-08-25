<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan akun petugas.
     */
    public function index()
    {
        $user = auth()->user();

        return view('user.settings.index', compact('user'));
    }


    /**
     * Memperbarui informasi profil petugas.
     *
     * Data yang dapat diubah:
     * - Nama
     * - Username
     * - Email
     * - Foto profil
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Validasi Data
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')->ignore($user->id),
                ],

                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],

                'avatar' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],
            ],
            [
                'name.required' =>
                    'Nama lengkap wajib diisi.',

                'name.max' =>
                    'Nama lengkap maksimal 255 karakter.',

                'username.required' =>
                    'Username wajib diisi.',

                'username.max' =>
                    'Username maksimal 255 karakter.',

                'username.unique' =>
                    'Username sudah digunakan oleh pengguna lain.',

                'email.email' =>
                    'Format email tidak valid.',

                'email.max' =>
                    'Email maksimal 255 karakter.',

                'email.unique' =>
                    'Email sudah digunakan oleh pengguna lain.',

                'avatar.image' =>
                    'File yang dipilih harus berupa gambar.',

                'avatar.mimes' =>
                    'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

                'avatar.max' =>
                    'Ukuran foto maksimal 2 MB.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Update Data Profil
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];

        $user->username = $validated['username'];

        $user->email = $validated['email'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Upload Foto Profil
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('avatar')) {

            /*
            |--------------------------------------------------------------------------
            | Hapus Foto Lama
            |--------------------------------------------------------------------------
            */

            if (
                $user->avatar &&
                Storage::disk('public')->exists($user->avatar)
            ) {
                Storage::disk('public')->delete($user->avatar);
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan Foto Baru
            |--------------------------------------------------------------------------
            */

            $avatarPath = $request
                ->file('avatar')
                ->store('avatars', 'public');

            $user->avatar = $avatarPath;
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Data User
        |--------------------------------------------------------------------------
        */

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Informasi profil berhasil diperbarui.'
        );
    }


    /**
     * Memperbarui password petugas.
     */
    public function updatePassword(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi Password
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'current_password' => [
                    'required',
                    'string',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ],
            [
                'current_password.required' =>
                    'Password lama wajib diisi.',

                'password.required' =>
                    'Password baru wajib diisi.',

                'password.min' =>
                    'Password baru minimal 8 karakter.',

                'password.confirmed' =>
                    'Konfirmasi password tidak cocok.',
            ]
        );


        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Cek Password Lama
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $validated['current_password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'Password lama yang Anda masukkan salah.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Password Baru
        |--------------------------------------------------------------------------
        */

        $user->update([
            'password' => Hash::make(
                $validated['password']
            ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Password berhasil diperbarui.'
        );
    }


    /**
     * Memperbarui preferensi akun.
     *
     * Untuk sementara fitur preferensi belum disimpan
     * ke database.
     */
    public function updatePreferences(Request $request)
    {
        return back()->with(
            'success',
            'Pengaturan preferensi berhasil diperbarui.'
        );
    }
}