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
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jenis_layanan')->nullable()->after('id_admin');
            // membuat foreign key ke tabel jenis_layanan
            $table->foreign('id_jenis_layanan')->references('id')->on('jenis_layanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropForeign(['id_jenis_layanan']);
            $table->dropColumn('id_jenis_layanan');
        });
    }
};
