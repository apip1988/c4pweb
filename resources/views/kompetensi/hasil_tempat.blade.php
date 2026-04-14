@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo_kkm.png') }}" alt="Logo KKM" style="width: 120px;" class="mb-3">
                <h5 class="font-weight-bold mb-0">CAWANGAN PERKHIDMATAN PENOLONG PEGAWAI PERUBATAN</h5>
                <p class="mb-0">BAHAGIAN AMALAN PERUBATAN</p>
                <p class="mb-0">ARAS 6, BLOK E1, KOMPLEK E</p>
                <p class="mb-0">PUSAT PENTADBIRAN KERAJAAN PERSEKUTUAN, 62590 PUTRAJAYA</p>
                <p>Tel: 03-88831370/1373/1378</p>
            </div>

            <div class="card border-primary mb-4" style="border: 2px solid #3051a0; border-radius: 15px;">
                <div class="card-body text-center py-5">
                    <h3 class="font-weight-bold" style="color: #3051a0;">SEMAKAN</h3>
                    <h4 class="font-weight-bold" style="color: #3051a0;">MAKLUMAT PENEMPATAN UJIAN</h4>
                    <p class="text-muted font-italic mb-4">
                        ** CALON DIKEHENDAKI BERADA DI LOKASI 30 MINIT SEBELUM UJIAN BERMULA **
                    </p>

                    <div class="row justify-content-center">
                        <div class="col-md-8 text-left bg-light p-4 rounded shadow-sm">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th width="40%">NAMA CALON</th>
                                    <td>: {{ strtoupper($calon->nama) }}</td>
                                </tr>
                                <tr>
                                    <th>NO. KAD PENGENALAN</th>
                                    <td>: {{ $calon->no_ic }}</td>
                                </tr>
                                <tr>
                                    <th>LOKASI UJIAN</th>
                                    <td class="text-danger font-weight-bold">: {{ strtoupper($calon->tempat_peperiksaan ?? 'DALAM PROSES') }}</td>
                                </tr>
                                <tr>
                                    <th>STATUS KELAYAKAN</th>
                                    <td>: 
                                        <span class="badge {{ $calon->status_kelayakan == 'LAYAK' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $calon->status_kelayakan ?? 'DALAM PROSES' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="mb-4">
                    Sila cetak slip maklumat penempatan ini untuk rujukan semasa hari peperiksaan.
                </p>
                
                <div class="alert alert-info d-inline-block">
                    <i class="fas fa-print mr-2"></i> 
                    <strong>SILA TEKAN <span class="text-danger">Ctrl + P</span> UNTUK CETAK SURAT PANGGULAN DALAM PDF</strong>
                </div>

                <div class="mt-4 no-print">
                    <a href="{{ route('kompetensi.tempat') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <p class="text-center text-muted mt-5 small">
                Sekiranya ada sebarang pertanyaan, sila hubungi Cawangan Perkhidmatan Penolong Pegawai Perubatan, Kementerian Kesihatan Malaysia. <br>
                Dokumen ini dijana melalui cetakan komputer. Tiada tanda tangan diperlukan.
            </p>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print, #top-nav, footer { display: none !important; }
        body { padding-top: 0 !important; background: white !important; }
        .container { width: 100% !important; max-width: 100% !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-body { padding: 0 !important; }
    }
</style>
@endsection