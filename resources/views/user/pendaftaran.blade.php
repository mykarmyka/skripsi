@extends('user.main')

@push('style')
/* Pendaftaran Layanan */
.container {
    background-color: #fdfcfc;
    max-width: 700px;
    margin: auto;
}

form label {
    font-weight: 600;
    color: #333;
}

form input, form select {
    border: 1px solid #ccc;
    padding: 8px;
    border-radius: 4px;
}

form button.btn-primary {
    background-color: #4d76cc;
    border: none;
}
form button.btn-primary:hover {
    background-color: #345ac2;
}
@endpush

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
<div class="container bg-white p-5 rounded shadow">
    <h4 class="fw-bold mb-2">Pendaftaran Layanan Medis</h4>
    <p class="text-muted mb-4">Silakan isi formulir berikut untuk mendaftar layanan medis yang Anda butuhkan</p>

    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Pasien</label>
            <input type="text" name="nama_pasien" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal Pendaftaran</label>
            <input type="date" name="tgl_pendaftaran" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Layanan</label>
            <select name="layanan" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Pemeriksaan Umum">Pemeriksaan Umum</option>
                <option value="Pemeriksaan Kehamilan">Pemeriksaan Kehamilan</option>
                <option value="Persalinan">Persalinan</option>
                <option value="KB">KB</option>
                <option value="Imunisasi">Nifas</option>
                <option value="Massage & Baby Spa">Massage & Baby Spa</option>
                <option value="Lainnya">Lainnya</option>
            </select>

        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Catatan</label>
            <input type="text" name="catatan" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary px-4">Daftar Sekarang</button>
    </form>
</div>
@endsection
