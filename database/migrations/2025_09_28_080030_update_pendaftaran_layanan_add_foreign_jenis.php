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
        Schema::table('pendaftaran_layanan', function (Blueprint $table) {
            // Tambahkan kolom baru
            if (!Schema::hasColumn('pendaftaran_layanan', 'id_jenis_layanan')) {
                $table->unsignedBigInteger('id_jenis_layanan')->after('tgl_pendaftaran')->nullable();

                // foreign key ke tabel jenis_layanan
                $table->foreign('id_jenis_layanan')
                      ->references('id')
                      ->on('jenis_layanan')
                      ->onDelete('restrict');
            }

            // Hapus kolom lama kalau masih ada
            if (Schema::hasColumn('pendaftaran_layanan', 'jenis_layanan')) {
                $table->dropColumn('jenis_layanan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_layanan', function (Blueprint $table) {
            // Rollback: hapus foreign key & kolom baru
            if (Schema::hasColumn('pendaftaran_layanan', 'id_jenis_layanan')) {
                $table->dropForeign(['id_jenis_layanan']);
                $table->dropColumn('id_jenis_layanan');
            }

            // Balikin kolom lama
            if (!Schema::hasColumn('pendaftaran_layanan', 'jenis_layanan')) {
                $table->string('jenis_layanan')->nullable();
            }
        });
    }
};
