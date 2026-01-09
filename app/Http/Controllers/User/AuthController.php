<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|digits_between:10,15',
            'nama_pasangan' => 'nullable|string|max:255',
            'email' => 'required|email|unique:pasien,email',
            
        ]);

        try {

            $pasien = Pasien::findOrFail($id);
            $pasien->update($request->all());

            return redirect()->route('pasien.index')->with('success', 'Data berhasil diupdate');
        
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data pasien.');
        }   
    }


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

        try {

            $last = Pasien::orderBy('id_pasien', 'desc')->first(); // sesuaikan primary key tabelmu
            $newRM = 'RM' . str_pad(($last ? $last->id_pasien + 1 : 1), 4, '0', STR_PAD_LEFT);

            $pasien = Pasien::create([
                'id_rm' => $newRM,
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
            return redirect()->route('user.login')
                            ->with('success', 'Selamat! Anda sudah terdaftar, silakan login.');

        } catch (\Exception $e) {
            return back()->with('error', 'Pendaftaran gagal, silakan coba lagi.');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|exists:pasien,nik',
        ]);

        try {
            Auth::guard('pasien')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();


            $pasien = Pasien::where('nik', $request->nik)->first();

            if ($pasien) {
                Auth::guard('pasien')->login($pasien); 
                $request->session()->regenerate();    
                
                return redirect()->route('user.home');
            }

            return back()->withErrors(['nik' => 'nik tidak ditemukan.']);

        } catch (\Exception $e) {
            return back()->with('error', 'Login gagal, silakan coba kembali.');
        }
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('user.login');
    }
}
