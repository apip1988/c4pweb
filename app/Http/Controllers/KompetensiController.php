<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use Auth;

class KompetensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index', 'dashboard', 'user_index', 'halaman_semak_tempat', 
            'proses_semak_tempat', 'proses_semak_keputusan'
        ]);
    }

    // --- HUB UTAMA ADMIN ---
    public function admin_dashboard() 
    {
        $notifikasi_kompetensi = DB::table('permohonans')->where('status', 'PENDING')->count();
        $total_ahli = DB::table('users')->count();
        return view('admin.main_dashboard', compact('notifikasi_kompetensi', 'total_ahli'));
    }

    // --- PROSES HANTAR PERMOHONAN (USER) ---
    public function hantar_permohonan(Request $request)
{
    $user = Auth::user();
    $currentTime = date('Y-m-d H:i:s');

    DB::table('permohonans')->insert([
        'user_id'      => $user->id,
        'name'         => $user->name,
        'ic_number'    => $user->ic_number,
        'email'        => $user->email,
        'sektor'       => $user->sektor,
        'phone_number' => $user->phone_number, // TUKAR: Ikut nama kolom kat phpMyAdmin Afif
        'ptj_sekarang' => $user->ptj_sekarang, // TUKAR: Ikut nama kolom kat phpMyAdmin Afif
        'status'       => 'PENDING',
        'created_at'   => $currentTime,
        'updated_at'   => $currentTime,
    ]);

    return redirect()->back()->with('success', 'Permohonan Berjaya Dihantar!');
}
    // --- PROSES SAHKAN PERMOHONAN (ADMIN) ---
    public function update_status_permohonan(Request $request)
{
    $currentTime = date('Y-m-d H:i:s');
    $id = $request->id;
    $status = $request->status;

    // 1. Ambil data asal permohonan
    $dataAsal = DB::table('permohonans')->where('id', $id)->first();

    if (!$dataAsal) {
        return redirect()->back()->with('error', 'Data permohonan tidak dijumpai!');
    }

    // 2. KEMASKINI STATUS (Rekod tidak dipadam, kekal sebagai history)
    DB::table('permohonans')->where('id', $id)->update([
        'status' => $status,
        'updated_at' => $currentTime
    ]);

    // 3. JIKA DISAHKAN: Salin data ke Daftar Penempatan (Keputusan Penilaian)
    if ($status == 'DISAHKAN') {
        
        // Cek jika sudah wujud dalam daftar penempatan untuk elak data bertindan
        $wujud = DB::table('keputusan_penilaian')->where('ic_number', $dataAsal->ic_number)->exists();

        if (!$wujud) {
            DB::table('keputusan_penilaian')->insert([
                'nama'          => strtoupper($dataAsal->name),
                'ic_number'     => $dataAsal->ic_number,
                'no_lpp'        => '-', 
                'phone'         => $dataAsal->phone_number,
                'alamat_ptj'    => strtoupper($dataAsal->ptj_sekarang),
                'jenis_ujian'   => 'PENILAIAN KOMPETENSI PPT ' . date('Y'),
                'tempat_ujian'  => 'BELUM DITETAPKAN',
                'tarikh_ujian'  => null,
                'masa_ujian'    => null,
                'keputusan'     => 'DALAM PROSES',
                'created_at'    => $currentTime
            ]);
        }
    }

    return redirect()->back()->with('success', 'Status telah dikemaskini. Rekod disimpan dalam sejarah permohonan.');
}


    // --- FUNGSI-FUNGSI LAIN (KEKALKAN) ---
    public function admin_senarai_permohonan() {
        $senarai = DB::table('permohonans')->orderBy('created_at', 'desc')->get();
        return view('kompetensi.admin_permohonan', compact('senarai'));
    }

    public function admin_index() {
        $senarai_stats = DB::table('statistik_utama')->get();
        $senarai = DB::table('keputusan_penilaian')->orderBy('id', 'desc')->get();
        $notifikasi = DB::table('permohonans')->where('status', 'PENDING')->count();
        return view('admin.kompetensi_index', compact('senarai_stats', 'senarai', 'notifikasi'));
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

    public function index() { return view('welcome'); }
    public function user_index() { return view('kompetensi.semak'); }
    public function halaman_semak_tempat() { return view('kompetensi.semak_tempat'); }
    public function borang_permohonan() { return view('kompetensi.permohonan'); }

    public function proses_semak_keputusan(Request $request)
{
    $ic = $request->ic_nombor;
    $hasil = DB::table('keputusan_penilaian')->where('ic_number', $ic)->first();

    if (!$hasil) {
        return redirect()->back()->with('error', 'Rekod tidak dijumpai.');
    }

    // TUKAR DI SINI: Kita hantar variable sebagai 'data' supaya match dengan blade Afif
    return view('kompetensi.keputusan', ['data' => $hasil, 'hasil' => $hasil]);
}

    public function proses_semak_tempat(Request $request) {
        $ic = $request->ic_search;
        $carian = DB::table('keputusan_penilaian')->where('ic_number', $ic)->first();
        if(!$carian) return redirect()->back()->with('error_tempat', "IC tidak wujud.");
        return view('kompetensi.hasil_tempat', compact('carian'));
    }

    public function store(Request $request) {
        DB::table('keputusan_penilaian')->insert([
            'nama' => strtoupper($request->nama), 'ic_number' => $request->ic_number,
            'jenis_ujian' => $request->jenis_ujian, 'tempat_ujian' => $request->tempat_ujian,
            'tarikh_ujian' => $request->tarikh_ujian, 'masa_ujian' => $request->masa_ujian,
            'keputusan' => 'DALAM PROSES'
        ]);
        return redirect()->back()->with('success', 'Calon Berjaya Didaftarkan!');
    }

    public function update_calon(Request $request) {
        DB::table('keputusan_penilaian')->where('id', $request->id)->update([
            'nama' => strtoupper($request->nama), 'ic_number' => $request->ic_number,
            'jenis_ujian' => $request->jenis_ujian, 'tarikh_ujian' => $request->tarikh_ujian,
            'masa_ujian' => $request->masa_ujian, 'tempat_ujian' => $request->tempat_ujian,
            'keputusan' => $request->keputusan
        ]);
        return redirect()->back()->with(['success' => 'Data Calon Dikemaskini!', 'open_modal' => true]);
    }

    public function destroy($id) {
        DB::table('keputusan_penilaian')->where('id', $id)->delete();
        return redirect()->back()->with(['success' => 'Rekod dipadam!', 'open_modal' => true]);
    }

    public function store_profil(Request $request) {
        if($request->stats) {
            foreach ($request->stats as $kategori => $jumlah) {
                DB::table('statistik_utama')->where('kategori', $kategori)->update(['jumlah' => $jumlah]);
            }
        }
        return redirect()->back()->with('success', 'Statistik Berjaya Dikemaskini!');
    }

   public function cetak_slip($ic)
{
    // Cari data berdasarkan IC yang dihantar melalui URL
    $data = DB::table('keputusan_penilaian')->where('ic_number', $ic)->first();

    if (!$data) {
        return "Rekod tidak dijumpai untuk dicetak.";
    }

    // Hantar ke fail cetak_slip.blade.php
    return view('kompetensi.cetak_slip', compact('data'));
}
    
    public function hantar_emel_penempatan(Request $request)
{
    // Ambil data user yang sedang login
    $user = Auth::user();
    
    // Data yang mahu dihantar dalam emel
    $data = [
        'nama' => $user->name,
        'ic'   => $user->ic_number,
        'mesej' => "Mohon semakan maklumat penempatan ujian kompetensi."
    ];

    try {
        // Kita guna Mail facade Laravel
        // Pastikan Afif dah setup .env (SMTP) untuk Gmail/Mailtrap
        Mail::send('emails.penempatan', $data, function($message) use ($user) {
            $message->to('admin@test.com', 'Urusetia Kompetensi')
                    ->subject('Permohonan Maklumat Penempatan Ujian - ' . $user->name);
        });

        return redirect()->back()->with('success', 'Emel permohonan telah dihantar ke Urusetia.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal hantar emel. Sila semak konfigurasi SMTP anda.');
    }
}

public function hantar_borang_hubungi(Request $request)
{
    // Di sini nanti Afif boleh letak logik Mail::send
    return redirect()->back()->with('success', 'Terima kasih! Mesej anda telah diterima dan akan diproses oleh Urusetia.');
}


}

