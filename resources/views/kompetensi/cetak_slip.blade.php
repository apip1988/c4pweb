@extends('layouts.app')

@section('content')
<style>
    /* 1. CSS UNTUK PAPARAN SKRIN (SCREEN) */
    .surat-container {
        background-color: white;
        padding: 40px 60px;
        margin: 20px auto;
        width: 210mm;
        min-height: 297mm;
        border: 1px solid #ddd;
        font-family: Arial, Helvetica, sans-serif;
        color: black;
        line-height: 1.4;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .header-kkm {
        text-align: center;
        margin-bottom: 20px;
    }

    .header-kkm img {
        width: 100px;
        margin-bottom: 10px;
    }

    .header-kkm p {
        margin: 0;
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
    }

    .alamat-kkm {
        font-size: 12px;
        font-weight: normal !important;
        margin-top: 5px !important;
    }

    .content-body {
        margin-top: 40px;
        font-size: 14px;
    }

    .title-slip {
        margin-top: 30px;
        font-weight: bold;
        text-decoration: underline;
        text-transform: uppercase;
    }

    .table-keputusan {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .table-keputusan th, .table-keputusan td {
        border: 1px solid black;
        padding: 10px;
        text-align: left;
        font-weight: bold;
    }

    .perhatian-box {
        margin-top: 20px;
        font-size: 13px;
        text-align: justify;
    }

    .footer-surat {
        margin-top: 40px;
    }

    .no-print-btn {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    /* 2. CSS KHAS UNTUK CETAKAN (PRINT) */
    @media print {
        /* SOROKKAN SEMUA KOMPONEN PORTAL */
        header, 
        nav, 
        footer, 
        #top-nav, 
        .nav-custom, 
        .no-print-btn,
        .navbar { 
            display: none !important; 
        }

        /* RESET CONTAINER UNTUK KERTAS A4 */
        .surat-container {
            margin: 0 !important;
            padding: 20px !important;
            border: none !important;
            width: 100% !important;
            box-shadow: none !important;
        }

        body { 
            background: white !important; 
            margin: 0 !important;
        }

        /* Pastikan table nampak border bila print */
        .table-keputusan th, .table-keputusan td {
            border: 1px solid black !important;
        }
    }
</style>

<div class="no-print-btn">
    <button onclick="window.print()" class="btn btn-primary px-5 rounded-pill shadow">
        <i class="fas fa-print"></i> CETAK SLIP RASMI
    </button>
    <p class="small text-muted mt-2">Sila pastikan "Headers and Footers" di-uncheck dalam tetapan printer anda.</p>
</div>

<div class="surat-container">
    <div class="header-kkm">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Coat_of_arms_of_Malaysia.svg/1200px-Coat_of_arms_of_Malaysia.svg.png" alt="Jata Negara">
        <p>KEMENTERIAN KESIHATAN MALAYSIA</p>
        <p>CAWANGAN PERKHIDMATAN PENOLONG PEGAWAI PERUBATAN</p>
        <p>BAHAGIAN AMALAN PERUBATAN</p>
        <p class="alamat-kkm">ARAS 6, BLOK E1, KOMPLEK E</p>
        <p class="alamat-kkm">PUSAT PENTADBIRAN KERAJAAN PERSEKUTUAN</p>
        <p class="alamat-kkm">62590 PUTRAJAYA, W.P PUTRAJAYA.</p>
    </div>

    <hr style="border: 1px solid black;">

    <div class="content-body">
        <p><strong>NAMA CALON:</strong> {{ strtoupper($data->nama) }}</p>
        <p><strong>NO. KAD PENGENALAN :</strong> {{ $data->ic_number }}</p>
        <p><strong>NO. PENDAFTARAN (LPP) :</strong> {{ isset($data->no_lpp) ? $data->no_lpp : '-' }}</p>

        <p style="margin-top: 20px;">Tuan/Puan,</p>

        <p class="title-slip">
            SLIP KEPUTUSAN PENILAIAN KOMPETENSI<br>
            PERAKUAN PEMBAHARUAN TAHUNAN (PPT) TAHUN {{ date('Y') + 1 }}
        </p>

        <p>Dengan hormatnya merujuk perkara di atas.</p>

        <p>2. Adalah disahkan bahawa tuan/puan telah menjalani Penilaian Kompetensi Perakuan Pembaharuan Tahunan (PPT) tahun {{ date('Y') + 1 }} pada tarikh dan keputusan penilaian seperti berikut :-</p>

        <table class="table-keputusan">
            <thead>
                <tr>
                    <th>TARIKH PENILAIAN</th>
                    <th>KEPUTUSAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ isset($data->tarikh_ujian) ? date('d/m/Y', strtotime($data->tarikh_ujian)) : 'TIADA MAKLUMAT' }}</td>
                    <td style="color: {{ $data->keputusan == 'GAGAL' ? 'red' : 'black' }};">
                        {{ strtoupper($data->keputusan) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="perhatian-box">
            <p><strong>PERHATIAN:</strong> Memperbaharui Perakuan Pembaharuan Tahunan (PPT) adalah menjadi tanggungjawab setiap Pembantu Perubatan berdaftar. 
            Kegagalan memperbaharui PPT boleh diambil tindakan pemotongan nama dari daftar Pembantu Perubatan mengikut Akta 180, Seksyen 14 sub seksyen (1) (C).</p>
        </div>

        <p>3. Sehubungan itu, sebarang pertanyaan, sila hubungi Urusetia Penilaian Kompetensi di talian: 03-88831479.</p>

        <p style="margin-top: 20px;">Tanggungjawab dan kesedaran tuan/puan dalam perkara ini amatlah dihargai.</p>

        <div class="footer-surat">
            <p>Sekian, terima kasih.</p>
            <p><strong>"MALAYSIA MADANI"</strong></p>
            <p><strong>"BERKHIDMAT UNTUK NEGARA"</strong></p>
            
            <p style="margin-top: 30px; line-height: 1.2;">
                Urusetia<br>
                Penilaian Kompetensi PPT/ARC<br>
                Sekretariat Lembaga Pembantu Perubatan<br>
                Cawangan Perkhidmatan Penolong Pegawai Perubatan, KKM
            </p>

            <p style="margin-top: 40px; font-size: 11px; font-style: italic;">
                *CETAKAN KOMPUTER TIDAK PERLU TANDATANGAN
            </p>
        </div>
    </div>
</div>
@endsection