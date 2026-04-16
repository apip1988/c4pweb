<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\QuizData\Set1;
use Illuminate\Http\Request;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes - SISTEM AMOPPP (FULL RESTORE + AUTO-CALCULATE)
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

Route::post('/admin/document/store', function (Request $request) {
    return back()->with('success', 'Dokumen berjaya dimuat naik!');
})->name('admin.document.store');

Route::post('/admin/profil/store', function (Request $request) {
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

Route::post('/admin/users/update-role/{id}', function (Request $request, $id) {
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

// 7.1 MULA EXAM
Route::get('/prpa/quiz/{id}', function ($id) {
    $questions = Set1::questions(); 
    return view('phcals.exam', compact('questions', 'id')); 
})->name('prpa.start_exam');

// 7.2 SUBMIT JAWAPAN (FIXED: Kira Markah & Simpan DB)
Route::post('/phcals/submit', function (Request $request) {
    $user_answers = $request->input('ans'); 
    $questions = Set1::questions();
    $correct_count = 0;
    
    // Logik Kira Markah
    foreach ($questions as $index => $q) {
        if (isset($user_answers[$index]) && $user_answers[$index] === $q['answer']) {
            $correct_count++;
        }
    }
    
    $score = ($correct_count / count($questions)) * 100;
    $status = ($score == 100) ? 'PASSED' : 'RE-ATTEMPT';

    // Simpan ke Table phcals_results
    DB::table('phcals_results')->insert([
        'user_id'      => Auth::id(),
        'set_id'       => $request->input('set_id'),
        'score'        => $score,
        'status'       => $status,
        'review_data'  => json_encode($user_answers),
        'attempt_date' => Carbon::now(),
        'expiry_date'  => Carbon::now()->addYears(3),
        'created_at'   => Carbon::now(),
        'updated_at'   => Carbon::now(),
    ]);

    // Redirect guna ID login (Privasi: Sembunyi No IC dlm URL)
    return redirect()->route('prpa.history')->with('success', 'Ujian tamat! Rekod anda telah dikemaskini.');
})->name('phcals.submit');

// 7.3 HISTORY (Paparan Rekod Peribadi)
Route::get('/prpa/history', function () {
    $results = DB::table('phcals_results')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
    return view('phcals.history', compact('results'));
})->name('prpa.history');

// Route Semakan Manual (Carian No IC)
Route::match(['get', 'post'], '/prpa/hasil-semakan', function (Request $request) {
    $ic = $request->input('ic'); 
    $results = DB::table('phcals_