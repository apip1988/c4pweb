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
        $userAnswers = $request->input('ans'); // Ambil jawapan dari form
        $originalQuestions = session('quiz_questions'); // Ambil soalan dari session
        $setId = $request->input('set_id');

        if (!$originalQuestions) {
            return redirect()->route('prpa.index')->with('error', 'Session expired. Please try again.');
        }

        $totalQuestions = count($originalQuestions);
        $correctCount = 0;

        // Bandingkan jawapan user dengan jawapan betul
        foreach ($originalQuestions as $index => $q) {
            if (isset($userAnswers[$index]) && $userAnswers[$index] === $q['answer']) {
                $correctCount++;
            }
        }

        $score = ($correctCount / $totalQuestions) * 100;
        $status = ($score == 100) ? 'LULUS' : 'RE-ATTEMPT';

        // Simpan keputusan ke database
        PhcalsResult::create([
            'user_id' => Auth::id(),
            'set_id' => $setId,
            'score' => round($score, 2),
            'status' => $status,
            'attempt_date' => now(),
            'expiry_date' => now()->addYears(3),
        ]);

        return redirect()->route('phcals.history')->with('success', 'Quiz completed! Your score: ' . round($score, 2) . '%');
    }
}