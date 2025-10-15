<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\PendaftaranLayanan;
use App\Models\RekamMedis;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



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
        $pendaftaran = PendaftaranLayanan::with('pasien', 'jenisLayanan') 
            ->orderBy('tgl_pendaftaran', 'desc')
            ->paginate(10);

        return view('admin.layanan', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:waiting,done',
        ]);

        $pendaftaran = PendaftaranLayanan::findOrFail($id);
        $pendaftaran->status = $pendaftaran->status === 'waiting' ? 'done' : 'waiting';
        $pendaftaran->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }   
    
    
    public function laporan(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'pendaftaran.jenisLayanan']);

        // Filter berdasarkan jenis layanan (jika dipilih)
        if ($request->filled('jenis_layanan')) {
            $query->whereHas('pendaftaran.jenisLayanan', function ($q) use ($request) {
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
        $dataKunjungan = RekamMedis::with(['pasien', 'pendaftaran.jenisLayanan'])
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

    public function ajax(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'pendaftaran.jenisLayanan']);

        if ($request->layanan) {
            $query->whereHas('pendaftaran.jenisLayanan', function($q) use ($request) {
                $q->where('nama', $request->layanan);
            });
        }

        if ($request->tanggal) {
            $query->whereDate('tgl_rm', $request->tanggal);
        }

        $data = $query->get();

        return view('admin.laporan._table', compact('data'));
    }

    public function pdf(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'pendaftaran.jenisLayanan']);

        if ($request->layanan) {
            $query->whereHas('pendaftaran.jenisLayanan', function($q) use ($request) {
                $q->where('nama', $request->layanan);
            });
        }

        if ($request->tanggal) {
            $query->whereDate('tgl_rm', $request->tanggal);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.laporan_cetak', compact('data'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-kunjungan.pdf');
    }



    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {   

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();

            // Cek role bidan atau staff
            if ($user->hasRole('bidan') || $user->hasRole('staff')) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'Akses ditolak. Role tidak valid.');
            }
        }

        
        return redirect()->route('admin.login')->with('error', 'Login gagal. Cek kembali email dan password.');
    }

}
