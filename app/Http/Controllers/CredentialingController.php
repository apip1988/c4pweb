<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CredentialingDocument; 
use App\Rujukan; // PASTIKAN MODEL INI ADA
use Illuminate\Support\Facades\File;

class CredentialingController extends Controller
{
    // --- DATA HELPER (Untuk elakkan taip berulang kali) ---
    private function getDisciplines() {
        return [
            'Peri-Operative Care', 'Emergency Medicine & Trauma Services (AMO & Nurses)', 
            'Emergency Medicine & Trauma Services (Lecturer & Clinical Instructor)', 'Ophthalmology', 
            'Dialysis Care (Haemodialysis)', 'Pre Hospital Care Services', 
            'Anaesthesiology & Intensive Care (Anaesthesia)', 'Anaesthesiology & Intensive Care (Peri-Anaesthesia)', 
            'Anaesthesiology & Intensive Care (Intensive Care)', 'Orthopaedics Services', 
            'Cardio (Cardiovascular Perfusion)', 'Cardio (Cardiology)', 'Endoscopy Services', 
            'Peri-Anaesthesia Care (P.A.C)', 'Circumcision (Dorsal Slit Technique)'
        ];
    }

    private function getDocTypes() {
        return ['Borang Credentialing', 'Borang Recredentialing', 'Carta Alir', 'Buku Log', 'Kriteria', 'Garis Panduan'];
    }

    // 1. Paparan Carian User (Credentialing Only)
    public function index(Request $request)
    {
        $disciplines = $this->getDisciplines();
        $docTypes = $this->getDocTypes();

        $selectedDiscipline = $request->get('discipline');
        $selectedDocType = $request->get('document_type');
        
        $query = CredentialingDocument::query();

        if ($selectedDiscipline && $selectedDiscipline != 'ALL') {
            $query->where('discipline', $selectedDiscipline);
        }

        if ($selectedDocType && $selectedDocType != 'ALL') {
            $query->where('document_type', $selectedDocType);
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        return view('credentialing.index', compact('disciplines', 'docTypes', 'results'));
    }

    // 2. Paparan Borang Muat Naik Unified (Admin)
    public function create()
    {
        $disciplines = $this->getDisciplines();
        $docTypes = $this->getDocTypes();

        return view('credentialing.upload', compact('disciplines', 'docTypes'));
    }

    // 3. Simpan Dokumen (Logik Berpusat)
    public function store(Request $request)
    {
        // Penentuan jenis modul (CREDENTIALING atau RUJUKAN)
        $module = $request->input('module_type', 'CREDENTIALING');

        // Validasi Asas
        $rules = [
            'title' => 'required',
            'file' => 'required|mimes:pdf|max:20480',
        ];

        // Validasi tambahan mengikut modul
        if ($module == 'RUJUKAN') {
            $rules['type'] = 'required';
            $rules['year'] = 'required|numeric';
            $rules['publisher'] = 'required';
        } else {
            $rules['discipline'] = 'required';
            $rules['document_type'] = 'required';
        }

        $request->validate($rules);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Tentukan folder simpanan mengikut modul
            $subFolder = ($module == 'RUJUKAN') ? 'rujukan' : 'credentialing';
            $file->move(public_path('uploads/' . $subFolder), $fileName);
            $finalPath = 'uploads/' . $subFolder . '/' . $fileName;

            if ($module == 'RUJUKAN') {
                // SIMPAN KE TABLE RUJUKAN
                Rujukan::create([
                    'type' => $request->type,
                    'title' => $request->title,
                    'publisher' => $request->publisher,
                    'year' => $request->year,
                    'file_path' => $finalPath,
                ]);
                $message = "Dokumen e-Rujukan berjaya dimuat naik!";
            } else {
                // SIMPAN KE TABLE CREDENTIALING
                CredentialingDocument::create([
                    'discipline' => $request->discipline,
                    'document_type' => $request->document_type,
                    'title' => $request->title,
                    'file_path' => $finalPath,
                ]);
                $message = "Dokumen e-Credentialing berjaya dimuat naik!";
            }

            return back()->with('success', $message);
        }
    }

    // 4. Padam Dokumen (Credentialing Only - Rujukan urus di RujukanController jika perlu)
    public function destroy($id)
{
    $doc = \App\CredentialingDocument::findOrFail($id);
    
    // Padam fail fizikal
    if (file_exists(public_path($doc->file_path))) {
        unlink(public_path($doc->file_path));
    }
    
    $doc->delete();
    return back()->with('success', 'Dokumen e-Credentialing berjaya dipadam!');
}
}