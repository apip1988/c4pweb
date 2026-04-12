<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - MASTER COPY AFIF (FIX PRPA VIEW)
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
Route::get('password/reset', function() { return "Fungsi Reset Password Belum Aktif."; })->name('password.request');


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


// --- 4. e-KOMPETENSI (ADMIN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});


// --- 5. e-PRPA (PENYELAMAT VIEW ERROR) ---
Route::get('/prpa', function () { 
    return view('prpa.index'); 
})->name('prpa.index');

Route::get('/prpa/semak-keputusan', function () { 
    // CEK FAIL SEBELUM PAPAR: Supaya tak keluar error 'View Not Found'
    if (view()->exists('prpa.semak')) {
        return view('prpa.semak');
    }
    
    // Mesej bantuan kalau fail tak wujud
    return "<h3>Fail Tidak Dijumpai!</h3>
            <p>Sila pastikan fail wujud di: <b>resources/views/prpa/semak.blade.php</b></p>
            <p>Mungkin nama fail kau <i>semak_keputusan.blade.php</i>? Sila tukar nama fail tu jadi <b>semak.blade.php</b></p>";
})->name('prpa.semak.borang');


// --- 6. MENU DIREKTORI & LAIN-LAIN ---
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/rujukan', function () { return view('rujukan.index'); })->name('rujukan.index');
Route::get('/credentialing', function () { return view('credentialing.index'); })->name('credentialing.index');
Route::get('/credentialing/create', function () { return view('credentialing.create'); })->name('credentialing.create');
Route::get('/admin/users', function () { return view('admin.users.index'); })->name('admin.users.index');
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/profile', function () { return view('auth.profile'); });