<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan halaman kelola user / petugas.
     */
    public function index()
    {
        $users = User::select([
            'id',
            'name',
            'id_pegawai',
            'username',
            'email',
            'avatar',
            'role',
            'status',
            'created_at',
        ])
        ->orderBy('name')
        ->get()
        ->map(function ($user) {
            $user->avatar_url = $user->avatar
                ? asset('storage/' . $user->avatar)
                : null;

            return $user;
        });

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan halaman tambah user / petugas.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user / petugas baru via Web form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_pegawai' => 'required|string|max:255|unique:users,id_pegawai',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'id_pegawai' => $validated['id_pegawai'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => $validated['password'],
            'role' => 'petugas',
            'status' => 'aktif',
        ]);

        return redirect()
            ->route('admin.users')
            ->with('success', 'Petugas baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman edit user / petugas.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user / petugas via Web form.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_pegawai' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'id_pegawai')->ignore($user->id),
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
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $validated['name'];
        $user->id_pegawai = $validated['id_pegawai'];
        $user->username = $validated['username'];
        $user->email = $validated['email'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('admin.users')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }
}