<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PhcalsResult;

class PrpaController extends Controller
{
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

    public function startQuiz($id)
{
    // Kita panggil fail data soalan yang kita buat tadi (app/QuizData/Set1.php)
    $className = "App\QuizData\Set" . $id;
    
    // Pastikan class wujud
    if (!class_exists($className)) {
        return redirect()->back()->with('error', 'Set not found.');
    }

    $allQuestions = $className::questions();

    // Rawakkan soalan & jawapan (SHUFFLE)
    $questions = collect($allQuestions)->shuffle()->map(function($item) {
        $item['options'] = collect($item['options'])->shuffle()->all();
        return $item;
    })->all();

    // Hantar $questions ke view phcals.exam
    // COMPACT ini yang akan hilangkan error "Undefined variable" tu
    return view('phcals.exam', compact('questions', 'id'));
}

    public function showQuiz($id)
{
    // Jika user pilih Set 1, kita panggil view soalan tadi
    if ($id == 1) {
        return view('prpa.quiz1'); // Pastikan nama fail blade soalan Afif betul
    }

    // Jika set lain, hantar balik ke page utama dengan mesej
    return redirect()->route('prpa.index')->with('error', 'Set soalan ini belum tersedia.');
}
}