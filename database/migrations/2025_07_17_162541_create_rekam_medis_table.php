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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id('id_rm');
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_pendaftaran');
            $table->unsignedBigInteger('id_admin');
            $table->date('tgl_rm');
            $table->text('anamnesa');
            $table->text('diagnosa');
            $table->text('terapi');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_layanan')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('cascade');
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
