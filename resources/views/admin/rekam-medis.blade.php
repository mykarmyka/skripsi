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
            <input type="text" class="form-control me-2" placeholder="Search" style="width: 200px;">
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
                <input type="text" id="search" class="form-control" placeholder="Search">
            </div>
        </div>

        <!-- Modal Tambah Rekam Medis -->
        <div class="modal fade" id="modalRekamMedis" tabindex="-1" aria-labelledby="modalRekamMedisLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form action="{{ route('rekam.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalRekamMedisLabel">Input Rekam Medis Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="pasien_id" class="form-label">Nama Pasien</label>
                    <select name="pasien_id" class="form-control" required>
                    <option value="">-- Pilih Pasien --</option>
                    
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                    <input type="text" name="jenis_layanan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="diagnosa" class="form-label">Anamnesa</label>
                    <input type="text" name="anamnesa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="diagnosa" class="form-label">Diagnosa</label>
                    <input type="text" name="diagnosa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="diagnosa" class="form-label">Terapi</label>
                    <input type="text" name="terapi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="diagnosa" class="form-label">Keterangan</label>
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
                    @php $data = [
                        ['tgl' => '2025-07-10', 'nama' => 'Siti Aminah', 'layanan' => 'Pemeriksaan Kehamilan', 'diagnosa' => 'Kehamilan normal'],
                        ['tgl' => '2025-07-10', 'nama' => 'Linda Wati', 'layanan' => 'KB Suntik', 'diagnosa' => 'Tidak ada keluhan'],
                        ['tgl' => '2025-07-09', 'nama' => 'Dewi Lestari', 'layanan' => 'Pemeriksaan Nifas', 'diagnosa' => 'Luka perineum ringan'],
                        ['tgl' => '2025-07-08', 'nama' => 'Rina Maulida', 'layanan' => 'Imunisasi', 'diagnosa' => 'Imunisasi DPT 1'],
                        ['tgl' => '2025-07-08', 'nama' => 'Yusuf Ramadhan', 'layanan' => 'Pemeriksaan Umum', 'diagnosa' => 'ISPA ringan'],
                    ]; @endphp

                    @foreach ($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['tgl'] }}</td>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['layanan'] }}</td>
                        <td>{{ $item['diagnosa'] }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-success me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="#" method="POST" class="d-inline">
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                <a href="#" class="btn-nav"><i class="bi bi-chevron-double-left"></i></a>
                <span class="page-number">1</span>
                <a href="#" class="btn-nav"><i class="bi bi-chevron-double-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection


