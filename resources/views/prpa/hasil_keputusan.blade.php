@extends('layouts.app')

@section('content')
<style>
    .result-box { background: #fff; padding: 40px; border-radius: 10px; border: 1px solid #ddd; font-family: 'Courier New', Courier, monospace; color: #000; }
    .line-separator { border-top: 2px solid #000; margin: 20px 0; }
    .history-card { background: #f8f9fa; border-radius: 10px; border-left: 5px solid #3051a0; }
    @media print {
        .no-print { display: none !important; }
        .result-box { border: none; padding: 0; }
        body { background: white; }
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            <div class="d-flex justify-content-between mb-4 no-print">
                <a href="{{ url('/prpa/semak-keputusan') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button onclick="window.print()" class="btn btn-dark rounded-pill px-4">
                    <i class="fas fa-print mr-2"></i> CETAK KEPUTUSAN
                </button>
            </div>

            <div class="result-box shadow-sm mb-5">
                <p>Hello <strong>{{ $data->name }}</strong>,</p>
                <p>Here are your PHCALS Pre-Test Quiz results:</p>

                <div class="line-separator"></div>

                <div class="row mb-2">
                    <div class="col-4">Name:</div>
                    <div class="col-8"><strong>{{ strtoupper($data->name) }}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">No. IC:</div>
                    <div class="col-8"><strong>{{ $data->ic_number }}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Post and Grade:</div>
                    <div class="col-8"><strong>{{ $data->jawatan }} ({{ $data->gred }})</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Facility:</div>
                    <div class="col-8"><strong>{{ $data->ptj }}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Timestamp Completed:</div>
                    <div class="col-8"><strong>{{ date('d/m/Y, h:i A', strtotime($data->updated_at)) }}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 font-weight-bold">Total Score:</div>
                    <div class="col-8"><span class="badge {{ $data->score == 100 ? 'badge-success' : 'badge-danger' }}" style="font-size: 1.2rem;">{{ $data->score }}%</span></div>
                </div>

                <div class="line-separator"></div>

                <p style="text-align: justify;">
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

            <div class="card history-card no-print shadow-sm">
                <div class="card-body">
                    <h6 class="font-weight-bold text-primary mb-3">
                        <i class="fas fa-history mr-2"></i> HISTORY (REKOD PERCUBAAN)
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Percubaan Ke-</th>
                                    <th>Tarikh & Masa</th>
                                    <th class="text-center">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ date('d/m/Y, h:i A', strtotime($row->created_at)) }}</td>
                                    <td class="text-center font-weight-bold {{ $row->score == 100 ? 'text-success' : 'text-danger' }}">
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