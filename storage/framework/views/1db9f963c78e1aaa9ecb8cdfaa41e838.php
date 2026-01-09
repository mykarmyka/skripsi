<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login Bidan</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
</head>
<body class="login-page-container">
    <div class="login-container">
        <h2 class="fw-bold">Login Bidan</h2>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
            <?php echo csrf_field(); ?>
            <div class="login-form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Masukkan Email Anda" required>
            </div>
            <div class="login-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
            </div>
            <button type="submit" class="login-submit-button">Login</button>
        </form>
        <p class="login-register-link">Belum punya akun? <a href="#">Hubungi Admin</a></p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skripsi\resources\views/admin/login.blade.php ENDPATH**/ ?>