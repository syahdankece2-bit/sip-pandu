<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokasiArsip extends Model
{
    use HasFactory;

    protected $table = 'lokasi_arsip';

    protected $fillable = [
        'nasabah_id',
        'rak',
        'nomor_map',
        'posisi',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }
}