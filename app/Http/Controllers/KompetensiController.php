<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Mail;

class KompetensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index', 'dashboard', 'user_index', 'halaman_semak_tempat', 
            'proses_semak_tempat', 'proses_semak_keputusan'
        ]);
    }

    // --- 1. PROSES USER: HANTAR PERMOHONAN ---
    public function hantar_permohonan(Request $request)
    {
        $user = Auth::user();
        $currentTime = date('Y-m-d H:i:s');

        // Simpan ke table permohonans
        DB::table('permohonans')->insert([
            'user_id'      => $user->id,
            'name'         => $user->name,
            'ic_number'    => $user->ic_number,
            'email'        => $user->email,
            'sektor'       => $user->sektor,
            'phone_number' => $user->phone_number,
            'ptj_sekarang' => $user->ptj_sekarang,
            'status'       => 'PENDING', // Status awal: Senarai Nama Calon
            'created_at'   => $currentTime,
            'updated_at'   => $currentTime,
        ]);

        return redirect()->back()->with('success', 'Permohonan Berjaya Dihantar!');
    }

    // --- 2. PROSES ADMIN: PENGURUSAN CALON (VIEW UTAMA) ---
    public function admin_pengurusan_calon(Request $request)
    {
        // Table 1: Permohonan Baru (Status PENDING)
        $senarai_baru = DB::table('permohonans')->where('status', 'PENDING')->get();

        // Table 2: Semakan Tempat (Status DISAHKAN & Belum Kemaskini Tempat)
        $senarai_tempat = DB::table('keputusan_penilaian')
                            ->where('tempat_ujian', 'BELUM DITETAPKAN')
                            ->get();

        // Table 3 & 4: Keputusan & Senarai Akhir
        $senarai_keputusan = DB::table('keputusan_penilaian')
                                ->where('tempat_ujian', '!=', 'BELUM DITETAPKAN')
                                ->get();

        return view('kompetensi.admin_permohonan', compact('senarai_baru', 'senarai_tempat', 'senarai_keputusan'));
    }

    // --- 3. PROSES ADMIN: SAHKAN PERMOHONAN (BULK/SINGLE) ---
    public function sahkan_permohonan(Request $request)
    {
        $ids = $request->ids; // Ambil array ID dari checkbox
        $currentTime = date('Y-m-d H:i:s');

        foreach ($ids as $id) {
            $data = DB::table('permohonans')->where('id', $id)->first();
            
            if ($data) {
                // Update status di table permohonans
                DB::table('permohonans')->where('id', $id)->update(['status' => 'DISAHKAN']);

                // Masuk ke table keputusan_penilaian (Semakan Tempat)
                DB::table('keputusan_penilaian')->updateOrInsert(
                    ['ic_number' => $data->ic_number],
                    [
                        'nama' => strtoupper($data->name),
                        'phone' => $data->phone_number,
                        'alamat_ptj' => strtoupper($data->ptj_sekarang),
                        'jenis_ujian' => 'PENILAIAN KOMPETENSI PPT ' . date('Y'),
                        'tempat_ujian' => 'BELUM DITETAPKAN',
                        'keputusan' => 'DALAM PROSES',
                        'created_at' => $currentTime
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Calon telah disahkan ke peringkat Semakan Tempat.');
    }

    // --- 4. PROSES ADMIN: KEMASKINI TEMPAT & KELAYAKAN (BULK/SINGLE) ---
    public function kemaskini_penempatan(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            if ($request->status_layak == 'TIDAK LAYAK') {
                $keputusan = 'TIDAK LAYAK';
                $tempat = 'TIADA';
            } else {
                $keputusan = 'DALAM PROSES';
                $tempat = ($request->medium == 'MAYA') ? $request->pautan : $request->lokasi_fizikal;
            }

            DB::table('keputusan_penilaian')->where('id', $id)->update([
                'tarikh_ujian' => $request->tarikh_ujian,
                'masa_ujian' => $request->masa_ujian,
                'tempat_ujian' => $tempat,
                'keputusan' => $keputusan,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        return redirect()->back()->with('success', 'Maklumat penempatan telah dikemaskini.');
    }

    // --- 5. PROSES ADMIN: KEMASKINI KEPUTUSAN (BULK/SINGLE) ---
    public function kemaskini_keputusan_akhir(Request $request)
    {
        $ids = $request->ids;
        // Pilihan: LULUS, GAGAL, TIDAK HADIR & GAGAL
        
        DB::table('keputusan_penilaian')->whereIn('id', $ids)->update([
            'keputusan' => $request->keputusan_pilihan,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Keputusan peperiksaan telah dikemaskini.');
    }

    // --- 6. PROSES USER: SEMAKAN (KEKALKAN) ---
    public function proses_semak_keputusan(Request $request)
    {
        $ic = $request->ic_nombor;
        $hasil = DB::table('keputusan_penilaian')->where('ic_number', $ic)->first();
        if (!$hasil) return redirect()->back()->with('error', 'Rekod tidak dijumpai.');
        return view('kompetensi.keputusan', ['data' => $hasil, 'hasil' => $hasil]);
    }

    public function proses_semak_tempat(Request $request) {
        $ic = $request->ic_search;
        $carian = DB::table('keputusan_penilaian')->where('ic_number', $ic)->first();
        if(!$carian) return redirect()->back()->with('error_tempat', "IC tidak wujud.");
        return view('kompetensi.hasil_tempat', compact('carian'));
    }

    public function cetak_slip($ic)
    {
        $data = DB::table('keputusan_penilaian')->where('ic_number', $ic)->first();
        if (!$data) return "Rekod tidak dijumpai.";
        return view('kompetensi.cetak_slip', compact('data'));
    }

    // --- 7. ADMIN: DELETE (KEKALKAN) ---
    public function destroy($id) {
        DB::table('keputusan_penilaian')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Rekod dipadam!');
    }
}