<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumen';

    protected $fillable = [
        'nama_dokumen',
        'deskripsi',
        'status',
    ];

    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }
}