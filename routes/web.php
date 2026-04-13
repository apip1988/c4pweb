<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - MASTER COPY AFIF (FIX TOTAL ARRAY KEYS)
|--------------------------------------------------------------------------
*/

// --- 1. UTAMA & DASHBOARD ---
Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard']);
Route::get('/hubungi', function () { return view('hubungi'); });


// --- 2. AUTHENTICATION (LOGIN, REGISTER, LOGOUT) ---
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', function() { return "Fungsi Reset Belum Aktif."; })->name('password.request');


// --- 3. e-KOMPETENSI (USER & PROSES DAFTAR) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan']);
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});


// --- 4. SEMAKAN e-KOMPETENSI ---
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');
Route::get('/kompetensi/cetak-slip/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak_slip');


// --- 5. e-KOMPETENSI (ADMIN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});


// --- 6. e-PRPA ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');
Route::post('/prpa/hasil-semakan', function () { return "Paparan Hasil PRPA"; })->name('prpa.semak.hasil');


// --- 7. e-CREDENTIALING ---
Route::get('/credentialing', function () { return view('credentialing.index'); })->name('credentialing.index');
Route::get('/credentialing/create', function () { return view('credentialing.create'); })->name('credentialing.create');
Route::post('/credentialing/store', function () { return "Proses simpan"; })->name('admin.document.store');
Route::delete('/credentialing/delete/{id}', function ($id) { return "Padam ID: ".$id; })->name('credentialing.destroy');


// --- 8. MENU LAIN-LAIN (FIX RUJUKAN STATS LENGKAP) ---
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');

// KEMASKINI RUJUKAN: Aku tambah 'spg' dan lain-lain supaya tak Undefined Array Key
Route::get('/rujukan', function () { 
    $stats = [
        'total' => 0,
        'baru' => 0,
        'arkib' => 0,
        'spg' => 0,    // INI YANG KAU KENA TADI
        'aktif' => 0
    ];
    return view('rujukan.index', compact('stats')); 
})->name('rujukan.index');

Route::delete('/rujukan/delete/{id}', function ($id) { 
    return "Proses padam rujukan ID: ".$id; 
})->name('admin.rujukan.destroy');

Route::get('/admin/users', function () { return view('admin.users.index'); })->name('admin.users.index');
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/profile', function () { return view('auth.profile'); });