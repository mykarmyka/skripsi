@extends('layouts.main')

@section('content')

    <!-- Main Content -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-xl font-semibold mb-2">Dashboard</h2>
    <p class="mb-6 text-gray-700">Selamat Datang di Website Klinik</p>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2" placeholder="Search" style="width: 200px;">
                    <span class="me-2">Hello, Admin</span>
                    <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                </div>
            </div>

    <div class="grid grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-5 rounded shadow">
            <div class="text-2xl font-bold">0</div>
            <p class="text-gray-600">Jumlah Pasien</p>
        </div>
        <div class="bg-white p-5 rounded shadow">
            <div class="text-2xl font-bold">0</div>
            <p class="text-gray-600">Jumlah Layanan</p>
        </div>
        <div class="bg-white p-5 rounded shadow">
            <div class="text-2xl font-bold">0</div>
            <p class="text-gray-600">Antrian Pasien</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Data Riwayat Rekam Medis</h3>
        <input type="text" placeholder="Search..." class="mb-3 border rounded px-2 py-1">
        <table class="w-full border text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Tanggal Periksa</th>
                    <th class="p-2 border">Layanan</th>
                    <th class="p-2 border">Nama Pasien</th>
                    <th class="p-2 border">Keluhan</th>
                    <th class="p-2 border">Diagnosa</th>
                    <th class="p-2 border">Tindakan</th>
                    <th class="p-2 border">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2 border text-center" colspan="7">No data available in table</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
