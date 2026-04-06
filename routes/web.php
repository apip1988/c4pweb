<?php

use App\Http\Controllers\DirektoriController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PrpaController;
use App\Http\Controllers\PhcalsExamController; // Pastikan ini ada

/*
|--------------------------------------------------------------------------
| 1. LALUAN AWAM (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard']);
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');
Route::post('/hubungi/hantar', [KompetensiController::class, 'hantar_borang_hubungi'])->name('hubungi.hantar');

// --- Modul Direktori ---
Route::get('/direktori/carian-ppp', [DirektoriController::class, 'index'])->name('direktori.carian_ppp.index');
Route::get('/direktori/carian-ppp/hasil', [DirektoriController::class, 'hasil_carian'])->name('direktori.carian_ppp.hasil');
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta-organisasi'); })->name('direktori.carta-organisasi');

// --- Modul Kompetensi (Public) ---
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
Route::get('/kompetensi/hasil-semakan', [KompetensiController::class, 'proses_semak_keputusan']);
Route::get('/kompetensi/cetak/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak');
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
Route::post('/kompetensi/tempat/hasil', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_hasil');

// --- Modul PRPA (Public) ---
Route::get('/prpa', function () { return view('prpa.index'); });
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak_keputusan'); })->name('prpa.semak.borang');
Route::get('/prpa/hasil-keputusan', [PrpaController::class, 'proses_semak'])->name('prpa.semak.hasil');

// --- Auth Routes ---
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

/*
|--------------------------------------------------------------------------
| 2. LALUAN WAJIB LOGIN (AUTH GROUP) - SEMUA LETAK SINI
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
    
    // Dashboard & Profil
    Route::get('/user/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/home', function() { 
        return (auth()->user()->role == 'ADMIN') ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
    });

    // Modul PHCALS (Exam) - GABUNG SINI
    Route::get('/phcals/exam', [PhcalsExamController::class, 'index'])->name('phcals.exam');
    Route::post('/phcals/submit', [PhcalsExamController::class, 'submit'])->name('phcals.submit');
    Route::get('/phcals/history', [PhcalsExamController::class, 'history'])->name('phcals.history');
    Route::get('/phcals/review/{id}', [PhcalsExamController::class, 'review'])->name('phcals.review');

    // Modul Permohonan User
    Route::get('/kompetensi/permohonan', function () { return view('kompetensi.permohonan'); })->name('user.permohonan');
    Route::post('/kompetensi/hantar-permohonan', [KompetensiController::class, 'hantar_permohonan']);
    Route::match(['get', 'post'], '/kompetensi/hantar-emel', [KompetensiController::class, 'hantar_emel_penempatan'])->name('kompetensi.hantar_emel');

    /* --- KHAS UNTUK ADMIN --- */
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/dashboard', [KompetensiController::class, 'admin_dashboard'])->name('admin.dashboard');
        Route::get('/kompetensi/senarai-permohonan', [KompetensiController::class, 'admin_senarai_permohonan'])->name('admin.permohonan');
        Route::post('/permohonan/update-status', [KompetensiController::class, 'update_status_permohonan'])->name('admin.update_status');
        Route::get('/kompetensi/pengurusan', [KompetensiController::class, 'admin_index'])->name('admin.kompetensi.index');
        Route::post('/kompetensi/store', [KompetensiController::class, 'store']);
        Route::post('/kompetensi/update', [KompetensiController::class, 'update_calon']);
        Route::get('/kompetensi/delete/{id}', [KompetensiController::class, 'destroy']);
    });
});

//Credentialing//
// Cara BARU (Lebih Tepat)
Route::get('/credentialing', [App\Http\Controllers\CredentialingController::class, 'index'])->name('credentialing.index');