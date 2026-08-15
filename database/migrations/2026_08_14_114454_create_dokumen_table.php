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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nasabah_id')
                ->constrained('nasabah')
                ->cascadeOnDelete();

            $table->foreignId('jenis_dokumen_id')
                ->constrained('jenis_dokumen')
                ->restrictOnDelete();

            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('nama_file')->nullable();
            $table->string('path_file')->nullable();

            $table->enum('status_fisik', [
                'tersedia',
                'tidak_tersedia'
            ])->default('tersedia');

            $table->enum('status_digital', [
                'tersedia',
                'belum_tersedia'
            ])->default('belum_tersedia');

            $table->timestamp('uploaded_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
