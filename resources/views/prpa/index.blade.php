@extends('layouts.app')

@section('content')
<style>
    /* 🎨 TEMA WARNA HIJAU PPP */
    :root { 
        --ppp-green: #2d5a27; 
        --ppp-light: #f0f7f0; 
        --ppp-accent: #4caf50; 
    }
    
    .section-title { 
        font-weight: 700; color: var(--ppp-green); text-transform: uppercase; 
        margin-bottom: 25px; border-left: 5px solid var(--ppp-green); padding-left: 15px; 
    }
    
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: 0.3s; background: #fff; }
    .card-custom:hover { transform: translateY(-5px); }
    
    .stat-box { background: var(--ppp-light); padding: 20px; border-radius: 12px; text-align: center; height: 100%; border: 1px solid #e0eee0; }
    .stat-number { font-size: 1.8rem; font-weight: 700; color: var(--ppp-green); display: block; }
    .stat-label { font-size: 0.8rem; color: #444; text-transform: uppercase; font-weight: 600; }
    
    .btn-menu { 
        height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; 
        padding: 25px 15px; border-radius: 15px; text-decoration: none !important; transition: 0.3s; 
        background: #fff; border: 1px solid #eee; color: #333; box-shadow: 0 4px 6px rgba(0,0,0,0.02); cursor: pointer;
    }
    .btn-menu i { font-size: 2.2rem; margin-bottom: 15px; color: var(--ppp-green); }
    .btn-menu:hover { background: var(--ppp-green); color: #fff !important; border-color: var(--ppp-green); }
    .btn-menu:hover i { color: #fff; }
    
    .scroll-offset { scroll-margin-top: 100px; }

    .instruction-text {
        background: #f8f9fa; border-left: 5px solid #3051a0; padding: 20px;
        text-align: left; font-size: 0.95rem; color: #333; line-height: 1.6; border-radius: 8px;
        max-height: 300px; overflow-y: auto;
    }

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
            <div class="row">
                <div class="col-6 mb-3">
                    <div class="stat-box">
                        <span class="stat-label">Kursus Tahun {{ date('Y') }}</span>
                        <span class="stat-number">45</span>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <div class="stat-box">
                        <span class="stat-label">Jumlah Keseluruhan</span>
                        <span class="stat-number">1,280</span>
                    </div>
                </div>
            </div>
            <div class="row mt-md-3">
                <div class="col-4"><div class="stat-box"><span class="stat-label">MOT</span><span class="stat-number">0</span></div></div>
                <div class="col-4"><div class="stat-box"><span class="stat-label">TOT</span><span class="stat-number">0</span></div></div>
                <div class="col-4"><div class="stat-box"><span class="stat-label">Provider</span><span class="stat-number">0</span></div></div>
            </div>
        </div>
    </div>

    <div id="prpa-kursus" class="scroll-offset mb-5">
        <h4 class="section-title">Pengurusan Kursus</h4>
        <div class="row text-center px-2 px-md-0">
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <a href="#" class="btn-menu shadow-sm"><i class="fas fa-file-signature"></i><span class="font-weight-bold">Borang Permohonan</span></a>
            </div>
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <a href="#" class="btn-menu shadow-sm"><i class="fas fa-video"></i><span class="font-weight-bold">Video Kursus</span></a>
            </div>
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <div class="btn-menu shadow-sm" data-toggle="modal" data-target="#quizSelectorModal">
                    <i class="fas fa-question-circle"></i><span class="font-weight-bold">e-Quiz</span>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3 px-1 px-md-2">
                <a href="{{ route('prpa.semak.borang') }}" class="btn-menu shadow-sm"><i class="fas fa-poll"></i><span class="font-weight-bold">Semak Keputusan</span></a>
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
                            <tr><th>Tarikh</th><th>Nama Kursus</th><th>Lokasi</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>12-14 Mei 2026</td><td>Kursus PHCALS Provider</td><td>KSKB Sungai Buloh</td></tr>
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
</div>

<div class="modal fade" id="quizSelectorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-file-alt mr-2"></i> EXAMINATION INSTRUCTIONS</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="instruction-text mb-4 text-dark shadow-sm">
                    <p>This quiz consists of <strong>120 questions</strong> in English version and must be completed in a single session. Please allocate approximately <strong>two (2) hours</strong> for uninterrupted completion.</p>
                    <p>Read each question carefully and select the single (1) best answer from the options provided. Before attempting the quiz, thoroughly review the course manual to ensure you are prepared. You may refer to the manual anytime if you are in doubt.</p>
                    <p>The objective is to achieve <strong>100% accuracy</strong>. You may retake the quiz as many times as needed. You can download your result and give it to your supervisor.</p>
                    <p>This quiz requires a seamless internet connection to work.</p>
                    <p class="mb-0 font-weight-bold text-primary">Best regards, PHCALS Team</p>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold d-block text-left ml-1">Select Your Question Set:</label>
                    <select id="finalSetSelect" class="form-control form-control-lg" style="border: 2px solid #3051a0; font-weight: bold;">
    <option value="">-- SELECT SET --</option>
    <option value="{{ url('/prpa/quiz/1') }}">SET 1</option>
    <option value="" disabled>SET 2</option>
</select>
                </div>

                <button id="finalStartBtn" class="btn btn-block mt-4" 
    style="height: 60px; border-radius: 30px; font-size: 1.3rem; font-weight: 900; color: white;
           background: linear-gradient(180deg, #ff4d4d 0%, #cc0000 50%, #800000 100%);
           box-shadow: 0 6px 20px rgba(255, 0, 0, 0.4); border: none; cursor: pointer; opacity: 1;">
    START EXAMINATION <i class="fas fa-play-circle ml-2"></i>
</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('finalStartBtn');
        const select = document.getElementById('finalSetSelect');

        btn.onclick = function() {
            const url = select.value;
            if (url !== "") {
                // Cara paling "kasar" untuk paksa browser pindah page
                window.location = url;
            } else {
                alert("Please select SET 1 first!");
            }
        };
    });
</script>
@endsection