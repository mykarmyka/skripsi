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

    public function pencarian(Request $request)
    {
        $query = PendaftaranLayanan::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'tgl_pendaftaran', 'no_antrian', 'like', "%$search%");
        }

        $rekamMedis = $query->get();

        return view('user.pendaftaran', compact('pendaftaran'));
    }

}
