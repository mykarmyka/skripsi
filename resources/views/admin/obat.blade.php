@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/obat.css') }}">
@endpush

@section('title', 'Daftar Nama Obat')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="judul-halaman">Daftar Nama Obat</h2>
            <p class="deskripsi">Periksa dan perbarui status pendaftaran layanan medis pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="me-2">Hello, Admin</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="card-obat">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahObat">
                + Tambah Obat Baru
            </button>
            <div class="search-box d-flex align-items-center">
                <input type="text" id="search" class="form-control" placeholder="Search">
            </div>
        </div>

        <!-- Modal Tambah Obat -->
        <div class="modal fade" id="modalTambahObat" tabindex="-1" aria-labelledby="modalTambahObatLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form action="{{ route('admin.obat.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTambahObatLabel">Tambah Obat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="nama_obat" class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <input type="text" name="jenis" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="stok_tersedia" class="form-label">Stok Tersedia</label>
                    <input type="number" name="stok_tersedia" class="form-control" required>
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

        <div class="table-wrapper">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Jenis</th>
                        <th>Stok tersedia</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $obats = [
                        ['nama' => 'Paracetamol', 'jenis' => 'Sirup & Tablet', 'stok' => 25],
                        ['nama' => 'Fe (Zat Besi)', 'jenis' => 'Tablet', 'stok' => 16],
                        ['nama' => 'Asam Folat', 'jenis' => 'Tablet', 'stok' => 30],
                        ['nama' => 'Metronidazol', 'jenis' => 'Tablet', 'stok' => 27],
                        ['nama' => 'Amoxicilline', 'jenis' => 'Tablet', 'stok' => 20],
                        ['nama' => 'Vaksin Tetanus Toksoid', 'jenis' => 'Suntik', 'stok' => 15]
                    ]; @endphp

                    @foreach ($obats as $index => $obat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $obat['nama'] }}</td>
                        <td>{{ $obat['jenis'] }}</td>
                        <td>{{ $obat['stok'] }}</td>
                        <td>
                            <button class="btn btn-edit" title="Edit"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link rounded" href="#" tabindex="-1" aria-disabled="true">&laquo;</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link rounded bg-primary text-white border-0" href="#">1</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link rounded" href="#">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
