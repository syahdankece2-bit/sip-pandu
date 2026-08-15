<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lokasi_arsip', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nasabah_id')
                ->unique()
                ->constrained('nasabah')
                ->cascadeOnDelete();

            $table->string('rak');
            $table->string('nomor_map');
            $table->string('posisi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_arsip');
    }
};
