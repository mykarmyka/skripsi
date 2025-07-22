<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranLayanan;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tgl_pendaftaran' => 'required|date',
            'jenis_layanan' => 'required',
             
        ]);

        $pasienId = Auth::guard('pasien')->user()->id;

        // Ambil no antrian terbaru hari ini
        $noAntrian = PendaftaranLayanan::whereDate('tgl_pendaftaran', now()->toDateString())->max('no_antrian');
        $noAntrian = $noAntrian ? $noAntrian + 1 : 1;

        PendaftaranLayanan::create([
            'id_pasien' => $pasienId,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'jenis_layanan' => $request->jenis_layanan,
            'no_antrian' => $noAntrian,
            'status' => 'waiting', // default status
        ]);

        return redirect()->route('pasien.home')->with('success', 'Pendaftaran berhasil!');
    }

    public function simpanPendaftaran(Request $request)
    {
        $request->validate([
        'jenis_layanan' => 'required|in:Pemeriksaan Umum,Pemeriksaan Kehamilan,KB,Persalinan,Nifas,Massage Baby & Spa',
        'tgl_pendaftaran' => 'required|date',
        'status' => 'nullable|in:waiting,done', 
    ]);

    // Ambil pasien yang sedang login
    $pasien = Auth::guard('pasien')->user();

    // Simpan ke database
    Pendaftaran::create([
        'id_pendaftaran' => $pasien->id_pendaftaran,
        'id_pasien' => $request->id_pasien,
        'tgl_pendaftaran' => $request->tgl_pendaftaran,
        'jenis_layanan' => $request->jenis_layanan,
        'no_antrian' => str_pad(rand(1, 99), 4, '0', STR_PAD_LEFT),
        'status' => $request->status ?? 'waiting', // default waiting kalau belum dikirim
    ]);

    return redirect()->route('user.home')->with('success', 'Pendaftaran berhasil disimpan ke database!');
    }
}
