@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="font-weight-bold mb-4 text-center">SEJARAH KEPUTUSAN PHCALS</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>PERCUBAAN</th>
                        <th>TARIKH & MASA</th>
                        <th>MARKAH (%)</th>
                        <th>STATUS</th>
                        <th>TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $index => $res)
                    <tr>
                        <td>Ke-{{ $results->count() - $index }}</td>
                        <td>{{ $res->created_at->format('d/m/Y h:i A') }}</td>
                        <td class="font-weight-bold {{ $res->score == 100 ? 'text-success' : 'text-danger' }}">
                            {{ $res->score }}%
                        </td>
                        <td>
                            @if($res->score == 100)
                                <span class="badge badge-success">LULUS (CEMERLANG)</span>
                            @else
                                <span class="badge badge-danger">GAGAL (SILA CUBA LAGI)</span>
                            @endif
                        </td>
                        <td>
                            @if($res->score == 100)
                                <a href="{{ url('/phcals/review/'.$res->id) }}" class="btn btn-sm btn-info text-white shadow-sm">
    <i class="fas fa-search"></i> Review
</a>
                                
                            @else
                                <a href="{{ url('/phcals/exam') }}" class="btn btn-sm btn-warning">Ulang Ujian</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Tiada rekod ujian dijumpai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection