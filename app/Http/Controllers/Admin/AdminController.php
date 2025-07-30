<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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
    
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    
    public function laporan(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'jenis_layanan']);

        // Filter berdasarkan jenis layanan (jika dipilih)
        if ($request->filled('jenis_layanan')) {
            $query->whereHas('jenis_layanan', function ($q) use ($request) {
                $q->where('nama', $request->jenis_layanan);
            });
        }

        // Filter berdasarkan waktu (mingguan/bulanan)
        if ($request->filled('filter_type') && $request->filled('tanggal')) {
            $tanggal = \Carbon\Carbon::parse($request->tanggal);

            if ($request->filter_type === 'mingguan') {
                $startOfWeek = $tanggal->startOfWeek();
                $endOfWeek = $tanggal->endOfWeek();
                $query->whereBetween('tgl_rm', [$startOfWeek, $endOfWeek]);
            } elseif ($request->filter_type === 'bulanan') {
                $query->whereMonth('tgl_rm', $tanggal->month)
                    ->whereYear('tgl_rm', $tanggal->year);
            }
        }

        $dataKunjungan = $query->orderBy('tgl_rm', 'desc')->get();

        return view('admin.laporan', compact('dataKunjungan'));
    }

    public function filterLaporan(Request $request) 
    {
        $data = RekamMedis::filter($request)->get();
        $pdf = PDF::loadView('admin.laporan.filter', compact('data'));
        return $pdf->download('laporan-kunjungan.pdf');
    }

    public function cetakLaporan(Request $request)
    {
        $dataKunjungan = RekamMedis::with(['pasien', 'jenis_layanan'])
            // Tambahkan filter sesuai kebutuhan kamu di sini...
            ->orderBy('tgl_rm', 'desc')
            ->get();

        $pdf = PDF::loadView('admin.laporan_cetak', compact('dataKunjungan'))
                ->setPaper('A4', 'landscape'); // Atur ukuran kertas

        return $pdf->download('laporan-kunjungan.pdf');
    }

    public function laporanKunjungan()
    {
        // Ambil data kunjungan per bulan
        $kunjunganPerBulan = RekamMedis::selectRaw('MONTH(tgl_rm) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Ambil data kunjungan per minggu
        $kunjunganPerMinggu = RekamMedis::selectRaw('WEEK(tgl_rm, 1) as minggu, COUNT(*) as jumlah')
            ->groupBy('minggu')
            ->orderBy('minggu')
            ->get();

        return view('admin.laporan', compact('kunjunganPerBulan', 'kunjunganPerMinggu'));
    }



}
