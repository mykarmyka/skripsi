<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\PendaftaranBerhasilMail;
use App\Mail\NotifikasiAntrianMail;
use App\Models\PendaftaranLayanan;
use App\Models\Pasien;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class PendaftaranController extends Controller
{

    public function simpanPendaftaran(Request $request)
    {
        $request->validate([
            'id_jenis_layanan' => 'required|exists:jenis_layanan,id',
            'tgl_pendaftaran' => 'required|date',
            'status' => 'nullable|in:waiting,done',
        ]);

        $pasien = Auth::guard('pasien')->user()->id_pasien;

        $jumlahAntrianHariIni = PendaftaranLayanan::whereDate('tgl_pendaftaran', $request->tgl_pendaftaran)->count();
        $no_antrian_baru = $jumlahAntrianHariIni + 1;

        PendaftaranLayanan::create([
            'id_pasien' => $pasien,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'id_jenis_layanan' => $request->id_jenis_layanan,
            'no_antrian' => str_pad($no_antrian_baru, 4, '0', STR_PAD_LEFT),
            'status' => $request->status ?? 'waiting',
        ]);

        return redirect()->route('user.home')->with('success', 'Pendaftaran berhasil disimpan ke database!');
    }

    public function simpanPersalinan(Request $request)
    {
        $request->validate([
            'id_jenis_layanan' => 'required|exists:jenis_layanan,id',
            'tgl_pendaftaran' => 'required|date',
            'status' => 'nullable|in:waiting,done',
        ]);

        $pasien = Auth::guard('pasien')->user()->id_pasien;

        // Hitung jumlah pendaftar persalinan di tanggal yang sama
        $jumlahAntrian = PendaftaranLayanan::where('jenis_layanan', 'Persalinan')
            ->whereDate('tgl_pendaftaran', $request->tgl_pendaftaran)
            ->count();

        if ($jumlahAntrian >= 3) {
            return redirect()->route('user.home')
                ->with('error', 'Pendaftaran persalinan sudah penuh untuk hari ini (maksimal 3 pasien).');
        }

        // Nomor antrian: urut sesuai jumlah antrian, bukan random
        $no_antrian = $jumlahAntrian + 1;


        PendaftaranLayanan::create([
            'id_pasien' => $pasien,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'id_jenis_layanan' => $request->id_jenis_layanan,
            'no_antrian' => str_pad($no_antrian_baru, 4, '0', STR_PAD_LEFT),
            'status' => $request->status ?? 'waiting',
        ]);

        return redirect()->route('user.home')->with('success', 'Pendaftaran berhasil disimpan ke database!');
    }

    public function store(Request $request)
    {
        $request->validate([
        'id_pasien' => 'required',
        'id_jenis_layanan' => 'required',
        'tgl_pendaftaran' => 'required|date',
    ]);

    // hitung no antrian hari ini
    $noAntrian = PendaftaranLayanan::whereDate('tgl_pendaftaran', $request->tgl_pendaftaran)->count() + 1;

    // simpan pendaftaran
    $pendaftaran = PendaftaranLayanan::create([
        'id_pasien' => $request->id_pasien,
        'id_jenis_layanan' => $request->id_jenis_layanan,
        'tgl_pendaftaran' => $request->tgl_pendaftaran,
        'no_antrian' => $noAntrian,
        'status' => 'waiting',
    ]);

    // ambil data pasien dan layanan
    $pasien = $pendaftaran->pasien;
    $layanan = JenisLayanan::find($request->id_jenis_layanan);

    // hitung estimasi datang (pakai function dari model)
    $estimasiDatang = PendaftaranLayanan::hitungEstimasiDatang($request->id_jenis_layanan, $noAntrian);

    // kirim email
    Mail::to($pasien->email)->send(
        new PendaftaranBerhasilMail(
            $pasien,
            $noAntrian,
            $layanan->nama_layanan,
            $estimasiDatang,
            $request->tgl_pendaftaran
        )
    );

    return redirect()->back()->with('success', 'Pendaftaran berhasil dan email notifikasi telah dikirim!');

    }

    

}
