<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranLayanan;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{

    public function simpanPendaftaran(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|in:Pemeriksaan Umum,Pemeriksaan Kehamilan,KB,Persalinan,Nifas,Massage & Baby Spa',
            'tgl_pendaftaran' => 'required|date',
            'status' => 'nullable|in:waiting,done',
        ]);

        $pasien = Auth::guard('pasien')->user()->id_pasien;


        PendaftaranLayanan::create([
            'id_pasien' => $pasien,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'jenis_layanan' => $request->jenis_layanan,
            'no_antrian' => str_pad(rand(1, 99), 4, '0', STR_PAD_LEFT),
            'status' => $request->status ?? 'waiting',
        ]);

        return redirect()->route('user.home')->with('success', 'Pendaftaran berhasil disimpan ke database!');
    }

    public function simpanPersalinan(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|in:Persalinan',
            'tgl_pendaftaran' => 'required|date',
            'status' => 'nullable|in:waiting,done',
        ]);

        $pasien = Auth::guard('pasien')->user()->id_pasien;

        // Hitung jumlah pendaftar persalinan di tanggal yang sama
        $jumlahAntrian = PendaftaranLayanan::where('jenis_layanan', 'Persalinan')
            ->whereDate('tgl_pendaftaran', $request->tgl_pendaftaran)
            ->count();

        if ($jumlahAntrian >= 3) {
            return redirect()->route('user.home')
                ->with('error', 'Pendaftaran persalinan sudah penuh untuk hari ini (maksimal 3 pasien).');
        }

        // Nomor antrian: urut sesuai jumlah antrian, bukan random
        $no_antrian = $jumlahAntrian + 1;


        PendaftaranLayanan::create([
            'id_pasien' => $pasien,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'jenis_layanan' => $request->jenis_layanan,
            'no_antrian' => str_pad(rand(1, 99), 4, '0', STR_PAD_LEFT),
            'status' => $request->status ?? 'waiting',
        ]);

        return redirect()->route('user.home')->with('success', 'Pendaftaran berhasil disimpan ke database!');
    }

    

}
