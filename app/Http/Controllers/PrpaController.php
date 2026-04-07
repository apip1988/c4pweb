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
        // Panggil class data soalan (PENTING: Gunakan Backslash \ di depan App)
        $className = "\\App\\QuizData\\Set" . $id;
        
        if (!class_exists($className)) {
            return redirect()->back()->with('error', 'Set not found.');
        }

        $allQuestions = $className::questions();

        // Rawakkan soalan & jawapan (SHUFFLE)
        $questions = collect($allQuestions)->shuffle()->map(function($item) {
            $item['options'] = collect($item['options'])->shuffle()->all();
            return $item;
        })->all();

        // Simpan soalan yang dirawakkan ke dalam session (untuk rujukan masa semak markah)
        session(['quiz_questions' => $questions]);

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