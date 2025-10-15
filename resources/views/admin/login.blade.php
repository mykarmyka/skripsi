<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Bidan</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body class="login-page-container">
    <div class="login-container">
        <h2 class="fw-bold">Login Bidan</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
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
