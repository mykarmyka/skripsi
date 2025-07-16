@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pasien.css') }}">
@endpush

@section('title', 'Data Pasien')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold mb-2">Pasien</h2>
            <p class='mb-4'>Periksa dan perbarui data pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
            <input type="text" class="form-control me-2" placeholder="Search" style="width: 200px;">
            <span class="me-2">Hello, Admin</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow" class="table-putih">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPasien">
                + Tambah Pasien Baru
            </button>
            <div>
                <!-- <label for="search">Search</label> -->
                <input type="text" id="search" class="form-control" placeholder="Cari pasien...">
            </div>
        </div>  

        <!-- Modal Form Tambah Pasien -->
        <div class="modal fade" id="modalTambahPasien" tabindex="-1" aria-labelledby="modalTambahPasienLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTambahPasienLabel">Tambah Data Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" required>
                </div>
                        
                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                    <option value="Perempuan">Perempuan</option>
                    <option value="Laki-laki">Laki-laki</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Nama Suami/Istri</label>
                    <input type="text" name="nama_pasangan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control">
                </div>
                
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Registrasi</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>Tgl Lahir</th>
                        <th>Usia</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Nama Suami/Istri</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasien as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tanggal_registrasi }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->tanggal_lahir }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} th</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->no_telepon }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->nama_pasangan }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info" tittle="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-warning" tittle="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" tittle="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">Belum ada data pasien.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
