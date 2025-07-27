@extends('user.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('title', 'Home - Klinik')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="judul-halaman">Selamat Datang, {{ Auth::guard('pasien')->user()->nama }}.</h2>
            <p class="deskripsi">Silakan pilih layanan yang Anda butuhkan atau lihat status pendaftaran Anda di bawah ini.</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="me-2">Hello, {{ Auth::guard('pasien')->user()->nama }}</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="card-obat">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><strong>Riwayat Pendaftaran Layanan Medis</strong></h4>
            <div class="search-box d-flex align-items-center">
                <form method="GET" action="{{ route('admin.pasien') }}">
                    <input type="text" name="search" placeholder="Cari nama pasien..." value="{{ request('search') }}">
                    <button type="submit">Cari</button>
                </form>
                <input type="text" id="search" class="form-control" placeholder="Search">
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
                    @forelse ($riwayat as $data)
                        <tr>
                            <td>{{ $data['id'] }}</td>
                            <td>{{ $data['jenis_layanan'] }}</td>
                            <td>{{ $data['tgl_pendaftaran'] }}</td>
                            <td>{{ $data['no_antrian'] }}</td>
                            <td>{{ $data['no_antrian'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pendaftaran.</td>
                        </tr>
                    @endforelse
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
