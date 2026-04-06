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
    public function store(Request $request)
{
    // Logic simpan ke table rujukan_documents
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/rujukan'), $fileName);

        \App\RujukanDocument::create([
            'type' => $request->document_type,
            'title' => $request->title,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'file_path' => 'uploads/rujukan/' . $fileName,
        ]);

        return back()->with('success', 'Dokumen Rujukan berjaya dimuat naik!');
    }
}

public function destroy($id)
{
    $doc = \App\RujukanDocument::find($id);
    if ($doc) {
        // Padam fail fizikal
        if (file_exists(public_path($doc->file_path))) {
            unlink(public_path($doc->file_path));
        }
        $doc->delete();
        return back()->with('success', 'Dokumen rujukan berjaya dipadam!');
    }
    return back()->with('error', 'Gagal memadam dokumen.');
}

}
