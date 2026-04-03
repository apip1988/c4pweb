@extends('layouts.app')

@section('content')
<style>
    :root { --prpa-blue: #3051a0; --prpa-light: #f1f4f9; }
    .section-title { font-weight: 700; color: var(--prpa-blue); text-transform: uppercase; margin-bottom: 25px; border-left: 5px solid var(--prpa-blue); padding-left: 15px; }
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: 0.3s; background: #fff; }
    .card-custom:hover { transform: translateY(-5px); }
    .stat-box { background: var(--prpa-light); padding: 20px; border-radius: 12px; text-align: center; }
    .stat-number { font-size: 1.8rem; font-weight: 700; color: var(--prpa-blue); display: block; }
    .stat-label { font-size: 0.8rem; color: #666; text-transform: uppercase; }
    
    /* Box Butang Kursus */
    .btn-menu { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px; border-radius: 15px; text-decoration: none !important; transition: 0.3s; background: #fff; border: 1px solid #eee; color: #333; }
    .btn-menu i { font-size: 2.5rem; margin-bottom: 15px; color: var(--prpa-blue); }
    .btn-menu:hover { background: var(--prpa-blue); color: #fff !important; }
    .btn-menu:hover i { color: #fff; }
    
    .scroll-offset { scroll-margin-top: 100px; }
</style>

<div class="container py-5">
    
    <div id="prpa-dashboard" class="scroll-offset mb-5">
        <h4 class="section-title">Dashboard PRPA</h4>
        <div class="card card-custom p-4 shadow-sm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="stat-box">
                        <span class="stat-label">Jumlah Kursus Tahun {{ date('Y') }}</span>
                        <span class="stat-number">45</span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="stat-box">
                        <span class="stat-label">Jumlah Kursus Keseluruhan (Sejak PHCALS)</span>
                        <span class="stat-number">1,280</span>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
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
            <div class="col-md-4 mb-3">
                <a href="#" class="btn-menu shadow-sm">
                    <i class="fas fa-file-signature"></i>
                    <span class="font-weight-bold">Borang Permohonan</span>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="https://phcmalaysia.com/phcals/" target="_blank" class="btn-menu shadow-sm">
                    <i class="fas fa-laptop-code"></i>
                    <span class="font-weight-bold">e-Latihan PHCALS</span>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="#" class="btn-menu shadow-sm">
                    <i class="fas fa-certificate"></i>
                    <span class="font-weight-bold">Semak Keputusan & Cetak Slip</span>
                </a>
            </div>
        </div>
    </div>

    <div id="prpa-aktiviti" class="scroll-offset mb-5">
        <h4 class="section-title">Aktiviti PRPA</h4>
        <div class="row">
            <div class="col-md-7 mb-3">
                <div class="card card-custom p-4 h-100 shadow-sm">
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
                                <td>12-14 Mei 2026</td>
                                <td>Kursus PHCALS Provider</td>
                                <td>KSKB Sungai Buloh</td>
                            </tr>
                            <tr>
                                <td>02-04 Jun 2026</td>
                                <td>Kursus TOT PRPA</td>
                                <td>BPP Putrajaya</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-5 mb-3">
                <div class="card card-custom p-4 h-100 text-center shadow-sm">
                    <h6 class="font-weight-bold mb-3 text-secondary"><i class="fas fa-camera-retro mr-2"></i>Galeri Aktiviti</h6>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="height: 150px;">
                        <i class="fas fa-images fa-3x text-muted opacity-50"></i>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm mt-3 rounded-pill px-4">Lihat Galeri Penuh</a>
                </div>
            </div>
        </div>
    </div>

    <div id="prpa-rujukan" class="scroll-offset mb-5">
        <h4 class="section-title">Rujukan Dokumentasi</h4>
        <div class="card card-custom p-4 shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-5 mb-3 mb-md-0">
                    <p class="small text-muted mb-2 font-weight-bold">Carian Cepat:</p>
                    <div class="input-group">
                        <input type="text" class="form-control rounded-left" placeholder="Pekeliling, Polisi, Garis Panduan...">
                        <div class="input-group-append">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <p class="small text-muted mb-2 font-weight-bold text-center">Kategori Rujukan:</p>
                    <div class="d-flex flex-wrap justify-content-center">
                        <button class="btn btn-outline-dark btn-sm m-1 px-3 rounded-pill">Pekeliling</button>
                        <button class="btn btn-outline-dark btn-sm m-1 px-3 rounded-pill">Polisi</button>
                        <button class="btn btn-outline-dark btn-sm m-1 px-3 rounded-pill">Garis Panduan</button>
                        <button class="btn btn-outline-dark btn-sm m-1 px-3 rounded-pill">Carta Alir</button>
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
                        <p class="mb-0 font-weight-bold">En. Mohd Faris bin Abdul Rashid</p>
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
                        <p class="mb-0 font-weight-bold">En. Muhammad Romzi bin Husain</p>
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