@extends('user.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('title', 'Riwayat - Klinik')

@section('content')
<div class="container">

    <div class="card-obat">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><strong>Riwayat Pendaftaran Layanan Medis</strong></h4>
            <div class="search-box d-flex align-items-center">
                <input type="text" id="search" class="form-control" placeholder="Search">
            </div>
        </div>


        <div class="table-wrapper">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        
                        <th>Layanan</th>
                        <th>Tanggal Daftar</th>
                        <th>Antrian</th>
                        <th>Keterangan</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $data)
                        <tr>
                            
                            <td>{{ $data->jenisLayanan->nama_layanan ?? '-' }}</td>
                            <td>{{ $data->created_at->format('d M Y, H:i') }} WIB</td>
                            <td>{{ $data['no_antrian'] }}</td>
                            <td>{{ $data['keterangan'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pendaftaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $riwayat->links() }}
            </div>
        </div>
    </div>

    <!-- <div class="main-section">
        <div class="info-box">
        Layanan KB ditutup sementara tanggal 20 Juli.
        </div>
    </div> -->
    

</div>
@endsection
