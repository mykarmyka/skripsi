<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
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
            <td>{{ $item->jenisLayanan->nama_layanan ?? '-' }}</td>
            <td>{{ $item->diagnosa ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted">
                Tidak ada data
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
