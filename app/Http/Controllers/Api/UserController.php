<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user/petugas.
     *
     * Khusus Admin.
     */
    public function index()
    {
        $users = User::query()
            ->select([
                'id',
                'name',
                'id_pegawai',
                'username',
                'email',
                'role',
                'status',
                'created_at',
            ])
            ->orderBy('name')
            ->get();

        return response()->json([
            'message' => 'Daftar user berhasil diambil.',
            'data' => $users,
        ]);
    }


    /**
     * Menampilkan detail user.
     *
     * Khusus Admin.
     */
    public function show(User $user)
    {
        return response()->json([
            'message' => 'Detail user berhasil diambil.',
            'data' => $user->only([
                'id',
                'name',
                'id_pegawai',
                'username',
                'email',
                'role',
                'status',
                'created_at',
            ]),
        ]);
    }


    /**
     * Menambahkan Petugas baru.
     *
     * Khusus Admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'id_pegawai' => [
                'required',
                'string',
                'max:255',
                'unique:users,id_pegawai',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'id_pegawai' => $validated['id_pegawai'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => $validated['password'],
            'role' => 'petugas',
            'status' => 'aktif',
        ]);


        return response()->json([
            'message' => 'Petugas berhasil ditambahkan.',
            'data' => $user->only([
                'id',
                'name',
                'id_pegawai',
                'username',
                'email',
                'role',
                'status',
                'created_at',
            ]),
        ], 201);
    }


    /**
     * Mengedit data Petugas.
     *
     * Khusus Admin.
     */
    public function update(Request $request, User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan yang diedit adalah Petugas
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'petugas') {
            return response()->json([
                'message' => 'Data Admin tidak dapat diedit melalui fitur ini.',
            ], 403);
        }


        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'id_pegawai' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'id_pegawai')
                    ->ignore($user->id),
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')
                    ->ignore($user->id),
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
            ],
        ]);


        $user->name = $validated['name'];
        $user->id_pegawai = $validated['id_pegawai'];
        $user->username = $validated['username'];
        $user->email = $validated['email'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Password hanya diubah jika dikirim
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();


        return response()->json([
            'message' => 'Data petugas berhasil diperbarui.',
            'data' => $user->only([
                'id',
                'name',
                'id_pegawai',
                'username',
                'email',
                'role',
                'status',
                'created_at',
            ]),
        ]);
    }


    /**
     * Mengaktifkan atau menonaktifkan Petugas.
     *
     * Khusus Admin.
     */
    public function deactivate(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan yang dinonaktifkan adalah Petugas
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'petugas') {
            return response()->json([
                'message' => 'Data Admin tidak dapat dinonaktifkan melalui fitur ini.',
            ], 403);
        }


        $user->status = 'nonaktif';
        $user->save();


        return response()->json([
            'message' => 'Petugas berhasil dinonaktifkan.',
            'data' => $user->only([
                'id',
                'name',
                'id_pegawai',
                'username',
                'email',
                'role',
                'status',
            ]),
        ]);
    }


    /**
     * Mengaktifkan kembali Petugas.
     *
     * Khusus Admin.
     */
    public function activate(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan yang diaktifkan adalah Petugas
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'petugas') {
            return response()->json([
                'message' => 'Data Admin tidak dapat diaktifkan melalui fitur ini.',
            ], 403);
        }


        $user->status = 'aktif';
        $user->save();


        return response()->json([
            'message' => 'Petugas berhasil diaktifkan.',
            'data' => $user->only([
                'id',
                'name',
                'id_pegawai',
                'username',
                'email',
                'role',
                'status',
            ]),
        ]);
    }
}