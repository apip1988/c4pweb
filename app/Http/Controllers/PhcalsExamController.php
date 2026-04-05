<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhcalsQuestion;
use App\PhcalsResult;
use Auth;
use Carbon\Carbon;

class PhcalsExamController extends Controller
{
    public function index()
    {
        // Ambil 50 soalan Set 1 dan acak (random) kedudukannya
        $questions = \DB::table('phcals_questions')
                        ->where('set_number', 1)
                        ->inRandomOrder()
                        ->get();

        // Rekod masa mula dalam session
        session(['exam_start_time' => now()]);

        return view('phcals.exam', compact('questions'));
    }

    public function submit(Request $request)
{
    $userAnswers = $request->input('answers'); // Ambil jawapan dari form
    $totalQuestions = 50;
    $correctCount = 0;

    if ($userAnswers) {
        foreach ($userAnswers as $questionId => $answer) {
            // Check jawapan betul dalam database
            $question = \App\PhcalsQuestion::find($questionId);
            if ($question && $question->correct_answer == $answer) {
                $correctCount++;
            }
        }
    }

    // Kira Peratus
    $score = ($correctCount / $totalQuestions) * 100;

    // Simpan dalam Table phcals_results
    \App\PhcalsResult::create([
        'user_id' => auth()->user()->id,
        'set_number' => 1,
        'score' => $score,
        'correct_count' => $correctCount,
        'start_time' => session('exam_start_time'),
        'end_time' => now(),
    ]);

    // Hantar user ke halaman keputusan
    return redirect()->route('phcals.history')->with('status', 'Ujian selesai! Sila semak keputusan anda.');
}
public function history()
{
    $results = \App\PhcalsResult::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

    return view('phcals.history', compact('results'));
}

public function review($id)
{
    // Cari result, kalau tak jumpa dia akan keluar 404
    $result = \App\PhcalsResult::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

    return view('phcals.review', compact('result'));
}

}