

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/rekam-medis.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Layanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold mb-2">Daftar Layanan</h2>
            <p class="deskripsi">Periksa dan perbarui status pendaftaran layanan medis pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
            
            <span class="me-2">Hello, <?php echo e(Auth::user()->username); ?></span>
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
                        <th>No Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal Daftar</th>
                        <th>RM</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                   <?php $__currentLoopData = $pendaftaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $daftar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($daftar->no_antrian); ?></td>
                        <td><?php echo e($daftar->pasien->nama); ?></td>
                        <td><?php echo e($daftar->jenisLayanan->nama_layanan ?? '-'); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($daftar['tgl_pendaftaran'])->format('d-m-Y')); ?></td>
                        <td>
                            <?php if($daftar->status == 'waiting'): ?>
                                <button class="btn btn-link p-0 text-success" data-bs-toggle="modal" data-bs-target="#rekamMedisModal<?php echo e($daftar->id_pendaftaran); ?>" title="Isi Rekam Medis">
                                    <i class="bi bi-journal-medical fs-5"></i>
                                </button>
                            <?php else: ?>
                                <span class="text-muted">Sudah Diisi</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($daftar->status == 'waiting'): ?>
                                <span class="badge bg-warning">Menunggu</span>
                            <?php elseif($daftar->status == 'hadir'): ?>
                                <span class="badge bg-success">Hadir</span>
                            <?php elseif($daftar->status == 'done'): ?>
                                <span class="badge bg-primary">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    
                    <div class="modal fade" id="rekamMedisModal<?php echo e($daftar->id_pendaftaran); ?>" tabindex="-1" aria-labelledby="rekamMedisModalLabel<?php echo e($daftar->id_pendaftaran); ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="<?php echo e(route('admin.pendaftaran.simpanRekamMedis', $daftar->id_pendaftaran)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rekamMedisModalLabel<?php echo e($daftar->id_pendaftaran); ?>">Isi Rekam Medis - <?php echo e($daftar->pasien->nama); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Tanggal Rekam Medis</label>
                                            <input type="date" name="tgl_rm" class="form-control" value="<?php echo e(now()->format('Y-m-d')); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Keluhan</label>
                                            <textarea name="anamnesa" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Diagnosa</label>
                                            <textarea name="diagnosa" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tindakan</label>
                                            <textarea name="terapi" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Terapi</label>
                                            <textarea name="keterangan" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                <?php echo e($pendaftaran->links()); ?>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\klinik-bidan\resources\views/admin/layanan.blade.php ENDPATH**/ ?>