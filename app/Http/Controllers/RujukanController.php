<?php

namespace App\Http\Controllers;

use App\RujukanDocument;
use Illuminate\Http\Request;

class RujukanController extends Controller
{
    public function index(Request $request)
    {
        $query = RujukanDocument::query();

        // Logic Carian
        if ($request->type && $request->type != 'ALL') {
            $query->where('type', $request->type);
        }
        if ($request->year) {
            $query->where('year', $request->year);
        }
        if ($request->publisher) {
            $query->where('publisher', 'LIKE', "%{$request->publisher}%");
        }

        $results = $query->orderBy('year', 'desc')->get();

        // Data Dashboard Pastel
        $stats = [
            'spg' => RujukanDocument::where('type', 'SPG')->count(),
            'surat' => RujukanDocument::whereIn('type', ['Surat', 'Polisi', 'Pekeliling', 'Punca Kuasa'])->count(),
            'guideline' => RujukanDocument::where('type', 'Guideline')->count(),
            'minit' => RujukanDocument::where('type', 'Minit Mesyuarat')->count(),
        ];

        return view('rujukan.index', compact('results', 'stats'));
    }

    // Fungsi Admin (Upload & Delete) akan diletakkan di sini nanti
}