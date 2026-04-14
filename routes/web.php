<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes - SISTEM AMOPPP (FIXED FOR CREDENTIALING & RUJUKAN)
|--------------------------------------------------------------------------
*/

// --- 1. UTAMA ---
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');

// --- 2. AUTHENTICATION ---
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// --- 3. e-KOMPETENSI ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');

// --- 4. PENGURUSAN DOKUMEN (PAGE YANG KAU BAGI TADI) ---
Route::get('/admin/credentialing/create', function () { 
    // Kita hantar $senarai_stats kosong untuk "diamkan" error kat layout/header kau
    $senarai_stats = collect(); 
    return view('admin.credentialing.create', compact('senarai_stats')); 
})->name('admin.document.create');

// Handle Form Muat Naik (Baris 33 dlm Blade kau)
Route::post('/admin/document/store', function (\Illuminate\Http\Request $request) {
    // Logik simpan fail kau letak sini ikut module_type
    return back()->with('success', 'Dokumen berjaya dimuat naik!');
})->name('admin.document.store');

// Handle Delete (Baris 131 & 157 dlm Blade kau)
Route::get('/credentialing/destroy/{id}', function ($id) {
    \App\CredentialingDocument::destroy($id);
    return back()->with('success', 'Dokumen Credentialing dipadam!');
})->name('credentialing.destroy');

Route::get('/admin/rujukan/destroy/{id}', function ($id) {
    \App\Rujukan::destroy($id);
    return back()->with('success', 'Fail rujukan dipadam!');
})->name('admin.rujukan.destroy');

// --- 5. ADMIN: PENGURUSAN PENGGUNA ---
Route::get('/admin/users', function () { 
    $users = \App\Models\User::all(); 
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

Route::get('/admin/users/delete/{id}', function ($id) {
    \App\Models\User::destroy($id);
    return back()->with('success', 'Pengguna dipadam!');
})->name('admin.users.destroy');

// --- 6. LAIN-LAIN ---
Route::get('/rujukan', function () { 
    return view('rujukan.index'); 
})->name('rujukan.index');
Route::get('/credentialing', function () { 
    return view('credentialing.index'); 
})->name('credentialing.index');
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');