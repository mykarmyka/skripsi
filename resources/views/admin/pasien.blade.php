@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pasien.css') }}">

@endpush

@php use Carbon\Carbon; @endphp

@section('title-pasien', 'Data Pasien')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold mb-2">Pasien</h2>
            <p class='mb-4'>Periksa dan perbarui data pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
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
                 <form action="{{ route('admin.pasien') }}" method="get" class="d-flex align-items-center me-3">
                    <input type="text" class="form-control me-2" name="search" value="{{ request('search') }}" placeholder="Search">
                    <button type="submit"></button>
                </form>
                
            </div>
        </div>  

        <!-- Modal Form Tambah Pasien -->
        <div class="modal fade" id="modalTambahPasien" tabindex="-1" aria-labelledby="modalTambahPasienLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form action="{{ route('admin.pasien.store') }}" method="POST">
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
                    <label class="form-label">nik</label>
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

        <div class="table-responsive" style="overflow-x: auto;">
            <div class="table-scroll">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Tempat Lahir</th>
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
                        @forelse ($dataPasien as $index => $pasien)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pasien->id_rm }}</td>
                            <td>{{ $pasien->nama }}</td>
                            <td>{{ $pasien->nik }}</td>
                            <td>{{ $pasien->tempat_lahir }}</td>
                            <td>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} th</td>
                            <td>{{ $pasien->jenis_kelamin }}</td>
                            <td>{{ $pasien->no_telp }}</td>
                            <td>{{ $pasien->alamat }}</td>
                            <td>{{ $pasien->nama_pasangan }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#lihatPasien{{ $pasien->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
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
</div>

<!-- Modal Lihat Detail Pasien -->
<div class="modal fade" id="lihatPasien{{ $pasien->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pasien->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $pasien->id }}">Detail Data Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Nama</th><td>{{ $pasien->nama }}</td></tr>
                    <tr><th>nik</th><td>{{ $pasien->nik }}</td></tr>
                    <tr><th>Usia</th><td>{{ Carbon::parse($pasien->tgl_lahir)->age }} tahun</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ $pasien->jenis_kelamin }}</td></tr>
                    <tr><th>Tempat Lahir</th><td>{{ $pasien->tempat_lahir }}</td></tr>
                    <tr><th>Tanggal Lahir</th><td>{{ $pasien->tgl_lahir }}</td></tr>
                    <tr><th>No. Telepon</th><td>{{ $pasien->no_telp }}</td></tr>
                    <tr><th>Nama Suami/Istri</th><td>{{ $pasien->nama_pasangan }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $pasien->alamat }}</td></tr>
                    <tr><th>Email</th><td>{{ $pasien->email }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
