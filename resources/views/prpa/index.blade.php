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

    /* FAQ STYLING */
    .faq-header {
        background-color: #3b8d66; /* Hijau seperti dalam gambar */
        color: white;
        border-radius: 8px !important;
        margin-bottom: 10px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        font-weight: 500;
    }
    .faq-header:hover { background-color: #2d6d4f; }
    .faq-header[aria-expanded="true"] { border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important; margin-bottom: 0; }
    .faq-body {
        background-color: #fff;
        border: 1px solid #3b8d66;
        border-top: none;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        margin-bottom: 10px;
        padding: 20px;
        color: #444;
        line-height: 1.6;
    }
    .faq-icon { transition: transform 0.3s; }
    .faq-header[aria-expanded="true"] .faq-icon { transform: rotate(180deg); }

    .learning-list { max-height: 450px; overflow-y: auto; border-radius: 10px; }
    .learning-item { transition: 0.2s; border-left: 3px solid transparent !important; }
    .learning-item:hover { background-color: #f0f7f0; border-left: 3px solid var(--ppp-green) !important; }

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
        <div class="row text-center px-2 px-md-0 d-flex justify-content-center">
            <div class="col-6 col-md-2 mb-3 px-1 px-md-2">
                <a href="#" class="btn-menu shadow-sm"><i class="fas fa-file-signature"></i><span class="font-weight-bold">Borang Permohonan</span></a>
            </div>
            <div class="col-6 col-md-2 mb-3 px-1 px-md-2">
                <div class="btn-menu shadow-sm" data-toggle="modal" data-target="#elearningModal">
                    <i class="fas fa-video"></i><span class="font-weight-bold">e-Learning</span>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-3 px-1 px-md-2">
                <div class="btn-menu shadow-sm" data-toggle="modal" data-target="#manualModal">
                    <i class="fas fa-book"></i><span class="font-weight-bold">PHCALS Manual</span>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-3 px-1 px-md-2">
                <div class="btn-menu shadow-sm" data-toggle="modal" data-target="#quizSelectorModal">
                    <i class="fas fa-question-circle"></i><span class="font-weight-bold">e-Quiz</span>
                </div>
            </div>
            <div class="col-12 col-md-2 mb-3 px-1 px-md-2">
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

    <div id="prpa-faq" class="scroll-offset mb-5">
        <h4 class="section-title">FAQ</h4>
        <div class="accordion" id="accordionFAQ">
            
            <div class="faq-header" data-toggle="collapse" data-target="#collapse1" aria-expanded="false">
                <span>What is PHCALS course?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse1" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    PHCALS is a program developed by Cawangan Perkhidmatan Penolong Pegawai Perubatan (C4P), Minister of Health Malaysia (MOH) as standardized national training module for all Pre Hospital Care and Ambulance Services (PHCAS) responders.<br><br>
                    It comprises of PHCALS Course Manual, PHCALS Practical Session Handbook, Educational Videos, Lecture Presentation Slides, and Logbooks.<br><br>
                    This is a comprehensive program to benchmark PHCAS responder to ensure their competency and capability to provide the best care for the patients in PHCAS.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse2" aria-expanded="false">
                <span>Who can attend this course?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse2" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    Eligibility to attend this course is as follow:
                    <ul>
                        <li>Active Basic Life Support Certificate (both NCORT & AHA are accepted), AND</li>
                        <li>Registered with the Medical Assistant Board with an active Annual Practising Certificate, (APC), AND</li>
                        <li>Completed the pre-test quizzes (open source – with multiple attempts allowed) with a score of 100%.</li>
                    </ul>
                    Basic course for non Assistant Medical Officers is under development and will be available soon.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse3" aria-expanded="false">
                <span>Do I need to pay for this course?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse3" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    This course does not impose any fee for MOH personnel.<br><br>
                    The price you might need to pay will be for food, accommodation and training venue as applicable. This might be different for each organizer.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse4" aria-expanded="false">
                <span>Who can organize this course?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse4" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    The Course Coordinators who is the State Head of Assistant Medical Officer is responsible to organize PHCALS in their own state.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse5" aria-expanded="false">
                <span>How to enroll into this course?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse5" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    After completion of your pre-test quiz with 100% score, you may forward by emailing your result to your local supervisor so that they can assist you to to enroll for this course through the Course Coordinator.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse6" aria-expanded="false">
                <span>Will I get a certificate from this course?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse6" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    After completion of this course which consist of pre-test quiz, passing the PHCALS examination, and completed the PHCALS certification logbook (Appendix A) within the stipulated period (3 months), you will received an official PHCALS e-certificated from C4P, MOH.<br><br>
                    We do not provide certificate of attendance, the certificate is only for those who has successfully completed the whole program.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse7" aria-expanded="false">
                <span>How long is the validity of PHCALS certificate?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse7" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    PHCALS certification is valid for 3-years.<br><br>
                    During the 3-years, the candidate are suppose to complete their logbook (Appendix B) for re-certification.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse8" aria-expanded="false">
                <span>I have passed my ADEC sub in PHC / AMTAC before year 2026. What shall I do to be certified in PHCALS?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse8" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    You are automatically considered passed your PHCALS program as PHCALS program is embedded inside your ADEC sub PHC training program and not required to sit for the PHCALS course.<br><br>
                    However, you are required to complete the logbook (Appendix B) for re-certification after 3-years starting from 2026 onwards.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse9" aria-expanded="false">
                <span>I have passed ADEC non PHC sub. What shall I do to be certified in PHCALS?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse9" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    You may proceed to attempt the pre-test quiz and enroll for PHCALS course once eligible.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse10" aria-expanded="false">
                <span>I am fresh new Assistant Medical Officer currently undergoing PPW training. Am I eligible to join this course?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse10" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    All Assistant Medical Officers who fulfills all the prerequisite is eligible to enroll for this course.
                </div>
            </div>

            <div class="faq-header" data-toggle="collapse" data-target="#collapse11" aria-expanded="false">
                <span>This is an advanced course. Is this course suitable for newbie in PHCAS?</span>
                <i class="fas fa-chevron-circle-down faq-icon"></i>
            </div>
            <div id="collapse11" class="collapse" data-parent="#accordionFAQ">
                <div class="faq-body">
                    As an Assistant Medical Officer, you have been trained in PHCAS in your college and your license to practice indicates that you are not a basic responder. Sometimes, you only need to refresh or recall your knowledge learnt in your college and perform more PHCAS calls to enhance your experience in the field. Therefore, this course is suitable for all Assistant Medical Officers that is actively involved in PHCAS.
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
                    <p>This quiz consists of <strong>10 questions</strong> in English version and must be completed in a single session. Please allocate approximately <strong>90 minutes</strong> for uninterrupted completion.</p>
                    <p>Read each question carefully and select the single (1) best answer from the options provided. Before attempting the quiz, thoroughly review the course manual.</p>
                    <p>The objective is to achieve <strong>100% accuracy</strong>. You may retake the quiz as many times as needed.</p>
                    <p class="mb-0 font-weight-bold text-primary">Best regards, PHCALS Team</p>
                </div>

                <div class="form-group mb-4 text-left">
                    <label class="font-weight-bold">Select Your Question Set:</label>
                    <select id="finalSetSelect" class="form-control form-control-lg" style="border: 2px solid #3051a0; font-weight: bold;">
                        <option value="">-- SELECT SET --</option>
                        <option value="{{ url('/prpa/quiz/1') }}">SET 1</option>
                        <option value="" disabled>SET 2 (Locked)</option>
                    </select>
                </div>

                <button id="finalStartBtn" class="btn btn-block mt-4" 
                    style="height: 60px; border-radius: 30px; font-size: 1.3rem; font-weight: 900; color: white;
                           background: linear-gradient(180deg, #ff4d4d 0%, #cc0000 50%, #800000 100%);
                           box-shadow: 0 6px 20px rgba(255, 0, 0, 0.4); border: none; cursor: pointer;">
                    START EXAMINATION <i class="fas fa-play-circle ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elearningModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header text-white py-3" style="background-color: var(--ppp-green);">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-graduation-cap mr-2"></i> PHCALS E-LEARNING PORTAL</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4" style="background-color: #f8fbf8;">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <h6 class="font-weight-bold mb-3 text-success border-bottom pb-2">
                            <i class="fas fa-file-pdf mr-2"></i> LECTURE NOTES (PDF)
                        </h6>
                        <div class="list-group list-group-flush shadow-sm learning-list">
                            @php
                                $lectures = [
                                    "Overview Essential of PHCAS", "Essential Assessment", "Out-of-Hospital Cardiac Arrest",
                                    "Medical Emergencies Assessment and Management", "Trauma Assessment and Management", "Medication Administration",
                                    "Effective Communication", "Mass Casualty Incident", "Obstetric Emergencies",
                                    "Paediatric Emergency in PHCAS", "Special Considerations", "Infectious Disease and Decontamination Process"
                                ];
                            @endphp
                            @foreach($lectures as $index => $lecture)
                            <a href="{{ asset('lectures/lecture'.($index+1).'.pdf') }}" target="_blank" class="list-group-item list-group-item-action small py-3 learning-item lecture-link">
                                <span class="badge badge-success mr-2">{{ $index + 1 }}</span> {{ $lecture }}
                                <i class="fas fa-external-link-alt float-right text-muted mt-1"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6 mt-4 mt-md-0">
                        <h6 class="font-weight-bold mb-3 text-primary border-bottom pb-2">
                            <i class="fas fa-play-circle mr-2"></i> EDUCATIONAL VIDEOS
                        </h6>
                        <div class="list-group list-group-flush shadow-sm learning-list">
                            @php
                                $videos = [
                                    "Medical Emergency (Anaphylactic Shock)", "Trauma Assessment (Catastrophic Bleeding)", "Medical Assessment (Hypoglycemia & Stroke)",
                                    "Trauma Assessment (Pelvic & Intraabdominal)", "Out-of-hospital Cardiac Arrest Management", "Monitoring in Ambulance",
                                    "Cardiology Assessment and Management", "Trauma Assessment (Tension Pneumothorax)", "Peadiatric Medical Emergency",
                                    "Paediatric OHCA (Drowning)", "Obstetric Emergency (Delivery)", "Neonatal Resuscitation"
                                ];
                            @endphp
                            @foreach($videos as $index => $video)
                            <a href="#" target="_blank" class="list-group-item list-group-item-action small py-3 learning-item">
                                <span class="badge badge-primary mr-2">{{ $index + 1 }}</span> {{ $video }}
                                <i class="fas fa-video float-right text-muted mt-1"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 text-center d-block">
                <small class="text-muted italic"><i class="fas fa-lock mr-1"></i> Content is restricted. Printing, downloading and right-click are disabled for security purposes.</small>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="manualModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header text-white py-3" style="background-color: var(--ppp-green);">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-book-open mr-2"></i> PHCALS DOCUMENTATION</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4" style="background-color: #f8fbf8;">
                <div class="list-group shadow-sm">
                    <a href="{{ asset('manuals/course_manual.pdf') }}" target="_blank" class="list-group-item list-group-item-action py-3 d-flex align-items-center learning-item lecture-link">
                        <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                        <div>
                            <h6 class="mb-0 font-weight-bold small">PHCALS Course Manual</h6>
                            <small class="text-muted small">Main Reference Document</small>
                        </div>
                    </a>
                    <a href="{{ asset('manuals/handbook.pdf') }}" target="_blank" class="list-group-item list-group-item-action py-3 d-flex align-items-center learning-item lecture-link">
                        <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                        <div>
                            <h6 class="mb-0 font-weight-bold small">PHCALS Practical Sessions Handbook</h6>
                            <small class="text-muted small">Procedures and Skill Sheets</small>
                        </div>
                    </a>
                    <a href="{{ asset('manuals/guideline.pdf') }}" target="_blank" class="list-group-item list-group-item-action py-3 d-flex align-items-center learning-item lecture-link">
                        <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                        <div>
                            <h6 class="mb-0 font-weight-bold small">Assessment and Certification Guideline</h6>
                            <small class="text-muted small">For candidates and local preceptors</small>
                        </div>
                    </a>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 text-center d-block">
                <small class="text-muted italic"><i class="fas fa-info-circle mr-1"></i> Restricted access for PHCALS candidates.</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LOGIK E-QUIZ ---
        const startBtn = document.getElementById('finalStartBtn');
        const setSelect = document.getElementById('finalSetSelect');

        if(startBtn) {
            startBtn.onclick = function() {
                const url = setSelect.value;
                if (url !== "") {
                    window.location = url;
                } else {
                    alert("Please select a Question Set first!");
                }
            };
        }

        // --- LOGIK SECURITY E-LEARNING & MANUAL ---
        document.addEventListener('contextmenu', function(e) {
            if (e.target.closest('.learning-list') || e.target.closest('.modal-body')) {
                e.preventDefault();
                alert('Security: Content is protected. Right-click is disabled.');
                return false;
            }
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 's' || e.key === 'u')) {
                e.preventDefault();
                alert('Security: Printing or Saving this content is restricted.');
            }
        });
    });
</script>
@endsection