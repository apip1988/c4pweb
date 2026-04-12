<?php

namespace App\Http\Controllers;

use App\Rujukan; // Kita guna Model baru
use Illuminate\Http\Request;

class RujukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Rujukan::query();

        // Logic Carian (Kekal macam asal Afif punya)
        if ($request->type && $request->type != 'ALL') {
            $query->where('type', $request->type);
        }
        if ($request->year) {
            $query->where('year', $request->year);
        }
        if ($request->publisher) {
            $query->where('publisher', 'LIKE', "%{$request->publisher}%");
        }

        // Kita guna pembolehubah 'results' supaya Afif tak payah tukar fail Blade (View)
        $results = $query->orderBy('year', 'desc')->get();

        // Data Dashboard Pastel (Guna Model Rujukan baru)
        $stats = [
            'spg' => Rujukan::where('type', 'SPG')->count(),
            'surat' => Rujukan::whereIn('type', ['Surat', 'Polisi', 'Pekeliling', 'Punca Kuasa'])->count(),
            'guideline' => Rujukan::where('type', 'Guideline')->count(),
            'minit' => Rujukan::where('type', 'Minit Mesyuarat')->count(),
        ];

        return view('rujukan.index', compact('results', 'stats'));
    }

    public function destroy($id)
    {
        $doc = Rujukan::find($id);
        if ($doc) {
            // Padam fail fizikal jika wujud
            if (file_exists(public_path($doc->file_path))) {
                unlink(public_path($doc->file_path));
            }
            $doc->delete();
            return back()->with('success', 'Dokumen rujukan berjaya dipadam!');
        }
        return back()->with('error', 'Gagal memadam dokumen.');
    }
}