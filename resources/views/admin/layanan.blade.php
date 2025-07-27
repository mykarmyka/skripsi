@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/rekam-medis.css') }}">
@endpush

@section('title', 'Layanan')

@section('content')
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold mb-2">Daftar Layanan</h2>
            <p class="deskripsi">Periksa dan perbarui status pendaftaran layanan medis pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
            
            <span class="me-2">Hello, Admin</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <div class="d-flex justify-content-between align-items-center mb-3">
        
            <div>
                <input type="text" id="search" class="form-control" placeholder="Search">
            </div>
        </div>


        <h5 class="font-semibold mb-3">Daftar Antrean Pendaftaran Layanan</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>No Antrean</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal Daftar</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($pendaftaran as $i => $daftar)
                    <tr>
                        <td>{{ $daftar->no_antrian }}</td>
                        <td>{{ $daftar->pasien->nama }}</td>
                        <td>{{ $data->jenis_layanan }}</td>
                        <td>{{ \Carbon\Carbon::parse($daftar['tgl_pendaftaran'])->format('d-m-Y') }}</td>
                        <td>
                            @if ($daftar->status == 'waiting')
                                <span class="badge bg-warning">Menunggu</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
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


