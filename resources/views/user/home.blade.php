@extends('user.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('title', 'Home - Klinik')

@section('content')

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
          <h2 class="judul-halaman">Selamat Datang, {{ Auth::guard('pasien')->user()->nama }}.</h2>
          <p class="deskripsi">Dapatkan layanan kesehatan terbaik di Klinik Bidan X.</p>
      </div>
      <div class="d-flex align-items-center">
          <span class="me-2">Hello, {{ Auth::guard('pasien')->user()->nama }}</span>
          <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
      </div>
  </div>



  <div class="container mt-4">

    {{-- Statistik Pribadi --}}
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Kunjungan Bulan Ini</h6>
            <h3 class="fw-bold text-primary">{{ $kunjunganBulanIni ?? 0 }}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Total Kunjungan</h6>
            <h3 class="fw-bold text-success">{{ $totalKunjungan ?? 0 }}</h3>
          </div>
        </div>
      </div>
    </div>

    {{-- Status Pendaftaran --}}
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Status Pendaftaran Hari Ini</h5>
        <hr>
        @if($pendaftaranHariIni)
          <p><strong>Layanan:</strong> {{ $pendaftaranHariIni->jenisLayanan->nama_layanan }}</p>
          <p><strong>No Antrian:</strong> {{ $pendaftaranHariIni->no_antrian }}</p>
          <p><strong>Status:</strong>
            <span class="badge 
              @if($pendaftaranHariIni->status == 'menunggu') bg-warning 
              @elseif($pendaftaranHariIni->status == 'diperiksa') bg-info 
              @else bg-success @endif">
              {{ ucfirst($pendaftaranHariIni->status) }}
            </span>
          </p>
        @else
          <p class="text-muted">Anda belum mendaftar layanan hari ini.</p>
          <a href="{{ route('user.pendaftaran') }}" class="btn btn-primary btn-sm">Daftar Layanan Baru</a>
        @endif
      </div>
    </div>

    {{-- Rekam Medis Terakhir --}}
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Rekam Medis Terakhir</h5>
        <hr>
        @if($rekamMedisTerakhir)
          <p><strong>Tanggal:</strong> {{ $rekamMedisTerakhir->tgl_rm }}</p>
          <p><strong>Diagnosa:</strong> {{ $rekamMedisTerakhir->diagnosa }}</p>
        @else
          <p class="text-muted">Belum ada data rekam medis.</p>
        @endif
      </div>
    </div>

  </div>
</div>  

@endsection
