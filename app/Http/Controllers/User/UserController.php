<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\PendaftaranLayanan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserController extends Controller
{
    public function home()
    {
        $idPasien = Auth::guard('pasien')->id();
        $riwayat = PendaftaranLayanan::where('id_pasien', $idPasien)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('user.home', compact('riwayat'));
    }

    public function formPendaftaran() 
    {
        $jenis = JenisLayanan::all();
        return view('user.pendaftaran', compact ('jenis'));
    }

    public function formPendaftaranPersalinan() 
    {
        $jenis = JenisLayanan::all();
        return view('user.pendaftaran-persalinan', compact('jenis'));
    }

    public function profil()
    {
        $pasien = Auth::guard('pasien')->user();
        return view('user.profil', compact('pasien'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|digits_between:10,15',
            'nama_pasangan' => 'nullable|string|max:255',
            'nik' => 'required|digits:16',
            'email' => 'required|email|max:255',
        ]);

        $pasien = Auth::guard('pasien')->user();
        $pasien->update($request->all());

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    


    


}
