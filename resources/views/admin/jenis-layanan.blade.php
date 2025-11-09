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
            <h2 class="text-xl font-semibold mb-2">Jenis Layanan</h2>
            <p class='mb-4'>Kelola daftar jenis layanan yang tersedia di praktik bidan</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="me-2">Hello, Admin</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow" class="table-putih">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahLayanan">
                + Tambah Layanan
            </button>

            <form action="{{ route('admin.jenis-layanan') }}" method="get" class="d-flex align-items-center me-3">
                <input type="text" class="form-control me-2" name="search" value="{{ request('search') }}" placeholder="Cari layanan...">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
            </form>
        </div>

        <!-- Modal Form Tambah Layanan -->
        <div class="modal fade" id="modalTambahLayanan" tabindex="-1" aria-labelledby="modalTambahLayananLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.jenis-layanan.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="modalTambahLayananLabel">Tambah Jenis Layanan Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Layanan</label>
                                <input type="text" name="nama_layanan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Durasi (menit)</label>
                                <input type="number" name="durasi" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Jenis Layanan -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Layanan</th>
                        <th>Durasi (menit)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataLayanan as $index => $layanan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $layanan->nama_layanan }}</td>
                        <td>{{ $layanan->durasi }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.jenis-layanan.destroy', $layanan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">Belum ada data layanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
