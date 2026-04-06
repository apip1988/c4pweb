<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CredentialingController extends Controller
{
    public function index(Request $request)
    {
        // Senarai Disiplin Credentialing
        $disciplines = [
            'Kecemasan (ED)', 
            'Dewan Bedah (OT)', 
            'Kesihatan Awam', 
            'Hemodialisis', 
            'Ortopedik',
            'Anaestesiologi',
            'Perawatan Rapi (ICU)'
        ];
        
        // Senarai Dokumen Credentialing Sahaja
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