@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-weight-bold" style="color: #2d5a27;">
            <i class="fas fa-history mr-2"></i> EXAMINATION HISTORY
        </h4>
        <a href="{{ route('prpa.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm" style="border-radius: 15px; border: none;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="py-3">No.</th>
                            <th class="py-3 text-left">Date & Time</th>
                            <th class="py-3">Set</th>
                            <th class="py-3">Score</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Expiry Date</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $res)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle text-left">
                                <span class="font-weight-bold">{{ $res->created_at->format('d M Y') }}</span><br>
                                <small class="text-muted">{{ $res->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="align-middle">Set {{ $res->set_id }}</td>
                            <td class="align-middle font-weight-bold">{{ $res->score }}%</td>
                            <td class="align-middle">
                                @if($res->status == 'PASSED')
                                    <span class="badge badge-pill badge-success px-3 py-2">PASSED</span>
                                @else
                                    <span class="badge badge-pill badge-danger px-3 py-2">RE-ATTEMPT</span>
                                @endif
                            </td>
                            <td class="align-middle text-muted">
                                {{ \Carbon\Carbon::parse($res->expiry_date)->format('d/m/Y') }}
                            </td>
                            <td class="align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('phcals.review', $res->id) }}" class="btn btn-sm btn-info text-white" title="Review Answers">
    <i class="fas fa-eye"></i> View Review
</a>
                                    @if($res->status == 'PASSED')
                                    <a href="#" class="btn btn-sm btn-secondary" title="Print Certificate">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-5 text-muted">
                                <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>
                                No examination history found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection