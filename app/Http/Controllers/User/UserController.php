<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        return view('user.home');
        $riwayat = session('riwayat', []);
        return view('user.home', compact('riwayat'));
    }

    public function formPendaftaran() 
    {
        return view('user.pendaftaran');
    }

    public function submitPendaftaran(Request $request) {
        // Validasi dan simpan ke DB
        // Redirect atau tampilkan pesan sukses
    }

    public function simpanPendaftaran(Request $request)
    {
        // Simpan data ke session (sementara)
        $data = [
            'id' => '2025-' . rand(1000, 9999),
            'layanan' => $request->layanan,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'no_antrian' => str_pad(rand(1, 99), 4, '0', STR_PAD_LEFT),
        ];

        // Simpan ke session sebagai array
        $riwayat = session('riwayat', []);
        $riwayat[] = $data;
        session(['riwayat' => $riwayat]);

        return redirect()->route('user.home')->with('success', 'Pendaftaran berhasil!');
    }


}
