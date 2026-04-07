@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="container">
        
        <div class="text-center mb-5">
            <h2 class="font-weight-bold" style="color: #3051a0; text-transform: uppercase; letter-spacing: 2px;">
                UJIAN KURSUS PHCALS (SET {{ $id }})
            </h2>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <span class="badge badge-pill badge-info px-4 py-2 mx-2" style="font-size: 1rem;">
                    <i class="fas fa-list-ol mr-2"></i> 10 SOALAN
                </span>
                <span class="badge badge-pill badge-secondary px-4 py-2 mx-2" style="font-size: 1rem;">
                    <i class="fas fa-clock mr-2"></i> 90 MINIT
                </span>
            </div>
            <p class="text-muted mt-3">Nota: Anda perlu skor 100% untuk lulus dan mencetak sijil.</p>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <form id="quizForm" action="{{ route('phcals.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="set_id" value="{{ $id }}">

                    @foreach($questions as $index => $q)
                    <div class="card shadow-sm mb-4 question-card" id="card-{{ $index }}" style="border-radius: 15px; border-left: 5px solid #3051a0;">
                        <div class="card-body p-4">
                            <h5 class="font-weight-bold" style="color: #3051a0;">Question {{ $index + 1 }}</h5>
                            <p class="lead" style="font-weight: 500; color: #333;">{{ $q['question'] }}</p>
                            <hr>

                            @foreach($q['options'] as $oIndex => $option)
                            <div class="custom-control custom-radio mb-3 p-2 option-container" style="border-radius: 10px; transition: 0.3s;">
                                <input type="radio" id="q{{$index}}o{{$oIndex}}" name="ans[{{$index}}]" value="{{$option}}" 
                                       class="custom-control-input quiz-radio" onchange="markAsAnswered({{ $index }})">
                                <label class="custom-control-label w-100 font-weight-normal" for="q{{$index}}o{{$oIndex}}" style="cursor: pointer; font-size: 1.1rem;">
                                    {{ $option }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    <div class="card shadow-sm mb-5" style="border-radius: 15px; background: #fff;">
                        <div class="card-body text-center py-5">
                            <h4 class="font-weight-bold mb-3">Sudah selesai menjawab?</h4>
                            <p class="text-muted mb-4">Pastikan semua soalan telah diisi sebelum menghantar.</p>
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow" 
                                    style="border-radius: 30px; font-weight: bold; letter-spacing: 1px;"
                                    onclick="return confirm('Adakah anda pasti ingin menghantar jawapan sekarang?')">
                                HANTAR JAWAPAN SEKARANG <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-3">
                <div class="sticky-top" style="top: 20px; z-index: 1020;">
                    <div id="timerBox" class="card shadow-sm mb-3 text-white text-center" 
                         style="border-radius: 50px; background: linear-gradient(45deg, #28a745, #218838); border: none;">
                        <div class="card-body py-3">
                            <h3 class="mb-0 font-weight-bold"><i class="fas fa-clock mr-2"></i> <span id="timer">90:00</span></h3>
                        </div>
                    </div>

                    <div class="card shadow-sm" style="border-radius: 15px;">
                        <div class="card-header bg-white font-weight-bold text-center">NAVIGATOR</div>
                        <div class="card-body p-3">
                            <div class="d-flex flex-wrap justify-content-center">
                                @foreach($questions as $index => $q)
                                <a href="#card-{{ $index }}" id="nav-{{ $index }}" 
                                   class="btn btn-outline-secondary m-1 rounded-circle d-flex align-items-center justify-content-center nav-dot" 
                                   style="width: 35px; height: 35px; font-size: 0.8rem; font-weight: bold;">
                                    {{ $index + 1 }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .option-container:hover { background-color: #f0f4ff; }
    .nav-dot.answered { background-color: #28a745 !important; color: white !important; border-color: #28a745 !important; }
    html { scroll-behavior: smooth; }
    /* Anti-Copy */
    body { -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
</style>

<script>
    // Fungsi untuk tanda navigator bila soalan dijawab
    function markAsAnswered(index) {
        document.getElementById('nav-' + index).classList.add('answered');
    }

    // Logic Timer 90 Minit
    let time = 90 * 60; 
    const timerElement = document.getElementById('timer');
    const timerBox = document.getElementById('timerBox');

    const countdown = setInterval(() => {
        let minutes = Math.floor(time / 60);
        let seconds = time % 60;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        timerElement.innerHTML = `${minutes}:${seconds}`;

        if (time <= 300) { // 5 minit terakhir tukar merah
            timerBox.style.background = "linear-gradient(45deg, #dc3545, #c82333)";
        } else if (time <= 900) { // 15 minit terakhir tukar kuning
            timerBox.style.background = "linear-gradient(45deg, #ffc107, #e0a800)";
            timerBox.classList.remove('text-white');
            timerBox.classList.add('text-dark');
        }

        if (time <= 0) {
            clearInterval(countdown);
            alert("Masa telah tamat! Jawapan anda akan dihantar secara automatik.");
            document.getElementById('quizForm').submit();
        }
        time--;
    }, 1000);
</script>
@endsection