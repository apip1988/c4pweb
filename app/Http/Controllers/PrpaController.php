<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PhcalsResult;
use Illuminate\Support\Facades\Auth;

class PrpaController extends Controller
{
    /**
     * Semakan keputusan kuiz untuk awam (Public)
     */
    public function proses_semak(Request $request)
    {
        $ic = $request->input('ic_number');

        // 1. Cari user berdasarkan IC
        $user = User::where('ic_number', $ic)->first();

        if (!$user) {
            return back()->with('error', 'Maaf, rekod bagi No. K/P tersebut tidak dijumpai dalam sistem.');
        }

        // 2. Tarik semua result PHCALS milik user tersebut
        $results = PhcalsResult::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        if ($results->isEmpty()) {
            return back()->with('error', 'Rekod user dijumpai, tetapi tiada sejarah ujian PHCALS direkodkan.');
        }

        // 3. Hantar data ke view hasil keputusan
        return view('prpa.hasil_keputusan', compact('user', 'results'));
    }

    /**
     * Memulakan sesi kuiz (Start Exam)
     */
    public function startQuiz($id)
{
    // Gunakan full path yang tepat
    $className = "App\QuizData\Set" . $id;
    
    // Check kalau class ni wujud atau tidak
    if (!class_exists($className)) {
        // Kalau tak wujud, dia akan redirect balik (Sebab tu keluar 302)
        return "ERROR: Class $className tidak dijumpai. Pastikan fail app/QuizData/Set1.php ada dan namespace betul.";
    }

    $allQuestions = $className::questions();

    $questions = collect($allQuestions)->shuffle()->map(function($item) {
        $item['options'] = collect($item['options'])->shuffle()->all();
        return $item;
    })->all();

    return view('phcals.exam', compact('questions', 'id'));
}

    /**
     * Proses Submit Jawapan & Kira Markah
     */
    public function submitQuiz(Request $request)
{
    // 1. Ambil jawapan yang user pilih dari form (ans[0], ans[1], etc)
    $userAnswers = $request->input('ans'); 
    
    // 2. Ambil soalan yang tersimpan dalam session masa mula kuiz tadi
    $questions = session('quiz_questions');
    $setId = $request->input('set_id', 1);

    // Jika session hilang (timeout), hantar balik ke main page
    if (!$questions) {
        return redirect()->route('prpa.index')->with('error', 'Session expired. Please restart the quiz.');
    }

    $totalQuestions = count($questions);
    $correctCount = 0;
    $reviewData = []; // Untuk simpan sejarah jawapan (Review)

    // 3. Proses Pengiraan
    foreach ($questions as $index => $q) {
        $userAns = $userAnswers[$index] ?? null;
        $isCorrect = ($userAns === $q['answer']);
        
        if ($isCorrect) { 
            $correctCount++; 
        }

        // Simpan data untuk paparan Hijau/Merah nanti
        $reviewData[] = [
            'question' => $q['question'],
            'correct'  => $q['answer'],
            'user_ans' => $userAns,
            'is_right' => $isCorrect
        ];
    }

    // 4. Tentukan Markah & Status
    $score = ($correctCount / $totalQuestions) * 100;
    $status = ($score == 100) ? 'PASSED' : 'RE-ATTEMPT';

    // 5. Simpan ke Database
    \App\PhcalsResult::create([
        'user_id'      => auth()->id(),
        'set_id'       => $setId,
        'score'        => round($score, 2),
        'status'       => $status,
        'review_data'  => json_encode($reviewData), // Simpan sebagai JSON
        'attempt_date' => now(),
        'expiry_date'  => now()->addYears(3), // Expired dalam 3 tahun
    ]);

    // 6. Selesai! Hantar user ke page history
    return redirect()->route('phcals.history')->with('success', 'Examination submitted successfully!');
}

    public function showHistory()
{
    // Ambil semua sejarah kuiz milik user yang tengah login sekarang
    $results = \App\PhcalsResult::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

    return view('phcals.history', compact('results'));
}

}