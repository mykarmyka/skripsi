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

use App\Http\Controllers\User\UserController;

// Home
Route::get('/user/home', [UserController::class, 'home'])->name('user.home');
Route::post('/user/pendaftaran/simpan', [UserController::class, 'simpanPendaftaran'])->name('user.pendaftaran.simpan');

// Pendaftaran
Route::get('/user/pendaftaran', [UserController::class, 'formPendaftaran'])->name('user.pendaftaran');

// Profil
Route::get('/user/profil', function () {
    return view('user.profil'); })->name('user.profil');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
