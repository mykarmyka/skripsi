<!DOCTYPE html>
<html>
<head>
    <title>Login Pasien</title>
</head>
<body>
    <h2>Login Pasien</h2>
    <form method="POST" action="{{ route('user.login.submit') }}">
        @csrf
        <label for="nik">NIK:</label>
        <input type="text" name="nik" placeholder="Masukkan NIK" required>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="{{ route('user.register') }}">Register</a></p>
</body>
</html>
