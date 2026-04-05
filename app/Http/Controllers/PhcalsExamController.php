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
        // Logik kira markah akan kita buat selepas ni
        return "Jawapan anda telah diterima!";
    }
}