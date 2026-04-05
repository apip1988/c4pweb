@extends('layouts.app')

@section('content')
<style>
    /* 🎨 TEMA WARNA HIJAU PPP */
    :root { 
        --ppp-green: #2d5a27; /* Hijau Baju PPP */
        --ppp-light: #f0f7f0; /* Hijau Mint Sangat Lembut */
        --ppp-accent: #4caf50; /* Hijau Terang untuk Hover */
    }
    
    /* Utility */
    .section-title { 
        font-weight: 700; 
        color: var(--ppp-green); 
        text-transform: uppercase; 
        margin-bottom: 25px; 
        border-left: 5px solid var(--ppp-green); 
        padding-left: 15px; 
    }
    
    .card-custom { 
        border: none; 
        border-radius: 15px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
        transition: 0.3s; 
        background: #fff; 
    }
    .card-custom:hover { transform: translateY(-5px); }
    
    /* Stat Box */
    .stat-box { 
        background: var(--ppp-light); 
        padding: 20px; 
        border-radius: 12px; 
        text-align: center; 
        height: 100%; 
        border: 1px solid #e0eee0;
    }
    .stat-number { font-size: 1.8rem; font-weight: 700; color: var(--ppp-green); display: block; }
    .stat-label { font-size: 0.8rem; color: #444; text-transform: uppercase; font-weight: 600; }
    
    /* 🟢 BOX BUTANG KURSUS (4 CARDS) */
    .btn-menu { 
        height: 100%; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        padding: 25px 15px; 
        border-radius: 15px; 
        text-decoration: none !important; 
        transition: 0.3s; 
        background: #fff; 
        border: 1px solid #eee; 
        color: #333; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .btn-menu i { font-size: 2.2rem; margin-bottom: 15px; color: var(--ppp-green); }
    .btn-menu:hover { 
        background: var(--ppp-green); 
        color: #fff !important; 
        border-color: var(--ppp-green);
    }
    .btn-menu:hover i { color: #fff; }
    
    .scroll-offset { scroll-margin-top: 100px; }

    /* 📱 MOBILE OPTIMIZATION */
    @media (max-width: 768px) {
        .btn-menu { padding: 15px 5px !important; }
        .btn-menu i { font-size: 1.6rem !important; }
        .btn-menu span { font-size: 0.75rem; line-height: 1.2; }
    }
</style>

<div class="container py-4">
    
    <div id="prpa-dashboard" class="scroll-offset mb-5">
        <h4 class="section-title">Dashboard PRPA</h4>
        <div class="card card-custom p-3 p-md-4 shadow-sm">
            <div class="row mobile-dash-top">
                <div class="col-6 col-md-6 mb-3">
                    <div class="stat-box">
                        <span class="stat-label">Kursus Tahun {{ date('Y') }}</span>
                        <span class="stat-number">45</span>
                    </div>
                </div>
                <div class="col-6 col-md-6 mb-3">
                    <div class="stat-box">
                        <span class="stat-label">Jumlah Keseluruhan</span>
                        <span class="stat-number">1,280</span>
                    </div>
                </div>
            </div>
            <div class="row mt-md-3 mobile-dash-bottom">
                <div class="col-4">
                    <div class="stat-box">
                        <span class="stat-label">MOT</span>
                        <span class="stat-number">0</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-box">
                        <span class="stat-label">TOT</span>
                        <span class="stat-number">0</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-box">
                        <span class="stat-label">Provider</span>
                        <span class="stat-number">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="prpa-kursus" class="scroll-offset mb-5">
        <h4 class="section-title">Pengurusan Kursus</h4>
        <div class="row text-center px-2 px-md-0">
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <a href="#" class="btn-menu shadow-sm h-100">
                    <i class="fas fa-file-signature"></i>
                    <span class="font-weight-bold">Borang Permohonan</span>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <a href="#" class="btn-menu shadow-sm h-100">
                    <i class="fas fa-video"></i>
                    <span class="font-weight-bold">Video Kursus</span>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <a href="{{ url('/phcals/history') }}" class="btn-menu shadow-sm h-100">
                    <i class="fas fa-user-edit"></i>
                    <span class="font-weight-bold">e-Quiz</span>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <a href="{{ route('prpa.semak.borang') }}" class="btn-menu shadow-sm h-100">
                    <i class="fas fa-poll"></i>
                    <span class="font-weight-bold">Semak Keputusan</span>
                </a>
            </div>
        </div>
    </div>

    <div id="prpa-aktiviti" class="scroll-offset mb-5">
        <h4 class="section-title">Aktiviti PRPA</h4>
        <div class="row">
            <div class="col-md-7 mb-3">
                <div class="card card-custom p-4 h-100 shadow-sm table-responsive">
                    <h6 class="font-weight-bold mb-3" style="color: var(--ppp-green);"><i class="fas fa-calendar-alt mr-2"></i>Kursus Akan Datang</h6>
                    <table class="table table-hover small">
                        <thead style="background-color: var(--ppp-light);">
                            <tr>
                                <th>Tarikh</th>
                                <th>Nama Kursus</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap">12-14 Mei 2026</td>
                                <td>Kursus PHCALS Provider</td>
                                <td>KSKB Sungai Buloh</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-5 mb-3">
                <div class="card card-custom p-4 h-100 text-center shadow-sm">
                    <h6 class="font-weight-bold mb-3" style="color: var(--ppp-green);"><i class="fas fa-camera-retro mr-2"></i>Galeri Aktiviti</h6>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="height: 120px;">
                        <i class="fas fa-images fa-2x text-muted opacity-50"></i>
                    </div>
                    <a href="#" class="btn btn-sm mt-3 rounded-pill px-4" style="background-color: var(--ppp-green); color: white;">Lihat Galeri</a>
                </div>
            </div>
        </div>
    </div>

    <div id="prpa-hubungi" class="scroll-offset mb-5 pb-5">
        <h4 class="section-title">Hubungi Sekretariat</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card card-custom p-4 d-flex flex-row align-items-center shadow-sm" style="border-left: 5px solid var(--ppp-green) !important;">
                    <i class="fas fa-user-circle fa-3x mr-3" style="color: var(--ppp-green);"></i>
                    <div>
                        <p class="mb-0 font-weight-bold" style="font-size: 0.95rem;">En. Mohd Faris bin Abdul Rashid</p>
                        <p class="mb-0 small text-muted">Pen. Peg. Perubatan U10</p>
                        <p class="mb-0 small font-weight-bold mt-1" style="color: var(--ppp-green);"><i class="fas fa-phone-alt mr-1"></i>03-8883 1517</p>
                        <p class="mb-0 small font-weight-bold text-info mt-1"><i class="fas fa-envelope mr-1"></i>mdfaris@moh.gov.my</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card card-custom p-4 d-flex flex-row align-items-center shadow-sm" style="border-left: 5px solid var(--ppp-green) !important;">
                    <i class="fas fa-user-circle fa-3x mr-3" style="color: var(--ppp-green);"></i>
                    <div>
                        <p class="mb-0 font-weight-bold" style="font-size: 0.95rem;">En. Muhammad Romzi bin Husain</p>
                        <p class="mb-0 small text-muted">Penolong Pegawai Perubatan U7</p>
                        <p class="mb-0 small font-weight-bold mt-1" style="color: var(--ppp-green);"><i class="fas fa-phone-alt mr-1"></i>03-8883 1386</p>
                        <p class="mb-0 small font-weight-bold text-info mt-1"><i class="fas fa-envelope mr-1"></i>muhammad.romzi@moh.gov.my</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection