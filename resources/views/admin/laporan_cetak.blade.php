<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }

        @media print {
            .btn, .modal-footer { display: none; } /* tombol tidak ikut tercetak */
        }
    </style>
</head>
<body>
    <h2>Laporan Kunjungan Pasien</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Periksa</th>
                <th>Nama Pasien</th>
                <th>Layanan</th>
                <th>Diagnosa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_rm)->format('d-m-Y') }}</td>
                    <td>{{ $item->pasien->nama }}</td>
                    <td>{{ $item->jenis_layanan->nama }}</td>
                    <td>{{ $item->diagnosa }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p><strong>Tanda tangan Bidan</strong></p>
        <br><br>
        <p>___________________________</p>
    </div>
</body>
</html>
