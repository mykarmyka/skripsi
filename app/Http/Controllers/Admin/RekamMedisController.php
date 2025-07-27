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
            'id_rm' => 'required|',
            'id_pasien' => 'required|exists:pasien,id',
            'id_pendaftaran' => 'required|',
            'id_admin' => 'required',
            'tgl_rm' => 'required|date',
            'anamnesa' => 'required|text|',
            'diagnosa' => 'required|text|',
            'terapi' => 'required|text',
            'keterangan' => 'required|text',
        ]);

        RekamMedis::create([
            'id_rm' => $request->id_rm,
            'id_pasien' => $request->id_pasien,
            'id_pendaftaran' => $request->id_pendaftaran,
            'id_admin' => $request->id_admin,
            'tgl_rm' => $request->tgl_rm,
            'anamnesa' => $request->anamnesa,
            'diagnosa' => $request->diagnosa,
            'terapi' => $request->terapi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.rekam-medis')->with('success', 'Rekam medis berhasil ditambahkan!');
    }

    public function pencarian(Request $request)
    {
        $query = RekamMedis::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'tgl_rm', 'id_admin', 'like', "%$search%");
        }

        $rekamMedis = $query->get();

        return view('admin.rekam-medis', compact('rekamMedis'));
    }
}
