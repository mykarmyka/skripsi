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
        Schema::table('pasien', function (Blueprint $table) {
            // Jadikan kolom NIK unique
            $table->string('nik')->unique()->change();

            // Ubah kolom nama_pasangan menjadi not null
            $table->string('nama_pasangan')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            // Balikkan kolom nik jadi tidak unique
            $table->dropUnique(['nik']);
            $table->string('nik')->change();

            // Balikkan kolom nama_pasangan jadi nullable
            $table->string('nama_pasangan')->nullable()->change();
        });
    }
};
