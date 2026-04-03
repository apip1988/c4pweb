@extends('layouts.app')

@section('content')
<style>
    :root { --prpa-blue: #3051a0; --prpa-light: #f1f4f9; }
    
    /* Utility */
    .section-title { font-weight: 700; color: var(--prpa-blue); text-transform: uppercase; margin-bottom: 25px; border-left: 5px solid var(--prpa-blue); padding-left: 15px; }
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: 0.3s; background: #fff; }
    .card-custom:hover { transform: translateY(-5px); }
    
    /* Stat Box */
    .stat-box { background: var(--prpa-light); padding: 20px; border-radius: 12px; text-align: center; height: 100%; }
    .stat-number { font-size: 1.8rem; font-weight: 700; color: var(--prpa-blue); display: block; }
    .stat-label { font-size: 0.8rem; color: #666; text-transform: uppercase; font-weight: 600; }
    
    /* Box Butang Kursus */
    .btn-menu { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px; border-radius: 15px; text-decoration: none !important; transition: 0.3s; background: #fff; border: 1px solid #eee; color: #333; }
    .btn-menu i { font-size: 2.5rem; margin-bottom: 15px; color: var(--prpa-blue); }
    .btn-menu:hover { background: var(--prpa-blue); color: #fff !important; }
    .btn-menu:hover i { color: #fff; }
    
    .scroll-offset { scroll-margin-top: 100px; }

    /* 📱 MOBILE OPTIMIZATION (KHAS UNTUK PHONE) 📱 */
    @media (max-width: 768px) {
        .container { padding-left: 15px; padding-right: 15px; }
        .section-title { font-size: 1.1rem; margin-bottom: 15px; }
        
        /* Kecilkan Stat Box kat Dashboard */
        .stat-box { padding: 12px 5px; }
        .stat-number { font-size: 1.3rem; }
        .stat-label { font-size: 0.65rem; }
        
        /* Dashboard stack 2-kolom */
        .mobile-dash-top .col-6 { padding: 5px; }
        .mobile-dash-bottom .col-4 { padding: 5px; }

        /* Kecilkan butang menu */
        .btn-menu { padding: 20px 10px !important; }
        .btn-menu i { font-size: 1.8rem !important; margin-bottom: 10px; }
        .btn-menu span { font-size: 0.85rem; }

        /* Hubungi Card */
        .card-custom.p-4 { padding: 1.2rem !important; }
        .fa-3x { font-size: 2rem !important; }
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
                        <span class="stat-number">12</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-box">
                        <span class="stat-label">TOT</span>
                        <span class="stat-number">34</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-box">
                        <span class="stat-label">Provider</span>
                        <span class="stat-number">850</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="prpa-kursus" class="scroll-offset mb-5">
        <h4 class="section-title">Pengurusan Kursus</h4>
        <div class="row text-center">
            <div class="col-6 col-md-4 mb-3">
                <a href="#" class="btn-menu shadow-sm">
                    <i class="fas fa-file-signature"></i>
                    <span class="font-weight-bold">Borang Permohonan</span>
                </a>
            </div>
            <div class="col-6 col-md-4 mb-3">
                <a href="https://phcmalaysia.com/phcals/" target="_blank" class="btn-menu shadow-sm">
                    <i class="fas fa-laptop-code"></i>
                    <span class="font-weight-bold">e-Latihan PHCALS</span>
                </a>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <a href="{{ route('prpa.semak.borang') }}" class="btn-menu shadow-sm">
                    <i class="fas fa-search-plus"></i>
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
                    <h6 class="font-weight-bold mb-3 text-secondary"><i class="fas fa-calendar-alt mr-2"></i>Kursus Akan Datang</h6>
                    <table class="table table-hover small">
                        <thead class="thead-light">
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
                    <h6 class="font-weight-bold mb-3 text-secondary"><i class="fas fa-camera-retro mr-2"></i>Galeri Aktiviti</h6>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="height: 120px;">
                        <i class="fas fa-images fa-2x text-muted opacity-50"></i>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm mt-3 rounded-pill px-4">Lihat Galeri</a>
                </div>
            </div>
        </div>
    </div>

    <div id="prpa-rujukan" class="scroll-offset mb-5">
        <h4 class="section-title">Rujukan Dokumentasi</h4>
        <div class="card card-custom p-4 shadow-sm">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-5 mb-4 mb-md-0">
                    <p class="small text-muted mb-2 font-weight-bold">Carian Cepat:</p>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari...">
                        <div class="input-group-append">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end">
                        <button class="btn btn-outline-dark btn-sm m-1 rounded-pill">Pekeliling</button>
                        <button class="btn btn-outline-dark btn-sm m-1 rounded-pill">Polisi</button>
                        <button class="btn btn-outline-dark btn-sm m-1 rounded-pill">Garis Panduan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="prpa-hubungi" class="scroll-offset mb-5 pb-5">
        <h4 class="section-title">Hubungi Sekretariat</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card card-custom p-4 d-flex flex-row align-items-center shadow-sm border-left" style="border-left: 5px solid #28a745 !important;">
                    <i class="fas fa-user-circle fa-3x text-primary mr-3"></i>
                    <div>
                        <p class="mb-0 font-weight-bold" style="font-size: 0.95rem;">En. Mohd Faris bin Abdul Rashid</p>
                        <p class="mb-0 small text-muted">Pen. Peg. Perubatan U10</p>
                        <p class="mb-0 small font-weight-bold text-success mt-1"><i class="fas fa-phone-alt mr-1"></i>03-8883 1517</p>
                        <p class="mb-0 small font-weight-bold text-info mt-1"><i class="fas fa-envelope mr-1"></i>mdfaris@moh.gov.my</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card card-custom p-4 d-flex flex-row align-items-center shadow-sm border-left" style="border-left: 5px solid #28a745 !important;">
                    <i class="fas fa-user-circle fa-3x text-primary mr-3"></i>
                    <div>
                        <p class="mb-0 font-weight-bold" style="font-size: 0.95rem;">En. Muhammad Romzi bin Husain</p>
                        <p class="mb-0 small text-muted">Penolong Pegawai Perubatan U7</p>
                        <p class="mb-0 small font-weight-bold text-success mt-1"><i class="fas fa-phone-alt mr-1"></i>03-8883 1386</p>
                        <p class="mb-0 small font-weight-bold text-info mt-1"><i class="fas fa-envelope mr-1"></i>muhammad.romzi@moh.gov.my</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection