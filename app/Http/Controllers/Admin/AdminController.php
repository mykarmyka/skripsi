<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\PendaftaranLayanan;
use App\Models\RekamMedis;

class AdminController extends Controller
{
    public function dashboard()
    {
        $jumlahPasien = Pasien::count();
        $jumlahLayanan = PendaftaranLayanan::count();
        $jumlahAntrian = PendaftaranLayanan::whereDate('tgl_pendaftaran', now())->count();

        $rekamMedis = RekamMedis::with(['pendaftaran.pasien'])->orderBy('created_at', 'desc')->get();
        
        return view('admin.dashboard', compact(
            'jumlahPasien',
            'jumlahLayanan',
            'jumlahAntrian',
            'rekamMedis'
        )); 
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

    public function lihatPendaftaran()
    {
        // Simulasi data dummy (belum dari DB)
        $pendaftaran = [
            [
                'id' => 1,
                'nama' => 'Siti Aisyah',
                'jenis_layanan' => 'Pemeriksaan Kehamilan',
                'tanggal' => '2025-07-16',
            ],
            [
                'id' => 2,
                'nama' => 'Dewi Lestari',
                'jenis_layanan' => 'KB Implan',
                'tanggal' => '2025-07-16',
            ],
            [
                'id' => 3,
                'nama' => 'Lina Marlina',
                'jenis_layanan' => 'Persalinan',
                'tanggal' => '2025-07-16',
            ],
        ];

        return view('admin.layanan', compact('pendaftaran'));
    }

}
