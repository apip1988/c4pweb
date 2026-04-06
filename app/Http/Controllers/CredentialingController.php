<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CredentialingDocument; 

class CredentialingController extends Controller
{
    // Paparan Carian (User)
    public function index(Request $request)
    {
        // 1. Senarai Disiplin (Gunakan ejaan yang sama TEPAT dengan upload)
        $disciplines = [
            'Peri-Operative Care',
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

        // 3. LOGIK CARIAN
        $selectedDiscipline = $request->get('discipline');
        $selectedDocType = $request->get('document_type'); // Tukar kepada document_type
        
        $query = CredentialingDocument::query();

        // Filter Disiplin: Jalankan jika ada pilihan DAN bukan 'ALL'
        if ($selectedDiscipline && $selectedDiscipline != 'ALL') {
            $query->where('discipline', $selectedDiscipline);
        }

        // Filter Jenis Dokumen: Jalankan jika ada pilihan DAN bukan 'ALL'
        if ($selectedDocType && $selectedDocType != 'ALL') {
            $query->where('document_type', $selectedDocType);
        }

        // Ambil hasil carian
        $results = $query->orderBy('created_at', 'desc')->get();

        // 4. Hantar data ke View
        return view('credentialing.index', compact('disciplines', 'docTypes', 'results'));
    }

    // Paparan Borang Muat Naik (Admin)
    public function create()
    {
        $disciplines = [
            'Peri-Operative Care', 'Emergency Medicine & Trauma Services (AMO & Nurses)', 
            'Emergency Medicine & Trauma Services (Lecturer & Clinical Instructor)', 'Ophthalmology', 
            'Dialysis Care (Haemodialysis)', 'Pre Hospital Care Services', 
            'Anaesthesiology & Intensive Care (Anaesthesia)', 'Anaesthesiology & Intensive Care (Peri-Anaesthesia)', 
            'Anaesthesiology & Intensive Care (Intensive Care)', 'Orthopaedics Services', 
            'Cardio (Cardiovascular Perfusion)', 'Cardio (Cardiology)', 'Endoscopy Services', 
            'Peri-Anaesthesia Care (P.A.C)', 'Circumcision (Dorsal Slit Technique)'
        ];
        
        $docTypes = [
            'Borang Credentialing', 'Borang Recredentialing', 'Carta Alir', 
            'Buku Log', 'Kriteria', 'Garis Panduan'
        ];

        return view('credentialing.upload', compact('disciplines', 'docTypes'));
    }

    // Simpan Dokumen (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'discipline' => 'required',
            'document_type' => 'required',
            'title' => 'required',
            'file' => 'required|mimes:pdf|max:20480', // Besarkan had ke 20MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/credentialing'), $fileName);

            CredentialingDocument::create([
                'discipline' => $request->discipline,
                'document_type' => $request->document_type,
                'title' => $request->title,
                'file_path' => 'uploads/credentialing/' . $fileName,
            ]);

            return back()->with('success', 'Dokumen berjaya dimuat naik!');
        }
    }

    // Padam Dokumen (Admin)
    public function destroy($id)
    {
        $doc = CredentialingDocument::find($id);

        if ($doc) {
            $filePath = public_path($doc->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $doc->delete();
            return back()->with('success', 'Dokumen dan fail fizikal berjaya dipadam!');
        }

        return back()->with('error', 'Dokumen tidak dijumpai.');
    }
}