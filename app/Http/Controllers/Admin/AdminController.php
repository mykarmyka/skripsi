<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); 
    }

    public function dataPasien()
    {
        // $pasiens = Pasien::all();
        // return view('admin.pasien');
        $pasien = [
        (object)[
            'id' => 1,
            'tanggal_registrasi' => '2025-06-07',
            'nama_lengkap' => 'Ani Lestari',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1990-04-15',
            'jenis_kelamin' => 'Perempuan',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Melati No. 10',
            'nama_pasangan' => 'Budi Santoso',
        ],
        (object)[
            'id' => 2,
            'tanggal_registrasi' => '2025-06-07',
            'nama_lengkap' => 'Rina Maulida',
            'nik' => '2345678901234567',
            'tanggal_lahir' => '1988-10-01',
            'jenis_kelamin' => 'Perempuan',
            'no_telepon' => '082345678901',
            'alamat' => 'Jl. Kenanga No. 23',
            'nama_pasangan' => 'Andi Wijaya',
        ],
        // Tambahkan lebih banyak data jika perlu
    ];

    return view('admin.pasien', compact('pasien'));
    }

    public function dataObat()
    {
        return view('admin.obat');
    }
}
