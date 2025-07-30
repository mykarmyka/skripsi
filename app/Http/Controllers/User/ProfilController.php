<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;

class ProfilController extends Controller
{
    public function index()
    {
        // Ambil data pasien yang sedang login
        $pasien = Auth::guard('pasien')->user()->id_pasien;
        return view('user.profil', compact('pasien'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|email|max:255',
        ]);

        $pasien = Auth::guard('pasien')->user();

         $pasien->update([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp, 
            'nama_pasangan' => $request->nama_pasangan,
            'nik' => $request->nik,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
