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
                <a href="javascript:void(0)" class="btn btn-primary btn-block shadow-sm" data-toggle="modal" data-target="#quizSelectorModal" style="border-radius: 10px; font-weight: bold;">
    <i class="fas fa-play mr-2"></i> SOALAN
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
<div class="modal fade" id="quizSelectorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 25px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
            <div class="modal-header" style="background: linear-gradient(45deg, #3051a0, #4a69bd); color: white; border: none; padding: 20px;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-tasks mr-2"></i> KONFIGURASI e-QUIZ</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body p-4 text-center">
                <div class="mb-4">
                    <div style="font-size: 50px; color: #3051a0;"><i class="fas fa-user-graduate"></i></div>
                    <h5 class="font-weight-bold mt-2">Sediaan Minda PRPA</h5>
                    <p class="text-muted small">Pilih set soalan dan tekan butang merah untuk mula.</p>
                </div>

                <div class="form-group">
                    <select id="quizSetPicker" class="form-control form-control-lg text-center" 
                            style="border-radius: 15px; border: 2px solid #3051a0; font-weight: 700; color: #3051a0; background: #f0f4ff;">
                        <option value="">-- PILIH SET SOALAN --</option>
                        <option value="{{ url('/prpa/quiz/1') }}">SET 1: ASAS & PENGENALAN (AKTIF)</option>
                        <option value="" disabled>SET 2: (AKAN DATANG)</option>
                        <option value="" disabled>SET 3: (AKAN DATANG)</option>
                        <option value="" disabled>SET 4: (AKAN DATANG)</option>
                        <option value="" disabled>SET 5: (AKAN DATANG)</option>
                    </select>
                </div>

                <button id="startQuizBtn" class="btn btn-block mt-4" 
                    style="height: 65px; border-radius: 50px; font-size: 1.3rem; font-weight: 900; color: white;
                           background: linear-gradient(180deg, #ff5e62 0%, #ff0000 50%, #990000 100%);
                           box-shadow: 0 8px 25px rgba(255, 0, 0, 0.5), inset 0 3px 6px rgba(255, 255, 255, 0.4);
                           border: 2px solid #660000; text-shadow: 2px 2px 4px rgba(0,0,0,0.4); 
                           opacity: 0.4; cursor: not-allowed; transition: all 0.4s ease;" disabled>
                    START QUIZ <i class="fas fa-fire ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Pantau perubahan dropdown
    $('#quizSetPicker').on('change', function() {
        var val = $(this).val();
        var btn = $('#startQuizBtn');

        if (val !== "") {
            btn.prop('disabled', false).css({
                'opacity': '1',
                'cursor': 'pointer',
                'transform': 'scale(1.05)'
            });
        } else {
            btn.prop('disabled', true).css({
                'opacity': '0.4',
                'cursor': 'not-allowed',
                'transform': 'scale(1)'
            });
        }
    });

    // Handle Klik Start
    $('#startQuizBtn').click(function() {
        var url = $('#quizSetPicker').val();
        if (url !== "") {
            $(this).html('<i class="fas fa-sync fa-spin"></i> SEDANG MEMPROSES...');
            window.location.href = url;
        }
    });
});
</script>
@endsection