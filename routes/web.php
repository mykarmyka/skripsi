<?php

use Illuminate\Support\Facades\Route;
use App\HTTP\Controllers\Admin\AdminController;
use App\HTTP\Controllers\Admin\RekamMedisController;
use App\HTTP\Controllers\Admin\PasienController;

//route halaman utama
Route::get('/', function () {
    return view('admin/dashboard');
}); 

// Dashboard & Data
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/obat', [AdminController::class, 'dataObat'])->name('admin.obat');

// Kelola Pasien (ADMIN)
Route::get('/admin/pasien', [AdminController::class, 'dataPasien'])->name('admin.pasien');
Route::post('/admin/pasien', [PasienController::class, 'store'])->name('pasien.store');

// Obat
Route::post('/admin/obat', [ObatController::class, 'store'])->name('obat.store'); 

// Rekam Medis
Route::get('/admin/rekam-medis', [RekamMedisController::class, 'index'])->name('admin.rekam-medis');
Route::post('/admin/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam.store');