<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// --- 1. UTAMA & LOGIN ---
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');

// Auth Routes (Login, Logout, Reset)
Auth::routes(); 

// --- 2. MODUL e-KOMPETENSI (CALON) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
    Route::get('/kompetensi/tempat', [KompetensiController::class, 'halaman_semak_tempat'])->name('kompetensi.tempat');
    Route::post('/kompetensi/proses-semak-tempat', [KompetensiController::class, 'proses_semak_tempat'])->name('kompetensi.proses_semak_tempat');
    Route::get('/kompetensi/semak', [KompetensiController::class, 'user_index'])->name('kompetensi.semak');
    Route::post('/kompetensi/proses-semak', [KompetensiController::class, 'proses_semak_keputusan'])->name('kompetensi.proses_semak');
    Route::get('/kompetensi/cetak-slip/{ic}', [KompetensiController::class, 'cetak_slip'])->name('kompetensi.cetak_slip');
});

// --- 3. MODUL PENGURUSAN DOKUMEN (FIXED: PAGE CREATE KAU) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/credentialing/create', function () { 
        // Untuk "diamkan" ralat Lelaki/Perempuan kat Layout/Header kau
        $senarai_stats = collect(); 
        return view('admin.credentialing.create', compact('senarai_stats')); 
    })->name('admin.document.create');

    // Route name yang dipanggil dlm Blade create.blade.php kau
    Route::post('/admin/document/store', [KompetensiController::class, 'simpan_dokumen'])->name('admin.document.store');
    
    // Route Delete ikut Model dlm Blade kau
    Route::get('/credentialing/destroy/{id}', function ($id) {
        \App\CredentialingDocument::destroy($id);
        return back()->with('success', 'Dokumen dipadam!');
    })->name('credentialing.destroy');

    Route::get('/admin/rujukan/destroy/{id}', function ($id) {
        \App\Rujukan::destroy($id);
        return back()->with('success', 'Fail rujukan dipadam!');
    })->name('admin.rujukan.destroy');
});

// --- 4. MODUL ADMIN (PENGURUSAN CALON & PENGGUNA) ---
Route::middleware(['auth'])->group(function () {
    // Pengurusan Calon
    Route::get('/admin/kompetensi/pengurusan-calon', [KompetensiController::class, 'admin_pengurusan_calon'])->name('kompetensi.admin_pengurusan');
    Route::post('/admin/kompetensi/sahkan', [KompetensiController::class, 'sahkan_permohonan'])->name('kompetensi.sahkan');
    Route::post('/admin/kompetensi/kemaskini-penempatan', [KompetensiController::class, 'kemaskini_penempatan'])->name('kompetensi.kemaskini_penempatan');
    Route::post('/admin/kompetensi/kemaskini-keputusan', [KompetensiController::class, 'kemaskini_keputusan_akhir'])->name('kompetensi.kemaskini_keputusan');
    Route::delete('/admin/kompetensi/delete/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');

    // Pengurusan Pengguna (Guna Model \App\Models\User)
    Route::get('/admin/users', function () { 
        $users = \App\Models\User::all(); 
        return view('admin.users.index', compact('users')); 
    })->name('admin.users.index');
    Route::get('/admin/users/delete/{id}', function ($id) {
        \App\Models\User::destroy($id);
        return back()->with('success', 'Pengguna dipadam!');
    })->name('admin.users.destroy');
});

// --- 5. e-PRPA, e-RUJUKAN, e-CREDENTIALING (INDEX) ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');
Route::get('/rujukan', function () { return view('rujukan.index'); })->name('rujukan.index');
Route::get('/credentialing', function () { return view('credentialing.index'); })->name('credentialing.index');

// --- 6. DIREKTORI & PROFIL ---
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); });
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');

// Handle form statistik dashboard (Kalau page tu perlukan)
Route::post('/admin/profil/store', function (\Illuminate\Http\Request $request) {
    if($request->stats) {
        foreach ($request->stats as $kat => $jum) {
            DB::table('statistik_utama')->updateOrInsert(['kategori' => $kat], ['jumlah' => $jum]);
        }
    }
    return back()->with('success', 'Statistik dikemaskini!');
});