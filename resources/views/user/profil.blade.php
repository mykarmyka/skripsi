@extends('user.main') 

@push('style')
input[readonly] {
    background-color: #f9f9f9;
    cursor: default;
}
@endpush

@if(Auth::guard('pasien')->check())
    <div class="alert alert-success">Pasien sudah login.</div>
@else
    <div class="alert alert-danger">Belum login sebagai pasien!</div>
@endif

@section('content')
<div class="d-flex flex-column align-items-center mb-4">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User" class="rounded-circle" width="100">
    <h5 class="mt-2">Hello, {{ Auth::guard('pasien')->user()->nama }}</h5>
</div>

<div class="bg-white p-5 rounded shadow w-75 mx-auto">
    <form>
        @php
            $profil = Auth::guard('pasien')->user();
        @endphp

        @foreach([
            'Nama Lengkap' => 'nama',
            'Tempat Lahir' => 'tempat_lahir',
            'Tanggal Lahir' => 'tgl_lahir',
            'Jenis Kelamin' => 'jenis_kelamin',
            'Alamat' => 'alamat',
            'No. Telpon' => 'telp',
            'Nama Pasangan' => 'nama_pasangan',
            'NIK' => 'nik',
            'Email' => 'email',
        ] as $label => $field)
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label fw-semibold">{{ $label }}</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="{{ $profil->$field }}" readonly>
                </div>
            </div>
        @endforeach

        <div class="text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                Edit Profil
            </button>
        </div>
    </form>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('user.updateProfil') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $profil->nama }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ $profil->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" value="{{ $profil->tgl_lahir }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="Perempuan" {{ $profil->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                <option value="Laki-laki" {{ $profil->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ $profil->alamat }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telpon</label>
                            <input type="text" name="telp" class="form-control" pattern="08[0-9]{8,11}" value="{{ $profil->telp }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pasangan</label>
                            <input type="text" name="nama_pasangan" class="form-control" value="{{ $profil->nama_pasangan }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" pattern="[0-9]{16}" value="{{ $profil->nik }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $profil->email }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
