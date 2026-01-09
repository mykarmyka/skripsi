<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pasien</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/user.css')); ?>">
</head>
<body class="login-page-container">
     <div class="login-container">
        <h2 class="fw-bold">Login Pasien</h2>
        <form method="POST" action="<?php echo e(route('user.login.submit')); ?>">
            <?php echo csrf_field(); ?>
            <div class="login-form-group"> <label for="nik">NIK</label>
                <input type="text" id="nik" name="nik" placeholder="Masukkan NIK Anda" required>
            </div>
            <button type="submit" class="login-submit-button">Login</button> </form>
        <p class="login-register-link">Belum punya akun? <a href="<?php echo e(route('user.register')); ?>">Register di sini</a></p> </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skripsi\resources\views/user/login.blade.php ENDPATH**/ ?>