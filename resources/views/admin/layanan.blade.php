@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/rekam-medis.css') }}">
@endpush

@section('title', 'Layanan')

@section('content')
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold mb-2">Daftar Layanan</h2>
            <p class="deskripsi">Periksa dan perbarui status pendaftaran layanan medis pasien secara menyeluruh</p>
        </div>
        <div class="d-flex align-items-center">
            
            <span class="me-2">Hello, {{ Auth::user()->username }}</span>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <div class="d-flex justify-content-between align-items-center mb-3">
        
            <div>
                <form method="GET">
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search"
                        value="{{ request('search') }}">
                </form>
            </div>
        </div>


        <h5 class="font-semibold mb-3">Daftar Antrean Pendaftaran Layanan</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>No Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal Daftar</th>
                        <th>RM</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($pendaftaran as $i => $daftar)
                    <tr>
                        <td>{{ $daftar->no_antrian }}</td>
                        <td>{{ $daftar->pasien->nama }}</td>
                        <td>{{ $daftar->jenisLayanan->nama_layanan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($daftar['tgl_pendaftaran'])->format('d-m-Y') }}</td>
                        <td>
                            @if ($daftar->status == 'waiting')
                                <button class="btn btn-link p-0 text-success" data-bs-toggle="modal" data-bs-target="#rekamMedisModal{{ $daftar->id_pendaftaran }}" title="Isi Rekam Medis">
                                    <i class="bi bi-journal-medical fs-5"></i>
                                </button>
                            @else
                                <span class="text-muted">Sudah Diisi</span>
                            @endif
                        </td>
                        <td>
                            @if ($daftar->status == 'waiting')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif ($daftar->status == 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif ($daftar->status == 'done')
                                <span class="badge bg-primary">Selesai</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Modal Rekam Medis --}}
                    <div class="modal fade" id="rekamMedisModal{{ $daftar->id_pendaftaran }}" tabindex="-1" aria-labelledby="rekamMedisModalLabel{{ $daftar->id_pendaftaran }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('admin.pendaftaran.simpanRekamMedis', $daftar->id_pendaftaran) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rekamMedisModalLabel{{ $daftar->id_pendaftaran }}">Isi Rekam Medis - {{ $daftar->pasien->nama }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Tanggal Rekam Medis</label>
                                            <input type="date" name="tgl_rm" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Keluhan</label>
                                            <textarea name="anamnesa" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Diagnosa</label>
                                            <textarea name="diagnosa" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tindakan</label>
                                            <textarea name="terapi" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Terapi</label>
                                            <textarea name="keterangan" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $pendaftaran->links() }}
            </div>

        </div>
    </div>
</div>
@endsection


