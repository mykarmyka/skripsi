<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\PasienController;

use App\Http\Controllers\User\ProfilController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\PendaftaranController;
use App\Http\Controllers\User\UserController;


Route::get('/login', fn() => redirect()->route('user.login'))->name('login');

//route halaman utama
Route::get('/', [AdminController::class, 'dashboard']);

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Data
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/obat', [AdminController::class, 'dataObat'])->name('obat');
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store'); 

    // Kelola Pasien (ADMIN)
    Route::get('/pasien', [PasienController::class, 'dataPasien'])->name('pasien');
    Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');

    // Layanan
    Route::get('/layanan', [AdminController::class, 'lihatPendaftaran'])->name('layanan');

    // Rekam Medis
    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis');
    Route::post('/admin/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam.store');

    // Route (web.php)
    Route::post('/pendaftaran/{id}/update-status', [PendaftaranController::class, 'updateStatus'])->name('updateStatus');

});    



Route::prefix('user')->name('user.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:pasien')->group(function () {
        Route::get('/home', [UserController::class, 'home'])->name('home');
        Route::get('/profil', [UserController::class, 'profil'])->name('profil');
        Route::put('/profil', [UserController::class, 'updateProfil'])->name('updateProfil');
        Route::get('/pendaftaran', [UserController::class, 'formPendaftaran'])->name('pendaftaran');
        Route::post('/pendaftaran/simpan', [PendaftaranController::class, 'simpanPendaftaran'])->name('pendaftaran.simpan');
    });
});

// Home
Route::get('/user/home', [UserController::class, 'home'])->name('user.home');
Route::post('/user/pendaftaran/simpan', [PendaftaranController::class, 'simpanPendaftaran'])->name('user.pendaftaran.simpan');

// Pendaftaran
Route::get('/user/pendaftaran', [UserController::class, 'formPendaftaran'])->name('user.pendaftaran');

// Profil

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth:pasien'])->group(function () {
    Route::get('/user/profil', [ProfilController::class, 'index'])->name('user.profil');
    Route::post('/user/profil/update', [ProfilController::class, 'update'])->name('user.profil.update');
});