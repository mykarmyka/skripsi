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
            $table->dropColumn('nama_pasangan');
        });

        Schema::table('pasien', function (Blueprint $table) {
            $table->string('nama_pasangan')->nullable(); // tambah ulang jadi nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('nama_pasangan');
        });

        Schema::table('pasien', function (Blueprint $table) {
            $table->string('nama_pasangan'); // tambah ulang jadi NOT NULL
        });
    }
};
