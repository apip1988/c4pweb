@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="border: 2px solid #3051a0; border-radius: 10px;">
                <div class="panel-heading" style="background-color: #3051a0; color: white; font-weight: bold; text-align: center;">
                    HASIL SEMAKAN KEPUTUSAN PENILAIAN KOMPETENSI
                </div>
                <div class="panel-body">
                    <table class="table table-striped" style="margin-top: 20px;">
                        <tr>
                            <th width="40%">NAMA</th>
                            <td>{{ $data->nama }}</td>
                        </tr>
                        <tr>
                            <th>NO. KAD PENGENALAN</th>
                            <td>{{ $data->ic_number }}</td>
                        </tr>
                        <tr>
                            <th>TARIKH PENILAIAN</th>
                            <td>{{ date('d/m/Y', strtotime($data->tarikh_penilaian)) }}</td>
                        </tr>
                        <tr>
                            <th>KEPUTUSAN</th>
                            <td>
                                @if($data->keputusan == 'LULUS')
                                    <span class="label label-success" style="font-size: 14px; padding: 5px 15px;">LULUS</span>
                                @elseif($data->keputusan == 'GAGAL')
                                    <span class="label label-danger" style="font-size: 14px; padding: 5px 15px;">GAGAL</span>
                                @else
                                    <span class="label label-warning" style="font-size: 14px; padding: 5px 15px;">TIDAK HADIR & GAGAL</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>
                    <div class="text-center" style="margin-bottom: 20px;">
                        <p style="font-weight: bold; color: #3051a0;">SILA TEKAN <span style="color: red;">Ctrl + P</span> UNTUK CETAK SURAT KEPUTUSAN DALAM PDF</p>
                        
                        <a href="{{ route('kompetensi.cetak', $hasil->ic_number) }}" class="btn btn-dark shadow-sm" target="_blank">
    <i class="fas fa-print mr-2"></i> CETAK SLIP KEPUTUSAN
</a>
                    </div>

                    <div style="font-size: 11px; color: #666; font-style: italic; border-top: 1px solid #eee; padding-top: 10px;">
                        * Sekiranya ada sebarang pertanyaan, sila hubungi Cawangan Perkhidmatan Penolong Pegawai Perubatan.
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ url('/kompetensi/semak') }}" class="btn btn-default">Kembali ke Semakan</a>
            </div>
        </div>
    </div>
</div>
@endsection