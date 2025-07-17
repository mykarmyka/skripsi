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
        Schema::create('pendaftaran_layanan', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->unsignedBigInteger('id_pasien');
            $table->dateTime('tgl_pendaftaran');
            $table->enum('jenis_layanan', ['KB', 'Pemeriksaan Umum', 'Persalinan', 'Pemeriksaan Kehamilan']);
            $table->integer('no_antrian');
            $table->timestamps();

            // Relasi foreign key
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_layanan');
    }
};
