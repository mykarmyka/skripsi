@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Antrean Pendaftaran Layanan</h2>

    <table class="table table-bordered table-striped">
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
                <td>{{ str_pad($i+1, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $daftar['nama'] }}</td>
                <td>{{ $daftar['jenis_layanan'] }}</td>
                <td>{{ \Carbon\Carbon::parse($daftar['tanggal'])->format('d-m-Y') }}</td>
                <td>-</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
