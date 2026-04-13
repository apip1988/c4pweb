<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - MASTER COPY AFIF (VERSI PULIHKAN SEMUA DATA)
|--------------------------------------------------------------------------
*/

// --- 1. UTAMA & DASHBOARD ---
Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard']);
Route::get('/hubungi', function () { return view('hubungi'); });

// --- 2. AUTHENTICATION ---
Auth::routes(); 
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// --- 3. e-KOMPETENSI (USER & SEMAKAN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan']);
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});

Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');
Route::get('/kompetensi/cetak-slip/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak_slip');

// --- 4. e-KOMPETENSI (ADMIN / PENGURUSAN CALON) ---
Route::middleware(['auth'])->group(function () {
    // Gunakan Controller asal supaya butang sahkan/kemaskini respon!
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});

// --- 5. e-PRPA ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');
Route::post('/prpa/hasil-semakan', function () { return "Hasil Semakan PRPA"; })->name('prpa.semak.hasil');

// --- 6. e-CREDENTIALING (FIX $disciplines ERROR) ---
Route::get('/credentialing', function () { 
    // Blade kau cari $disciplines, kita hantar collection kosong supaya tak error
    $disciplines = collect(); 
    return view('credentialing.index', compact('disciplines')); 
})->name('credentialing.index');

Route::get('/credentialing/create', function () { return view('credentialing.create'); })->name('credentialing.create');
Route::post('/credentialing/store', function () { return "Simpan Dokumen"; })->name('admin.document.store');
Route::delete('/credentialing/delete/{id}', function ($id) { return "Padam Dokumen"; })->name('credentialing.destroy');

// --- 7. e-RUJUKAN ---
Route::get('/rujukan', function () { 
    $stats = ['total'=>0, 'baru'=>0, 'arkib'=>0, 'spg'=>0, 'surat'=>0, 'guideline'=>0, 'minit'=>0, 'aktif'=>0];
    $results = collect(); 
    return view('rujukan.index', compact('stats', 'results')); 
})->name('rujukan.index');
Route::delete('/rujukan/delete/{id}', function ($id) { return "Padam Rujukan"; })->name('admin.rujukan.destroy');

// --- 8. ADMIN: PENGURUSAN PENGGUNA (FIX count() ERROR) ---
Route::get('/admin/users', function () { 
    $users = \App\Models\User::all(); 
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

// --- 9. DIREKTORI & PROFIL ---
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); });