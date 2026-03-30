@extends('layouts.app')

@section('content')
<style>
    .negeri-wrapper { padding: 40px 20px; background: #f0f2f5; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
    .header-title { text-align: center; color: #3051a0; margin-bottom: 50px; font-weight: 800; text-transform: uppercase; }
    
    /* Grid Bendera Bulat */
    .flag-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
        gap: 30px; max-width: 1100px; margin: 0 auto; 
    }
    
    .flag-item { text-align: center; cursor: pointer; transition: 0.3s; }
    .flag-item:hover { transform: scale(1.1); }
    
    .flag-circle {
        width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 10px;
        border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden; background: #eee;
    }
    .flag-circle img { width: 100%; height: 100%; object-fit: cover; }
    .negeri-name { font-size: 0.85rem; font-weight: 700; color: #333; text-transform: uppercase; }

    /* Modal Styling */
    .modal-negeri { border-radius: 20px; overflow: hidden; }
    .header-negeri { background: #3051a0; color: white; padding: 20px; }
    .card-kpppn { 
        background: #f8f9fa; border-radius: 15px; padding: 20px; 
        margin-bottom: 15px; border-left: 5px solid #3051a0;
        display: flex; align-items: center; gap: 20px;
    }
    .img-kpppn { width: 80px; height: 80px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .img-kpppn img { width: 100%; height: 100%; object-fit: cover; }
    .info-kpppn h5 { margin: 0; font-size: 1rem; font-weight: 700; color: #3051a0; }
    .info-kpppn p { margin: 2px 0; font-size: 0.8rem; color: #555; font-weight: 600; }
    .info-kpppn span { font-size: 0.75rem; color: #777; display: block; }
</style>

<div class="negeri-wrapper">
    <h2 class="header-title">Direktori KPPP Negeri & Wilayah Persekutuan</h2>

    <div class="flag-grid">
        @php
            // List 18 entiti (13 Negeri + 3 WP + 2 Institut)
            $senarai_negeri = [
                ['id' => 'perlis', 'n' => 'Perlis', 'img' => 'perlis.png'],
                ['id' => 'kedah', 'n' => 'Kedah', 'img' => 'kedah.png'],
                ['id' => 'penang', 'n' => 'Pulau Pinang', 'img' => 'penang.png'],
                ['id' => 'perak', 'n' => 'Perak', 'img' => 'perak.png'],
                ['id' => 'selangor', 'n' => 'Selangor', 'img' => 'selangor.png'],
                ['id' => 'n9', 'n' => 'Negeri Sembilan', 'img' => 'n9.png'],
                ['id' => 'melaka', 'n' => 'Melaka', 'img' => 'melaka.png'],
                ['id' => 'johor', 'n' => 'Johor', 'img' => 'johor.png'],
                ['id' => 'pahang', 'n' => 'Pahang', 'img' => 'pahang.png'],
                ['id' => 'terengganu', 'n' => 'Terengganu', 'img' => 'terengganu.png'],
                ['id' => 'kelantan', 'n' => 'Kelantan', 'img' => 'kelantan.png'],
                ['id' => 'sabah', 'n' => 'Sabah', 'img' => 'sabah.png'],
                ['id' => 'sarawak', 'n' => 'Sarawak', 'img' => 'sarawak.png'],
                ['id' => 'kl', 'n' => 'WP Kuala Lumpur', 'img' => 'wp.png'],
                ['id' => 'putrajaya', 'n' => 'WP Putrajaya', 'img' => 'wp.png'],
                ['id' => 'labuan', 'n' => 'WP Labuan', 'img' => 'wp.png'],
                ['id' => 'ikn', 'n' => 'Inst. Kanser Negara', 'img' => 'ikn.png'],
                ['id' => 'ipr', 'n' => 'Inst. Med Respiratori', 'img' => 'ipr.png'],
            ];
        @endphp

        @foreach($senarai_negeri as $negeri)
        <div class="flag-item" data-toggle="modal" data-target="#modal-{{ $negeri['id'] }}">
            <div class="flag-circle">
                <img src="{{ asset('img/flags/'.$negeri['img']) }}" alt="{{ $negeri['n'] }}" onerror="this.src='https://via.placeholder.com/100?text=Flag'">
            </div>
            <div class="negeri-name">{{ $negeri['n'] }}</div>
        </div>

        <div class="modal fade" id="modal-{{ $negeri['id'] }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content modal-negeri">
                    <div class="header-negeri d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">PENGURUSAN PPP NEGERI: {{ strtoupper($negeri['n']) }}</h4>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body p-4">
                        
                        <div class="card-kpppn">
                            <div class="img-kpppn"><i class="fas fa-user-tie fa-2x"></i></div>
                            <div class="info-kpppn">
                                <h5>Nama Ketua PPP Negeri</h5>
                                <p>Ketua Penolong Pegawai Perubatan Negeri (KPPPN)</p>
                                <span><i class="fas fa-envelope"></i> kpppn_{{ $negeri['id'] }}@moh.gov.my</span>
                                <span><i class="fas fa-phone"></i> 0x-xxxx xxxx (Pejabat)</span>
                            </div>
                        </div>

                        <div class="card-kpppn" style="border-left-color: #27ae60;">
                            <div class="img-kpppn"><i class="fas fa-user-circle fa-2x"></i></div>
                            <div class="info-kpppn">
                                <h5>Nama Timbalan (Perubatan)</h5>
                                <p>Timbalan KPPPN (Perubatan)</p>
                                <span><i class="fas fa-envelope"></i> timb_per_{{ $negeri['id'] }}@moh.gov.my</span>
                                <span><i class="fas fa-phone"></i> 0x-xxxx xxxx (Pejabat)</span>
                            </div>
                        </div>

                        <div class="card-kpppn" style="border-left-color: #e67e22;">
                            <div class="img-kpppn"><i class="fas fa-user-circle fa-2x"></i></div>
                            <div class="info-kpppn">
                                <h5>Nama Timbalan (Kesihatan Awam)</h5>
                                <p>Timbalan KPPPN (Kesihatan Awam)</p>
                                <span><i class="fas fa-envelope"></i> timb_ka_{{ $negeri['id'] }}@moh.gov.my</span>
                                <span><i class="fas fa-phone"></i> 0x-xxxx xxxx (Pejabat)</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection