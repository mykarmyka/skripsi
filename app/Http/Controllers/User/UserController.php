<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\PendaftaranLayanan;
use App\Models\JenisLayanan;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;


class UserController extends Controller
{
    public function home()
    {
        $pasien = Auth::guard('pasien')->user();

        if (!$pasien) {
            return redirect()->route('user.login');
        }

        $idPasien = $pasien->id_pasien;

        // 🧾 Statistik pribadi
        $totalKunjungan = RekamMedis::where('id_pasien', $idPasien)->count();
        $kunjunganBulanIni = RekamMedis::where('id_pasien', $idPasien)
            ->whereMonth('tgl_rm', Carbon::now()->month)
            ->whereYear('tgl_rm', Carbon::now()->year)
            ->count();

        // 🩺 Status pendaftaran hari ini
        $pendaftaranHariIni = PendaftaranLayanan::with('jenisLayanan')
            ->where('id_pasien', $idPasien)
            ->whereDate('tgl_pendaftaran', now()->toDateString())
            ->latest('created_at')
            ->first();

        // 🧠 Rekam medis terakhir
        $rekamMedisTerakhir = RekamMedis::where('id_pasien', $idPasien)
            ->latest('tgl_rm')
            ->first();

        // kirim semua variabel ke view
        return view('user.home', compact(
            'pasien',
            'totalKunjungan',
            'kunjunganBulanIni',
            'pendaftaranHariIni',
            'rekamMedisTerakhir'
        ));
        
    }

    public function formPendaftaran() 
    {
        $jenis = JenisLayanan::all();
        return view('user.pendaftaran', compact ('jenis'));
    }

    public function formPendaftaranPersalinan() 
    {
        $jenis = JenisLayanan::where('nama_layanan', 'Persalinan')->get();
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

    public function riwayat(){
        $idPasien = Auth::guard('pasien')->id();
        $riwayat = PendaftaranLayanan::with('jenisLayanan')
                    ->where('id_pasien', $idPasien)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('user.riwayat', compact('riwayat'));
    }

    


    


}
