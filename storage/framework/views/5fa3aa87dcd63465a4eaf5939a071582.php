

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Riwayat - Klinik'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            
                            <td><?php echo e($data->jenisLayanan->nama_layanan ?? '-'); ?></td>
                            <td><?php echo e($data->created_at->format('d M Y, H:i')); ?> WIB</td>
                            <td><?php echo e($data['no_antrian']); ?></td>
                            <td><?php echo e($data['status'] ?? '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pendaftaran.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="d-flex justify-content-end mt-3">
                <?php echo e($riwayat->links()); ?>

            </div>
        </div>
    </div>

    <!-- <div class="main-section">
        <div class="info-box">
        Layanan KB ditutup sementara tanggal 20 Juli.
        </div>
    </div> -->
    

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\klinik-bidan\resources\views/user/riwayat.blade.php ENDPATH**/ ?>