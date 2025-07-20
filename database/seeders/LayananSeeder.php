<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Layanan::create([
            'jenis_layanan' => 'Pemeriksaan Kehamilan',
            'deskripsi' => 'Pemeriksaan rutin untuk ibu hamil.'
        ]);

        Layanan::create([
            'jenis_layanan' => 'KB Suntik',
            'deskripsi' => 'Pelayanan KB dengan metode suntik.'
        ]);
    }
}
