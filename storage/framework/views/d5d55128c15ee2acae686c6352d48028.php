

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Home - Klinik'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
          <h2 class="judul-halaman">Selamat Datang, <?php echo e(Auth::guard('pasien')->user()->nama); ?>.</h2>
          <p class="deskripsi">Dapatkan layanan kesehatan terbaik di Klinik Bidan X.</p>
      </div>
      <div class="d-flex align-items-center">
          <span class="me-2">Hello, <?php echo e(Auth::guard('pasien')->user()->nama); ?></span>
          <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
      </div>
  </div>



  <div class="container mt-4">

    
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Kunjungan Bulan Ini</h6>
            <h3 class="fw-bold text-primary"><?php echo e($kunjunganBulanIni ?? 0); ?></h3>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Total Kunjungan</h6>
            <h3 class="fw-bold text-success"><?php echo e($totalKunjungan ?? 0); ?></h3>
          </div>
        </div>
      </div>
    </div>

    
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Status Pendaftaran Hari Ini</h5>
        <hr>
        <?php if($pendaftaranHariIni): ?>
          <p><strong>Layanan:</strong> <?php echo e($pendaftaranHariIni->jenisLayanan->nama_layanan); ?></p>
          <p><strong>No Antrian:</strong> <?php echo e($pendaftaranHariIni->no_antrian); ?></p>
          <p><strong>Status:</strong>
            <span class="badge 
              <?php if($pendaftaranHariIni->status == 'menunggu'): ?> bg-warning 
              <?php elseif($pendaftaranHariIni->status == 'diperiksa'): ?> bg-info 
              <?php else: ?> bg-success <?php endif; ?>">
              <?php echo e(ucfirst($pendaftaranHariIni->status)); ?>

            </span>
          </p>
        <?php else: ?>
          <p class="text-muted">Anda belum mendaftar layanan hari ini.</p>
          <a href="<?php echo e(route('user.pendaftaran')); ?>" class="btn btn-primary btn-sm">Daftar Layanan Baru</a>
        <?php endif; ?>
      </div>
    </div>

    
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Rekam Medis Terakhir</h5>
        <hr>
        <?php if($rekamMedisTerakhir): ?>
          <p><strong>Tanggal:</strong> <?php echo e($rekamMedisTerakhir->tgl_rm); ?></p>
          <p><strong>Diagnosa:</strong> <?php echo e($rekamMedisTerakhir->diagnosa); ?></p>
        <?php else: ?>
          <p class="text-muted">Belum ada data rekam medis.</p>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>  

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skripsi\resources\views/user/home.blade.php ENDPATH**/ ?>