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

    public function index()
    {
        return view('admin.dashboard');
    }

    public function dataObat()
    {
        return view('admin.obat');
    }

    public function lihatPendaftaran()
    {
        $pendaftaran = PendaftaranLayanan::with('pasien') // pastikan relasi 'pasien' ada
            ->orderBy('no_antrian')
            ->get();

        return view('admin.layanan', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:waiting,done',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->status = $request->status;
        $pendaftaran->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }    

}
