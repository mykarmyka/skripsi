<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pendaftaran::create([
            'id_pendaftaran' => 1,
            'id_pasien' => 1,
            'tgl_pendaftaran' => now(),
            'no_antrian' => 1
        ]);
    }
}
