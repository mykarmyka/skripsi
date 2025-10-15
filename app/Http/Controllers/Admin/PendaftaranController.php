<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranLayanan;
use Illuminate\Http\Request;


class PendaftaranController extends Controller
{

    public function simpanPendaftaran(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'id_jenis_layanan' => 'required|exists:jenis_layanan,id',
            'tgl_pendaftaran' => 'required|date',
        ]);

        // Nomor antrian otomatis per hari
        $jumlahAntrianHariIni = PendaftaranLayanan::whereDate('tgl_pendaftaran', $request->tgl_pendaftaran)->count();
        $no_antrian_baru = $jumlahAntrianHariIni + 1;

        PendaftaranLayanan::create([
            'id_pasien' => $request->id_pasien,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'id_jenis_layanan' => $request->id_jenis_layanan,
            'no_antrian' => str_pad($no_antrian_baru, 4, '0', STR_PAD_LEFT),
            'status' => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil!');
    }

    public function simpanPersalinan(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'id_jenis_layanan' => 'required|exists:jenis_layanan,id',
            'tgl_pendaftaran' => 'required|date',
        ]);

        // Hitung jumlah pendaftar persalinan di tanggal yang sama
        $jumlahAntrian = PendaftaranLayanan::where('id_jenis_layanan', $request->id_jenis_layanan)
            ->whereDate('tgl_pendaftaran', $request->tgl_pendaftaran)
            ->count();

        if ($jumlahAntrian >= 3) {
            return redirect()->back()->with('error', 'Pendaftaran persalinan sudah penuh untuk hari ini (maksimal 3 pasien).');
        }

        $no_antrian = $jumlahAntrian + 1;

        PendaftaranLayanan::create([
            'id_pasien' => $request->id_pasien,
            'id_jenis_layanan' => $request->id_jenis_layanan,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'no_antrian' => str_pad($no_antrian, 4, '0', STR_PAD_LEFT),
            'status' => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Pendaftaran persalinan berhasil!');
    }


}
