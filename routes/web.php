<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DirektoriController,
    KompetensiController,
    ProfileController,
    PrpaController,
    PhcalsExamController,
    CredentialingController,
    RujukanController,
    UserController
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController
};

/*
|--------------------------------------------------------------------------
| 1. LALUAN AWAM (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::get('/', [KompetensiController::class, 'index']);
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');
Route::post('/hubungi/hantar', [KompetensiController::class, 'hantar_borang_hubungi'])->name('hubungi.hantar');

// Modul Direktori
Route::prefix('direktori')->group(function () {
    Route::get('/carian-ppp', [DirektoriController::class, 'index'])->name('direktori.carian_ppp.index');
    Route::get('/carian-ppp/hasil', [DirektoriController::class, 'hasil_carian'])->name('direktori.carian_ppp.hasil');
    Route::get('/carta-organisasi', function () { return view('direktori.carta-organisasi'); })->name('direktori.carta-organisasi');
});

// Modul Kompetensi (Public Search)
Route::prefix('kompetensi')->group(function () {
    Route::get('/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
    Route::get('/hasil-semakan', [KompetensiController::class, 'proses_semak_keputusan']);
    Route::get('/cetak/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak');
    Route::get('/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
    Route::post('/tempat/hasil', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_hasil');
});

Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/credentialing', [CredentialingController::class, 'index'])->name('credentialing.index');
Route::get('/rujukan', [RujukanController::class, 'index'])->name('rujukan.index');

// Auth Routes
//Auth::routes(); // Menggunakan default Laravel Auth routes untuk simplify

/*
|--------------------------------------------------------------------------
| 2. LALUAN WAJIB LOGIN (AUTH GROUP)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Profile
    Route::get('/user/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/home', function() { 
        return (auth()->user()->role == 'ADMIN') ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
    });

    // Permohonan User (Kompetensi)
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('user.permohonan');
    Route::post('/kompetensi/hantar-permohonan', [KompetensiController::class, 'hantar_permohonan']);

    /* --- 🔐 KHAS UNTUK ADMIN SAHAJA --- */
    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function() {
        
        Route::get('/dashboard', [KompetensiController::class, 'admin_dashboard'])->name('admin.dashboard');
        
        // --- PENGURUSAN CALON KOMPETENSI (ALIRAN BARU) ---
        // Page Utama Pengurusan Calon (Ada 4 Table tu)
        Route::get('/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('admin.kompetensi.pengurusan');
        
        // Proses Aliran 1: Sahkan Permohonan (Bulk)
        Route::post('/kompetensi/sahkan-permohonan', [KompetensiController::class, 'sahkan_permohonan']);
        
        // Proses Aliran 2: Kemaskini Tempat & Kelayakan (Bulk)
        Route::post('/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan']);
        
        // Proses Aliran 3: Kemaskini Keputusan Akhir (Bulk)
        Route::post('/kompetensi/kemaskini-keputusan-akhir', [KompetensiController::class, 'kemaskini_keputusan_akhir']);
        
        // Padam Rekod
        Route::get('/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('admin.kompetensi.destroy');


        // Pengurusan User
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users/update-role/{id}', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
        Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // MASTER UPLOAD (Credentialing & Rujukan)
        Route::get('/document/upload', [CredentialingController::class, 'create'])->name('credentialing.create');
        Route::post('/document/store', [CredentialingController::class, 'store'])->name('admin.document.store');
        Route::get('/credentialing/delete/{id}', [CredentialingController::class, 'destroy'])->name('credentialing.destroy');
        Route::get('/rujukan/delete/{id}', [RujukanController::class, 'destroy'])->name('admin.rujukan.destroy');
    });
});