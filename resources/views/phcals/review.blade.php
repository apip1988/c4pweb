@extends('layouts.app')

@section('content')
<style>
    .letter-head { border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 30px; }
    .certificate-box {
        background: #fff;
        padding: 50px;
        border: 1px solid #ddd;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 800px;
        margin: 40px auto;
        font-family: 'Times New Roman', Times, serif;
        color: #000;
    }
    .content-text { font-size: 18px; line-height: 1.6; text-align: justify; }
    .signature-space { margin-top: 50px; }
    @media print {
        #top-nav, .no-print { display: none; }
        .certificate-box { border: none; box-shadow: none; margin: 0; width: 100%; }
        body { background: #fff; padding: 0; }
    }
</style>

<div class="container no-print mt-4">
    <div class="d-flex justify-content-between">
        <a href="{{ route('phcals.history') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <button onclick="window.print()" class="btn btn-success"><i class="fas fa-print"></i> Cetak Sekarang</button>
    </div>
</div>

<div class="certificate-box">
    <div class="text-center letter-head">
        <h3 class="font-weight-bold mb-0">CAWANGAN PERKHIDMATAN PENOLONG PEGAWAI PERUBATAN</h3>
        <p class="mb-0">KEMENTERIAN KESIHATAN MALAYSIA</p>
    </div>

    <div class="text-right mb-4">
        <p>Tarikh: <strong>{{ $result->created_at->format('d F Y') }}</strong></p>
    </div>

    <div class="content-text">
        <p>Tuan / Puan,</p>
        
        <h4 class="text-center font-weight-bold my-4 text-uppercase">KEPUTUSAN UJIAN KOMPETENSI PHCALS (SET {{ $result->set_number }})</h4>

        <p>Adalah dimaklumkan bahawa penama di bawah telah menduduki Ujian Kompetensi PHCALS secara atas talian:</p>

        <table class="table table-borderless w-75">
            <tr>
                <td width="30%">NAMA</td>
                <td>: <strong>{{ strtoupper($result->user->name) }}</strong></td>
            </tr>
            <tr>
                <td>NO. K/P</td>
                <td>: <strong>{{ $result->user->ic_number }}</strong></td>
            </tr>
            <tr>
                <td>MARKAH</td>
                <td>: <strong class="text-success">{{ $result->score }}%</strong></td>
            </tr>
            <tr>
                <td>STATUS</td>
                <td>: <strong>LULUS (CEMERLANG)</strong></td>
            </tr>
        </table>

        <p>Tahniah diucapkan atas pencapaian anda. Keputusan ini membuktikan tahap kompetensi anda dalam pengurusan Pre-Hospital Care and Ambulance Life Support (PHCALS).</p>

        <p>Sekian, terima kasih.</p>
        
        <p><strong>"BERKHIDMAT UNTUK NEGARA"</strong></p>
    </div>

    <div class="signature-space">
        <p>Regards:</p>
        <br>
        <p><strong>(DR. LEONG)</strong><br>
        Ketua Perkhidmatan Penolong Pegawai Perubatan Malaysia,<br>
        Kementerian Kesihatan Malaysia.</p>
    </div>
</div>
@endsection