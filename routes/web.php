<?php

use App\Http\Controllers\DirektoriController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| 1. LALUAN AWAM (PUBLIC) - Boleh diakses tanpa login
|--------------------------------------------------------------------------
*/
Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard']);

// --- Modul Direktori ---
Route::get('/direktori/carian-ppp', [DirektoriController::class, 'index'])->name('direktori.carian_ppp.index');
Route::get('/direktori/carian-ppp/hasil', [DirektoriController::class, 'hasil_carian'])->name('direktori.carian_ppp.hasil');
Route::get('/direktori/carta-organisasi', function () { 
    return view('direktori.carta-organisasi'); 
})->name('direktori.carta-organisasi');

// --- MODUL SEMAKAN ---
// Semak Keputusan
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
Route::get('/kompetensi/hasil-semakan', [KompetensiController::class, 'proses_semak_keputusan']);
Route::get('/kompetensi/cetak/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak');

// --- SEMAK TEMPAT UJIAN (PAKSA MATCH) ---
// Pastikan baris ini ada dalam web.php Afif
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');

// Baris untuk hasil carian
Route::post('/kompetensi/tempat/hasil', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_hasil');

Route::get('/hubungi', function () {
    return view('hubungi');
})->name('hubungi');

// Route untuk proses hantar borang hubungi
Route::post('/hubungi/hantar', [KompetensiController::class, 'hantar_borang_hubungi'])->name('hubungi.hantar');

// Auth routes manual replacement for Laravel 12
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
| 2. LALUAN WAJIB LOGIN (USER & ADMIN)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
    
    // Dashboard & Profil
    Route::get('/user/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('/profile', 'ProfileController@index')->name('profile');

    // Modul Permohonan User
    Route::get('/kompetensi/permohonan', function () { return view('kompetensi.permohonan'); })->name('user.permohonan');
    Route::post('/kompetensi/hantar-permohonan', [KompetensiController::class, 'hantar_permohonan']);

    // --- HANTAR EMEL (PAKSA MATCH) ---
    // Gunakan match supaya kalau klik link <a> (GET) atau Form (POST) pun dia jalan
    Route::match(['get', 'post'], '/kompetensi/hantar-emel', [KompetensiController::class, 'hantar_emel_penempatan'])->name('kompetensi.hantar_emel');

    /* --- KHAS UNTUK ADMIN --- */
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role != 'ADMIN') {
            return redirect('/')->with('error', 'Akses Terhad!');
        }
        return app('App\Http\Controllers\KompetensiController')->admin_dashboard();
    })->name('admin.dashboard');

    // Prefik Admin untuk Urusetia
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/kompetensi/senarai-permohonan', [KompetensiController::class, 'admin_senarai_permohonan'])->name('admin.permohonan');
        Route::post('/permohonan/update-status', [KompetensiController::class, 'update_status_permohonan'])->name('admin.update_status');
        Route::get('/kompetensi/pengurusan', [KompetensiController::class, 'admin_index'])->name('admin.kompetensi.index');
        Route::post('/kompetensi/store', [KompetensiController::class, 'store']);
        Route::post('/kompetensi/update', [KompetensiController::class, 'update_calon']);
        Route::get('/kompetensi/delete/{id}', [KompetensiController::class, 'destroy']);
        Route::get('/kpi', function() { return "Modul E-KPI Dalam Pembinaan"; })->name('admin.kpi');
        Route::get('/ebook', function() { return "Modul E-Book Dalam Pembinaan"; })->name('admin.ebook');
    });
});

/*
|--------------------------------------------------------------------------
| 3. REDIRECT HOME
|--------------------------------------------------------------------------
*/
Route::get('/home', function() { 
    if (auth()->check() && auth()->user()->role == 'ADMIN') {
        return redirect()->route('admin.dashboard'); 
    }
    return redirect()->route('user.dashboard');
});
/*
|-----------------------------------------------------------------------------
|4. PRPA
|------------------------------------------------------------------------------
*/
Route::get('/prpa', function () {
    return view('prpa.index');
});