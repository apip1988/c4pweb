<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PhcalsResult; // Pastikan Model ini wujud
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PrpaController extends Controller
{
    /**
     * Semakan keputusan kuiz untuk awam (Public)
     */
    public function proses_semak(Request $request)
    {
        // 1. Validasi Input: Wajib 12 digit angka sahaja (Security Level 1)
        $request->validate([
            'ic_number' => 'required|numeric|digits:12', 
        ], [
            'ic_number.required' => 'Sila masukkan No. Kad Pengenalan.',
            'ic_number.numeric'  => 'No. K/P mestilah dalam bentuk angka sahaja.',
            'ic_number.digits'   => 'No. K/P mestilah 12 digit (Tanpa tanda -).',
        ]);

        $ic = $request->input('ic_number');

        // 2. Cari user (Security Level 2: Mencari dalam data terenkripsi)
        // Kita gunakan filter supaya Laravel tolong decrypt IC semasa mencari
        $user = User::all()->filter(function($u) use ($ic) {
            return $u->ic_number === $ic;
        })->first();

        if (!$user) {
            return back()->with('error', 'Maaf, rekod bagi No. K/P tersebut tidak dijumpai dalam sistem.');
        }

        // 3. Tarik semua result PHCALS milik user tersebut
        $results = PhcalsResult::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        if ($results->isEmpty()) {
            return back()->with('error', 'Rekod user dijumpai, tetapi tiada sejarah ujian PHCALS direkodkan.');
        }

        return view('prpa.hasil_keputusan', compact('user', 'results'));
    }

    /**
     * Memulakan sesi kuiz (Start Exam)
     */
    public function startQuiz($id)
    {
        $className = "App\\QuizData\\Set" . $id;
        
        if (!class_exists($className)) {
            return back()->with('error', 'Fail soalan bagi Set ini tidak dijumpai.');
        }

        $allQuestions = $className::questions();

        // Ambil 10 soalan secara rawak & rawakkan pilihan jawapan
        $questions = collect($allQuestions)->shuffle()->take(10)->map(function($item) {
            $item['options'] = collect($item['options'])->shuffle()->all();
            return $item;
        })->all();

        // Simpan dalam session untuk kegunaan masa submit nanti
        session(['quiz_questions' => $questions]);

        return view('phcals.exam', compact('questions', 'id'));
    }

    /**
     * Proses Submit Jawapan & Kira Markah
     */
    public function submitQuiz(Request $request)
    {
        $userAnswers = $request->input('ans', []); // Default empty array kalau tak jawab langsung
        $questions = session('quiz_questions');
        $setId = $request->input('set_id', 1);

        if (!$questions) {
            return redirect()->route('prpa.index')->with('error', 'Sesi tamat. Sila mula semula ujian.');
        }

        $totalQuestions = count($questions);
        $correctCount = 0;
        $reviewData = [];

        foreach ($questions as $index => $q) {
            $userAns = $userAnswers[$index] ?? null;
            $isCorrect = (trim($userAns) === trim($q['answer'])); // trim untuk elak ralat ruang kosong
            
            if ($isCorrect) { 
                $correctCount++; 
            }

            $reviewData[] = [
                'question' => $q['question'],
                'correct'  => $q['answer'],
                'user_ans' => $userAns,
                'is_right' => $isCorrect
            ];
        }

        $score = ($correctCount / $totalQuestions) * 100;
        // Status LULUS (Passed) hanya jika 100%
        $status = ($score == 100) ? 'PASSED' : 'RE-ATTEMPT';

        // Simpan ke Database
        $result = PhcalsResult::create([
            'user_id'      => auth()->id(),
            'set_id'       => $setId,
            'score'        => round($score, 2),
            'status'       => $status,
            'review_data'  => json_encode($reviewData),
            'attempt_date' => now(),
            'expiry_date'  => now()->addYears(3), // Valid selama 3 tahun
        ]);

        return redirect()->route('phcals.history')->with('success', 'Ujian berjaya dihantar!');
    }

    /**
     * Paparan Sejarah Ujian
     */
    public function showHistory()
    {
        $results = PhcalsResult::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('phcals.history', compact('results'));
    }

    /**
     * Paparan Semakan Jawapan (Review)
     */
    public function showReview($id)
    {
        $result = PhcalsResult::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        $reviewData = json_decode($result->review_data, true);

        return view('phcals.review', compact('result', 'reviewData'));
    }

    /**
     * Cetak Sijil
     */
    public function printCertificate($id)
    {
        $result = PhcalsResult::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', 'PASSED') // Hanya boleh print kalau lulus
                    ->firstOrFail();

        return view('phcals.print', compact('result'));
    }
}