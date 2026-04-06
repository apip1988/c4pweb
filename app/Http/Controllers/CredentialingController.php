<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CredentialingController extends Controller
{
    public function index(Request $request)
    {
        // Senarai Disiplin Mengikut Senarai Afif
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
        
        $docTypes = [
            'Borang Credentialing', 
            'Borang Recredentialing', 
            'Carta Alir', 
            'Buku Log', 
            'Kriteria', 
            'Garis Panduan'
        ];

        return view('credentialing.index', compact('disciplines', 'docTypes'));
    }
}