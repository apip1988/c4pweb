<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes - SISTEM AMOPPP (VERSI FULL: DOKUMEN + UPLOAD + DELETE)
|--------------------------------------------------------------------------
*/

// --- 1. UTAMA ---
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');

// --- 2. AUTHENTICATION ---
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// --- 3. e-KOMPETENSI (USER/CALON) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});
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

// --- 5. PENGURUSAN DOKUMEN (FULL FUNCTION: VIEW, UPLOAD, DELETE) ---
Route::get('/admin/credentialing/create', function () { 
    // Ambil stats untuk dashboard kecil kat atas
    $senarai_stats = DB::table('statistik_utama')->get();
    
    // Ambil senarai dokumen SPG/Credentialing yang dah diupload
    $documents = DB::table('documents')->orderBy('created_at', 'desc')->get();
    
    return view('admin.credentialing.create', compact('senarai_stats', 'documents')); 
})->name('admin.dokumen.index');

// Proses Muat Naik Dokumen
Route::post('/admin/dokumen/upload', function (\Illuminate\Http\Request $request) {
    $request->validate(['file' => 'required|mimes:pdf,doc,docx,jpg,png|max:5048']);
    
    if($request->hasFile('file')) {
        $fileName = time().'_'.$request->file->getClientOriginalName();
        $request->file->move(public_path('uploads/documents'), $fileName);
        
        DB::table('documents')->insert([
            'title' => $request->title ?? $fileName,
            'file_path' => $fileName,
            'category' => $request->category ?? 'UMUM',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    return back()->with('success', 'Dokumen berjaya dimuat naik!');
})->name('admin.dokumen.upload');

// Proses Padam Dokumen
Route::get('/admin/dokumen/delete/{id}', function ($id) {
    $doc = DB::table('documents')->where('id', $id)->first();
    if($doc) {
        $path = public_path('uploads/documents/' . $doc->file_path);
        if(file_exists($path)) { @unlink($path); }
        DB::table('documents')->where('id', $id)->delete();
    }
    return back()->with('success', 'Dokumen berjaya dipadam!');
})->name('admin.dokumen.delete');

// Simpan Stats Dashboard
Route::post('/admin/profil/store', function (\Illuminate\Http\Request $request) {
    foreach ($request->stats as $kategori => $jumlah) {
        DB::table('statistik_utama')->updateOrInsert(['kategori' => $kategori], ['jumlah' => $jumlah]);
    }
    return back()->with('success', 'Statistik dikemaskini!');
});

// --- 6. e-PRPA & e-RUJUKAN ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');
Route::get('/rujukan', function () { 
    $stats = ['total'=>0, 'baru'=>0, 'arkib'=>0, 'spg'=>0, 'surat'=>0, 'guideline'=>0, 'minit'=>0, 'aktif'=>0];
    $results = collect(); return view('rujukan.index', compact('stats', 'results')); 
})->name('rujukan.index');

// --- 7. e-CREDENTIALING ---
Route::get('/credentialing', function () { 
    $disciplines = collect(); return view('credentialing.index', compact('disciplines')); 
})->name('credentialing.index');

// --- 8. PENGURUSAN PENGGUNA ---
Route::get('/admin/users', function () { 
    $users = DB::table('users')->get();
    return view('admin.users.index', compact('users')); 
})->name('admin.users.index');

Route::get('/admin/users/delete/{id}', function ($id) {
    DB::table('users')->where('id', $id)->delete();
    return back()->with('success', 'Pengguna dipadam!');
})->name('admin.users.destroy');

// --- 9. DIREKTORI & PROFIL ---
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); })->name('direktori.carian');
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');