@extends('user.main') 

@push('style')
input[readonly] {
    background-color: #f9f9f9;
    cursor: default;
}
@endpush

@section('content')
<div class="d-flex flex-column align-items-center mb-4">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User" class="rounded-circle" width="100">
    <h5 class="mt-2">Hello, User</h5>
</div>

<div class="bg-white p-5 rounded shadow w-75 mx-auto">
    <form>
        @php
            // Data dummy (ganti nanti pakai DB)
            $profil = [
                'nama' => 'Fulanah',
                'tempat_lahir' => 'Madiun',
                'tgl_lahir' => '1999-02-21',
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Jl. Mawar No. 17',
                'telp' => '08123456789',
                'nama_pasangan' => 'Fulan',
                'nik' => '4433789956352',
                'email' => 'fulanah@example.com'
            ];
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
                    <input type="text" class="form-control" value="{{ $profil[$field] }}" readonly>
                </div>
            </div>
        @endforeach
    </form>
</div>
@endsection
