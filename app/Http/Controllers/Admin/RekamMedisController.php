<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\PendaftaranLayanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $rekamMedis = RekamMedis::with(['pasien', 'pendaftaran'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('pasien', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                })->orWhere('tgl_rm', 'like', "%{$keyword}%");
            })
            ->orderByDesc('tgl_rm')
            ->get();

        $pasien = Pasien::orderBy('nama')->get();

        $pendaftaran = PendaftaranLayanan::with(['pasien'])
            ->where('status', 'waiting')
            ->orderBy('tgl_pendaftaran', 'desc')
            ->get();

        return view('admin.rekam-medis', compact('rekamMedis', 'pasien', 'pendaftaran'));
    }

    public function destroy($id)
    {
        RekamMedis::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data rekam medis berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'id_pendaftaran' => 'required|exists:pendaftaran_layanan,id_pendaftaran',

            'tgl_rm' => 'required|date',
            'anamnesa' => 'required|string|',
            'diagnosa' => 'required|string|',
            'terapi' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        $pendaftaran = \App\Models\PendaftaranLayanan::with(['pasien','jenisLayanan'])
            ->findOrFail($request->id_pendaftaran);

        $last = RekamMedis::orderBy('id_rm', 'desc')->first();
        if ($last) {
            $lastNumber = intval(substr($last->id_rm, 2)); // ambil angka setelah "RM"
            $newId = 'RM' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newId = 'RM0001';
        }
        
        RekamMedis::create([
            'id_rm' => $newId,
            'id_pasien' => $pendaftaran->id_pasien,
            'id_pendaftaran' => $request->id_pendaftaran,
            'id_admin' => Auth::check() ? Auth::user()->id : null,
            'id_jenis_layanan' => $pendaftaran->id_jenis_layanan,
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
            $query->where(function ($q) use ($search) {
                $q->where('id_admin', 'like', "%$search%")
                ->orWhere('tgl_rm', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%");
            });
        }

        $rekamMedis = $query->get();
        $pasien = Pasien::orderBy('nama')->get();

        return view('admin.rekam-medis', compact('rekamMedis','pasien'));
    }

    public function createRekamMedis()
    {
        $today = Carbon::today();

        $pendaftaran = PendaftaranLayanan::with(['pasien', 'jenisLayanan'])
            ->whereDate('tgl_pendaftaran', $today)
            ->orderBy('no_antrian', 'asc')
            ->get();

        return view('admin.rekam-medis', compact('pendaftaran'));
    }

}
