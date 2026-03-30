@extends('layouts.app')

@section('content')
<style>
    .direktori-wrapper { padding: 40px 20px; background: #f0f4f8; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
    .header-title { text-align: center; color: #3051a0; margin-bottom: 40px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; }
    
    .section-divider { text-align: center; margin: 50px 0 30px; border-bottom: 3px solid #3051a0; padding-bottom: 10px; width: fit-content; margin-left: auto; margin-right: auto; }
    .section-divider h3 { color: #3051a0; font-size: 1.4rem; font-weight: 700; margin: 0; }

    /* --- SLIDE PROFESIONAL (CAROUSEL) --- */
    .boss-slide-card {
        background: white; border-radius: 20px; padding: 40px; text-align: center;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-top: 8px solid #3051a0;
        max-width: 600px; margin: 0 auto;
    }
    .boss-img { width: 100px; height: 100px; border-radius: 50%; background: #eef2f7; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border: 3px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .boss-img i { font-size: 3rem; color: #3051a0; }
    .boss-name { font-size: 1.4rem; font-weight: 700; color: #2c3e50; }
    .boss-pos { font-size: 0.9rem; color: #3051a0; font-weight: 600; text-transform: uppercase; }

    /* --- TAB ANGGOTA DENGAN TAJUK KOLUM --- */
    .tab-container { background: #fff; border-radius: 25px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .column-header { color: #3051a0; font-weight: 700; font-size: 1.1rem; margin-bottom: 20px; border-bottom: 2px solid #3051a0; padding-bottom: 5px; display: inline-block; width: 100%; }
    
    .nav-pills .nav-link { background: #f8f9fa; color: #333; margin-bottom: 10px; border-radius: 12px; padding: 15px; font-weight: 600; border: 1px solid #eee; text-align: left; transition: 0.3s; }
    .nav-pills .nav-link.active { background: #3051a0 !important; color: white !important; transform: translateX(10px); }
    
    /* List Nama (Tengah) */
    .name-list .nav-link { background: #f0f2f5; border: none; font-size: 0.85rem; }
    .name-list .nav-link.active { background: #6c5ce7 !important; color: white !important; }

    /* Butiran (Kanan) */
    .detail-card { background: #fcfcfc; border-radius: 20px; padding: 30px; border: 1px solid #f0f0f0; min-height: 400px; }
    .detail-label { color: #3051a0; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-top: 15px; display: block; }
    .detail-value { color: #333; font-weight: 600; font-size: 1rem; border-bottom: 1px solid #eee; padding-bottom: 5px; display: block; }

    /* --- BENDERA NEGERI (6 MELINTANG) --- */
    .flag-grid-balanced { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; max-width: 1250px; margin: 0 auto; }
    .flag-item { background: #fff; padding: 15px; border-radius: 15px; text-align: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s; width: calc(16.66% - 15px); min-width: 150px; border: 1px solid #eee; }
    .flag-item:hover { background: #3051a0; color: #fff; transform: translateY(-5px); }
    .flag-circle { width: 55px; height: 55px; border-radius: 50%; margin: 0 auto 10px; background: #3051a0; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid #ddd; }
    .negeri-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
</style>

<div class="direktori-wrapper">
    <h1 class="header-title">Direktori PPP Malaysia</h1>

    <div id="bossCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @php
                $bosses = [
                    ['n' => 'En. Zulhelmi bin Abdullah', 'p' => 'Ketua Penolong Pegawai Perubatan Malaysia'],
                    ['n' => 'Tn. Hj. Mahadir bin Yunos', 'p' => 'Timbalan KPPPM'],
                    ['n' => 'Tn. Hj. Amin Zafri bin Abd Rahman', 'p' => 'Timbalan KPPPM (Kesihatan Awam)'],
                    ['n' => 'En. Alias bin Abu Hassan', 'p' => 'Ketua Sektor Dasar & Strategik'],
                    ['n' => 'En. Zulfikar bin Mohamed Khawari', 'p' => 'Ketua Sektor Pembangunan Profession'],
                    ['n' => 'En. Wan Asrulnizan bin Wan Mustaffa', 'p' => 'Ketua Sekretariat LPP']
                ];
            @endphp
            @foreach($bosses as $index => $b)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="boss-slide-card">
                    <div class="boss-img"><i class="fas fa-user-tie"></i></div>
                    <div class="boss-name">{{ $b['n'] }}</div>
                    <div class="boss-pos">{{ $b['p'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#bossCarousel" data-slide="prev"><i class="fas fa-chevron-left fa-2x text-dark"></i></a>
        <a class="carousel-control-next" href="#bossCarousel" data-slide="next"><i class="fas fa-chevron-right fa-2x text-dark"></i></a>
    </div>

    <div class="section-divider"><h3>Sektor / Unit & Anggota</h3></div>
    
    <div class="tab-container">
        <div class="row">
            <div class="col-md-4">
                <span class="column-header">Sektor / Unit</span>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <a class="nav-link active" data-toggle="pill" href="#s-dasar">Sektor Dasar & Strategik</a>
                    <a class="nav-link" data-toggle="pill" href="#s-pembangunan">Sektor Pembangunan Profession</a>
                    <a class="nav-link" data-toggle="pill" href="#s-lembaga">Sekretariat LPP</a>
                    <a class="nav-link" data-toggle="pill" href="#s-operasi">Unit Operasi</a>
                    <a class="nav-link" data-toggle="pill" href="#s-mystep">MySTEP</a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="tab-content" id="v-pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="s-dasar">
                        <div class="row">
                            <div class="col-md-5">
                                <span class="column-header">Nama Ahli</span>
                                <div class="nav flex-column nav-pills name-list" role="tablist">
                                    <a class="nav-link active" data-toggle="pill" href="#user-afif">MUHAMMAD AFIF BIN NORDIN</a>
                                    <a class="nav-link" data-toggle="pill" href="#user-afiq">NIK ABDUL AFIQ BIN ABD AZIZ</a>
                                    <a class="nav-link" data-toggle="pill" href="#user-najib">MOHD NAJIB BIN RAMLI</a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <span class="column-header">Butiran Ahli</span>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="user-afif">
                                        <div class="detail-card">
                                            <span class="detail-label">Nama</span><span class="detail-value">MUHAMMAD AFIF BIN NORDIN</span>
                                            <span class="detail-label">Pangkat</span><span class="detail-value">Ketua Unit Dasar, Pengurusan Sumber Manusia & Pembangunan Modal Insan</span>
                                            <span class="detail-label">E-mel</span><span class="detail-value text-primary">afifnordin88@moh.gov.my</span>
                                            <span class="detail-label">Telefon</span><span class="detail-value">03-88831466</span>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="user-afiq">
                                        <div class="detail-card">
                                            <span class="detail-label">Nama</span><span class="detail-value">NIK ABDUL AFIQ BIN ABD AZIZ</span>
                                            <span class="detail-label">Pangkat</span><span class="detail-value">Pegawai Unit Dasar</span>
                                            <span class="detail-label">E-mel</span><span class="detail-value text-primary">nikafiq@moh.gov.my</span>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="user-najib">
                                        <div class="detail-card"><p class="p-4 text-muted">Sila kemaskini butiran Mohd Najib.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="s-pembangunan"><p class="p-5 text-center">Data Sektor Pembangunan Profession</p></div>
                    <div class="tab-pane fade" id="s-lembaga"><p class="p-5 text-center">Data Sekretariat LPP</p></div>
                    <div class="tab-pane fade" id="s-operasi"><p class="p-5 text-center text-muted">Pilih nama ahli di Unit Operasi.</p></div>
                    <div class="tab-pane fade" id="s-mystep"><p class="p-5 text-center text-muted">Pilih nama ahli di MySTEP.</p></div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-divider"><h3>Direktori KPPPN (Negeri)</h3></div>
    <div class="flag-grid-balanced">
        @php
            $negeri = [
                ['id'=>'pls','n'=>'Perlis'],['id'=>'kdh','n'=>'Kedah'],['id'=>'png','n'=>'P.Pinang'],['id'=>'prk','n'=>'Perak'],['id'=>'sgr','n'=>'Selangor'],['id'=>'nsn','n'=>'N.Sembilan'],
                ['id'=>'mlk','n'=>'Melaka'],['id'=>'jhr','n'=>'Johor'],['id'=>'phg','n'=>'Pahang'],['id'=>'trg','n'=>'Terengganu'],['id'=>'ktn','n'=>'Kelantan'],['id'=>'sbh','n'=>'Sabah'],
                ['id'=>'swk','n'=>'Sarawak'],['id'=>'wpkl','n'=>'WP KL'],['id'=>'wpj','n'=>'WP Putrajaya'],['id'=>'wpl','n'=>'WP Labuan'],['id'=>'ikn','n'=>'Inst. Kanser'],['id'=>'ipr','n'=>'Inst. Respiratori']
            ];
        @endphp
        @foreach($negeri as $n)
        <div class="flag-item" data-toggle="modal" data-target="#modal-{{ $n['id'] }}">
            <div class="flag-circle">{{ strtoupper($n['id']) }}</div>
            <div class="negeri-label">{{ $n['n'] }}</div>
        </div>
        @endforeach
    </div>

    @foreach($negeri as $n)
    <div class="modal fade" id="modal-{{ $n['id'] }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:20px;">
                <div class="modal-header bg-primary text-white"><h5>PPP Negeri: {{ $n['n'] }}</h5></div>
                <div class="modal-body p-4">
                    <div class="p-3 bg-light mb-2 border-left border-primary" style="border-left-width:5px !important;"><h6>KPPPN Negeri</h6><p class="mb-0 text-muted">Pejabat: 0x-xxxxxxx</p></div>
                    <div class="p-3 bg-light mb-2 border-left border-success" style="border-left-width:5px !important;"><h6>Timbalan (Perubatan)</h6></div>
                    <div class="p-3 bg-light border-left border-warning" style="border-left-width:5px !important;"><h6>Timbalan (Kesihatan Awam)</h6></div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection