@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h3 class="font-weight-bold text-success">KEPUTUSAN UJIAN PHCALS</h3>
        <p class="text-muted">Maklumat bagi No. K/P: <strong>{{ $user->ic_number }}</strong></p>
    </div>

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-success text-white font-weight-bold">
            Nama: {{ strtoupper($user->name) }}
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light text-center">
                    <tr>
                        <th>Percubaan</th>
                        <th>Tarikh Ujian</th>
                        <th>Markah</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($results as $index => $res)
                    <tr>
                        <td>Ke-{{ $results->count() - $index }}</td>
                        <td>{{ $res->created_at->format('d/m/Y') }}</td>
                        <td class="font-weight-bold">{{ $res->score }}%</td>
                        <td>
                            {!! $res->score == 100 
                                ? '<span class="badge badge-success px-3">LULUS</span>' 
                                : '<span class="badge badge-danger px-3">GAGAL</span>' 
                            !!}
                        </td>
                        <td>
                            <a href="{{ url('/phcals/review/'.$res->id) }}" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-eye"></i> Review / Cetak
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('prpa.semak.borang') }}" class="btn btn-secondary">Semak IC Lain</a>
    </div>
</div>
@endsection