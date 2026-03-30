<?php
// app/Http/Controllers/DirektoriController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // Pastikan kita import Model User
use DB; // Pastikan kita import DB Facade

class DirektoriController extends Controller
{
    /**
     * Paparkan borang carian PPP.
     */
    public function index()
    {
        return view('direktori.carian-ppp-borang'); // Papar borang kosong
    }

    /**
     * Proses carian PPP berdasarkan No. LPP, Nama, atau IC.
     */
    public function hasil_carian(Request $request)
{
    // Ambil input dari borang
    $kata_kunci = $request->input('kata_kunci');

    // KITA CARI SEMUA (BUANG WHERE ROLE)
    $hasil_carian = \App\User::where('name', 'LIKE', "%{$kata_kunci}%")
        ->orWhere('no_lpp', 'LIKE', "%{$kata_kunci}%")
        ->orWhere('ic_number', 'LIKE', "%{$kata_kunci}%")
        ->first(); // Ambil data pertama yang dijumpai

    // Jika tak jumpa, hantar mesej error
    if (!$hasil_carian) {
        return redirect()->back()
            ->with('error', "Maaf, maklumat PPP '{$kata_kunci}' tidak dijumpai dalam database.");
    }

    // Jika jumpa, hantar ke view slip
    return view('direktori.carian-ppp-hasil', compact('hasil_carian', 'kata_kunci'));
}
}