<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Setting;
use App\Models\Nasabah;
use App\Models\Dokumen;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman Pengaturan Sistem.
     */
    public function index()
    {
        $user = Auth::user();

        $generalSettings = [
            'app_name' => Setting::getValue('app_name', 'SIP-PANDU'),
            'app_description' => Setting::getValue('app_description', 'Sistem Informasi Pengarsipan & Dokumentasi Nasabah (Enterprise DMS Edition)'),
            'max_file_size' => Setting::getValue('max_file_size', '25'),
            'allowed_file_types' => Setting::getValue('allowed_file_types', 'PDF, JPG, JPEG, PNG, DOCX'),
        ];

        $appInfo = [
            'app_name' => Setting::getValue('app_name', 'SIP-PANDU'),
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'db_driver' => ucfirst(DB::getDriverName()),
            'total_nasabah' => Nasabah::count(),
            'total_dokumen' => Dokumen::count(),
            'server_time' => now()->translatedFormat('d F Y, H:i:s T'),
        ];

        return view('admin.settings.index', compact('user', 'generalSettings', 'appInfo'));
    }

    /**
     * Memperbarui Profil Saya (Nama, Email, Avatar).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'Sesi login telah berakhir.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /** @var User $user */
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Handle Avatar File Upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Memperbarui Pengaturan Umum Sistem.
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:1000',
            'max_file_size' => 'required|numeric|min:1|max:100',
            'allowed_file_types' => 'required|string|max:255',
        ]);

        Setting::setValue('app_name', $validated['app_name']);
        Setting::setValue('app_description', $validated['app_description'] ?? '');
        Setting::setValue('max_file_size', (string) $validated['max_file_size']);
        Setting::setValue('allowed_file_types', $validated['allowed_file_types']);

        return back()->with('success', 'Pengaturan umum sistem berhasil diperbarui.');
    }

    /**
     * Memperbarui Password Saya.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'Sesi login telah berakhir.');
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        /** @var User $user */
        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Password Anda berhasil diperbarui.');
    }
}
