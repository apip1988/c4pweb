<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes - SISTEM AMOPPP (VERSI PENGURUSAN DOKUMEN AFIF)
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
Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');

// --- 4. e-KOMPETENSI (ADMIN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});

// --- 5. PENGURUSAN DOKUMEN (ROUTE NAME: admin.document.store) ---
// Ini page yang kau hantar tu (credentialing/create.blade.php)
Route::get('/admin/credentialing/create', function () { 
    // Kita tetap hantar $senarai_stats sebab Header/Layout kau perlukan benda ni (Error baris 10)
    $senarai_stats = DB::table('statistik_utama')->get();
    return view('admin.credentialing.create', compact('senarai_stats')); 
})->name('admin.document.create');

// Proses Simpan Dokumen (Handle e-Credentialing & e-Rujukan)
Route::post('/admin/document/store', function (\Illuminate\Http\Request $request) {
    if ($request->module_type == 'CREDENTIALING') {
        // Logik simpan ke table credentialing_documents
        return "Simpan Credentialing Berjaya"; 
    } else {
        // Logik simpan ke table rujukans
        return "Simpan Rujukan Berjaya";
    }
})->name('admin.document.store');

// Route Delete (Asing ikut table macam koding kau)
Route::get('/credentialing/destroy/{id}', function ($id) {
    \App\CredentialingDocument::destroy($id);
    return back()->with('success', 'Dokumen Credentialing dipadam!');
})->name('credentialing.destroy');

Route::get('/rujukan/destroy/{id}', function ($id) {
    \App\Rujukan::destroy($id);
    return back()->with('success', 'Dokumen Rujukan dipadam!');
})->name('admin.rujukan.destroy');

// --- 6. ADMIN: PENGURUSAN PENGGUNA ---
Route::get('/admin/users', function () { 
    $users = \App\Models\User::all(); 
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

Route::post('/admin/users/update-role/{id}', function (\Illuminate\Http\Request $request, $id) {
    $user = \App\Models\User::find($id);
    if($user) { $user->role = $request->role; $user->save(); }
    return back()->with('success', 'Role dikemaskini!');
})->name('admin.users.updateRole');

Route::get('/admin/users/delete/{id}', function ($id) {
    $user = \App\Models\User::find($id);
    if($user) { $user->delete(); }
    return back()->with('success', 'Pengguna dipadam!');
})->name('admin.users.destroy');

// --- 7. LAIN-LAIN ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');
Route::get('/rujukan', function () { 
    $stats = ['total'=>0, 'baru'=>0, 'arkib'=>0, 'spg'=>0, 'surat'=>0, 'guideline'=>0, 'minit'=>0, 'aktif'=>0];
    $results = collect(); return view('rujukan.index', compact('stats', 'results')); 
})->name('rujukan.index');
Route::get('/credentialing', function () { 
    $disciplines = collect(); return view('credentialing.index', compact('disciplines')); 
})->name('credentialing.index');
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');

// Route Simpan Stats Dashboard (Action Baris 8 dlm snippet kau)
Route::post('/admin/profil/store', function (\Illuminate\Http\Request $request) {
    if($request->stats) {
        foreach ($request->stats as $kat => $jum) {
            DB::table('statistik_utama')->updateOrInsert(['kategori' => $kat], ['jumlah' => $jum]);
        }
    }
    return back()->with('success', 'Statistik dikemaskini!');
});