<!DOCTYPE html>
<html>
<head>
    <title>Register Pasien</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body class="login-page-container">
   
    <div class="register-page-wrapper">
        <div class="register-header">
            <h3>Daftar Akun Pasien Baru</h3>
        </div>
        <div class="register-body">
            <form method="POST" action="{{ route('user.register.submit') }}">
                @csrf
                <div class="register-form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="register-form-group">
                    <label for="nik">NIK (Nomor Induk Kependudukan):</label>
                    <input type="text" id="nik" name="nik" placeholder="Masukkan NIK Anda (16 digit)" required>
                </div>

                <div class="register-form-group">
                    <label for="tempat_lahir">Tempat Lahir:</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Contoh: Surabaya" required>
                </div>

                <div class="register-form-group">
                    <label for="tgl_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" required>
                </div>

                <div class="register-form-group">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="register-form-group">
                    <label for="alamat">Alamat Lengkap:</label>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap Anda" required></textarea>
                </div>

                <div class="register-form-group">
                    <label for="no_telp">Nomor Telepon:</label>
                    <input type="text" id="no_telp" name="no_telp" placeholder="Contoh: 081234567890" required>
                </div>

                <div class="register-form-group">
                    <label for="nama_pasangan">Nama Pasangan (opsional):</label>
                    <input type="text" id="nama_pasangan" name="nama_pasangan" placeholder="Masukkan nama pasangan Anda (jika ada)">
                </div>

                <div class="register-form-group">
                    <label for="email">Alamat Email:</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda yang aktif" required>
                </div>

                <div class="register-form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Buat password minimal 8 karakter" required>
                </div>

                <div class="register-form-group">
                    <label for="password_confirmation">Konfirmasi Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda" required>
                </div>
            </form>
        </div>
        <div class="register-footer">
            <p class="register-login-link-footer">Sudah punya akun? <a href="{{ route('user.login') }}">Login di sini</a></p>
            <div class="register-button-group">
                {{-- Anda bisa menambahkan tombol batal jika diperlukan --}}
                {{-- <button type="button" class="register-cancel-button" onclick="history.back()">Batal</button> --}}
                <button type="submit" form="registerForm" class="register-submit-button">Daftar Akun</button>
            </div>
        </div>
    </div>
</body>
</html>
