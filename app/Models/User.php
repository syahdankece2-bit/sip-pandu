<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nama tabel database.
     */
    protected $table = 'users';

    /**
     * Field yang boleh diisi menggunakan mass assignment.
     */
    protected $fillable = [
        'name',
        'id_pegawai',
        'username',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * Field yang disembunyikan ketika model diubah menjadi array/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi:
     * Satu user dapat mengunggah banyak dokumen.
     */
    public function dokumenDiunggah(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'uploaded_by');
    }
}