@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/rekam-medis.css') }}">
@endpush

@section('title', 'Rekam Medis')

@section('content')
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold mb-2">Rekam Medis Pasien</h2>
            <p class="deskripsi">Periksa dan perbarui status pendaftaran layanan medis pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
            
            <span class="me-2">Hello, Admin</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRekamMedis">
                + Input Rekam Medis Baru
            </button>
            <div>
                <form action="{{ route('admin.rekam-medis') }}" method="GET" class="d-flex align-items-center me-3">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control me-2" placeholder="Search" value="{{ request('keyword') }}" style="width: 200px;">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="modalRekamMedis" tabindex="-1" aria-labelledby="modalRekamMedisLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            {{-- Sesuaikan action route jika controller Anda menangani proses pembuatan Pasien BARU + Rekam Medis BARU --}}
            <form action="{{ route('admin.rekam.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_admin" value="{{ Auth::check() ? Auth::user()->id : null }}">
    
                <input type="hidden" name="id_rm" value="{{ \Illuminate\Support\Str::uuid() }}">


                <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalRekamMedisLabel">Input Rekam Medis Pasien Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                    <input type="date" name="tgl_rm" class="form-control" value="{{ date('Y-m-d') }}" required> 
                </div>
                
                {{-- 1. INPUT NAMA PASIEN SECARA LANGSUNG --}}
                <div class="mb-3">
                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                    {{-- Ini akan mengirim nama pasien yang diinput langsung ke controller --}}
                    <input type="text" name="nama_pasien" id="nama_pasien_input" class="form-control" placeholder="Masukkan Nama Pasien" required>
                </div>

                {{-- 2. JENIS LAYANAN DARI DATABASE (Tabel jenis_layanan) --}}
                <div class="mb-3">
                    <label for="id_jenis_layanan" class="form-label">Jenis Layanan</label>
                    <select name="id_jenis_layanan" id="id_jenis_layanan_select" class="form-control" required>
                        <option value="">-- Pilih Jenis Layanan --</option>
                        {{-- LOOPING DATA DARI CONTROLLER --}}
                        {{-- **PASTIKAN Anda mengirim variabel $jenisLayanan (atau nama lain) dari controller Anda** --}}
                        @forelse ($jenisLayanan as $jl) 
                            <option value="{{ $jl->id_jenis_layanan }}">{{ $jl->nama_layanan }}</option>
                        @empty
                            <option value="">Data Layanan Kosong. Harap hubungi Admin IT.</option>
                        @endforelse
                    </select>
                </div>
                {{-- Field id_pasien dan id_jenis_layanan HANYA akan dibuat di Controller jika nama_pasien yang diinput adalah pasien baru. --}}

                <div class="mb-3">
                    <label for="anamnesa" class="form-label">Anamnesa</label>
                    <input type="text" name="anamnesa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="diagnosa" class="form-label">Diagnosa</label>
                    <input type="text" name="diagnosa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="terapi" class="form-label">Terapi</label>
                    <input type="text" name="terapi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" required>
                </div>

                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
            </div>
        </div>
        </div>


        <h5 class="font-semibold mb-3">Tabel Riwayat Rekam Medis Pasien</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tgl Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Diagnosa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Pastikan nama field $rm->tgl_rm, $rm->pasien->nama, $rm->jenisLayanan->nama_layanan, dan $rm->diagnosa sudah benar di controller Anda --}}
                    @forelse ($rekamMedis as $index => $rm)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($rm->tgl_rm)->format('d-m-Y') }}</td> 
                        <td>{{ $rm->pasien->nama ?? 'N/A' }}</td> 
                        <td>{{ $rm->jenisLayanan->nama_layanan ?? 'N/A' }}</td> 
                        <td>{{ $rm->diagnosa ?? '-' }}</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm">✏️</a>
                            <form action="{{ route('rekam_medis.destroy', $rm->id_rm) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data rekam medis</td>
                    </tr>
                    @endforelse 
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $rekamMedis->links() }}
            </div>

        </div>
    </div>
</div>

@endsection