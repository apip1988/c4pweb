@extends('layouts.app')

@section('content')
<style>
    .direktori-wrapper { padding: 40px 20px; background: #f0f4f8; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
    .header-title { text-align: center; color: #3051a0; margin-bottom: 40px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; }
    
    .section-divider { text-align: center; margin: 50px 0 30px; border-bottom: 3px solid #3051a0; padding-bottom: 10px; width: fit-content; margin-left: auto; margin-right: auto; }
    .section-divider h3 { color: #3051a0; font-size: 1.4rem; font-weight: 700; margin: 0; }

    .boss-slide-card {
        background: white; border-radius: 20px; padding: 40px; text-align: center;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-top: 8px solid #3051a0;
        max-width: 600px; margin: 0 auto;
    }
    .boss-img { width: 100px; height: 100px; border-radius: 50%; background: #eef2f7; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border: 3px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .boss-img i { font-size: 3rem; color: #3051a0; }
    .boss-name { font-size: 1.4rem; font-weight: 700; color: #2c3e50; }
    .boss-pos { font-size: 0.9rem; color: #3051a0; font-weight: 600; text-transform: uppercase; }

    .tab-container { background: #fff; border-radius: 25px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .column-header { color: #3051a0; font-weight: 700; font-size: 1.1rem; margin-bottom: 20px; border-bottom: 2px solid #3051a0; padding-bottom: 5px; display: inline-block; width: 100%; }
    
    .nav-pills .nav-link { background: #f8f9fa; color: #333; margin-bottom: 10px; border-radius: 12px; padding: 15px; font-weight: 600; border: 1px solid #eee; text-align: left; transition: 0.3s; font-size: 0.9rem; }
    .nav-pills .nav-link.active { background: #3051a0 !important; color: white !important; transform: translateX(5px); }
    
    .name-list .nav-link { background: #f0f2f5; border: none; font-size: 0.75rem; padding: 10px; margin-bottom: 5px; }
    .name-list .nav-link.active { background: #6c5ce7 !important; color: white !important; }

    .detail-card { background: #fcfcfc; border-radius: 20px; padding: 30px; border: 1px solid #f0f0f0; min-height: 400px; transition: 0.3s; }
    .detail-label { color: #3051a0; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; margin-top: 15px; display: block; }
    .detail-value { color: #333; font-weight: 600; font-size: 0.95rem; border-bottom: 1px solid #eee; padding-bottom: 5px; display: block; word-break: break-all; }

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
            <div class="col-md-3">
                <span class="column-header">Sektor / Unit</span>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <a class="nav-link active" data-toggle="pill" href="#s-pembangunan">Sektor Pembangunan Profession</a>
                    <a class="nav-link" data-toggle="pill" href="#s-dasar">Sektor Dasar & Strategik</a>
                    <a class="nav-link" data-toggle="pill" href="#s-lembaga">Sekretariat LPP</a>
                    <a class="nav-link" data-toggle="pill" href="#s-operasi">Unit Operasi</a>
                    <a class="nav-link" data-toggle="pill" href="#s-mystep">MySTEP</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="s-pembangunan">
                        <div class="row">
                            <div class="col-md-5">
                                <span class="column-header">Nama Ahli</span>
                                <div class="nav flex-column nav-pills name-list" role="tablist">
                                    <a class="nav-link active" data-toggle="pill" href="#u1-1">ZULKIFLI BIN MUHAMMAD</a>
                                    <a class="nav-link" data-toggle="pill" href="#u1-2">KHAIRUDIN BIN ABU BAKAR</a>
                                    <a class="nav-link" data-toggle="pill" href="#u1-3">MOHD FARIS BIN ABDUL RASHID</a>
                                    <a class="nav-link" data-toggle="pill" href="#u1-4">AHMAD SHARIF BIN ABDUL TALIB</a>
                                    <a class="nav-link" data-toggle="pill" href="#u1-5">MUHAMMAD ROMZI BIN HUSAIN</a>
                                    <a class="nav-link" data-toggle="pill" href="#u1-6">SHAHROL BIN MD NOR</a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <span class="column-header">Butiran Ahli</span>
                                <div class="tab-content">
                                    @include('carta.detail', ['id' => 'u1-1', 'active' => true, 'n' => 'ZULKIFLI BIN MUHAMMAD', 'r' => 'Ketua Unit Peperiksaan', 'g' => 'Penolong Pegawai Perubatan (U42)', 'e' => 'zulkifli.ka@moh.gov.my', 't' => '03-88831406'])
                                    @include('carta.detail', ['id' => 'u1-2', 'n' => 'KHAIRUDIN BIN ABU BAKAR', 'r' => 'Ketua Unit Pendidikan', 'g' => 'Pengajar Penolong Pegawai Perubatan (U42)', 'e' => 'khai@moh.gov.my', 't' => '03-88831380'])
                                    @include('carta.detail', ['id' => 'u1-3', 'n' => 'MOHD FARIS BIN ABDUL RASHID', 'r' => 'Ketua Unit EMTS', 'g' => 'Penolong Pegawai Perubatan (U42)', 'e' => 'mdfaris@moh.gov.my', 't' => '03-88831517'])
                                    @include('carta.detail', ['id' => 'u1-4', 'n' => 'AHMAD SHARIF BIN ABDUL TALIB', 'r' => 'Unit Akreditasi & Fasiliti', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'asharif@moh.gov.my', 't' => '03-88831085'])
                                    @include('carta.detail', ['id' => 'u1-5', 'n' => 'MUHAMMAD ROMZI BIN HUSAIN', 'r' => 'Unit EMTS', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'muhammad.romzi@moh.gov.my', 't' => '03-88831386'])
                                    @include('carta.detail', ['id' => 'u1-6', 'n' => 'SHAHROL BIN MD NOR', 'r' => 'Akademi Pembantu Perubatan', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'shahrol.mn@moh.gov.my', 't' => '03-88831407'])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="s-dasar">
                        <div class="row">
                            <div class="col-md-5">
                                <span class="column-header">Nama Ahli</span>
                                <div class="nav flex-column nav-pills name-list" role="tablist">
                                    <a class="nav-link active" data-toggle="pill" href="#u2-1">MOHD NAJIB BIN RAMLI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u2-2">NIK ABDUL AFIQ BIN ABD AZIZ</a>
                                    <a class="nav-link" data-toggle="pill" href="#u2-3">MUHAMMAD AFIF BIN NORDIN</a>
                                    <a class="nav-link" data-toggle="pill" href="#u2-4">ZULKEPLY BIN GHAZALI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u2-5">M. REMO INDRA</a>
                                    <a class="nav-link" data-toggle="pill" href="#u2-6">AHZAM BIN NOR ANUAR</a>
                                    <a class="nav-link" data-toggle="pill" href="#u2-7">YM. ENGKU MOHD NAZRI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u2-8">MOHD SUHAIDI</a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <span class="column-header">Butiran Ahli</span>
                                <div class="tab-content">
                                    @include('carta.detail', ['id' => 'u2-1', 'active' => true, 'n' => 'MOHD NAJIB BIN RAMLI', 'r' => 'Ketua Unit PPK', 'g' => 'Penolong Pegawai Perubatan (U42)', 'e' => 'mnajib.ramli@moh.gov.my', 't' => '03-88831376'])
                                    @include('carta.detail', ['id' => 'u2-2', 'n' => 'NIK ABDUL AFIQ BIN ABD AZIZ', 'r' => 'Ketua Unit Dasar & HR', 'g' => 'Penolong Pegawai Perubatan (U41)', 'e' => 'nikafiq@moh.gov.my', 't' => '03-88831466'])
                                    @include('carta.detail', ['id' => 'u2-3', 'n' => 'MUHAMMAD AFIF BIN NORDIN', 'r' => 'Ketua Unit Kualiti & Inovasi', 'g' => 'Penolong Pegawai Perubatan (U41)', 'e' => 'muhd.afif@moh.gov.my', 't' => '03-88831408'])
                                    @include('carta.detail', ['id' => 'u2-4', 'n' => 'ZULKEPLY BIN GHAZALI', 'r' => 'Unit CPD', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'mazulkeply@moh.gov.my', 't' => '03-88831520'])
                                    @include('carta.detail', ['id' => 'u2-5', 'n' => 'MOHAMAD REMO INDRA', 'r' => 'Unit Dasar & HR', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'remoindra@moh.gov.my', 't' => '03-88831518'])
                                    @include('carta.detail', ['id' => 'u2-6', 'n' => 'AHZAM BIN NOR ANUAR', 'r' => 'Unit Kualiti & Inovasi', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'ahzam@moh.gov.my', 't' => '03-88831409'])
                                    @include('carta.detail', ['id' => 'u2-7', 'n' => 'YM. ENGKU MOHD NAZRI', 'r' => 'Unit Dasar & HR', 'g' => 'Penolong Pegawai Perubatan (U32)', 'e' => 'engkunazri@moh.gov.my', 't' => '03-88831379'])
                                    @include('carta.detail', ['id' => 'u2-8', 'n' => 'MOHD SUHAIDI BIN MOHD ARIFFIN', 'r' => 'Unit Kualiti & Inovasi', 'g' => 'Penolong Pegawai Perubatan (U32)', 'e' => 'suhaidi0705@moh.gov.my', 't' => '03-88831474'])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="s-lembaga">
                        <div class="row">
                            <div class="col-md-5">
                                <span class="column-header">Nama Ahli</span>
                                <div class="nav flex-column nav-pills name-list" role="tablist">
                                    <a class="nav-link active" data-toggle="pill" href="#u3-1">SADRI BIN SAIDI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-2">MOHAMMAD FAUZZI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-3">MAT SHARIFF</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-4">FADHLI IZNAN</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-5">ASMAWI BIN ABDULLAH</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-6">MUHAMMAD FALAH</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-7">AZMAZURA BINTI ABD AZIZ</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-8">HASLINA BINTI MD YUNUS</a>
                                    <a class="nav-link" data-toggle="pill" href="#u3-9">KOSONG 1</a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <span class="column-header">Butiran Ahli</span>
                                <div class="tab-content">
                                    @include('carta.detail', ['id' => 'u3-1', 'active' => true, 'n' => 'SADRI BIN SAIDI', 'r' => 'Ketua Unit Pendaftaran', 'g' => 'Penolong Pegawai Perubatan (U41)', 'e' => 'sadri@moh.gov.my', 't' => '03-88831412'])
                                    @include('carta.detail', ['id' => 'u3-2', 'n' => 'MOHAMMAD FAUZI BIN SHAMSUDDIN', 'r' => 'Ketua Unit Kawalan Amalan', 'g' => 'Penolong Pegawai Perubatan (U41)', 'e' => 'mohammad_fauzi@moh.gov.my', 't' => '03-88831490'])
                                    @include('carta.detail', ['id' => 'u3-3', 'n' => 'MAT SHARIFF BIN HJ. BUDIN', 'r' => 'Unit Kawalan Amalan', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'mat_shariff@moh.gov.my', 't' => '03-88831416'])
                                    @include('carta.detail', ['id' => 'u3-4', 'n' => 'FADHLI IZNAN BIN JAAFAR', 'r' => 'Unit Pewartaan', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'fadhliiznan@moh.gov.my', 't' => '03-88831549'])
                                    @include('carta.detail', ['id' => 'u3-5', 'n' => 'ASMAWI BIN ABDULLAH', 'r' => 'Sekretariat LPHE', 'g' => 'Penolong Pegawai Perubatan (U36)', 'e' => 'asmawi.a@moh.gov.my', 't' => '03-88831414'])
                                    @include('carta.detail', ['id' => 'u3-6', 'n' => 'MUHAMMAD FALAH BIN MOHD NOR', 'r' => 'Unit Pendaftaran', 'g' => 'Penolong Pegawai Perubatan (U32)', 'e' => 'falah@moh.gov.my', 't' => '03-88831468'])
                                    @include('carta.detail', ['id' => 'u3-7', 'n' => 'AZMAZURA BINTI ABDUL AZIZ', 'r' => 'Unit Pendaftaran', 'g' => 'Penolong Pegawai Perubatan (U32)', 'e' => 'azmazura@moh.gov.my', 't' => '03-88831544'])
                                    @include('carta.detail', ['id' => 'u3-8', 'n' => 'HASLINA BINTI MD YUNUS', 'r' => 'Unit Pendaftaran', 'g' => 'Pembantu Tadbir (N22)', 'e' => 'haslinah_1983@moh.gov.my', 't' => '03-88831545'])
                                    @include('carta.detail', ['id' => 'u3-9', 'n' => 'KOSONG 1', 'r' => 'Unit Pendaftaran', 'g' => 'Pembantu Tadbir (N19)', 'e' => '-', 't' => '-'])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="s-operasi">
                        <div class="row">
                            <div class="col-md-5">
                                <span class="column-header">Nama Ahli</span>
                                <div class="nav flex-column nav-pills name-list" role="tablist">
                                    <a class="nav-link active" data-toggle="pill" href="#u4-1">NOOR NASHRIQ</a>
                                    <a class="nav-link" data-toggle="pill" href="#u4-2">ANIZA BINTI HUSIN</a>
                                    <a class="nav-link" data-toggle="pill" href="#u4-3">EMIRIA BINTI ISMAIL</a>
                                    <a class="nav-link" data-toggle="pill" href="#u4-4">AZAM SHAH</a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <span class="column-header">Butiran Ahli</span>
                                <div class="tab-content">
                                    @include('carta.detail', ['id' => 'u4-1', 'active' => true, 'n' => 'NOOR NASHRIQ BIN JAAFAR', 'r' => 'Pentadbiran', 'g' => 'Pembantu Tadbir (N22)', 'e' => 'noor_nashriq@moh.gov.my', 't' => '03-88831385'])
                                    @include('carta.detail', ['id' => 'u4-2', 'n' => 'ANIZA BINTI HUSIN', 'r' => 'Pentadbiran', 'g' => 'Pembantu Tadbir (N22)', 'e' => 'ptaniza@moh.gov.my', 't' => '03-88831460'])
                                    @include('carta.detail', ['id' => 'u4-3', 'n' => 'EMIRIA BINTI ISMAIL', 'r' => 'Kewangan', 'g' => 'Pembantu Tadbir (W22)', 'e' => 'emiria@moh.gov.my', 't' => '03-88831460'])
                                    @include('carta.detail', ['id' => 'u4-4', 'n' => 'AZAM SHAH BIN ISMAIL', 'r' => 'Pentadbiran', 'g' => 'PKA (H14)', 'e' => 'azam.shah@moh.gov.my', 't' => '03-88831542'])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="s-mystep">
                        <div class="row">
                            <div class="col-md-5">
                                <span class="column-header">Nama Ahli</span>
                                <div class="nav flex-column nav-pills name-list" role="tablist">
                                    <a class="nav-link active" data-toggle="pill" href="#u5-1">MUHAMMAD RUSYDI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-2">MOHD HAFIZ</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-3">NUR EFFA</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-4">NOOR DIYANA</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-5">AMIRA SOFEA</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-6">NOR HAFIZAH</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-7">ANESYA SURAYA</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-8">AMIRAH IZZATI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-9">AFIDA HAZWANI</a>
                                    <a class="nav-link" data-toggle="pill" href="#u5-10">KOSONG 2</a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <span class="column-header">Butiran Ahli</span>
                                <div class="tab-content">
                                    @include('carta.detail', ['id' => 'u5-1', 'active' => true, 'n' => 'MUHAMMAD RUSYDI', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep06@moh.gov.my', 't' => '03-88831462'])
                                    @include('carta.detail', ['id' => 'u5-2', 'n' => 'MOHD HAFIZ BIN JUNUS', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep02@moh.gov.my', 't' => '03-88831429'])
                                    @include('carta.detail', ['id' => 'u5-3', 'n' => 'NUR EFFA BINTI SUKKERI', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep07@moh.gov.my', 't' => '03-88831373'])
                                    @include('carta.detail', ['id' => 'u5-4', 'n' => 'NOOR DIYANA BINTI NORZAN', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep01@moh.gov.my', 't' => '03-88831370'])
                                    @include('carta.detail', ['id' => 'u5-5', 'n' => 'AMIRA SOFEA', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep10@moh.gov.my', 't' => '03-88831479'])
                                    @include('carta.detail', ['id' => 'u5-6', 'n' => 'NOR HAFIZAH', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep09@moh.gov.my', 't' => '03-88831519'])
                                    @include('carta.detail', ['id' => 'u5-7', 'n' => 'ANESYA SURAYA', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep08@moh.gov.my', 't' => '03-88831519'])
                                    @include('carta.detail', ['id' => 'u5-8', 'n' => 'AMIRAH IZZATI', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep05@moh.gov.my', 't' => '03-88831477'])
                                    @include('carta.detail', ['id' => 'u5-9', 'n' => 'AFIDA HAZWANI', 'r' => 'MyStep', 'g' => 'N19', 'e' => 'cpppp_mystep03@moh.gov.my', 't' => '03-88831384'])
                                    @include('carta.detail', ['id' => 'u5-10', 'n' => 'KOSONG 2', 'r' => 'MyStep', 'g' => 'N19', 'e' => '-', 't' => '-'])
                                </div>
                            </div>
                        </div>
                    </div>

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