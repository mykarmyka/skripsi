<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RekamMedis;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $idPasien = Auth::user()->id_pasien;

        // Statistik pribadi
        $totalKunjungan = RekamMedis::where('id_pasien', $idPasien)->count();
        $kunjunganBulanIni = RekamMedis::where('id_pasien', $idPasien)
            ->whereMonth('tgl_rm', Carbon::now()->month)
            ->count();

        // Status pendaftaran hari ini
        $pendaftaranHariIni = Pendaftaran::with('jenisLayanan')
            ->where('id_pasien', $idPasien)
            ->whereDate('tgl_pendaftaran', now()->toDateString())
            ->latest('created_at')
            ->first();

        // Rekam medis terakhir
        $rekamMedisTerakhir = RekamMedis::where('id_pasien', $idPasien)
            ->latest('tgl_rm')
            ->first();

            dd($totalKunjungan, $kunjunganBulanIni);

        return view('user.home', compact(
            'totalKunjungan',
            'kunjunganBulanIni',
            'pendaftaranHariIni',
            'rekamMedisTerakhir'
        ));
    }
}
