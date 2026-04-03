<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib ada untuk guna database

class PrpaController extends Controller
{
    public function proses_semak(Request $request)
    {
        // 1. Ambil IC dari input borang semakan
        $ic = $request->ic_nombor;

        // 2. Cari keputusan yang paling TERBARU (Latest) dalam table
        // Pastikan nama table Afif betul (contoh: phcals_results)
        $data = DB::table('phcals_results')
                    ->where('ic_number', $ic)
                    ->orderBy('created_at', 'desc')
                    ->first();

        // 3. Kalau IC tak wujud dalam database
        if (!$data) {
            return redirect()->back()->with('error', 'Maaf, rekod keputusan bagi No. IC ' . $ic . ' tidak dijumpai.');
        }

        // 4. Ambil SEJARAH (History) semua percubaan IC tersebut
        $history = DB::table('phcals_results')
                    ->where('ic_number', $ic)
                    ->orderBy('created_at', 'asc')
                    ->get();

        // 5. Hantar data ke page hasil_keputusan.blade.php
        return view('prpa.hasil_keputusan', compact('data', 'history'));
    }
}