<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Slip Keputusan PPT 2026</title>
    <style>
    @page { size: A4; margin: 0; }
    
    body { 
        font-family: "Arial", sans-serif; 
        line-height: 1.5; 
        margin: 0;
        padding: 0;
        color: #000;
    }

    .page-wrapper {
        position: relative;
        width: 210mm;
        height: 297mm;
        padding: 0.4in 0.6in;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .text-center { text-align: center; }
    .header { margin-bottom: 10px; line-height: 1.2; }
    .logo { width: 90px; margin-bottom: 5px; }
    
    .header-text { font-weight: bold; font-size: 13px; }

    .title { 
        font-weight: bold; 
        text-decoration: underline; 
        margin: 15px 0; 
        text-transform: uppercase; 
        font-size: 14px; 
        line-height: 1.3;
    }
    
    .table-data { width: 100%; border-collapse: collapse; }
    .table-data td { vertical-align: top; padding: 2px 0; font-size: 13px; }
    
    /* --- BAHAGIAN WARNA KOTAK (JADUAL) --- */
    .result-table { 
        width: 100%; 
        border: 1.5px solid black; 
        border-collapse: collapse; 
        margin: 15px 0; 
        background-color: #fcfcfc; /* Kelabu sangat cair untuk isi */
    }
    .result-table th { 
        border: 1.5px solid black; 
        padding: 10px; 
        text-align: center; 
        font-weight: bold; 
        background-color: #d3d3d3; /* INI WARNA KELABU LIGHT UNTUK TAJUK KOTAK */
    }
    .result-table td { 
        border: 1.5px solid black; 
        padding: 10px; 
        text-align: center; 
        font-weight: bold; 
    }
    /* ------------------------------------ */
    
    .main-content p { margin: 10px 0; text-align: justify; font-size: 13px; }

    .signature-section { margin-top: 15px; line-height: 1.3; }

    .footer-note { 
        position: absolute;
        bottom: 0.4in; 
        left: 0;
        right: 0;
        text-align: center;
        font-size: 11px;
        font-weight: bold;
        padding-top: 5px;
    }

    @media print { 
        .no-print { display: none; }
        .page-wrapper { height: 297mm; }
    }
</style>
</head>
<body>
    <div class="no-print" style="text-align: center; padding: 10px; background: #eee;">
        <button onclick="window.print()" style="padding: 10px 20px; font-weight: bold; cursor: pointer;">CETAK SLIP </button>
    </div>

    <div class="page-wrapper">
        <div class="text-center header">
    <img src="{{ asset('img/logo_kkm.png') }}" class="logo">
    <div style="font-weight: bold;">
        KEMENTERIAN KESIHATAN MALAYSIA<br>
        CAWANGAN PERKHIDMATAN PENOLONG PEGAWAI PERUBATAN<br>
        BAHAGIAN AMALAN PERUBATAN<br>
        ARAS 6, BLOK E1, KOMPLEK E<br>
        PUSAT PENTADBIRAN KERAJAAN PERSEKUTUAN<br>
        62590 PUTRAJAYA, W.P PUTRAJAYA.
    </div>
</div>

        <div class="main-content">
            <table class="table-data">
                <tr>
                    <td width="28%">NAMA CALON</td>
                    <td width="2%">:</td>
                    <td style="font-weight: bold;">{{ strtoupper($data->nama) }}</td>
                </tr>
                <tr>
                    <td>NO. KAD PENGENALAN</td>
                    <td>:</td>
                    <td style="font-weight: bold;">{{ $data->ic_number }}</td>
                </tr>
                <tr>
                    <td>NO. PENDAFTARAN</td>
                    <td>:</td>
                    <td style="font-weight: bold;">{{ isset($data->siri_no) ? $data->siri_no : '-' }}</td>
                </tr>
            </table>

            <p>Tuan/Puan,</p>

            <div class="title text-center">
                SLIP KEPUTUSAN PENILAIAN KOMPETENSI<br>
                PERAKUAN PEMBAHARUAN TAHUNAN (PPT) TAHUN 2026
            </div>

            <p>Dengan hormatnya merujuk perkara di atas.</p>

            <p>2. &nbsp;&nbsp; Adalah disahkan bahawa tuan/puan telah menjalani Penilaian Kompetensi Perakuan Pembaharuan Tahunan (PPT) tahun 2026 pada tarikh dan keputusan penilaian seperti berikut :-</p>

            <table class="result-table">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th width="50%">TARIKH PENILAIAN</th>
                        <th width="50%">KEPUTUSAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($data->tarikh_penilaian)) }}</td>
                        <td>{{ strtoupper($data->keputusan) }}</td>
                    </tr>
                </tbody>
            </table>

            <p style="font-size: 12px; line-height: 1.4;">
                <strong>PERHATIAN:</strong> Memperbaharui Perakuan Pembaharuan Tahunan (PPT) adalah menjadi tanggungjawab setiap Pembantu Perubatan berdaftar.
                Kegagalan memperbaharui PPT boleh diambil tindakan pemotongan nama dari daftar Pembantu Perubatan mengikut Akta 180, Seksyen 14 sub seksyen (1) (C).
            </p>

            <p>3. &nbsp;&nbsp; Sehubungan itu, sebarang pertanyaan, sila hubungi Urusetia Penilaian Kompetensi di talian: 03-88831479.
            Tanggungjawab dan kesedaran tuan/puan dalam perkara ini amatlah dihargai.</p>

            <p>Sekian, terima kasih.</p>

            <div class="signature-section">
                <p style="font-weight: bold;">
                    "MALAYSIA MADANI"<br>
                    “BERKHIDMAT UNTUK NEGARA”
                </p>

                <p style="font-size: 12px;">
                    Urusetia<br>
                    Penilaian Kompetensi PPT/ARC<br>
                    Sekretariat Lembaga Pembantu Perubatan<br>
                    Cawangan Perkhidmatan Penolong Pegawai Perubatan, KKM
                </p>
            </div>
        </div>

        <div class="footer-note">
            *CETAKAN KOMPUTER TIDAK PERLU TANDATANGAN*
        </div>
    </div>
</body>
</html>