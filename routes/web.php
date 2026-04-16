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
| Web Routes - SISTEM AMOPPP (FINAL STABLE MASTERCOPY)
|--------------------------------------------------------------------------
*/

Auth::routes();

// --- 1. UTAMA ---
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');

// --- 2. LOGIN & LOGOUT ---
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// --- 3. e-KOMPETENSI (USER) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});

// Semakan Kompetensi
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

// --- 5. PENGURUSAN DOKUMEN & STATS ---
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

// 7.1 Mula Exam
Route::get('/prpa/quiz/{id}', function ($id) {
    $questions = Set1::questions(); 
    return view('phcals.exam', compact('questions', 'id')); 
})->name('prpa.start_exam');

// 7.2 Submit Exam
Route::post('/phcals/submit', function (Request $request) {
    $user_answers = $request->input('ans'); 
    $questions = Set1::questions();
    $correct_count = 0;
    
    foreach ($questions as $index => $q) {
        if (isset($user_answers[$index]) && $user_answers[$index] === $q['answer']) {
            $correct_count++;
        }
    }
    
    $score = ($correct_count / count($questions)) * 100;
    $status = ($score == 100) ? 'PASSED' : 'RE-ATTEMPT';
    $now = Carbon::now('Asia/Kuala_Lumpur');

    DB::table('phcals_results')->insert([
        'user_id'      => Auth::id(),
        'set_id'       => $request->input('set_id'),
        'score'        => $score,
        'status'       => $status,
        'review_data'  => json_encode($user_answers),
        'attempt_date' => $now,
        'expiry_date'  => $now->copy()->addYears(3),
        'created_at'   => $now,
        'updated_at'   => $now,
    ]);

    return redirect()->route('prpa.history')->with('success', 'Ujian tamat! Rekod telah dikemaskini.');
})->name('phcals.submit');

// 7.3 Paparan History (PRIVASI TOTAL: Guna Auth ID)
Route::get('/prpa/history', function () {
    if (!Auth::check()) return redirect('/login');

    $results = DB::table('phcals_results')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($res) {
                    $res->created_at = Carbon::parse($res->created_at)->timezone('Asia/Kuala_Lumpur');
                    $res->expiry_date = Carbon::parse($res->expiry_date)->timezone('Asia/Kuala_Lumpur');
                    return $res;
                });

    return view('phcals.history', compact('results'));
})->name('prpa.history');

// 7.4 Hasil Semakan (Redirect ke History Bersih)
Route::match(['get', 'post'], '/prpa/hasil-semakan', function () {
    return redirect()->route('prpa.history');
})->name('prpa.semak.hasil');

// --- 8. ACTION ROUTES ---

// Route Re-attempt (Hantar balik ke pilihan set soalan)
Route::get('/prpa/re-attempt', function() {
    return redirect()->route('prpa.index');
})->name('phcals.reattempt');

// Review DIBUANG (Redirect ke History)
Route::get('/phcals/review/{id}', function($id) {
    return redirect()->route('prpa.history')->with('error', 'Fungsi review telah ditutup.');
})->name('phcals.review');

// Print (Hanya jika Skor 100%)
Route::get('/phcals/print/{id}', function($id) {
    $result = DB::table('phcals_results')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

    if (!$result || $result->score < 100) {
        return redirect()->route('prpa.history')->with('error', 'Cetak sijil hanya dibenarkan jika keputusan 100%.');
    }

    return view('phcals.print', compact('result', 'id'));
})->name('phcals.print');

// --- 9. LAIN-LAIN ---
Route::get('/rujukan', [KompetensiController::class, 'index'])->name('rujukan.index'); // Placeholder
Route::get('/credentialing', function () { 
    return view('credentialing.index', ['disciplines' => collect()]); 
})->name('credentialing.index');

Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); })->name('direktori.carian');
Route::get('/direktori/carta-organisasi', function () { return view('direktori.carta'); })->name('direktori.carta-organisasi');
Route::get('/profile', function () { return view('auth.profile'); })->name('profile');