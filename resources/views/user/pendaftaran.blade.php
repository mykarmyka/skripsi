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
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@section('content')
<div class="container bg-white p-5 rounded shadow">
    <h4 class="fw-bold mb-2">Pendaftaran Layanan Medis</h4>
    <p class="text-muted mb-4">Silakan isi formulir berikut untuk mendaftar layanan medis yang Anda butuhkan</p>

    <form action="{{ route('user.pendaftaran.simpan') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal Pendaftaran</label>
            <input type="date" name="tgl_pendaftaran" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Layanan</label>
            <input type="hidden" name="id_pasien" value="{{ Auth::guard('pasien')->user()->id_pasien }}">
            <select name="id_jenis_layanan" class="form-control" required>
                <option value="">-- Pilih --</option>
                @foreach($jenis as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_layanan }}</option>
                @endforeach
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
