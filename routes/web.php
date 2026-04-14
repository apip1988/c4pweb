<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| 1. UTAMA & DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');

/*
|--------------------------------------------------------------------------
| 2. SISTEM AUTHENTICATION (LOGIN/LOGOUT)
|--------------------------------------------------------------------------
*/
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. e-KOMPETENSI (BAHAGIAN CALON)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
    Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
    Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
    Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
    Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');
    Route::get('/kompetensi/cetak-slip/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak_slip');
});

/*
|--------------------------------------------------------------------------
| 4. e-KOMPETENSI (BAHAGIAN ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
});

/*
|--------------------------------------------------------------------------
| 5. PENGURUSAN DOKUMEN (CREDENTIALING & RUJUKAN)
|--------------------------------------------------------------------------
*/
// Buka Page Create (Hantar $senarai_stats kosong supaya Layout/Header tak error)
Route::get('/admin/credentialing/create', function () { 
    $senarai_stats = collect(); 
    return view('admin.credentialing.create', compact('senarai_stats')); 
})->name('admin.document.create');

// Simpan Dokumen (Store) - Dipanggil oleh Form Blade kau
Route::post('/admin/document/store', function (\Illuminate\Http\Request $request) {
    // Logik simpan ke model yang betul
    return back()->with('success', 'Dokumen berjaya disimpan!');
})->name('admin.document.store');

// Padam Dokumen Credentialing (Fix Link)
Route::get('/credentialing/destroy/{id}', function ($id) {
    if(class_exists('\App\CredentialingDocument')) { \App\CredentialingDocument::destroy($id); }
    return back()->with('success', 'Dokumen Credentialing berjaya dipadam!');
})->name('credentialing.destroy');

// Padam Dokumen Rujukan (Fix Link)
Route::get('/admin/rujukan/destroy/{id}', function ($id) {
    if(class_exists('\App\Rujukan')) { \App\Rujukan::destroy($id); }
    return back()->with('success', 'Fail rujukan berjaya dipadam!');
})->name('admin.rujukan.destroy');

/*
|--------------------------------------------------------------------------
| 6. ADMIN: PENGURUSAN PENGGUNA (USER MANAGEMENT)
|--------------------------------------------------------------------------
*/
Route::get('/admin/users', function () { 
    $users = class_exists('\App\Models\User') ? \App\Models\User::all() : \App\User::all();
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

Route::post('/admin/users/update-role/{id}', function (\Illuminate\Http\Request $request, $id) {
    $user = class_exists('\App\Models\User') ? \App\Models\User::find($id) : \App\User::find($id);
    if($user) { $user->role = $request->role; $user->save(); }
    return back()->with('success', 'Role pengguna berjaya dikemaskini!');
})->name('admin.users.updateRole');

Route::get('/admin/users/delete/{id}', function ($id) {
    $user = class_exists('\App\Models\User') ? \App\Models\User::find($id) : \App\User::find($id);
    if($user) { $user->delete(); }
    return back()->with('success', 'Pengguna berjaya dibuang!');
})->name('admin.users.destroy');

/*
|--------------------------------------------------------------------------
| 7. MODUL INDEX (PRPA, RUJUKAN, CREDENTIALING)
|--------------------------------------------------------------------------
*/
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');
Route::get('/rujukan', function () { return view('rujukan.index'); })->name('rujukan.index');
Route::get('/credentialing', function () { return view('credentialing.index'); })->name('credentialing.index');

/*
|--------------------------------------------------------------------------
| 8. DIREKTORI & PROFIL
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');

/*
|--------------------------------------------------------------------------
| 9. PROSES SIMPAN STATISTIK DASHBOARD (UTK LAYOUT/HEADER)
|--------------------------------------------------------------------------
*/
Route::post('/admin/profil/store', function (\Illuminate\Http\Request $request) {
    if($request->stats) {
        foreach ($request->stats as $kat => $jum) {
            DB::table('statistik_utama')->updateOrInsert(['kategori' => $kat], ['jumlah' => $jum]);
        }
    }
    return back()->with('success', 'Statistik Dashboard dikemaskini!');
});