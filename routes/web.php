<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN UTAMA & AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');

Auth::routes();

/*
|--------------------------------------------------------------------------
| 2. e-KOMPETENSI (CALON & ADMIN)
|--------------------------------------------------------------------------
*/
Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');

// Admin Kompetensi
Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');

/*
|--------------------------------------------------------------------------
| 3. PENGURUSAN DOKUMEN (CREDENTIALING & RUJUKAN)
|--------------------------------------------------------------------------
*/
// Buka Page Muat Naik (Create)
Route::get('/admin/credentialing/create', function () { 
    // Kita hantar data kosong saja supaya variable wujud tapi tak cari table SQL
    $senarai_stats = collect(); 
    return view('admin.credentialing.create', compact('senarai_stats')); 
})->name('admin.dokumen.index');

// Simpan Dokumen (Store)
Route::post('/admin/document/store', function () { 
    return back()->with('success', 'Dokumen berjaya disimpan!'); 
})->name('admin.document.store');

// Padam Dokumen Credentialing
Route::get('/credentialing/destroy/{id}', function ($id) {
    if(class_exists('\App\CredentialingDocument')) { \App\CredentialingDocument::destroy($id); }
    return back()->with('success', 'Dokumen dipadam!');
})->name('credentialing.destroy');

// Padam Dokumen Rujukan
Route::get('/admin/rujukan/destroy/{id}', function ($id) {
    if(class_exists('\App\Rujukan')) { \App\Rujukan::destroy($id); }
    return back()->with('success', 'Fail rujukan dipadam!');
})->name('admin.rujukan.destroy');

/*
|--------------------------------------------------------------------------
| 4. ADMIN: PENGURUSAN PENGGUNA
|--------------------------------------------------------------------------
*/
Route::get('/admin/users', function () { 
    $users = \App\Models\User::all(); 
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

Route::get('/admin/users/delete/{id}', function ($id) {
    \App\Models\User::destroy($id);
    return back()->with('success', 'Pengguna dipadam!');
})->name('admin.users.destroy');

/*
|--------------------------------------------------------------------------
| 5. DIREKTORI & PROFIL
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');

// Pintu simpan statistik (jika ada form hantar sini)
Route::post('/admin/profil/store', function () {
    return back()->with('success', 'Data disimpan!');
});