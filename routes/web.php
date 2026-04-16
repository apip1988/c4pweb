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
| Web Routes - SISTEM AMOPPP (TOTAL PRIVACY & AUTO-CALCULATE)
|--------------------------------------------------------------------------
*/

Auth::routes();

// --- 1. UTAMA ---
Route::get('/', [KompetensiController::class, 'index'])->name('welcome');
Route::get('/dashboard', [KompetensiController::class, 'dashboard'])->name('dashboard');
Route::get('/hubungi', function () { return view('hubungi'); })->name('hubungi');

// --- 2. e-KOMPETENSI ---
Route::middleware(['auth'])->group(function () {
    Route::get('/kompetensi/permohonan', [KompetensiController::class, 'borang_permohonan'])->name('kompetensi.permohonan');
    Route::post('/kompetensi/hantar', [KompetensiController::class, 'hantar_permohonan'])->name('kompetensi.hantar');
});

// --- 3. e-PRPA (QUIZ SYSTEM) ---
Route::get('/prpa', function () { return view('prpa.index'); })->name('prpa.index');
Route::get('/prpa/semak-keputusan', function () { return view('prpa.semak'); })->name('prpa.semak.borang');

// 3.1 MULA EXAM
Route::get('/prpa/quiz/{id}', function ($id) {
    $questions = Set1::questions(); 
    return view('phcals.exam', compact('questions', 'id')); 
})->name('prpa.start_exam');

// 3.2 SUBMIT EXAM (Auto-Calculate & Sembunyi IC Total)
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

    // Redirect bersih tanpa bawa IC kat URL
    return redirect()->route('prpa.history')->with('success', 'Ujian tamat!');
})->name('phcals.submit');

// 3.3 HISTORY (Data ditarik guna ID Login - URL Gerenti Bersih)
Route::get('/prpa/history', function () {
    if (!Auth::check()) return redirect('/login');

    // Kita tarik data berdasarkan ID user yang tengah login sahaja
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

// 3.4 HASIL SEMAKAN (Redirect ke URL bersih)
Route::match(['get', 'post'], '/prpa/hasil-semakan', function (Request $request) {
    // Paksa pergi ke /prpa/history tanpa parameter IC kat URL
    return redirect()->route('prpa.history');
})->name('prpa.semak.hasil');

// --- 4. PRINT SAHAJA (Review Dibuang/Dihapuskan) ---
Route::get('/phcals/print/{id}', function($id) {
    $result = DB::table('phcals_results')->where('id', $id)->first();
    return view('phcals.print', compact('result', 'id'));
})->name('phcals.print');

// --- 5. ADMIN, DOKUMEN & SIDEBAR FIX ---
Route::get('/credentialing', function () { 
    return view('credentialing.index', ['disciplines' => collect()]); 
})->name('credentialing.index');

Route::get('/admin/dokumen/create', function () { 
    return view('admin.credentialing.create', ['senarai_stats' => collect(), 'documents' => collect()]); 
})->name('admin.dokumen.index');

Route::get('/profile', function () { return view('auth.profile'); })->name('profile');
Route::get('/direktori/carian-ppp', function () { return view('direktori.carian'); })->name('direktori.carian');