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
}