@extends('layouts.app')

@section('content')
<style>
    /* Tema Hijau Mint Soft */
    :root { 
        --mint-main: #4db6ac; 
        --mint-light: #e0f2f1; 
        --mint-dark: #00897b; 
        --bg-soft: #f4fdfb;
    }
    
    body { background-color: var(--bg-soft); }

    .header-box { 
        background: linear-gradient(135deg, var(--mint-main) 0%, #80cbc4 100%); 
        padding: 50px 0; 
        border-radius: 0 0 40px 40px; 
        color: white; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .search-section { 
        background: white; 
        border-radius: 20px; 
        padding: 30px; 
        margin-top: -50px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid var(--mint-light);
    }

    .btn-mint { 
        background-color: var(--mint-dark); 
        color: white; 
        border-radius: 12px; 
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-mint:hover { background-color: #00695c; color: white; transform: translateY(-2px); }

    .card-info { 
        background: white; 
        border-radius: 15px; 
        border: none; 
        border-left: 6px solid var(--mint-main);
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .table-custom thead { background-color: var(--mint-main); color: white; }
    .badge-upcoming { background-color: #fff9c4; color: #f57f17; border: 1px solid #fbc02d; }
</style>

<div class="header-box text-center">
    <h2 class="font-weight-bold text-uppercase">Portal e-Credentialing</h2>
    <p class="opacity-75">Cawangan Perkhidmatan Penolong Pegawai Perubatan</p>
</div>

<div class="container mb-5">
    <div class="search-section mb-5">
        <h5 class="font-weight-bold mb-4" style="color: var(--mint-dark);">
            <i class="fas fa-folder-open mr-2"></i>Carian Dokumen Credentialing
        </h5>
        <form class="row">
            <div class="col-md-5 mb-3">
                <label class="small font-weight-bold">Disiplin</label>
                <select class="form-control form-control-lg" style="border-radius: 10px;">
                    <option>-- Pilih Disiplin --</option>
                    @foreach($disciplines as $d) <option>{{ $d }}</option> @endforeach
                </select>
            </div>
            <div class="col-md-5 mb-3">
                <label class="small font-weight-bold">Nama Dokumen</label>
                <select class="form-control form-control-lg" style="border-radius: 10px;">
                    <option>-- Pilih Jenis Dokumen --</option>
                    @foreach($docTypes as $doc) <option>{{ $doc }}</option> @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-mint btn-lg btn-block shadow-sm">CARI</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <h5 class="font-weight-bold mb-3" style="color: var(--mint-dark);">Jadual Persidangan SSC & NCC</h5>
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                <table class="table table-hover mb-0 table-custom">
                    <thead>
                        <tr>
                            <th>Mesyuarat / Sidang</th>
                            <th>Tarikh Bersidang</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Specialist Sub-Committee (SSC) Bil 1/2026</td>
                            <td>15 Mac 2026</td>
                            <td class="text-center"><span class="badge badge-success px-3 py-2">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>National Credentialing Committee (NCC) Bil 1/2026</td>
                            <td>22 Jun 2026</td>
                            <td class="text-center"><span class="badge badge-upcoming px-3 py-2">Akan Datang</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <h5 class="font-weight-bold mb-3" style="color: var(--mint-dark);">PIC Credentialing</h5>
            <div class="card card-info p-3 mb-3">
                <p class="mb-1 font-weight-bold" style="color: var(--mint-dark);">Urusetia Credentialing</p>
                <p class="small mb-1 text-muted"><i class="fas fa-user-tie mr-2"></i>En. Ahmad Shauki</p>
                <p class="small mb-0 text-muted"><i class="fas fa-phone-alt mr-2"></i>03-8883 1XXX</p>
            </div>
            <div class="card card-info p-3">
                <p class="mb-1 font-weight-bold" style="color: var(--mint-dark);">Sekretariat SSC/NCC</p>
                <p class="small mb-1 text-muted"><i class="fas fa-user-edit mr-2"></i>Pn. Siti Fatimah</p>
                <p class="small mb-0 text-muted"><i class="fas fa-envelope mr-2"></i>siti.f@moh.gov.my</p>
            </div>
        </div>
    </div>
</div>
@endsection