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
            // Kolom nama_pasangan, nullable
            if (!Schema::hasColumn('pasien', 'nama_pasangan')) {
                $table->string('nama_pasangan')->nullable()->after('nama_suami');
            }

            // Kolom id_rm sebagai foreign key ke tabel rekam_medis
            if (!Schema::hasColumn('pasien', 'id_rm')) {
                $table->unsignedBigInteger('id_rm')->nullable()->after('id_pasien');

                $table->foreign('id_rm')->references('id_rm')->on('rekam_medis')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropForeign(['id_rm']);
            $table->dropColumn('id_rm');

            $table->dropColumn('nama_pasangan');
        });
    }
};
