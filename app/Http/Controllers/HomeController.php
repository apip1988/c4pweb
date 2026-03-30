<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Mengira jumlah dari database
    $total_ppp = DB::table('keputusan_penilaian')->count();
    
    // Contoh mengira mengikut jantina (Jika ada kolum jantina)
    // Buat masa ni kita buat simulasi dinamik berdasarkan data sedia ada
    $lulus = DB::table('keputusan_penilaian')->where('keputusan', 'LULUS')->count();
    $gagal = DB::table('keputusan_penilaian')->where('keputusan', 'GAGAL')->count();
    
    // Mengira mengikut kategori (Jika ada kolum sektor/bidang)
    // Untuk permulaan, kita hantar pembolehubah ini ke view
    return view('welcome', compact('total_ppp', 'lulus', 'gagal'));
}
}
