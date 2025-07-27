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
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            
        ]);

        $pasien = Auth::guard('pasien')->user()->id_pasien;


        $pasien->nama = $request->nama;
        $pasien->alamat = $request->alamat;
        $pasien->no_telp = $request->no_telp;
        $pasien->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
