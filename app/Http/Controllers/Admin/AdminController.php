<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\JenisLayanan;
use App\Models\PendaftaranLayanan;
use App\Models\Admin;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;



class AdminController extends Controller
{   

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {   
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();

            $roles = $user->roles;
                
                if ($user->hasRole('bidan') || $user->hasRole('staff')) {
                    
                    return redirect()->intended(route('admin.dashboard'));
                } else {
                    
                    Auth::guard('admin')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return redirect()->route('admin.login')->with('error', 'Akses ditolak. Role tidak valid.');
                }    
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat login.');
        }    
    }

    public function dashboard(Request $request)
    {
        try {
            $jumlahPasien = Pasien::count();
            $jumlahAntrian = PendaftaranLayanan::where('status', 'waiting')
                ->whereDate('tgl_pendaftaran', now()->toDateString())
                ->count();

            $rekamMedis = RekamMedis::with(['pasien', 'jenisLayanan'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('pasien', function ($p) use ($request) {
                    $p->where('nama', 'like', '%'.$request->search.'%');
                })
                ->orWhereHas('jenisLayanan', function ($l) use ($request) {
                    $l->where('nama_layanan', 'like', '%'.$request->search.'%');
                })
                ->orWhere('tgl_rm', 'like', '%'.$request->search.'%');
            })
            ->orderBy('tgl_rm', 'desc')
            ->get();
            
            return view('admin.dashboard', compact(
                'jumlahPasien',
                'jumlahAntrian',
                'rekamMedis'
            )); 
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal memuat dashboard.');
        }   
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function dataObat()
    {
        return view('admin.obat');
    }

    public function lihatPendaftaran(Request $request)
    {
        $pendaftaran = PendaftaranLayanan::with(['pasien', 'jenisLayanan'])
        ->when($request->search, function ($q) use ($request) {

            $q->whereHas('pasien', function ($p) use ($request) {
                $p->where('nama', 'like', '%'.$request->search.'%');
            })
            ->orWhereHas('jenisLayanan', function ($l) use ($request) {
                $l->where('nama_layanan', 'like', '%'.$request->search.'%');
            });

        })
        ->where('status', '!=', 'done')
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
        try {
            $layanan = JenisLayanan::all();

            $query = RekamMedis::with(['pasien', 'jenisLayanan']);

            if ($request->filled('jenis_layanan')) {
                $query->where('id_jenis_layanan', $request->jenis_layanan);
            }

            if ($request->filled('filter_type') && $request->filled('tanggal')) {
                $tanggal = Carbon::parse($request->tanggal);

                if ($request->filter_type === 'mingguan') {
                    $query->whereBetween('tgl_rm', [
                        $tanggal->copy()->startOfWeek(),
                        $tanggal->copy()->endOfWeek()
                    ]);
                } elseif ($request->filter_type === 'bulanan') {
                    $query->whereMonth('tgl_rm', $tanggal->month)
                        ->whereYear('tgl_rm', $tanggal->year);
                }
            }

            $dataKunjungan = $query->orderBy('tgl_rm', 'desc')->get();

            // DATA GRAFIK
            $kunjunganPerBulan = PendaftaranLayanan::selectRaw(
                    'MONTH(tgl_pendaftaran) as bulan, COUNT(*) as jumlah'
                )
                ->whereYear('tgl_pendaftaran', now()->year)
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->pluck('jumlah', 'bulan');

            $kunjunganPerMinggu = PendaftaranLayanan::selectRaw(
                    'WEEK(tgl_pendaftaran, 1) as minggu, COUNT(*) as jumlah'
                )
                ->whereMonth('tgl_pendaftaran', now()->month)
                ->groupBy('minggu')
                ->orderBy('minggu')
                ->pluck('jumlah', 'minggu');

            return view('admin.laporan', compact(
                'dataKunjungan',
                'layanan',
                'kunjunganPerBulan',
                'kunjunganPerMinggu'
            ));
        } catch (Exception $e) {
        Log::error('Laporan error: '.$e->getMessage());
        return back()->with('error', 'Gagal memuat laporan.');
    }    
    }
   

    public function filterLaporan(Request $request) 
    {
        $layanan = JenisLayanan::all();

        $query = RekamMedis::with(['pasien', 'pendaftaran.jenisLayanan']);

        if ($request->filled('jenis_layanan')) {
            $query->whereHas('pendaftaran.jenisLayanan', function ($q) use ($request) {
                $q->where('id', $request->jenis_layanan);
            });
        }

        // (filter tanggal sama seperti di atas)

        $data = $query->get();
        $pdf = \PDF::loadView('admin.laporan.filter', compact('data', 'layanan'));
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
        // KUNJUNGAN PER BULAN (BERDASARKAN PENDAFTARAN)
        $kunjunganPerBulan = PendaftaranLayanan::selectRaw(
                'MONTH(tgl_pendaftaran) as bulan, COUNT(*) as jumlah'
            )
            ->whereYear('tgl_pendaftaran', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan');

        // KUNJUNGAN PER MINGGU
        $kunjunganPerMinggu = PendaftaranLayanan::selectRaw(
                'WEEK(tgl_pendaftaran, 1) as minggu, COUNT(*) as jumlah'
            )
            ->whereMonth('tgl_pendaftaran', now()->month)
            ->groupBy('minggu')
            ->orderBy('minggu')
            ->pluck('jumlah', 'minggu');

        return view('admin.laporan', compact(
            'kunjunganPerBulan',
            'kunjunganPerMinggu'
        ));
    }


    public function ajax(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'pendaftaran.jenisLayanan']);

        if ($request->filled('jenis_layanan')) {
            $query->whereHas('pendaftaran', function ($q) use ($request) {
                $q->where('id_jenis_layanan', $request->jenis_layanan);
            });
        }

        if ($request->filled('filter_type') && $request->filled('tanggal')) {
            $tanggal = Carbon::parse($request->tanggal);

            if ($request->filter_type === 'mingguan') {
                $query->whereBetween('tgl_rm', [
                    $tanggal->copy()->startOfWeek(),
                    $tanggal->copy()->endOfWeek()
                ]);
            } else {
                $query->whereMonth('tgl_rm', $tanggal->month)
                    ->whereYear('tgl_rm', $tanggal->year);
            }
        }

        $data = $query->orderBy('tgl_rm', 'desc')->get();

        return view('admin.laporan_table', compact('data'));

    }

   public function pdf(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'pendaftaran.jenisLayanan']);

        if ($request->filled('jenis_layanan')) {
            $query->whereHas('pendaftaran', function ($q) use ($request) {
                $q->where('id_jenis_layanan', $request->jenis_layanan);
            });
        }

        if ($request->filled('filter_type') && $request->filled('tanggal')) {
            $tanggal = Carbon::parse($request->tanggal);

            if ($request->filter_type === 'mingguan') {
                $query->whereBetween('tgl_rm', [
                    $tanggal->copy()->startOfWeek(),
                    $tanggal->copy()->endOfWeek()
                ]);
            } else {
                $query->whereMonth('tgl_rm', $tanggal->month)
                    ->whereYear('tgl_rm', $tanggal->year);
            }
        }

        $data = $query->orderBy('tgl_rm', 'desc')->get();

        $pdf = Pdf::loadView('admin.laporan_cetak', compact('data'))
                ->setPaper('A4', 'landscape');

        return $pdf->download('laporan-kunjungan.pdf');
    }

    public function simpanPendaftaran(Request $request)
    {
        try {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'id_jenis_layanan' => 'required|exists:jenis_layanan,id',
            'tgl_pendaftaran' => 'required|date',
        ]);

        // Nomor antrian otomatis per hari
        $jumlahAntrianHariIni = PendaftaranLayanan::whereDate('tgl_pendaftaran', $request->tgl_pendaftaran)->count();
        $no_antrian_baru = $jumlahAntrianHariIni + 1;

        PendaftaranLayanan::create([
            'id_pasien' => $request->id_pasien,
            'tgl_pendaftaran' => $request->tgl_pendaftaran,
            'id_jenis_layanan' => $request->id_jenis_layanan,
            'no_antrian' => str_pad($no_antrian_baru, 4, '0', STR_PAD_LEFT),
            'status' => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil!');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal melakukan pendaftaran.');
        }
    }

    public function simpanRekamMedis(Request $request, $id)
    {
        try {
            $request->validate([
                'anamnesa' => 'required|string',
                'diagnosa' => 'required|string',
                'terapi' => 'required|string',
                'keterangan' => 'nullable|string',
                'tgl_rm' => 'required|date',
            ]);

            // load pendaftaran dan pasien
            $pendaftaran = PendaftaranLayanan::with('pasien')->findOrFail($id);
            $pasien = $pendaftaran->pasien;

            
            if (!$pasien) {
                return back()->with('error', 'Data pasien tidak ditemukan untuk pendaftaran ini.');
            }

            $data = [
                'id_rm' => $pasien->id_rm,               
                'id_pasien' => $pasien->id_pasien,
                'id_pendaftaran' => $pendaftaran->id_pendaftaran ?? $pendaftaran->id, 
                'id_admin' => auth()->check() ? auth()->id() : null,
                'id_jenis_layanan' => $pendaftaran->id_jenis_layanan ?? null,
                'tgl_rm' => $request->tgl_rm,
                'anamnesa' => $request->anamnesa,
                'diagnosa' => $request->diagnosa,
                'terapi' => $request->terapi,
                'keterangan' => $request->keterangan,
            ];

            RekamMedis::create($data);

            $pendaftaran->update(['status' => 'done']);

            return redirect()->back()->with('success', 'Rekam medis berhasil disimpan dan status pasien diperbarui.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal memuat dashboard.');
        }
        
    }
}