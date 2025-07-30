@extends('layouts.main')

@section('title', 'Laporan Kunjungan')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxBulan = document.getElementById('chartBulan');
    const chartBulan = new Chart(ctxBulan, {
        type: 'bar',
        data: {
            labels: {!! json_encode($kunjunganPerBulan->pluck('bulan')->map(fn($b) => 'Bulan ' . $b)) !!},
            datasets: [{
                label: 'Kunjungan per Bulan',
                data: {!! json_encode($kunjunganPerBulan->pluck('jumlah')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });

    const ctxMinggu = document.getElementById('chartMinggu');
    const chartMinggu = new Chart(ctxMinggu, {
        type: 'line',
        data: {
            labels: {!! json_encode($kunjunganPerMinggu->pluck('minggu')->map(fn($m) => 'Minggu ' . $m)) !!},
            datasets: [{
                label: 'Kunjungan per Minggu',
                data: {!! json_encode($kunjunganPerMinggu->pluck('jumlah')) !!},
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2
            }]
        }
    });
</script>
@endpush

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="bi bi-bar-chart me-2"></i>Grafik Laporan Kunjungan</h4>

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
@endsection
