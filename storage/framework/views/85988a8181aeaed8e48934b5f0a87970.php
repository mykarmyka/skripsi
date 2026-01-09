<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Pasien</th>
            <th>Layanan</th>
            <th>Diagnosa</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($item->tgl_rm)->format('d-m-Y')); ?></td>
            <td><?php echo e($item->pasien->nama); ?></td>
            <td><?php echo e($item->jenisLayanan->nama_layanan ?? '-'); ?></td>
            <td><?php echo e($item->diagnosa ?? '-'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="5" class="text-center text-muted">
                Tidak ada data
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\xampp\htdocs\skripsi\resources\views/admin/laporan_table.blade.php ENDPATH**/ ?>