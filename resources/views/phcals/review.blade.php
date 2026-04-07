@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold">EXAMINATION REVIEW</h2>
        <h4 class="text-muted">Score: <span class="{{ $result->score == 100 ? 'text-success' : 'text-danger' }}">{{ $result->score }}%</span></h4>
        <a href="{{ route('phcals.history') }}" class="btn btn-primary mt-3">Back to History</a>
    </div>

    @foreach($reviewData as $index => $data)
    <div class="card shadow-sm mb-4" style="border-radius: 15px; border-left: 10px solid {{ $data['is_right'] ? '#28a745' : '#dc3545' }};">
        <div class="card-body">
            <h5>Question {{ $index + 1 }}</h5>
            <p class="lead">{{ $data['question'] }}</p>
            <hr>
            <div class="p-3 mb-2 {{ $data['is_right'] ? 'bg-light-success' : 'bg-light-danger' }}" style="border-radius: 10px;">
                <p class="mb-1"><strong>Your Answer:</strong> 
                    <span class="{{ $data['is_right'] ? 'text-success' : 'text-danger' }}">
                        {{ $data['user_ans'] ?? 'No Answer' }}
                    </span>
                    @if($data['is_right']) <i class="fas fa-check-circle text-success"></i> @else <i class="fas fa-times-circle text-danger"></i> @endif
                </p>
                @if(!$data['is_right'])
                <p class="mb-0 text-success"><strong>Correct Answer:</strong> {{ $data['correct'] }}</p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .bg-light-success { background-color: #d4edda; }
    .bg-light-danger { background-color: #f8d7da; }
</style>
@endsection