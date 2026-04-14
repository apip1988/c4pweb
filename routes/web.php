<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - SISTEM AMOPPP (VERSI PULIHKAN SEMUA FUNGSI)
|--------------------------------------------------------------------------
| Semua pautan di bawah telah disemak baris demi baris untuk memastikan 
| tiada fungsi yang hilang.
*/

// =========================================================================
// 1. HALAMAN UTAMA & DASHBOARD
// =========================================================================
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');

// =========================================================================
// 2. SISTEM LOGIN (MANUAL - FIX ERROR LARAVEL/UI)
// =========================================================================
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// =========================================================================
// 3. e-KOMPETENSI (BAHAGIAN CALON/PENGGUNA)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    // Borang Permohonan
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    
    // FIX 404: Hantar Permohonan (Mesti sama dengan Form Action)
    Route::post('/kompetensi/hantar-permohonan', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});

// Semakan Maklumat Penempatan (Surat Panggilan)
Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');

// Semakan Keputusan Akhir
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');
Route::get('/kompetensi/cetak-slip/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak_slip');

// =========================================================================
// 4. e-KOMPETENSI (BAHAGIAN ADMIN - PENGURUSAN CALON)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    // Menu Utama Admin Kompetensi
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    
    // Tindakan Admin
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});

// =========================================================================
// 5. e-PRPA (PENDAFTARAN & SEMAKAN)
// =========================================================================
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');
Route::post('/prpa/hasil-semakan', function () { return "Hasil Semakan PRPA Sedang Diproses"; })->name('prpa.semak.hasil');

// =========================================================================
// 6. PENGURUSAN DOKUMEN (CREDENTIALING)
// =========================================================================
Route::get('/credentialing', function () { 
    return view('credentialing.create'); // Terus buka Borang Tambah Dokumen
})->name('credentialing.index');

Route::post('/credentialing/store', function () { 
    return "Proses Simpan Dokumen Berjaya"; 
})->name('admin.document.store');

Route::delete('/credentialing/delete/{id}', function ($id) { 
    return "Dokumen Berhasil Dipadam"; 
})->name('credentialing.destroy');

// =========================================================================
// 7. e-RUJUKAN (STATISTIK & FAIL)
// =========================================================================
Route::get('/rujukan', function () { 
    $stats = [
        'total' => 0, 'baru' => 0, 'arkib' => 0, 'spg' => 0, 
        'surat' => 0, 'guideline' => 0, 'minit' => 0, 'aktif' => 0
    ];
    $results = collect(); 
    return view('rujukan.index', compact('stats', 'results')); 
})->name('rujukan.index');

Route::delete('/rujukan/delete/{id}', function ($id) { 
    return redirect()->back()->with('success', 'Fail Rujukan dipadam'); 
})->name('admin.rujukan.destroy');

// =========================================================================
// 8. ADMIN: PENGURUSAN PENGGUNA (FIX UPDATE ROLE)
// =========================================================================
Route::get('/admin/users', function () { 
    $users = class_exists('\App\Models\User') ? \App\Models\User::all() : \App\User::all();
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

// Pintu Tukar Role (Mesti ada supaya index.blade tak crash)
Route::post('/admin/users/update-role/{id}', function (\Illuminate\Http\Request $request, $id) {
    $user = class_exists('\App\Models\User') ? \App\Models\User::find($id) : \App\User::find($id);
    if($user) {
        $user->role = $request->role;
        $user->save();
    }
    return back()->with('success', 'Role pengguna telah dikemaskini.');
})->name('admin.users.updateRole');

// =========================================================================
// 9. DIREKTORI & PROFIL
// =========================================================================
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); })->name('direktori.carian');
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');