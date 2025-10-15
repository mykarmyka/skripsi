<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Nomor Antrian</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo, {{ $pasien->nama }}</h2>
    <p>Terima kasih telah mendaftar di <strong>Klinik Bidan X</strong>.</p>

    <p>Berikut detail pendaftaran Anda:</p>
    <ul>
        <li><strong>No. Antrian:</strong> {{ $pendaftaran->no_antrian }}</li>
        <li><strong>Layanan:</strong> {{ $layanan->nama_layanan }}</li>
        <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pendaftaran->tgl_pendaftaran)->format('d-m-Y') }}</li>
        <li><strong>Estimasi Kedatangan:</strong> {{ $pendaftaran->estimasi_datang }}</li>
    </ul>

    <p>Mohon hadir 10 menit sebelum estimasi waktu tersebut.</p>
    <p>Terima kasih, semoga sehat selalu ❤️</p>
</body>
</html>
