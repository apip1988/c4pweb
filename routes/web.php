<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - Master Copy Afif (VERSI PALING STABIL)
|--------------------------------------------------------------------------
*/

// --- 1. LALUAN UTAMA, DASHBOARD & HUBUNGI ---
Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard']);
Route::get('/hubungi', function () { return view('hubungi'); });


// --- 2. LALUAN AUTHENTICATION (LOG MASUK / KELUAR) ---
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// PENYELAMAT: Route ini untuk elakkan error 'password.request' & 'register' not defined dalam page Login
Route::get('password/reset', function() { return "Fungsi Reset Password Belum Aktif."; })->name('password.request');
Route::get('register', function() { return "Sila hubungi Admin untuk pendaftaran."; })->name('register');


// --- 3. LALUAN E-KOMPETENSI (USER - PERLU LOGIN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan']);
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});


// --- 4. LALUAN SEMAKAN & CETAK SLIP (AWAM / USER) ---
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat']);
Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index']);
Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');
Route::get('/kompetensi/cetak-slip/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak_slip');


// --- 5. LALUAN ADMIN E-KOMPETENSI (PENGURUSAN CALON) ---
Route::middleware(['auth'])->group(function () {
    // Paparan Utama
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon']);
    
    // Proses Sahkan, Tempat & Keputusan
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    
    // Padam Rekod
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});


// --- 6. DIREKTORI, RUJUKAN & PENGURUSAN PENGGUNA ---
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');

// Route e-Rujukan
Route::get('/rujukan', function () { return view('rujukan.index'); })->name('rujukan.index');

// Route e-Credentialing
Route::get('/credentialing', function () { return view('credentialing.index'); })->name('credentialing.index');
Route::get('/credentialing/create', function () { return view('credentialing.create'); })->name('credentialing.create');

// Route Pengurusan Pengguna (Admin)
Route::get('/admin/users', function () { return view('admin.users.index'); })->name('admin.users.index');
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/profile', function () { return view('auth.profile'); });