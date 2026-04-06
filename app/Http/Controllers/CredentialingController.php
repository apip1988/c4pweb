<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Tambah ini di atas untuk panggil Model yang kita buat tadi
use App\CredentialingDocument; 

class CredentialingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Senarai Disiplin Afif
        $disciplines = [
            'Peri-Operative Care',
            'Intensive Care Nursing',
            'Emergency Medicine & Trauma Services (AMO & Nurses)',
            'Emergency Medicine & Trauma Services (Lecturer & Clinical Instructor)',
            'Ophthalmology',
            'Dialysis Care (Haemodialysis)',
            'Pre Hospital Care Services',
            'Anaesthesiology & Intensive Care (Anaesthesia)',
            'Anaesthesiology & Intensive Care (Peri-Anaesthesia)',
            'Anaesthesiology & Intensive Care (Intensive Care)',
            'Orthopaedics Services',
            'Cardio (Cardiovascular Perfusion)',
            'Cardio (Cardiology)',
            'Endoscopy Services',
            'Peri-Anaesthesia Care (P.A.C)',
            'Circumcision (Dorsal Slit Technique)'
        ];
        
        // 2. Senarai Jenis Dokumen
        $docTypes = [
            'Borang Credentialing', 
            'Borang Recredentialing', 
            'Carta Alir', 
            'Buku Log', 
            'Kriteria', 
            'Garis Panduan'
        ];

        // 3. LOGIK CARIAN (Tangkis input dari Form)
        $selectedDiscipline = $request->get('discipline');
        $selectedDocType = $request->get('doc_type');
        
        $results = null;

        // Jika user ada buat carian
        if ($selectedDiscipline || $selectedDocType) {
            $query = CredentialingDocument::query();

            if ($selectedDiscipline) {
                $query->where('discipline', $selectedDiscipline);
            }

            if ($selectedDocType) {
                $query->where('document_type', $selectedDocType);
            }

            $results = $query->get();
        }

        // 4. Hantar semua data ke View
        return view('credentialing.index', compact('disciplines', 'docTypes', 'results'));
    }

    public function create()
{
    // Copy senarai disiplin dari fungsi index tadi supaya sama
    $disciplines = ['Peri-Operative Care', 'Intensive Care Nursing', 'Emergency Medicine & Trauma Services (AMO & Nurses)', 'Emergency Medicine & Trauma Services (Lecturer & Clinical Instructor)', 'Ophthalmology', 'Dialysis Care (Haemodialysis)', 'Pre Hospital Care Services', 'Anaesthesiology & Intensive Care (Anaesthesia)', 'Anaesthesiology & Intensive Care (Peri-Anaesthesia)', 'Anaesthesiology & Intensive Care (Intensive Care)', 'Orthopaedics Services', 'Cardio (Cardiovascular Perfusion)', 'Cardio (Cardiology)', 'Endoscopy Services', 'Peri-Anaesthesia Care (P.A.C)', 'Circumcision (Dorsal Slit Technique)'];
    
    $docTypes = ['Borang Credentialing', 'Borang Recredentialing', 'Carta Alir', 'Buku Log', 'Kriteria', 'Garis Panduan'];

    return view('credentialing.upload', compact('disciplines', 'docTypes'));
}

public function store(Request $request)
{
    $request->validate([
        'discipline' => 'required',
        'document_type' => 'required',
        'title' => 'required',
        'file' => 'required|mimes:pdf|max:10000', // Had 10MB
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/credentialing'), $fileName);

        \App\CredentialingDocument::create([
            'discipline' => $request->discipline,
            'document_type' => $request->document_type,
            'title' => $request->title,
            'file_path' => 'uploads/credentialing/' . $fileName,
        ]);

        return back()->with('success', 'Dokumen berjaya dimuat naik!');
    }
}

}