@extends('layouts.app')

@section('content')
<style>
    /* Desktop & General Style */
    .result-box { 
        background: #fff; 
        padding: 40px; 
        border-radius: 10px; 
        border: 1px solid #ddd; 
        font-family: 'Courier New', Courier, monospace; 
        color: #000; 
        position: relative;
    }
    .line-separator { border-top: 2px solid #000; margin: 20px 0; }
    .history-card { background: #f8f9fa; border-radius: 10px; border-left: 5px solid #3051a0; }
    
    /* 📱 MOBILE OPTIMIZATION 📱 */
    @media (max-width: 768px) {
        .container { padding-left: 10px; padding-right: 10px; }
        .result-box { 
            padding: 20px; 
            font-size: 0.85rem; /* Kecilkan font sikit kat phone */
        }
        .result-box p { margin-bottom: 10px; }
        
        /* Jadikan label (Name, IC) dan value duduk atas bawah kat phone */
        .row-mobile { display: flex; flex-direction: column; margin-bottom: 15px; }
        .col-label { font-weight: normal; color: #666; margin-bottom: 2px; }
        .col-value { font-weight: bold; border-bottom: 1px dashed #ccc; padding-bottom: 5px; }
        
        .badge { font-size: 1rem !important; width: 100%; display: block; padding: 10px; }
        
        /* Table history swipeable */
        .table-responsive { border: 0; }
        .table-sm td, .table-sm th { font-size: 0.75rem; }
    }

    @media print {
        .no-print { display: none !important; }
        .result-box { border: none; padding: 0; box-shadow: none; }
        body { background: white; }
    }
</style>

<div class="container py-3 py-md-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            <div class="d-flex justify-content-between mb-4 no-print">
                <a href="{{ url('/prpa/semak-keputusan') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left"></i> <span class="d-none d-md-inline">Kembali</span>
                </a>
                <button onclick="window.print()" class="btn btn-dark btn-sm rounded-pill px-4">
                    <i class="fas fa-print mr-2"></i> CETAK <span class="d-none d-md-inline">KEPUTUSAN</span>
                </button>
            </div>

            <div class="result-box shadow-sm mb-4">
                <p>Hello <strong>{{ $data->name }}</strong>,</p>
                <p>Here are your PHCALS Pre-Test Quiz results:</p>

                <div class="line-separator"></div>

                <div class="row row-mobile mb-md-2">
                    <div class="col-md-4 col-label">Name:</div>
                    <div class="col-md-8 col-value">{{ strtoupper($data->name) }}</div>
                </div>
                
                <div class="row row-mobile mb-md-2">
                    <div class="col-md-4 col-label">No. IC:</div>
                    <div class="col-md-8 col-value">{{ $data->ic_number }}</div>
                </div>
                
                <div class="row row-mobile mb-md-2">
                    <div class="col-md-4 col-label">Post and Grade:</div>
                    <div class="col-md-8 col-value">{{ $data->jawatan }} ({{ $data->gred }})</div>
                </div>
                
                <div class="row row-mobile mb-md-2">
                    <div class="col-md-4 col-label">Facility:</div>
                    <div class="col-md-8 col-value">{{ $data->ptj }}</div>
                </div>
                
                <div class="row row-mobile mb-md-2">
                    <div class="col-md-4 col-label">Timestamp Completed:</div>
                    <div class="col-md-8 col-value">{{ date('d/m/Y, h:i A', strtotime($data->updated_at)) }}</div>
                </div>
                
                <div class="row row-mobile mt-4 mt-md-2">
                    <div class="col-md-4 font-weight-bold col-label text-dark">Total Score:</div>
                    <div class="col-md-8">
                        <span class="badge {{ $data->score == 100 ? 'badge-success' : 'badge-danger' }}">
                            {{ $data->score }}%
                        </span>
                    </div>
                </div>

                <div class="line-separator"></div>

                <p class="text-justify">
                    @if($data->score == 100)
                        If you have successfully achieved 100%, please submit this result to your supervisor to enrol for PHCALS course. 
                    @else
                        Otherwise, try again until you reached 100%. Thank you.
                    @endif
                </p>

                <div class="mt-4">
                    <p class="mb-0">Regards,</p>
                    <p class="font-weight-bold">Dr. Leong YC</p>
                </div>
            </div>

            <div class="card history-card no-print shadow-sm mb-5">
                <div class="card-body p-3 p-md-4">
                    <h6 class="font-weight-bold text-primary mb-3 text-uppercase" style="font-size: 0.9rem;">
                        <i class="fas fa-history mr-2"></i> Rekod Percubaan
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="py-2">Percubaan</th>
                                    <th class="py-2">Tarikh & Masa</th>
                                    <th class="py-2 text-center">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $index => $row)
                                <tr>
                                    <td class="py-2">#{{ $index + 1 }}</td>
                                    <td class="py-2">{{ date('d/m/Y, h:i A', strtotime($row->created_at)) }}</td>
                                    <td class="py-2 text-center font-weight-bold {{ $row->score == 100 ? 'text-success' : 'text-danger' }}">
                                        {{ $row->score }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection