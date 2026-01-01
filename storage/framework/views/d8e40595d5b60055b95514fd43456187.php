

<?php $__env->startSection('content'); ?>

    <!-- Main Content -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-xl font-semibold mb-2">Dashboard</h2>
                    <p class="mb-6 text-gray-700">Selamat Datang di Website Klinik</p>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2" placeholder="Search" style="width: 200px;">
                    <span class="me-2">Hello, <?php echo e(Auth::user()->username); ?></span>
                    <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                </div>
            </div>

    <div class="grid grid-cols-2 gap-10 mb-10">
        <a href="<?php echo e(route('admin.pasien')); ?>" class="block hover:scale-105 transition-transform">
            <div class="bg-white p-5 rounded shadow">
                <div class="text-2xl font-bold"><?php echo e($jumlahPasien); ?></div>
                <p class="text-gray-600">Jumlah Pasien</p>
            </div>
        </a>    
        
        <a href="<?php echo e(route('admin.layanan')); ?>" class="block hover:scale-105 transition-transform">
            <div class="bg-white p-5 rounded shadow">
                <div class="text-2xl font-bold"><?php echo e($jumlahAntrian); ?></div>
                <p class="text-gray-600">Antrian Pasien</p>
            </div>
        </a>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Data Riwayat Rekam Medis</h3>
        <input type="text" placeholder="Search..." class="mb-3 border rounded px-2 py-1">
        <table class="w-full border text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Tanggal Periksa</th>
                    <th class="p-2 border">Layanan</th>
                    <th class="p-2 border">Nama Pasien</th>
                    <th class="p-2 border">Keluhan</th>
                    <th class="p-2 border">Diagnosa</th>
                    <th class="p-2 border">Tindakan</th>
                    <th class="p-2 border">Keterangan</th>
                </tr>
            </thead>
            <tbody>
            <?php if($rekamMedis->count()): ?>
                <?php $__currentLoopData = $rekamMedis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="p-2 border text-center"><?php echo e($index + 1); ?></td>

                        <td class="p-2 border">
                            <?php echo e(\Carbon\Carbon::parse($rm->tgl_rm)->format('d-m-Y')); ?>

                        </td>

                        <td class="p-2 border">
                            <?php echo e($rm->jenisLayanan->nama_layanan ?? '-'); ?>

                        </td>

                        <td class="p-2 border">
                            <?php echo e($rm->pasien->nama ?? '-'); ?>

                        </td>

                        <td class="p-2 border">
                            <?php echo e($rm->anamnesa ?? '-'); ?>

                        </td>

                        <td class="p-2 border">
                            <?php echo e($rm->diagnosa ?? '-'); ?>

                        </td>

                        <td class="p-2 border">
                            <?php echo e($rm->terapi ?? '-'); ?>

                        </td>

                        <td class="p-2 border">
                            <?php echo e($rm->keterangan ?? '-'); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="p-2 text-center text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\klinik-bidan\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>