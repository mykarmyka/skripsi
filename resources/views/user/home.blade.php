@extends('user.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('title', 'Home - Klinik')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="judul-halaman">Selamat Datang, User.</h2>
            <p class="deskripsi">Silakan pilih layanan yang Anda butuhkan atau lihat status pendaftaran Anda di bawah ini.</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="me-2">Hello, User</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="card-obat">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><strong>Riwayat Pendaftaran Layanan Medis</strong></h4>
            <div class="search-box d-flex align-items-center">
                <label for="search" class="me-2">Search</label>
                <input type="text" id="search" class="form-control" placeholder="...">
            </div>
        </div>


        <div class="table-wrapper">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>No. Registrasi</th>
                        <th>Layanan</th>
                        <th>Tanggal Daftar</th>
                        <th>Antrian</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>2025-1202</td>
                    <td>Pemeriksaan Umum</td>
                    <td>12 Februari</td>
                    <td>0052</td>
                </tr>
                <tr>
                    <td>2025-1705</td>
                    <td>Pemeriksaan Umum</td>
                    <td>17 Mei</td>
                    <td>0021</td>
                </tr>
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

    <div class="main-section">
        <div class="info-box">
        Layanan KB ditutup sementara tanggal 20 Juli.
        </div>
    </div>
    

</div>
@endsection
