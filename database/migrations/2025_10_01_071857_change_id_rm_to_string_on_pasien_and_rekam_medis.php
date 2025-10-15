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
            $table->string('id_rm', 20)->nullable()->change();
        });

        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->string('id_rm', 20)->change(); // tetap not null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->bigInteger('id_rm')->nullable()->change();
        });

        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->bigInteger('id_rm')->change();
        });
    }
};
