

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('title', 'Laporan Kunjungan Pasien'); ?>

<?php $__env->startSection('content'); ?>
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
                <select name="jenis_layanan" id="layanan" class="form-select">
                    <option value="">Semua Layanan</option>
                    <?php $__currentLoopData = $layanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>" <?php echo e(request('jenis_layanan') == $item->id ? 'selected' : ''); ?>>
                            <?php echo e($item->nama_layanan); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    <div class="container mb-4">
        <h4 class="font-semibold mb-3">
            Grafik Laporan Kunjungan
        </h4>

        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header">Kunjungan Per Bulan</div>
                    <div class="card-body">
                        <canvas id="chartBulan" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header">Kunjungan Per Minggu</div>
                    <div class="card-body">
                        <canvas id="chartMinggu" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <!-- Data Table -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="font-semibold mb-3">Data Kunjungan Pasien</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Periksa</th>
                        <th>Nama Pasien</th>
                        <th>Layanan</th>
                        <th>Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $dataKunjungan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($item->tgl_rm)->format('d/m/Y')); ?></td>
                            <td><?php echo e($item->pasien->nama); ?></td>
                            <td><?php echo e($item->pendaftaran->jenisLayanan->nama_layanan ?? '-'); ?></td>
                            <td><?php echo e($item->diagnosa ?? '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data kunjungan ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Laporan -->
<div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title">Hasil Laporan Kunjungan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="loading" class="text-center d-none py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 text-muted">Memuat data laporan...</p>
                </div>

                <div class="table-responsive" id="laporanTable"></div>
            </div>
            <div class="modal-footer">
                <a href="<?php echo e(route('admin.laporan.pdf', request()->only('tanggal','jenis_layanan'))); ?>" target="_blank" class="btn btn-success">
                    Download PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kunjunganPerBulan = <?php echo json_encode($kunjunganPerBulan ?? [], 15, 512) ?>;
    const kunjunganPerMinggu = <?php echo json_encode($kunjunganPerMinggu ?? [], 15, 512) ?>;
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

        const namaBulan = {
        1: 'Jan', 2: 'Feb', 3: 'Mar', 4: 'Apr',
        5: 'Mei', 6: 'Jun', 7: 'Jul', 8: 'Agu',
        9: 'Sep', 10: 'Okt', 11: 'Nov', 12: 'Des'
    };

    const labelBulan = Object.keys(kunjunganPerBulan).map(
        b => namaBulan[b]
    );

    const labelMinggu = Object.keys(kunjunganPerMinggu).map(
        m => 'Minggu ke-' + m
    );


    // Grafik Kunjungan Per Bulan
    new Chart(document.getElementById('chartBulan'), {
        type: 'bar',
        data: {
            labels: labelBulan,
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: Object.values(kunjunganPerBulan)
            }]
        },
        options: { responsive: true }
    });


    // Grafik Kunjungan Per Minggu
    new Chart(document.getElementById('chartMinggu'), {
        type: 'line',
        data: {
            labels: labelMinggu,
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: Object.values(kunjunganPerMinggu),
                tension: 0.4
            }]
        },
        options: { responsive: true }
    });


});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\klinik-bidan\resources\views/admin/laporan.blade.php ENDPATH**/ ?>