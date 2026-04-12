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

// --- Modul Direktori ---
Route::prefix('direktori')->group(function () {
    Route::get('/carian-ppp', [DirektoriController::class, 'index'])->name('direktori.carian_ppp.index');
    Route::get('/carian-ppp/hasil', [DirektoriController::class, 'hasil_carian'])->name('direktori.carian_ppp.hasil');
    Route::get('/carta-organisasi', function () { return view('direktori.carta-organisasi'); })->name('direktori.carta-organisasi');
});

// --- Modul Kompetensi (Public Search) ---
Route::prefix('kompetensi')->group(function () {
    Route::get('/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
    Route::get('/hasil-semakan', [KompetensiController::class, 'proses_semak_keputusan']);
    Route::get('/cetak/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak');
    Route::get('/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
    Route::post('/tempat/hasil', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_hasil');
});

// --- Modul PRPA & e-Rujukan (Public View) ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak_keputusan'); })->name('prpa.semak.borang');
Route::get('/prpa/hasil-keputusan', [PrpaController::class, 'proses_semak'])->name('prpa.semak.hasil');

Route::get('/credentialing', [CredentialingController::class, 'index'])->name('credentialing.index');
Route::get('/rujukan', [RujukanController::class, 'index'])->name('rujukan.index');

// --- Auth Routes ---
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

/*
|--------------------------------------------------------------------------
| 2. LALUAN WAJIB LOGIN (AUTH GROUP)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Profile logic
    Route::get('/user/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/home', function() { 
        return (auth()->user()->role == 'ADMIN') ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
    });

    // Modul PHCALS & PRPA Quiz
    Route::prefix('prpa')->group(function () {
        Route::get('/quiz/{id}', [PrpaController::class, 'startQuiz'])->name('prpa.quiz.start');
        Route::post('/quiz/submit', [PrpaController::class, 'submitQuiz'])->name('prpa.quiz.submit');
    });

    Route::prefix('phcals')->group(function () {
        Route::get('/exam', [PhcalsExamController::class, 'index'])->name('phcals.exam');
        Route::post('/submit', [PrpaController::class, 'submitQuiz'])->name('phcals.submit');
        Route::get('/history', [PrpaController::class, 'showHistory'])->name('phcals.history');
        Route::get('/review/{id}', [PrpaController::class, 'showReview'])->name('phcals.review');
        Route::get('/print/{id}', [PrpaController::class, 'printCertificate'])->name('phcals.print');
    });

    // Permohonan User
    Route::get('/kompetensi/permohonan', function () { return view('kompetensi.permohonan'); })->name('user.permohonan');
    Route::post('/kompetensi/hantar-permohonan', [KompetensiController::class, 'hantar_permohonan']);
    Route::match(['get', 'post'], '/kompetensi/hantar-emel', [KompetensiController::class, 'hantar_emel_penempatan'])->name('kompetensi.hantar_emel');

    /* --- 🔐 KHAS UNTUK ADMIN SAHAJA --- */
    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function() {
        
        Route::get('/dashboard', [KompetensiController::class, 'admin_dashboard'])->name('admin.dashboard');
        
        // Pengurusan User
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users/update-role/{id}', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
        Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // Pengurusan Kompetensi
        Route::get('/kompetensi/senarai-permohonan', [KompetensiController::class, 'admin_senarai_permohonan'])->name('admin.permohonan');
        Route::post('/permohonan/update-status', [KompetensiController::class, 'update_status_permohonan'])->name('admin.update_status');
        Route::get('/kompetensi/pengurusan', [KompetensiController::class, 'admin_index'])->name('admin.kompetensi.index');
        Route::post('/kompetensi/store', [KompetensiController::class, 'store']);
        Route::post('/kompetensi/update', [KompetensiController::class, 'update_calon']);
        Route::get('/kompetensi/delete/{id}', [KompetensiController::class, 'destroy']);

        // MASTER UPLOAD (Credentialing & Rujukan)
        // Ini adalah route berpusat yang kita bincangkan tadi
        Route::get('/document/upload', [CredentialingController::class, 'create'])->name('credentialing.create');
        Route::post('/document/store', [CredentialingController::class, 'store'])->name('admin.document.store');
        
        // Route pemadaman spesifik
        Route::get('/credentialing/delete/{id}', [CredentialingController::class, 'destroy'])->name('credentialing.destroy');
        Route::get('/rujukan/delete/{id}', [RujukanController::class, 'destroy'])->name('admin.rujukan.destroy');
    });
});