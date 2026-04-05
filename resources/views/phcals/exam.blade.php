@extends('layouts.app')

@section('content')
<style>
    /* 1. SEKATAN SECURITY */
    body { 
        -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; 
    }
    
    /* 2. TIMER FLOATING */
    #timer-container {
        position: fixed; top: 100px; right: 20px; z-index: 1000;
        padding: 15px 25px; border-radius: 50px; color: white;
        font-weight: bold; font-size: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transition: all 0.5s ease; min-width: 180px; text-align: center;
    }
    .timer-green { background: #28a745; border: 4px solid #1e7e34; }
    .timer-orange { background: #fd7e14; border: 4px solid #d96d00; animation: blink 1s infinite; }
    .timer-red { background: #dc3545; border: 4px solid #a71d2a; animation: blink 0.5s infinite; }

    @keyframes blink { 50% { opacity: 0.7; } }

    /* 3. DESIGN KAD SOALAN */
    .question-card {
        background: white; border-radius: 15px; padding: 30px;
        margin-bottom: 25px; border-left: 8px solid #3051a0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .option-container { margin-top: 15px; }
    .option-item {
        display: block; position: relative; padding: 12px 15px 12px 50px;
        margin-bottom: 12px; cursor: pointer; border: 1px solid #eee;
        border-radius: 10px; transition: 0.2s; background: #f9f9f9;
    }
    .option-item:hover { background: #eef2ff; border-color: #3051a0; }
    .option-item input { position: absolute; opacity: 0; cursor: pointer; }
    .checkmark {
        position: absolute; top: 12px; left: 15px; height: 22px; width: 22px;
        background-color: #ddd; border-radius: 50%;
    }
    .option-item input:checked ~ .checkmark { background-color: #3051a0; }
    .option-item input:checked ~ span { font-weight: bold; color: #3051a0; }
</style>

<div id="timer-container" class="timer-green">
    <i class="fas fa-clock"></i> <span id="time-display">01:30:00</span>
</div>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="text-center mb-5">
                <h2 class="font-weight-bold text-uppercase">Ujian Kompetensi PHCALS (Set 1)</h2>
                <div class="badge badge-info px-3 py-2">50 SOALAN | 90 MINIT</div>
                <p class="text-muted mt-2">Nota: Anda perlu skor 100% untuk lulus dan mencetak sijil.</p>
            </div>

            <form action="{{ route('phcals.submit') }}" method="POST" id="exam-form" oncontextmenu="return false;">
                @csrf
                
                @foreach($questions as $index => $q)
                <div class="question-card">
                    <h5 class="font-weight-bold">Soalan {{ $index + 1 }}</h5>
                    <p class="lead" style="font-size: 1.1rem;">{{ $q->question_text }}</p>
                    
                    <div class="option-container">
                        @foreach(['A', 'B', 'C', 'D'] as $opt)
                        @php $field = 'ans_'.strtolower($opt); @endphp
                        <label class="option-item">
                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" required>
                            <span class="checkmark"></span>
                            <span><strong>{{ $opt }}.</strong> {{ $q->$field }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="card p-4 shadow-sm bg-light text-center border-0">
                    <h4>Sudah selesai menjawab?</h4>
                    <p>Pastikan semua soalan telah diisi sebelum menghantar.</p>
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow" onclick="return confirm('Adakah anda pasti mahu menghantar jawapan?')">
                        HANTAR JAWAPAN SEKARANG
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. LOGIK TIMER
    let totalSeconds = 90 * 60; // 90 minit
    const timerDisplay = document.getElementById('time-display');
    const timerContainer = document.getElementById('timer-container');

    const countdown = setInterval(function() {
        let hours = Math.floor(totalSeconds / 3600);
        let minutes = Math.floor((totalSeconds % 3600) / 60);
        let seconds = totalSeconds % 60;

        timerDisplay.innerHTML = 
            (hours < 10 ? "0" : "") + hours + ":" + 
            (minutes < 10 ? "0" : "") + minutes + ":" + 
            (seconds < 10 ? "0" : "") + seconds;

        // TUKAR WARNA IKUT MASA
        if (totalSeconds <= 900) { // Bawah 15 minit (MERAH)
            timerContainer.className = "timer-red";
        } else if (totalSeconds <= 1800) { // Bawah 30 minit (OREN)
            timerContainer.className = "timer-orange";
        }

        if (totalSeconds <= 0) {
            clearInterval(countdown);
            alert("Masa telah tamat! Jawapan anda akan dihantar secara automatik.");
            document.getElementById('exam-form').submit();
        }
        totalSeconds--;
    }, 1000);

    // 2. SEKATAN SECURITY (DISABLE RIGHT CLICK & F12)
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.onkeydown = function(e) {
        if(e.keyCode == 123) return false; // F12
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false; // Inspect
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false; // Element
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false; // Console
        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false; // View Source
    };
</script>
@endsection