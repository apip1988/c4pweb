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

    // --- LALUAN AWAM / DASHBOARD ---
    public function index()
    {
        return view('welcome');
    }

    public function dashboard() {
        $data = DB::table('statistik_utama')->pluck('jumlah', 'kategori');
        $getData = function($key) use ($data) { return isset($data[$key]) ? (int)$data[$key] : 0; };
        return view('dashboard', [
            'total_ppp' => $getData('Lelaki') + $getData('Perempuan'),
            'lelaki' => $getData('Lelaki'), 'perempuan' => $getData('Perempuan'),
            'perubatan' => $getData('Perubatan'), 'kesihatan' => $getData('Kesihatan'),
            'pengurusan' => $getData('Pengurusan'), 'sektor_awam' => $getData('Awam'),
            'sektor_swasta' => $getData('Swasta'), 'tetap' => $getData('Tetap'),
            'kontrak' => $getData('Kontrak'), 'mers' => $getData('NG MERS999'),
            'ipkkm' => $getData('IPKKM'), 'jkn' => $getData('JKN'),
            'pkd' => $getData('PKD'), 'hospital' => $getData('HOSPITAL'),
            'klinik' => $getData('KLINIK'), 'kader' => $getData('KADER'),
        ]);
    }

    // --- FUNGSI USER (BORANG & SEMAKAN) ---
    public function borang_permohonan()
    {
        return view('kompetensi.permohonan');
    }

    public function halaman_semak_tempat()
    {
        return view('kompetensi.semak_tempat');
    }

    public function user_index()
    {
        return view('kompetensi.semak');
    }

    public function hantar_permohonan(Request $request)
    {
        $user = Auth::user();
        $currentTime = date('Y-m-d H:i:s');

        // KOD PAKSA: Jika table tak wujud, buat sekarang juga!
        DB::statement("CREATE TABLE IF NOT EXISTS permohonans (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED,
            name VARCHAR(191),
            ic_number VARCHAR(191),
            email VARCHAR(191),
            sektor VARCHAR(191),
            phone_number VARCHAR(191),
            ptj_sekarang VARCHAR(191),
            status VARCHAR(191) DEFAULT 'PENDING',
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )");

        DB::table('permohonans')->insert([
            'user_id'      => $user->id,
            'name'         => $user->name,
            'ic_number'    => $user->ic_number,
            'email'        => $user->email,
            'sektor'       => $user->sektor,
            'phone_number' => $user->phone_number,
            'ptj_sekarang' => $user->ptj_sekarang,
            'status'       => 'PENDING',
            'created_at'   => $currentTime,
            'updated_at'   => $currentTime,
        ]);

        return redirect()->back()->with('success', 'Permohonan Berjaya Dihantar!');
    }

    // --- FUNGSI ADMIN: PENGURUSAN CALON ---
    public function admin_pengurusan_calon(Request $request)
{
    // KOD PAKSA: Jika table tak wujud, buat sekarang juga!
    DB::statement("CREATE TABLE IF NOT EXISTS keputusan_penilaian (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(191),
        ic_number VARCHAR(191),
        phone VARCHAR(191),
        alamat_ptj TEXT,
        jenis_ujian VARCHAR(191),
        tarikh_ujian DATE NULL,
        masa_ujian TIME NULL,
        tempat_ujian VARCHAR(191) DEFAULT 'BELUM DITETAPKAN',
        keputusan VARCHAR(191) DEFAULT 'DALAM PROSES',
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )");

    // Ambil data untuk paparan table
    $senarai_baru = DB::table('permohonans')->where('status', 'PENDING')->get();
    $senarai_tempat = DB::table('keputusan_penilaian')->where('tempat_ujian', 'BELUM DITETAPKAN')->get();
    $senarai_keputusan = DB::table('keputusan_penilaian')->where('tempat_ujian', '!=', 'BELUM DITETAPKAN')->get();

    return view('kompetensi.admin_permohonan', compact('senarai_baru', 'senarai_tempat', 'senarai_keputusan'));
}

    public function sahkan_permohonan(Request $request)
    {
        $ids = $request->ids; 
        $currentTime = date('Y-m-d H:i:s');

        if(!$ids) return redirect()->back()->with('error', 'Sila pilih calon.');

        foreach ($ids as $id) {
            $data = DB::table('permohonans')->where('id', $id)->first();
            if ($data) {
                DB::table('permohonans')->where('id', $id)->update(['status' => 'DISAHKAN']);
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
        return redirect()->back()->with('success', 'Calon telah disahkan.');
    }

    public function kemaskini_penempatan(Request $request)
    {
        $ids = $request->ids;
        if(!$ids) return redirect()->back()->with('error', 'Sila pilih calon.');

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
        return redirect()->back()->with('success', 'Maklumat penempatan dikemaskini.');
    }

    public function kemaskini_keputusan_akhir(Request $request)
    {
        $ids = $request->ids;
        if(!$ids) return redirect()->back()->with('error', 'Sila pilih calon.');
        
        DB::table('keputusan_penilaian')->whereIn('id', $ids)->update([
            'keputusan' => $request->keputusan_pilihan,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Keputusan peperiksaan dikemaskini.');
    }

    // --- PROSES SEMAKAN & CETAKAN ---
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

    public function destroy($id) {
        DB::table('keputusan_penilaian')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Rekod dipadam!');
    }
}