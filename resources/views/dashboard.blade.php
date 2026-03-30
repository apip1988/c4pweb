@extends('layouts.app')

@section('content')
@php
    // 1. Logik Pengiraan Peratus untuk 4 Kategori Utama
    // Formula: (Nilai / Total) * 100
    $p_lelaki = $total_ppp > 0 ? ($lelaki / $total_ppp) * 100 : 0;
    $p_perempuan = $total_ppp > 0 ? ($perempuan / $total_ppp) * 100 : 0;

    $p_perubatan = $total_ppp > 0 ? ($perubatan / $total_ppp) * 100 : 0;
    $p_kesihatan = $total_ppp > 0 ? ($kesihatan / $total_ppp) * 100 : 0;
    $p_pengurusan = $total_ppp > 0 ? ($pengurusan / $total_ppp) * 100 : 0;

    $p_awam = $total_ppp > 0 ? ($sektor_awam / $total_ppp) * 100 : 0;
    $p_swasta = $total_ppp > 0 ? ($sektor_swasta / $total_ppp) * 100 : 0;

    $p_tetap = $total_ppp > 0 ? ($tetap / $total_ppp) * 100 : 0;
    $p_kontrak = $total_ppp > 0 ? ($kontrak / $total_ppp) * 100 : 0;

    // 2. Logik Pengiraan Peratus untuk Bahagian (Carta Pai)
    $total_bahagian = $mers + $ipkkm + $jkn + $pkd + $hospital + $klinik + $kader;
@endphp

