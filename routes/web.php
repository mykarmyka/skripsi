<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Mail\PendaftaranBerhasilMail;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\JenisLayananController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\User\PendaftaranController as UserPendaftaranController;
use App\Http\Controllers\User\ProfilController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;



// ROUTE HALAMAN UTAMA
Route::get('/', function () {
    
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }

    if (Auth::guard('pasien')->check()) {
        return redirect()->route('user.home');
    }

    // Default: Admin login dulu
    return redirect()->route('admin.login');
});



// ================= ADMIN =================
Route::prefix('admin')->name('admin.')->group(function () {

    // LOGIN ADMIN
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');

    // ROUTE ADMIN YANG SUDAH LOGIN
    Route::middleware(['auth:admin', 'role:bidan|staff'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Obat
        Route::get('/obat', [AdminController::class, 'dataObat'])->name('obat');
        Route::post('/obat', [ObatController::class, 'store'])->name('obat.store'); 

        // Pasien
        Route::get('/pasien', [PasienController::class, 'dataPasien'])->name('pasien');
        Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');

        // Layanan
        Route::get('/layanan', [AdminController::class, 'lihatPendaftaran'])->name('layanan');
        Route::get('/pendaftaran/{id}/update-status', [AdminController::class, 'updateStatus'])->name('updateStatus'); 
        Route::post('/pendaftaran/simpan', [AdminController::class, 'simpanPendaftaran'])->name('pendaftaran.simpan');
        Route::post('/pendaftaran/persalinan', [AdminPendaftaranController::class, 'simpanPersalinan'])->name('pendaftaran.persalinan');
        Route::post('/pendaftaran/{id}/rekam-medis', [AdminController::class, 'simpanRekamMedis'])->name('pendaftaran.simpanRekamMedis');

        //Jenis Layanan
        Route::get('/jenis-layanan', [JenisLayananController::class, 'index'])->name('jenis-layanan');
        Route::post('/jenis-layanan/store', [JenisLayananController::class, 'storeLayanan'])->name('jenis-layanan.store');
        Route::delete('/jenis-layanan/{id}', [JenisLayananController::class, 'destroyLayanan'])->name('jenis-layanan.destroy');

        // Rekam Medis
        Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis');
        Route::get('/rekam-medis/{id}/detail', [RekamMedisController::class, 'detail'])->name('rekam.detail');
        Route::post('/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam.store');
        Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('rekam-medis.destroy');
        
        // Laporan
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::post('/laporan/filter', [AdminController::class, 'filterLaporan'])->name('laporan.filter');
        Route::get('/laporan/ajax', [AdminController::class, 'ajax'])->name('laporan.ajax');
        Route::get('/laporan/pdf', [AdminController::class, 'pdf'])->name('laporan.pdf');



        // Logout
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});

// ================= PASIEN =================
Route::prefix('user')->name('user.')->group(function () {

    // LOGIN & REGISTER PASIEN
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // ROUTE PASIEN YANG SUDAH LOGIN
    Route::middleware('auth:pasien')->group(function () {
        Route::get('/home', [UserController::class, 'home'])->name('home');
        Route::get('/profil', [UserController::class, 'profil'])->name('profil');
        Route::post('/profil/update', [ProfilController::class, 'update'])->name('profilUpdate');
        Route::put('/profil', [UserController::class, 'updateProfil'])->name('updateProfil');
        Route::get('/riwayat', [UserController::class, 'riwayat'])->name('riwayat');


        // Pendaftaran Layanan
        Route::get('/pendaftaran', [UserController::class, 'formPendaftaran'])->name('pendaftaran');
        Route::post('/pendaftaran/simpan', [UserPendaftaranController::class, 'simpanPendaftaran'])->name('pendaftaran.simpan');
        Route::get('/pendaftaran-persalinan', [UserController::class, 'formPendaftaranPersalinan'])->name('pendaftaran-persalinan');
        Route::post('/pendaftaran-persalinan/simpan', [UserPendaftaranController::class, 'simpanPersalinan'])->name('pendaftaran-persalinan.simpan');
        Route::post('/pendaftaran/store', [UserPendaftaranController::class, 'store'])->name('pendaftaran.store');
        
    });
});





