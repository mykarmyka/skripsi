@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endpush


@section('title', 'Laporan Kunjungan Pasien')

@section('content')
<div class="container">
    <h2 class="text-xl font-semibold mb-4" >Laporan Kunjungan Pasien</h2>

    <!-- Filter Form -->
    <div class="card shadow-sm p-4 mb-4">
        <form id="filterForm" class="row g-3">
            <div class="col-md-4">
                <label for="filter_type" class="form-label">Filter Waktu</label>
                <select name="filter_type" id="filter_type" class="form-select">
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="layanan" class="form-label">Jenis Layanan</label>
                <select name="layanan" id="layanan" class="form-select">
                    <option value="">Semua Layanan</option>
                    <option value="KB">KB</option>
                    <option value="Imunisasi">Imunisasi</option>
                    <option value="Persalinan">Persalinan</option>
                </select>
            </div>

            <div class="col-12 d-flex justify-content-end">
                <button type="button" id="btnTampilkan" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#laporanModal">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Grafik -->

    <div class="container">
        <h4 class="font-semibold mb-4"><i class="bi bi-bar-chart me-2"></i>Grafik Laporan Kunjungan</h4>

        <div class="card mb-4">
            <div class="card-header">Kunjungan Per Bulan</div>
            <div class="card-body">
                <canvas id="chartBulan" height="100"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Kunjungan Per Minggu</div>
            <div class="card-body">
                <canvas id="chartMinggu" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Modal Laporan -->
    <div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hasil Laporan Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Loader -->
                    <div id="loading" class="text-center d-none">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Memuat data...</p>
                    </div>

                    <!-- Hasil Data -->
                    <div class="table-responsive" id="laporanTable">
                        <!-- hasil AJAX dimasukkan di sini -->
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.laporan.pdf', request()->only('tanggal','layanan')) }}" target="_blank" class="btn btn-success">
                        Download PDF
                    </a>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Data Table -->
    <div class="card shadow-sm p-4">
        <h5 class="font-semibold mb-2">Data Kunjungan</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Periksa</th>
                        <th>Nama Pasien</th>
                        <th>Layanan</th>
                        <th>Diagnosa</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataKunjungan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_rm)->format('d-m-Y') }}</td>
                            <td>{{ $item->pasien->nama }}</td>
                            @if ($item->pendaftaran && $item->pendaftaran->jenisLayanan)
                                {{ $item->pendaftaran->jenisLayanan->nama_layanan }}
                            @else
                                <span class="text-danger">-- Data Tidak Lengkap --</span>
                            @endif
                            <td>{{ $item->diagnosa }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data kunjungan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#btnTampilkan').on('click', function() {
        let filter = $('#filter_type').val();
        let tanggal = $('#tanggal').val();
        let layanan = $('#layanan').val();

        // tampilkan loader
        $('#loading').removeClass('d-none');
        $('#laporanTable').html('');

        $.ajax({
            url: "{{ route('admin.laporan.ajax') }}",
            type: "GET",
            data: {
                filter_type: filter,
                tanggal: tanggal,
                layanan: layanan
            },
            success: function(res) {
                $('#loading').addClass('d-none');
                $('#laporanTable').html(res);
            },
            error: function() {
                $('#loading').addClass('d-none');
                $('#laporanTable').html('<p class="text-danger text-center">Gagal memuat data.</p>');
            }
        });
    });
</script>
@endpush
