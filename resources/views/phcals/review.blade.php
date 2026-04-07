@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <h2 class="font-weight-bold">EXAMINATION REVIEW</h2>
            <h4 class="mb-3">Score: <span class="{{ $result->score == 100 ? 'text-success' : 'text-danger' }}">{{ $result->score }}%</span></h4>
            <a href="{{ route('phcals.history') }}" class="btn btn-outline-primary btn-sm">Back to History</a>
        </div>
    </div>

    @foreach($reviewData as $index => $data)
    <div class="card mb-3 border-0 shadow-sm" style="border-left: 8px solid {{ $data['is_right'] ? '#28a745' : '#dc3545' }} !important;">
        <div class="card-body">
            <h5 class="font-weight-bold">Question {{ $index + 1 }}</h5>
            <p>{{ $data['question'] }}</p>
            
            <div class="p-3 rounded {{ $data['is_right'] ? 'bg-light text-success' : 'bg-light text-danger' }}">
                <strong>Your Answer:</strong> {{ $data['user_ans'] ?? 'No Answer' }}
                @if($data['is_right']) 
                    <i class="fas fa-check-circle ml-2"></i> (Correct)
                @else 
                    <i class="fas fa-times-circle ml-2"></i> (Incorrect)
                    <div class="mt-2 text-dark">
                        <strong>Correct Answer:</strong> <span class="text-success">{{ $data['correct'] }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection