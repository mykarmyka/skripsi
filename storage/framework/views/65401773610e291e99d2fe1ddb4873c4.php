

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/rekam-medis.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Rekam Medis'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold mb-2">Rekam Medis Pasien</h2>
            <p class="deskripsi">Periksa dan perbarui status pendaftaran layanan medis pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
            
            <span class="me-2">Hello, <?php echo e(Auth::user()->username); ?></span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRekamMedis">
                + Input Rekam Medis Baru
            </button>
            <div>
                <form action="<?php echo e(route('admin.rekam-medis')); ?>" method="GET" class="d-flex align-items-center me-3">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control me-2" placeholder="Search" value="<?php echo e(request('keyword')); ?>" style="width: 200px;">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="modalRekamMedis" tabindex="-1" aria-labelledby="modalRekamMedisLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?php echo e(route('admin.rekam.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="modalRekamMedisLabel">Input Rekam Medis Pasien</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            
                            <div class="mb-3">
                                <label class="form-label">Pilih Pendaftaran</label>
                                <select name="id_pendaftaran" class="form-control" required>
                                    <option value="">-- Pilih Pasien Terdaftar --</option>

                                    <?php $__currentLoopData = $pendaftaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p->id_pendaftaran); ?>">
                                            <?php echo e($p->pasien->nama); ?> — <?php echo e($p->jenisLayanan->nama_layanan); ?>

                                            (Antrian: <?php echo e($p->no_antrian); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <input type="hidden" name="id_admin"
                                value="<?php echo e(Auth::check() ? Auth::user()->id_admin : null); ?>">

                            
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kunjungan</label>
                                <input type="date" name="tgl_rm" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label">Anamnesa</label>
                                <input type="text" name="anamnesa" class="form-control" required>
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label">Diagnosa</label>
                                <input type="text" name="diagnosa" class="form-control" required>
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label">Terapi</label>
                                <input type="text" name="terapi" class="form-control" required>
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" required></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <h5 class="font-semibold mb-3">Tabel Riwayat Rekam Medis Pasien</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tgl Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Diagnosa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $rekamMedis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($rm->tgl_rm)->format('d-m-Y')); ?></td> 
                        <td><?php echo e($rm->pasien->nama ?? 'N/A'); ?></td> 
                        <td><?php echo e($rm->jenisLayanan->nama_layanan ?? 'N/A'); ?></td> 
                        <td><?php echo e($rm->diagnosa ?? '-'); ?></td>
                        <td>
                            <button class="btn btn-link p-0 text-primary btn-edit" data-id="<?php echo e($rm->id_rm); ?>" title="Detail Rekam Medis">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </button>
                            <form action="<?php echo e(route('admin.rekam-medis.destroy', $rm->id_rm)); ?>" method="POST" style="display:inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button onclick="return confirm('Yakin hapus data?')" class="btn btn-link p-0 text-danger" title="Hapus"><i class="bi bi-trash fs-5"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data rekam medis</td>
                    </tr>
                    <?php endif; ?> 
                </tbody>
            </table>

            <div class="modal fade" id="modalRekam" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detail Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <h5><strong>Data Kunjungan Ini</strong></h5>
                    <div id="detail-rekam"></div>

                    <hr>

                    <h5><strong>Riwayat Rekam Medis Sebelumnya</strong></h5>
                    <div class="accordion" id="riwayatAccordion"></div>

                </div>
                </div>
            </div>
            </div>


            <div class="d-flex justify-content-end mt-3">
                <?php echo e($rekamMedis->links()); ?>

            </div>

        </div>
    </div>

    <!-- Modal Detail Rekam Medis -->
    <div class="modal fade" id="modalRekam" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="detail-rekam">
                    
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).on('click', '.btn-edit', function() {
    let id = $(this).data('id');

    $.get('/admin/rekam-medis/' + id + '/detail', function(res) {

        // ============================
        // DETAIL KUNJUNGAN INI
        // ============================
        $('#detail-rekam').html(`
            <p><strong>Nama Pasien :</strong> ${res.rekam.pendaftaran.pasien.nama}</p>
            <p><strong>Jenis Layanan :</strong> ${res.rekam.pendaftaran.jenis_layanan.nama_layanan}</p>
            <p><strong>Tanggal Kunjungan :</strong> ${res.rekam.tgl_rm}</p>
            <p><strong>Diagnosa :</strong> ${res.rekam.diagnosa}</p>
            <p><strong>Tindakan :</strong> ${res.rekam.terapi}</p>
            <p><strong>Catatan :</strong> ${res.rekam.catatan ?? '-'}</p>
        `);

        // ============================
        // RIWAYAT REKAM MEDIS LAMA
        // ============================
        let riwayatHTML = '';
        res.riwayat.forEach((item, index) => {
            riwayatHTML += `
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading${index}">
                  <button class="accordion-button collapsed" 
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse${index}">
                    Rekam Medis Tanggal: ${item.tgl_rm}
                  </button>
                </h2>
                <div id="collapse${index}" class="accordion-collapse collapse" 
                     data-bs-parent="#riwayatAccordion">
                  <div class="accordion-body">
                    <p><strong>Diagnosa:</strong> ${item.diagnosa}</p>
                    <p><strong>Anamnesa :</strong> ${res.rekam.anamnesa ?? '-'}</p> 
                    <p><strong>Terapi :</strong> ${res.rekam.terapi ?? '-'}</p>   
                    <p><strong>Keterangan :</strong> ${res.rekam.keterangan ?? '-'}</p> 
                  </div>
                </div>
            </div>`;
        });

        $('#riwayatAccordion').html(riwayatHTML);

        $('#modalRekam').modal('show');
    });

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\klinik-bidan\resources\views/admin/rekam-medis.blade.php ENDPATH**/ ?>