<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - MASTER COPY AFIF (FIX 404 HANTAR BORANG)
|--------------------------------------------------------------------------
*/

// --- 1. UTAMA ---
Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard']);

// --- 2. AUTHENTICATION MANUAL ---
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// --- 3. e-KOMPETENSI (USER: BORANG & SEMAKAN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan']);
    
    // FIX 404: Pautan ini mesti sama dengan form action borang kau
    Route::post('/kompetensi/hantar-permohonan', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});

// Semakan Tempat & Keputusan
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');

// --- 4. e-KOMPETENSI (ADMIN: PENGURUSAN CALON) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});

// --- 5. PENGURUSAN DOKUMEN ---
Route::get('/credentialing', function () { return view('credentialing.create'); })->name('credentialing.index');

// --- 6. PENGURUSAN PENGGUNA ---
Route::get('/admin/users', function () { 
    $users = class_exists('\App\Models\User') ? \App\Models\User::all() : \App\User::all();
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

Route::post('/admin/users/update-role/{id}', function (\Illuminate\Http\Request $request, $id) {
    $user = class_exists('\App\Models\User') ? \App\Models\User::find($id) : \App\User::find($id);
    if($user) { $user->role = $request->role; $user->save(); }
    return back()->with('success', 'Role dikemaskini!');
})->name('admin.users.updateRole');

// --- 7. LAIN-LAIN ---
Route::get('/rujukan', function () { 
    $stats = ['total'=>0, 'baru'=>0, 'arkib'=>0, 'spg'=>0, 'surat'=>0, 'guideline'=>0, 'minit'=>0, 'aktif'=>0];
    $results = collect(); return view('rujukan.index', compact('stats', 'results')); 
})->name('rujukan.index');
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/profile', function () { return view('auth.profile'); });
Route::get('/hubungi', function () { return view('hubungi'); });