<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;

use App\Http\Controllers\User\ProfilController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\PendaftaranController;
use App\Http\Controllers\User\UserController;


Route::get('/', fn() => redirect()->route('user.login'));

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Data
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/obat', [AdminController::class, 'dataObat'])->name('obat');
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store'); 

    // Kelola Pasien (ADMIN)
    Route::get('/pasien', [PasienController::class, 'dataPasien'])->name('pasien');
    Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien', [PasienController::class, 'pencarian'])->name('pasien');

    // Layanan
    Route::get('/layanan', [AdminController::class, 'lihatPendaftaran'])->name('layanan');

    // Rekam Medis
    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis');
    Route::post('/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam.store');
    Route::get('/rekam-medis', [RekamMedisController::class, 'pencarian'])->name('rekam-medis');

    // Route (web.php)
    Route::post('/pendaftaran/{id}/update-status', [PendaftaranController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');


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
        Route::post('/profil/update', [ProfilController::class, 'update'])->name('profilUpdate');
        Route::put('/profil', [UserController::class, 'updateProfil'])->name('updateProfil');
        Route::get('/pendaftaran', [UserController::class, 'formPendaftaran'])->name('pendaftaran');
        Route::post('/pendaftaran/simpan', [PendaftaranController::class, 'simpanPendaftaran'])
        ->middleware('auth:pasien')
        ->name('pendaftaran.simpan');
        
    });
});


