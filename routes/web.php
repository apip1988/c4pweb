<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - Master Copy Afif
|--------------------------------------------------------------------------
*/

// 1. LALUAN UTAMA & DASHBOARD
Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard']);
Route::get('/hubungi', function () { return view('hubungi'); });

// 2. LALUAN AUTHENTICATION (MANUAL)
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// 3. LALUAN E-KOMPETENSI (USER - MESTI LOGIN)
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan']);
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});

// 4. LALUAN SEMAKAN (AWAM / USER)
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat']);
Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index']);
Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');
Route::get('/kompetensi/cetak-slip/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak_slip');

// 5. LALUAN ADMIN (E-KOMPETENSI)
Route::middleware(['auth'])->group(function () {
    
    // Paparan Utama Pengurusan Calon
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon']);
    
    // Proses Sahkan Calon (ID dari button yang Afif tambah tadi)
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    
    // Proses Kemaskini Tempat Ujian
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    
    // Proses Kemaskini Keputusan Akhir
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    
    // Padam Rekod Calon
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});

// 6. DIREKTORI & MENU-MENU LAIN (SUPAYA TAK HILANG)
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');

// Route untuk e-Credentialing & lain-lain (jika ada)
Route::get('/credentialing', [App\Http\Controllers\CredentialingController::class, 'index'])->name('credentialing.index');
Route::get('/credentialing/create', [App\Http\Controllers\CredentialingController::class, 'create'])->name('credentialing.create');