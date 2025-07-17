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
        Schema::create('pasien', function (Blueprint $table) {
        $table->id('id_pasien');
        $table->string('nama', 255);
        $table->string('NIK', 16)->unique();
        $table->string('tempat_lahir', 100);
        $table->date('tgl_lahir');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->text('alamat');
        $table->string('no_telp', 20);
        $table->string('nama_pasangan', 100);
        $table->string('email', 255)->unique();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
