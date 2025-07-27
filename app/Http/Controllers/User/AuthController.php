<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('user.login');
    }

    public function showRegister()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:pasien,nik',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|digits_between:10,15',
            'nama_pasangan' => 'nullable|string|max:255',
            'email' => 'required|email|unique:pasien,email',
            
        ]);

        $pasien = Pasien::create([
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

        session(['user_id' => $pasien->id]);
        return redirect()->route('user.home');
    }

    public function login(Request $request)
    {
        $request->validate([
        'nik' => 'required|digits:16|exists:pasien,nik',
        ]);

        // Tambahan: logout guard dulu biar session bersih
        Auth::guard('pasien')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        $pasien = Pasien::where('nik', $request->nik)->first();

        if ($pasien) {
            Auth::guard('pasien')->login($pasien); // ← LOGIN DENGAN GUARD 'pasien'
            $request->session()->regenerate();     // ← regenerasi session (wajib)
            return redirect()->route('user.home');
        }

        return back()->withErrors(['nik' => 'NIK tidak ditemukan.']);
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('user.login');
    }
}
