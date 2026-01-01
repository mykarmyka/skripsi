<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Klinik Bidan</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- popup-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-blue-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow p-5 space-y-4">
        <a href="/" class="d-block mb-4 text-center">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo Klinik" style="width: 200px;" >
        </a>

        <nav class="space-y-2">
            <a href="<?php echo e(route('admin.dashboard')); ?>" 
                class="block px-3 py-2 rounded hover:bg-blue-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-200 font-semibold text-blue-800' : ''); ?>">
                <i class="bi bi-house-door me-2"></i>Dashboard
            </a>

            <p class="text-gray-500 text-sm mt-4">MANAJEMEN</p>

            <a href="<?php echo e(route('admin.layanan')); ?>" class="block px-3 py-2 rounded hover:bg-blue-200 <?php echo e(request()->routeIs('admin.layanan') ? 'bg-blue-200 font-semibold text-blue-800' : ''); ?>">
                <i class="bi bi-clipboard-check me-2"></i>Pendaftaran
            </a>
            
            <a href="<?php echo e(route('admin.rekam-medis')); ?>" 
                class="block px-3 py-2 rounded hover:bg-blue-200 <?php echo e(request()->routeIs('admin.rekam-medis') ? 'bg-blue-200 font-semibold text-blue-800' : ''); ?>">
                <i class="bi bi-file-earmark-medical me-2"></i>Rekam Medis
            </a>

            <a href="<?php echo e(route('admin.laporan')); ?>" 
                class="block px-3 py-2 rounded hover:bg-blue-200 <?php echo e(request()->routeIs('admin.laporan') ? 'bg-blue-200 font-semibold text-blue-800' : ''); ?>">
                <i class="bi bi-file-earmark-text me-2"></i></i>Laporan
            </a>

            <p class="text-gray-500 text-sm mt-4">DATA MASTER</p>

            <a href="<?php echo e(route('admin.pasien')); ?>"
                class="block px-3 py-2 rounded hover:bg-blue-200 <?php echo e(request()->routeIs('admin.pasien') ? 'bg-blue-200 font-semibold text-blue-800' : ''); ?>">
                <i class="bi bi-person-lines-fill me-2"></i> Pasien
            </a>

            <a href="<?php echo e(route('admin.obat')); ?>"
                class="block px-3 py-2 rounded hover:bg-blue-200 <?php echo e(request()->routeIs('admin.obat') ? 'bg-blue-200 font-semibold text-blue-800' : ''); ?>">
                <i class="bi bi-grid me-2"></i> Obat
            </a>

            <a href="<?php echo e(route('admin.jenis-layanan')); ?>"
                class="block px-3 py-2 rounded hover:bg-blue-200 <?php echo e(request()->routeIs('admin.jenis-layanan') ? 'bg-blue-200 font-semibold text-blue-800' : ''); ?>">
                <i class="bi bi-heart-pulse me-2"></i> Jenis Layanan
            </a>

            <a href="#" 
                class="block px-3 py-2 rounded hover:bg-blue-200" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>

        </nav>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-10" style="width: 100%">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Modal Konfirmasi Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
        <div class="modal-header">
            <h5 class="modal-title fw-bold" id="logoutModalLabel">Konfirmasi Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            Apakah Anda yakin ingin logout?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            
            <!-- Logout form -->
            <form action="<?php echo e(route('user.logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-danger">Ya, Logout</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\klinik-bidan\resources\views/layouts/main.blade.php ENDPATH**/ ?>