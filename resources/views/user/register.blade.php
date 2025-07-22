<!DOCTYPE html>
<html>
<head>
    <title>Register Pasien</title>
</head>
<body>
    <h2>Register Pasien</h2>
    <form method="POST" action="{{ route('user.register.submit') }}">
        @csrf
        <label>Nama:</label>
        <input type="text" name="nama" required><br>

        <label>NIK:</label>
        <input type="text" name="nik" required><br>

        <label>Tempat Lahir:</label>
        <input type="text" name="tempat_lahir" required><br>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tgl_lahir" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="">--Pilih--</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>

        <label>Alamat:</label>
        <textarea name="alamat" required></textarea><br>

        <label>No. Telepon:</label>
        <input type="text" name="no_telp" required><br>

        <label>Nama Pasangan:</label>
        <input type="text" name="nama_pasangan"><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Konfirmasi Password:</label>
        <input type="password" name="password_confirmation" required><br>

        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="{{ route('user.login') }}">Login</a></p>
</body>
</html>
