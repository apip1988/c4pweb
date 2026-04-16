<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\QuizData\Set1; // <-- PENTING: Untuk panggil soalan exam kau

/*
|--------------------------------------------------------------------------
| Web Routes - SISTEM AMOPPP (FULL RESTORE + START EXAM PRPA)
|--------------------------------------------------------------------------
*/

// --- 0. AUTHENTICATION ---
Auth::routes();

// --- 1. UTAMA ---
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');

// --- 2. LOGIN & LOGOUT ---
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// --- 3. e-KOMPETENSI (USER/CALON) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});

// Semakan (Tempat & Keputusan)
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

// --- 5. PENGURUSAN DOKUMEN ---
Route::get('/admin/credentialing/create', function () { 
    $senarai_stats = collect(); 
    $documents = DB::table('documents')->orderBy('created_at', 'desc')->get();
    return view('admin.credentialing.create', compact('senarai_stats', 'documents')); 
})->name('admin.dokumen.index');

Route::post('/admin/document/store', function (\Illuminate\Http\Request $request) {
    return back()->with('success', 'Dokumen berjaya dimuat naik!');
})->name('admin.document.store');

Route::post('/admin/profil/store', function (\Illuminate\Http\Request $request) {
    if($request->has('stats')) {
        foreach ($request->stats as $kategori => $jumlah) {
            DB::table('statistik_utama')->updateOrInsert(['kategori' => $kategori], ['jumlah' => $jumlah]);
        }
    }
    return back()->with('success', 'Statistik Dashboard berjaya disimpan!');
});

Route::get('/credentialing/destroy/{id}', function ($id) {
    return back()->with('success', 'Dokumen berjaya dipadam!');
})->name('credentialing.destroy');

Route::get('/admin/dokumen/delete/{id}', function ($id) {
    $doc = DB::table('documents')->where('id', $id)->first();
    if($doc) {
        $path = public_path('uploads/documents/' . $doc->file_path);
        if(file_exists($path)) { @unlink($path); }
        DB::table('documents')->where('id', $id)->delete();
    }
    return back()->with('success', 'Dokumen berjaya dipadam!');
})->name('admin.dokumen.delete');

// --- 6. ADMIN: PENGURUSAN PENGGUNA ---
Route::get('/admin/users', function () { 
    $users = class_exists('\App\Models\User') ? \App\Models\User::all() : \App\User::all();
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

Route::post('/admin/users/update-role/{id}', function (\Illuminate\Http\Request $request, $id) {
    $user = class_exists('\App\Models\User') ? \App\Models\User::find($id) : \App\User::find($id);
    if($user) { $user->role = $request->role; $user->save(); }
    return back()->with('success', 'Role dikemaskini!');
})->name('admin.users.updateRole');

Route::get('/admin/users/delete/{id}', function ($id) {
    $user = class_exists('\App\Models\User') ? \App\Models\User::find($id) : \App\User::find($id);
    if($user) { $user->delete(); }
    return back()->with('success', 'Pengguna dipadam!');
})->name('admin.users.destroy');

// --- 7. e-PRPA (QUIZ SYSTEM) ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');

// 7.1 MULA EXAM (FIXED)
Route::get('/prpa/start-exam', function () {
    $questions = Set1::questions(); // Ambil soalan dari fail App/QuizData/Set1.php
    return view('prpa.exam', compact('questions')); // Paparkan fail resources/views/prpa/exam.blade.php
})->name('prpa.start_exam');

// 7.2 HASIL SEMAKAN
Route::match(['get', 'post'], '/prpa/hasil-semakan', function (\Illuminate\Http\Request $request) {
    $ic = $request->input('ic'); 
    $results = DB::table('phcals_results')
                ->join('users', 'phcals_results.user_id', '=', 'users.id')
                ->where('users.ic_number', $ic)
                ->select('phcals_results.*', 'users.name')
                ->orderBy('phcals_results.attempt_date', 'desc')
                ->get();
    return view('phcals.history', compact('results'));
})->name('prpa.semak.hasil');

// --- 8. e-RUJUKAN & e-CREDENTIALING ---
Route::get('/rujukan', function () { 
    $stats = ['total'=>0, 'baru'=>0, 'arkib'=>0, 'spg'=>0, 'surat'=>0, 'guideline'=>0, 'minit'=>0, 'aktif'=>0];
    $results = collect(); return view('rujukan.index', compact('stats', 'results')); 
})->name('rujukan.index');

Route::get('/admin/rujukan/destroy/{id}', function ($id) {
    return back()->with('success', 'Rujukan dipadam!');
})->name('admin.rujukan.destroy');

Route::get('/credentialing', function () { 
    $disciplines = collect(); return view('credentialing.index', compact('disciplines')); 
})->name('credentialing.index');

// --- 9. DIREKTORI & PROFIL ---
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); })->name('direktori.carian');
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');