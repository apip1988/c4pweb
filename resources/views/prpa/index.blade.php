@extends('layouts.app')

@section('content')
<style>
    :root { --ppp-green: #2d5a27; --ppp-light: #f0f7f0; }
    .section-title { font-weight: 700; color: var(--ppp-green); text-transform: uppercase; margin-bottom: 25px; border-left: 5px solid var(--ppp-green); padding-left: 15px; }
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background: #fff; }
    
    .btn-menu { 
        height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; 
        padding: 25px 15px; border-radius: 15px; text-decoration: none !important; transition: 0.3s; 
        background: #fff; border: 1px solid #eee; color: #333; cursor: pointer;
    }
    .btn-menu i { font-size: 2.2rem; margin-bottom: 15px; color: var(--ppp-green); }
    .btn-menu:hover { background: var(--ppp-green); color: #fff !important; }
    .btn-menu:hover i { color: #fff; }

    /* Style untuk Instruction Box dalam Modal */
    .instruction-text {
        background: #f8f9fa; border-left: 5px solid #3051a0; padding: 15px;
        text-align: left; font-size: 0.9rem; color: #333; line-height: 1.6;
        margin-top: 15px; border-radius: 5px;
    }
</style>

<div class="container py-4">
    <div id="prpa-dashboard" class="mb-5">
        <h4 class="section-title">Dashboard PRPA</h4>
        </div>

    <div id="prpa-kursus" class="mb-5">
        <h4 class="section-title">Pengurusan Kursus</h4>
        <div class="row text-center">
            <div class="col-6 col-md-3 mb-3">
                <a href="#" class="btn-menu shadow-sm"><i class="fas fa-file-signature"></i><span>Borang Permohonan</span></a>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <a href="#" class="btn-menu shadow-sm"><i class="fas fa-video"></i><span>Video Kursus</span></a>
            </div>
            
            <div class="col-6 col-md-3 mb-3">
                <div class="btn-menu shadow-sm" data-toggle="modal" data-target="#quizSelectorModal">
                    <i class="fas fa-question-circle"></i>
                    <span class="font-weight-bold">e-Quiz</span>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <a href="{{ route('prpa.semak.borang') }}" class="btn-menu shadow-sm"><i class="fas fa-poll"></i><span>Semak Keputusan</span></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="quizSelectorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">EXAMINATION INSTRUCTIONS</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4 text-center">
                
                <div class="instruction-text mb-4">
                    <p>This quiz consists of 120 questions in English version and must be completed in a single session. Please allocate approximately two (2) hours for uninterrupted completion.</p>
                    <p>Read each question carefully and select the single (1) best answer from the options provided. Before attempting the quiz, thoroughly review the course manual to ensure you are prepared. You may refer to the manual anytime if you are in doubt.</p>
                    <p>The objective is to achieve 100% accuracy. You may retake the quiz as many times as needed. You can download your result and give it to your supervisor.</p>
                    <p>This quiz requires seamless internet connection to work.</p>
                    <p class="mb-0 font-weight-bold text-primary">Best regards, PHCALS Team</p>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Please Select Question Set:</label>
                    <select id="finalSetSelect" class="form-control form-control-lg" style="border: 2px solid #3051a0; font-weight: bold;">
                        <option value="">-- SELECT SET --</option>
                        <option value="/prpa/quiz/1">SET 1</option>
                        <option value="" disabled>SET 2</option>
                        <option value="" disabled>SET 3</option>
                        <option value="" disabled>SET 4</option>
                        <option value="" disabled>SET 5</option>
                    </select>
                </div>

                <button id="finalStartBtn" class="btn btn-block mt-4" 
                    style="height: 60px; border-radius: 30px; font-size: 1.3rem; font-weight: 900; color: white;
                           background: linear-gradient(180deg, #ff4d4d 0%, #cc0000 50%, #800000 100%);
                           box-shadow: 0 6px 20px rgba(255, 0, 0, 0.4), inset 0 2px 4px rgba(255, 255, 255, 0.6);
                           border: none; opacity: 0.5; cursor: not-allowed;" disabled>
                    START EXAMINATION
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Guna Vanilla JS kalau JQuery Afif bermasalah
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('finalSetSelect');
        const btn = document.getElementById('finalStartBtn');

        select.addEventListener('change', function() {
            if (this.value !== "") {
                btn.disabled = false;
                btn.style.opacity = "1";
                btn.style.cursor = "pointer";
            } else {
                btn.disabled = true;
                btn.style.opacity = "0.5";
                btn.style.cursor = "not-allowed";
            }
        });

        btn.addEventListener('click', function() {
            if (select.value !== "") {
                window.location.href = select.value;
            }
        });
    });
</script>
@endsection