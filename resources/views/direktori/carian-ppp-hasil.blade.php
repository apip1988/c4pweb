@extends('layouts.app')

@section('content')
<style>
    /* Gunakan Font Serif untuk nampak rasmi & klasik slip SPM */
    .slip-spm {
        font-family: 'Times New Roman', Times, serif; 
        max-width: 600px;
        margin: 50px auto;
        padding: 40px;
        background: #fff;
        border: 2px solid #333; /* Bingkai utama */
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        color: #1a1a1a;
    }

    .slip-header {
        text-align: center;
        border-bottom: 2px solid #333;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .slip-header h1 {
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        margin: 0;
        letter-spacing: 1px;
    }

    .slip-header p {
        font-size: 16px;
        margin: 5px 0 0;
        text-transform: uppercase;
    }

    .slip-table {
        width: 100%;
        border-collapse: collapse;
    }

    .slip-table th, 
    .slip-table td {
        border: 1px solid #999; /* Garis tipis untuk dalam slip */
        padding: 15px 20px;
        vertical-align: top;
    }

    .slip-table th {
        background-color: #f9f9f9;
        text-align: left;
        width: 40%;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .slip-table td {
        font-size: 18px; /* Data keluar besar sikit */
        text-transform: uppercase; /* Semua data jadi HURUF BESAR */
        font-weight: normal;
    }

    .slip-footer {
        text-align: center;
        border-top: 2px solid #333;
        margin-top: 40px;
        padding-top: 20px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="container py-3">
    
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <a href="{{ route('direktori.carian_ppp.index') }}" class="btn btn-secondary btn-sm rounded-pill px-4">
                <i class="fas fa-arrow-left mr-2"></i> Kembali Ke Borang Carian
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="slip-spm">
                
                <div class="slip-header">
                    <h1>PORTAL PERKHIDMATAN PPP</h1>
                    <p>DIREKTORI PENOLONG PEGAWAI PERUBATAN (PPP)</p>
                    <div style="border-top: 1px solid #ddd; padding-top: 5px; margin-top: 10px; font-size: 12px;">SLIP CARIAN MAKLUMAT PPP</div>
                </div>

                <div class="slip-body">
                    <table class="slip-table">
    <tr>
        <th>NAMA LENGKAP</th>
        <td>{{ strtoupper($hasil_carian->name) }}</td>
    </tr>
    <tr>
        <th>NO. LPP</th>
        <td>{{ $hasil_carian->no_lpp }}</td>
    </tr>
    <tr>
        <th>TARIKH LANTIKAN</th>
        <td>{{ isset($hasil_carian->tarikh_lantikan) ? $hasil_carian->tarikh_lantikan : '-' }}</td>
    </tr>
    <tr>
        <th>TEMPAT BERTUGAS (PTJ)</th>
        <td>{{ isset($hasil_carian->ptj_sekarang) ? strtoupper($hasil_carian->ptj_sekarang) : '-' }}</td>
    </tr>
</table>
                </div>

                <div class="slip-footer">
                    <p>*** MAKLUMAT INI ADALAH UNTUK SEMAKAN SAHAJA. TIDAK BOLEH DIGUNAKAN SEBAGAI BUKTI RASMI PELANTIKAN. ***</p>
                    <p style="font-size: 10px;">TARIKH SEMAKAN: {{ date('d-m-Y H:i:s') }} | KATA KUNCI: '{{ $kata_kunci }}'</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection