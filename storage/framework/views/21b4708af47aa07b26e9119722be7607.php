

<?php $__env->startPush('style'); ?>
/* Pendaftaran Persalinan */
.container {
    background-color: #fdfcfc;
    max-width: 700px;
    margin: auto;
}

form label {
    font-weight: 600;
    color: #333;
}

form input, form select {
    border: 1px solid #ccc;
    padding: 8px;
    border-radius: 4px;
}

form button.btn-primary {
    background-color: #4d76cc;
    border: none;
}
form button.btn-primary:hover {
    background-color: #345ac2;
}
<?php $__env->stopPush(); ?>

<?php if(session('success')): ?>
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?php echo e(session('success')); ?>

            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
<div class="container bg-white p-5 rounded shadow">
    <h4 class="fw-bold mb-2">Pendaftaran Persalinan</h4>
    <p class="text-muted mb-4">Silakan isi formulir berikut untuk mendaftar layanan persalinan.</p>

    <form id="formPersalinan" action="<?php echo e(route('user.pendaftaran-persalinan.simpan')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal Pendaftaran</label>
            <input type="date" name="tgl_pendaftaran" id="tgl_pendaftaran" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Layanan</label>
            <input type="hidden" name="id_pasien" value="<?php echo e(Auth::guard('pasien')->user()->id_pasien); ?>">
            <select name="id_jenis_layanan" id="id_jenis_layanan" class="form-select" required>
                <option value="">-- Pilih --</option>
                <?php $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($j->id); ?>"><?php echo e($j->nama_layanan); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Catatan</label>
            <input type="text" name="catatan" id="catatan" class="form-control">
        </div>

        <button type="button" class="btn btn-primary px-4" id="btnDaftarPersalinan">Daftar Sekarang</button>
    </form>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="konfirmasiModalPersalinan" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="konfirmasiModalLabel">Konfirmasi Pendaftaran Persalinan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p><strong>Tanggal Pendaftaran:</strong> <span id="konfirmasiTanggal"></span></p>
        <p><strong>Layanan:</strong> <span id="konfirmasiLayanan"></span></p>
        <p><strong>Catatan:</strong> <span id="konfirmasiCatatan"></span></p>
        <hr>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="setujuCheckbox">
            <label class="form-check-label text-muted" for="setujuCheckbox">
                Data di atas sudah benar.
            </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
        <button type="button" class="btn btn-success" id="btnKirimPersalinan" disabled>Kirim</button>
      </div>
    </div>
  </div>
</div>

<!-- Script Konfirmasi -->
<script>
document.getElementById('btnDaftarPersalinan').addEventListener('click', function () {
    const tanggal = document.getElementById('tgl_pendaftaran').value;
    const layananSelect = document.getElementById('id_jenis_layanan');
    const catatan = document.getElementById('catatan').value || '-';
    const layananText = layananSelect.options[layananSelect.selectedIndex]?.text || '';

    if (!tanggal || !layananSelect.value) {
        alert('Harap isi tanggal dan pilih layanan terlebih dahulu.');
        return;
    }

    document.getElementById('konfirmasiTanggal').textContent = tanggal;
    document.getElementById('konfirmasiLayanan').textContent = layananText;
    document.getElementById('konfirmasiCatatan').textContent = catatan;

    const checkbox = document.getElementById('setujuCheckbox');
    const btnKirim = document.getElementById('btnKirimPersalinan');
    checkbox.checked = false;
    btnKirim.disabled = true;

    const modal = new bootstrap.Modal(document.getElementById('konfirmasiModalPersalinan'));
    modal.show();

    checkbox.onchange = function() {
        btnKirim.disabled = !this.checked;
    };

    btnKirim.onclick = function () {
        document.getElementById('formPersalinan').submit();
    };
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\klinik-bidan\resources\views/user/pendaftaran-persalinan.blade.php ENDPATH**/ ?>