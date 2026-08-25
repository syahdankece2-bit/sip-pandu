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
        Schema::table('nasabah', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('nama');
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->string('npwp', 32)->nullable()->after('no_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'no_kk',
                'npwp',
            ]);
        });
    }
};
