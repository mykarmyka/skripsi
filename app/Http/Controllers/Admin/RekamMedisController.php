<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pasien', 'pendaftaran'])->orderByDesc('tgl_rm')->get();
        return view('admin.rekam-medis', compact('rekamMedis'));
    }

    public function destroy($id)
    {
        RekamMedis::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data rekam medis berhasil dihapus.');
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
