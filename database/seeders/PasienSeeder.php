<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pasien::create([
            'nama' => 'Ani Setiawan',
            'nik' => '3579012345678901',
            'tempat_lahir' => 'Ngawi',
            'tgl_lahir' => '1995-06-15',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Melati No. 5',
            'no_telp' => '081234567890',
            'nama_pasangan' => 'Budi Setiawan',
            'email' => 'ani@example.com',
            
        ]);
    }
}
