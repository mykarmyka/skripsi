<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RekamMedisController extends Controller
{
    public function index()
    {
        return view('admin.rekam-medis'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'pasien_id' => 'required|exists:pasien,id',
            'jenis_layanan' => 'required|string|max:255',
            'anamnesa' => 'required|text|',
            'diagnosa' => 'required|text|',
            'terapi' => 'required|text',
            'ket' => 'required|text',
        ]);

        RekamMedis::create([
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'pasien_id' => $request->pasien_id,
            'jenis_layanan' => $request->jenis_layanan,
            'anamnesa' => $request->anamnesa,
            'diagnosa' => $request->diagnosa,
            'terapi' => $request->terapi,
            'ket' => $request->ket,
        ]);

        return redirect()->route('admin.rekam-medis')->with('success', 'Rekam medis berhasil ditambahkan!');
    }
}
