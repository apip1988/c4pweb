@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
    .hero-section { 
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://www.moh.gov.my/moh/images/slider_hq/slider_kkm_1.jpg'); 
        background-size: cover; background-position: center; color: white; padding: 100px 0; text-align: center; 
    }

    /* --- 1. KOTAK VISI/MISI (AUTO-HEIGHT & BESAR) --- */
    .glass-card { 
        background: white; 
        border-radius: 20px; 
        min-height: 350px; /* Besarkan lagi supaya selesa */
        perspective: 1000px; 
        cursor: pointer; 
        border: none; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        width: 100%;
    }
    .flip-card-inner { 
        position: relative; 
        width: 100%; 
        height: 100%; 
        min-height: 350px;
        transition: transform 0.8s; 
        transform-style: preserve-3d; 
    }
    .glass-card:hover .flip-card-inner { transform: rotateY(180deg); }
    
    .card-front, .card-back { 
        position: absolute; 
        width: 100%; 
        height: 100%; 
        backface-visibility: hidden; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        border-radius: 20px; 
        padding: 25px; 
    }

    .card-back { 
        background: #3051a0; 
        color: white; 
        transform: rotateY(180deg); 
        overflow-y: auto;
        text-align: center;
    }

    /* --- 2. LALUAN KERJAYA --- */
    .career-step { 
        transition: 0.3s; 
        min-height: 80px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 50px; 
        background: white; 
        border: 1px solid #dee2e6; 
    }
    .career-step:hover { background: #3051a0; color: white; transform: scale(1.05); }

    /* --- 3. LOGO MARQUEE FIX --- */
    .logo-item img {
        height: 60px !important; 
        width: auto;
        filter: grayscale(100%);
        opacity: 0.6;
        transition: all 0.4s ease;

        /* TAMBAH KOD BARU INI DI BAWAHNYA */
.logo-item:hover img {
    filter: grayscale(0%); /* Tukar jadi berwarna semula */
    opacity: 1;            /* Terangkan gambar */
    transform: scale(1.1); /* Besarkan sikit logo (optional) */
}
    }
</style>

<div class="hero-section shadow-sm">
    <div class="container">
        <h1 class="display-4 font-weight-bold">CAWANGAN PERKHIDMATAN PPP</h1>
        <div class="mt-4">
            <a href="{{ url('/dashboard') }}" class="btn btn-warning btn-lg px-5 font-weight-bold shadow rounded-pill">LIHAT DASHBOARD STATISTIK</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div id="section-visi" class="row mb-5">
        @php
            $elements = [
                ['title' => 'VISI', 'icon' => 'fa-eye', 'color' => 'text-primary', 'desc' => 'Melahirkan PENOLONG PEGAWAI PERUBATAN yang unggul dalam penyampaian perkhidmatan kesihatan kepada masyarakat.'],
                ['title' => 'MISI', 'icon' => 'fa-bullseye', 'color' => 'text-danger', 'desc' => '• Melestarikan perkhidmatan berkualiti.<br>• Meningkatkan peluang pendidikan ijazah.<br>• Memantapkan fungsi Pra-Hospital & Kecemasan.<br>• Penerapan konsep 3D (Discipline, Documentation, Development).'],
                ['title' => 'OBJEKTIF', 'icon' => 'fa-tasks', 'color' => 'text-success', 'desc' => 'Menyediakan perkhidmatan penggalakan, pencegahan, rawatan dan pemulihan yang cekap dan berkesan bagi mencapai taraf kesihatan yang produktif.'],
                ['title' => 'MOTTO', 'icon' => 'fa-quote-right', 'color' => 'text-warning', 'desc' => 'CEPAT: Tepat dalam rawatan.<br>CEKAP: Berkesan dalam tugas.<br>PROFESIONAL: Didasari modul latihan terancang & Akta 180.']
            ];
        @endphp
        @foreach($elements as $el)
        <div class="col-md-3 mb-4 text-center">
            <div class="glass-card shadow-sm">
                <div class="flip-card-inner">
                    <div class="card-front">
                        <i class="fas {{ $el['icon'] }} {{ $el['color'] }} fa-3x mb-3"></i>
                        <h5 class="font-weight-bold">{{ $el['title'] }}</h5>
                    </div>
                    <div class="card-back">
                        <p style="font-size: 12px; line-height: 1.6;">{!! $el['desc'] !!}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div id="section-fungsi" class="card shadow-sm mb-5 border-0" style="border-radius: 15px;">
        <div class="card-header bg-white border-0 pt-4"><h4 class="text-center font-weight-bold">CARTA FUNGSI UTAMA</h4></div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                <li class="nav-item"><a class="nav-link active font-weight-bold" data-toggle="pill" href="#f1">DASAR & STRATEGIK</a></li>
                <li class="nav-item"><a class="nav-link font-weight-bold" data-toggle="pill" href="#f2">PEMBANGUNAN PROFESION</a></li>
                <li class="nav-item"><a class="nav-link font-weight-bold" data-toggle="pill" href="#f3">SEKRETARIAT LPP</a></li>
                <li class="nav-item"><a class="nav-link font-weight-bold" data-toggle="pill" href="#f4">SEKRETARIAT LPHE</a></li>
            </ul>
            <div class="tab-content text-left p-4" style="background: #f9f9f9; border-radius: 15px; min-height: 250px;">
                <div class="tab-pane fade show active" id="f1">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Pengurusan perjawatan & sumber manusia profesion.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Penyediaan garis panduan & dokumen perkhidmatan.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Aktiviti kualiti: Credentialing, Audit Klinikal & MSQH.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Penetapan KPI & pemantauan CPD.</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="f2">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Pemantauan Standard & Guidelines Pendidikan PPP.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Kawalan kualiti Diploma, Ijazah & Post Basik.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Latihan Pentauliahan FSO & EMRS JBPM.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Program Penempatan Wajib (PPW).</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="f3">
                    <p class="font-weight-bold" style="color:#3051a0">Ketua Pengarah Kesihatan Malaysia (Pengerusi)</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Pendaftaran & Pembaharuan ARC.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Penilaian Kompetensi & Kawalan Amalan.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Siasatan aduan & Pewartaan.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Pendaftaran AMOTeX.</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="f4">
                    <p class="font-weight-bold" style="color:#3051a0">Timb. Ketua Pengarah Kesihatan (Pengerusi)</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Mengawal selia Akta Pembantu Hospital Estet 1965.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Pendaftaran, Peperiksaan & Kawalan Amalan PHE.</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Sekretariat Mesyuarat Lembaga.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="section-rakan" class="logo-marquee-section" style="background: #ffffff; padding: 40px 0; border-top: 1px solid #eee; overflow: hidden;">
        <div class="container">
            <h4 class="text-center" style="color: #3051a0; font-weight: bold; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 2px; font-size: 16px;">RAKAN STRATEGIK & AGENSI TERLIBAT</h4>
            <div class="marquee-container">
                <div class="marquee-content">
                    @php
                        $logos = [
                            ['img' => 'cpppp.png', 'name' => 'CPPPP'],
                            ['img' => 'pppm.png', 'name' => 'PPPM'],
                            ['img' => 'kkpppsm.png', 'name' => 'KKPPPSM'],
                            ['img' => 'bpkk.png', 'name' => 'BPKK'],
                            ['img' => 'samoa.png', 'name' => 'SAMOA'],
                            ['img' => 'kpps.png', 'name' => 'KPPS'],
                            ['img' => 'amas.png', 'name' => 'AMAS'],
                            ['img' => 'ukm.png', 'name' => 'UKM']
                        ];
                    @endphp
                    @foreach($logos as $logo)
                    <div class="logo-item">
                        <img src="{{ asset('img/Logo/'.$logo['img']) }}" alt="Logo">
                        <span class="tooltip-text">{{ $logo['name'] }}</span>
                    </div>
                    @endforeach
                    @foreach($logos as $logo)
                    <div class="logo-item">
                        <img src="{{ asset('img/Logo/'.$logo['img']) }}" alt="Logo">
                        <span class="tooltip-text">{{ $logo['name'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="section-kerjaya" class="py-5" style="background: #f4f7f6;">
    <div class="container-fluid" style="padding: 0 40px;">
        <h4 class="text-center font-weight-bold mb-5" style="color: #3051a0; letter-spacing: 1px;">LALUAN AKADEMIK & KERJAYA PPP</h4>
        
        <div class="career-wrapper">
            @php
                // Kita masukkan data institusi lengkap Afif ke dalam array PHP
                $steps = [
                    'diploma' => [
                        'title' => 'Diploma',
                        'sub' => 'TAHAP ASAS',
                        'icon' => 'fa-user-graduate',
                        'color' => '#007bff',
                        'desc' => 'Program Diploma Penolong Pegawai Perubatan - Pintu masuk utama ke profesion perubatan.',
                        'program' => 'Diploma Sains Perubatan dan Kesihatan (BMHS)',
                        'sections' => [
                            ['title' => 'Institusi Awam', 'items' => ['ILKKM Seremban', 'ILKKM Ulu Kinta', 'ILKKM Alor Star', 'ILKKM Johor Bahru', 'ILKKM Kota Kinabalu', 'ILKKM Kuching', 'INTAN (ATM)']],
                            ['title' => 'Institusi Swasta', 'items' => ['MSU', 'Murni', 'Widad (WUC)', 'UOW', 'Lincoln (LUC)', 'UCMI', 'UOC', 'UniKL MESTECH', 'UGM', 'DIT', 'IJNUC', 'Cyberjaya College KK']]
                        ]
                    ],
                    'postbasic' => [
                        'title' => 'Post-Basic',
                        'sub' => 'PENGKHUSUSAN',
                        'icon' => 'fa-book-reader',
                        'color' => '#6f42c1',
                        'desc' => 'Latihan pengkhususan klinikal dalam pelbagai bidang khusus PPP.',
                        'program' => 'Advanced Diploma / Sijil Pos Basik',
                        'sections' => [
                            ['title' => 'ILKKM Sultan Azlan Shah', 'items' => ['Dip. Lanjutan Kecemasan', 'Dip. Lanjutan Diabetes', 'Dip. Lanjutan Ortopedik', 'Sijil Nefrologi (6 bln)']],
                            ['title' => 'ILKKM Kota Kinabalu', 'items' => ['Dip. Lanjutan Gerontologi', 'Sijil Gastrointestinal Endoskopi']],
                            ['title' => 'ILKKM Sungai Buloh', 'items' => ['Dip. Lanjutan Otorinolaringologi', 'Sijil Pengurusan Penjagaan Luka']]
                        ]
                    ],
                    'degree' => [
                        'title' => 'Ijazah',
                        'sub' => 'SARJANA MUDA',
                        'icon' => 'fa-university',
                        'color' => '#e83e8c',
                        'desc' => 'Bachelor dalam bidang kesihatan untuk perkembangan kerjaya & kepimpinan.',
                        'program' => 'Ijazah Sarjana Muda',
                        'sections' => [
                            ['title' => 'Institusi Awam', 'items' => ['UKM (Sains Perubatan Kecemasan)', 'UMS (Sains Perubatan & Kesihatan)']],
                            ['title' => 'Institusi Swasta', 'items' => ['UniSZA (BMHS)', 'OUM (BMHS)']]
                        ]
                    ],
                    'master' => [
                        'title' => 'Master',
                        'sub' => 'SARJANA',
                        'icon' => 'fa-user-tie',
                        'color' => '#fd7e14',
                        'desc' => 'Program Master untuk penyelidikan, pengurusan dan kepakaran klinikal.',
                        'program' => 'Sarjana (Master)',
                        'sections' => [
                            ['title' => 'Universiti', 'items' => ['UKM (Medical Education)', 'UPM (Emergency Response)', 'UTM (Disaster Management)']]
                        ]
                    ],
                    'phd' => [
                        'title' => 'PhD',
                        'sub' => 'KEDOKTORAN',
                        'icon' => 'fa-award',
                        'color' => '#28a745',
                        'desc' => 'Tahap pengajian tertinggi untuk pakar bidang dan warga akademik.',
                        'program' => 'Kedoktoran (PhD)',
                        'sections' => [
                            ['title' => 'Universiti', 'items' => ['Penyelidikan akan ditambah tidak lama lagi']]
                        ]
                    ]
                ];
            @endphp

            @foreach($steps as $id => $s)
            <div class="career-column">
                <div class="career-card" style="border-top: 5px solid {{ $s['color'] }} !important;">
                    <div class="text-center">
                        <i class="fas {{ $s['icon'] }} main-icon" style="font-size: 30px; margin-bottom: 10px;"></i>
                        <h6 class="font-weight-bold mb-1">{{ $s['title'] }}</h6>
                        <small class="badge mb-3" style="background: {{ $s['color'] }}20; color: {{ $s['color'] }}; font-weight: bold; font-size: 9px;">{{ $s['sub'] }}</small>
                        <p class="career-desc" style="font-size: 11px; color: #666; height: 60px;">{{ $s['desc'] }}</p>
                    </div>
                    
                    <button class="btn btn-success btn-sm btn-block rounded-pill font-weight-bold shadow-sm" data-toggle="modal" data-target="#modal-{{ $id }}">
                        Institusi
                    </button>
                </div>
            </div>

            <div class="modal fade" id="modal-{{ $id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                        <div class="modal-header border-0 bg-light" style="border-radius: 20px 20px 0 0;">
                            <h5 class="modal-title font-weight-bold" style="color: {{ $s['color'] }}">
                                <i class="fas {{ $s['icon'] }} mr-2"></i> {{ $s['title'] }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body p-4">
                            <h6 class="text-muted mb-3"><i class="fas fa-graduation-cap mr-2"></i> {{ $s['program'] }}</h6>
                            <div class="row">
                                @foreach($s['sections'] as $sec)
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 h-100" style="background: #f8f9fa; border-radius: 12px; border-left: 4px solid {{ $s['color'] }};">
                                        <p class="font-weight-bold mb-2 text-dark">{{ $sec['title'] }}</p>
                                        <ul class="list-unstyled mb-0" style="font-size: 12px; line-height: 1.8;">
                                            @foreach($sec['items'] as $item)
                                            <li><i class="fas fa-caret-right mr-2" style="color: {{ $s['color'] }}"></i> {!! $item !!}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* CSS UNTUK MARQUEE & TOOLTIP */
    .marquee-container { width: 100%; overflow: hidden; white-space: nowrap; position: relative; padding: 80px 0 40px 0; }
    .marquee-content { display: flex; align-items: center; width: max-content; animation: marquee-scroll 40s linear infinite; }
    .marquee-container:hover .marquee-content { animation-play-state: paused; }
    .logo-item { position: relative; flex: 0 0 auto; padding: 0 40px; text-align: center; }
    .tooltip-text { visibility: hidden; width: 200px; background-color: #3051a0; color: #fff; text-align: center; border-radius: 6px; padding: 8px 12px; position: absolute; z-index: 999; bottom: 125%; left: 50%; transform: translateX(-50%); opacity: 0; transition: opacity 0.3s; font-size: 11px; line-height: 1.4; white-space: normal; box-shadow: 0 4px 15px rgba(0,0,0,0.2); pointer-events: none; }
    .tooltip-text::after { content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px; border-width: 5px; border-style: solid; border-color: #3051a0 transparent transparent transparent; }
    .logo-item:hover .tooltip-text { visibility: visible; opacity: 1; }
    @keyframes marquee-scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    /* 1. KONTENA UTAMA: Kita bagi dia lebar penuh */
    .career-wrapper {
        display: flex;
        flex-wrap: nowrap; /* Paksa sebaris, jangan bagi jatuh */
        justify-content: space-between;
        gap: 10px;
        padding: 20px 0;
    }

    /* 2. SETIAP KOLUM: Lebar tetap 19% supaya 5 muat cantik (19% x 5 = 95%) */
    .career-column {
        flex: 0 0 19%; 
        min-width: 180px; 
    }

    /* 3. KAD: Panjangkan kotak guna min-height */
    .career-card {
        background: white;
        border-radius: 15px;
        padding: 25px 15px;
        min-height: 480px; /* Panjangkan kotak supaya teks masuk semua */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Butang sentiasa di bawah */
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .career-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }

    /* Gaya teks deskripsi */
    .career-desc {
        font-size: 11px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Icon sikit kecil supaya tak makan ruang */
    .career-card i.main-icon {
        font-size: 30px;
        color: #444;
        margin-bottom: 15px;
    }

    /* Responsive: Bila skrin phone baru dia jatuh */
    @media (max-width: 992px) {
        .career-wrapper { flex-wrap: wrap; }
        .career-column { flex: 0 0 48%; }
    }
    @media (max-width: 576px) {
        .career-column { flex: 0 0 100%; }
    }
</style>
</style>
@endsection