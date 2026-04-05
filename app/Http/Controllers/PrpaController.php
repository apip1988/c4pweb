<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib ada untuk guna database

class PrpaController extends Controller
{
    public function proses_semak(Request $request)
{
    $ic = $request->ic_nombor;

    // Cari keputusan terbaru berserta data User (Guna Join)
    $data = DB::table('phcals_results')
                ->join('users', 'phcals_results.user_id', '=', 'users.id') // Ambil data dari table users
                ->select('phcals_results.*', 'users.name') // Ambil semua data result + Nama dari user
                ->where('phcals_results.ic_number', $ic)
                ->orderBy('phcals_results.created_at', 'desc')
                ->first();

    if (!$data) {
        return redirect()->back()->with('error', 'Maaf, rekod No. IC ' . $ic . ' tidak dijumpai.');
    }

    $history = DB::table('phcals_results')
                ->where('ic_number', $ic)
                ->orderBy('created_at', 'asc')
                ->get();

    return view('prpa.hasil_keputusan', compact('data', 'history'));
}
}