<style>
    .highlight-row {
        background-color: #f8f9fa !important;
        border-left: 5px solid #3490dc !important;
        transition: all 0.2s ease;
        transform: translateX(10px);
        font-weight: bold;
    }
    .list-group-item {
        cursor: pointer;
        transition: all 0.2s ease;
        border-left: 5px solid transparent;
    }
    .perc-tag {
        font-size: 0.75rem;
        opacity: 0.8;
        font-weight: normal;
    }

    @media print {
        .no-print, .main-sidebar, .main-header, .navbar, .btn, footer {
            display: none !important;
        }
        .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
        body { -webkit-print-color-adjust: exact !important; }
        .card { border: 1px solid #ddd !important; break-inside: avoid; }
    }
</style>

<div class="d-flex justify-content-end mb-3 no-print">
    <button onclick="window.print()" class="btn btn-danger shadow-sm font-weight-bold">
        <i class="fas fa-file-pdf mr-2"></i> CETAK LAPORAN (PDF)
    </button>
</div>

<div class="container-fluid py-4 px-4">
    <h3 class="font-weight-bold mb-4">DASHBOARD STATISTIK PPP</h3>

    <div class="card mb-4 border-0 shadow" style="background-color: #C2185B; color: white; border-radius: 15px;">
        <div class="card-body d-flex justify-content-between align-items-center p-4">
            <div>
                <h4 class="font-weight-bold mb-0">Jumlah Keseluruhan Anggota</h4>
                <p class="mb-0 small">Mewakili 100% data berdaftar dalam sistem</p>
            </div>
            <div class="text-right">
                <h1 class="display-4 font-weight-bold mb-0">{{ number_format($total_ppp) }}</h1>
                <p class="mb-0 small">Ahli Berdaftar (100%)</p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm text-white" style="background-color: #448AFF; border-radius: 15px;">
                <div class="card-body p-3">
                    <h6 class="text-center font-weight-bold small">JANTINA</h6>
                    <hr style="border-color: rgba(255,255,255,0.3)" class="my-2">
                    <div class="d-flex justify-content-between"><span>Lelaki:</span> <strong>{{ number_format($lelaki) }} <span class="perc-tag">({{ number_format($p_lelaki, 1) }}%)</span></strong></div>
                    <div class="d-flex justify-content-between"><span>Perempuan:</span> <strong>{{ number_format($perempuan) }} <span class="perc-tag">({{ number_format($p_perempuan, 1) }}%)</span></strong></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm text-white" style="background-color: #4CAF50; border-radius: 15px;">
                <div class="card-body p-3">
                    <h6 class="text-center font-weight-bold small">BIDANG</h6>
                    <hr style="border-color: rgba(255,255,255,0.3)" class="my-2">
                    <div class="d-flex justify-content-between"><span>Perubatan:</span> <strong>{{ number_format($perubatan) }} <span class="perc-tag">({{ number_format($p_perubatan, 1) }}%)</span></strong></div>
                    <div class="d-flex justify-content-between"><span>Kesihatan:</span> <strong>{{ number_format($kesihatan) }} <span class="perc-tag">({{ number_format($p_kesihatan, 1) }}%)</span></strong></div>
                    <div class="d-flex justify-content-between"><span>Pengurusan:</span> <strong>{{ number_format($pengurusan) }} <span class="perc-tag">({{ number_format($p_pengurusan, 1) }}%)</span></strong></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm text-white" style="background-color: #9C27B0; border-radius: 15px;">
                <div class="card-body p-3">
                    <h6 class="text-center font-weight-bold small">SEKTOR</h6>
                    <hr style="border-color: rgba(255,255,255,0.3)" class="my-2">
                    <div class="d-flex justify-content-between"><span>Awam:</span> <strong>{{ number_format($sektor_awam) }} <span class="perc-tag">({{ number_format($p_awam, 1) }}%)</span></strong></div>
                    <div class="d-flex justify-content-between"><span>Swasta:</span> <strong>{{ number_format($sektor_swasta) }} <span class="perc-tag">({{ number_format($p_swasta, 1) }}%)</span></strong></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm text-white" style="background-color: #FF9800; border-radius: 15px;">
                <div class="card-body p-3">
                    <h6 class="text-center font-weight-bold small">STATUS</h6>
                    <hr style="border-color: rgba(255,255,255,0.3)" class="my-2">
                    <div class="d-flex justify-content-between"><span>Tetap:</span> <strong>{{ number_format($tetap) }} <span class="perc-tag">({{ number_format($p_tetap, 1) }}%)</span></strong></div>
                    <div class="d-flex justify-content-between"><span>Kontrak:</span> <strong>{{ number_format($kontrak) }} <span class="perc-tag">({{ number_format($p_kontrak, 1) }}%)</span></strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius:15px;">
        <h4 class="font-weight-bold mb-4 text-secondary">PPP Mengikut Bahagian</h4>
        <div class="row align-items-center">
            <div class="col-md-5 text-center">
                <div style="position: relative; height:280px;">
                    <canvas id="bahagianChart"></canvas>
                </div>
            </div>
            <div class="col-md-7">
                <div class="list-group list-group-flush" id="chart-legend">
                    @php
                        $bahagian_list = [
                            ['NG MERS999', $mers, '#BBDEFB'],
                            ['IPKKM', $ipkkm, '#2ecc71'],
                            ['JKN', $jkn, '#D1C4E9'],
                            ['PKD/PKK/PKB', $pkd, '#FFCCBC'],
                            ['HOSPITAL', $hospital, '#B2EBF2'],
                            ['KLINIK', $klinik, '#FFECB3'],
                            ['KADER', $kader, '#CFD8DC']
                        ];
                    @endphp

                    @foreach($bahagian_list as $index => $item)
                    @php 
                        $peratus = $total_bahagian > 0 ? ($item[1] / $total_bahagian) * 100 : 0;
                    @endphp
                    <div class="list-group-item d-flex justify-content-between align-items-center" data-index="{{ $index }}">
                        <span><i class="fas fa-circle mr-2" style="color: {{ $item[2] }};"></i> {{ $item[0] }}</span>
                        <div class="text-right">
                            <span class="font-weight-bold">{{ number_format($item[1]) }}</span><br>
                            <small class="text-muted">{{ number_format($peratus, 1) }}%</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
$(document).ready(function() {
    var ctx = document.getElementById('bahagianChart').getContext('2d');
    
    var myDonut = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['NG MERS999', 'IPKKM', 'JKN', 'PKD/PKK/PKB', 'HOSPITAL', 'KLINIK', 'KADER'],
            datasets: [{
                data: [{{ $mers }}, {{ $ipkkm }}, {{ $jkn }}, {{ $pkd }}, {{ $hospital }}, {{ $klinik }}, {{ $kader }}],
                backgroundColor: ['#BBDEFB', '#2ecc71', '#D1C4E9', '#FFCCBC', '#B2EBF2', '#FFECB3', '#CFD8DC'],
                borderWidth: 0
            }]
        },
        options: {
            cutoutPercentage: 75,
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce((a, b) => a + b, 0);
                        var value = dataset.data[tooltipItem.index];
                        var percentage = ((value / total) * 100).toFixed(1);
                        return data.labels[tooltipItem.index] + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                    }
                }
            },
            onHover: function(evt, elements) {
                $('.list-group-item').removeClass('highlight-row');
                if (elements.length) {
                    var index = elements[0]._index;
                    $('.list-group-item[data-index="' + index + '"]').addClass('highlight-row');
                }
            }
        }
    });

    $('.list-group-item').on('mouseenter', function() {
        var idx = $(this).data('index');
        $(this).addClass('highlight-row');
        var segment = myDonut.getDatasetMeta(0).data[idx];
        myDonut.tooltip._active = [segment];
        myDonut.active = [segment];
        myDonut.tooltip.update(true);
        myDonut.draw();
    });

    $('.list-group-item').on('mouseleave', function() {
        $(this).removeClass('highlight-row');
        myDonut.tooltip._active = [];
        myDonut.active = [];
        myDonut.update();
    });
});
</script>
@endsection