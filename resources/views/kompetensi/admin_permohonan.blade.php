@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-header bg-dark text-white p-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-users-cog mr-2"></i> Pengurusan Permohonan Penilaian Kompetensi</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary shadow-sm" style="border-radius: 10px;">
        <i class="fas fa-arrow-left"></i> Kembali ke Hub Admin
    </a>
</div>
            <table class="table table-hover mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Tarikh</th>
                        <th>Nama Calon</th>
                        <th>No. IC</th>
                        <th>PTJ</th>
                        <th>Status</th>
                        <th class="text-center">Tindakan Urusetia</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($senarai as $s)
    {{-- LOGIK WARNA: Hijau untuk DISAHKAN, Merah untuk GAGAL, Putih untuk PENDING --}}
    <tr style="background-color: {{ $s->status == 'DISAHKAN' ? '#e1f7e1' : ($s->status == 'GAGAL' ? '#fceaea' : 'white') }}; transition: 0.3s;">
        
        {{-- Kita tukar loop iteration kepada tarikh mohon jika ada, atau kekalkan nombor --}}
        <td>{{ date('d/m/Y', strtotime($s->created_at)) }}</td>
        
        <td>{{ strtoupper($s->name) }}</td> 
        <td>{{ $s->ic_number }}</td>
        <td>{{ $s->ptj_sekarang }}</td>
        
        <td>
            {{-- Badge Status --}}
            @if($s->status == 'DISAHKAN')
                <span class="badge badge-success px-3"><i class="fas fa-check-circle"></i> {{ $s->status }}</span>
            @elseif($s->status == 'GAGAL')
                <span class="badge badge-danger px-3"><i class="fas fa-times-circle"></i> {{ $s->status }}</span>
            @else
                <span class="badge badge-warning px-3 pulse-notify"><i class="fas fa-clock"></i> {{ $s->status }}</span>
            @endif
        </td>

        <td class="text-center">
            {{-- Form Tindakan Urusetia --}}
            <form action="{{ route('admin.update_status') }}" method="POST" class="d-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $s->id }}">
                
                <select name="status" class="form-control form-control-sm d-inline-block w-auto shadow-sm" style="border-radius: 8px;">
                    <option value="PENDING" {{ $s->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                    <option value="DISAHKAN" {{ $s->status == 'DISAHKAN' ? 'selected' : '' }}>SAHKAN</option>
                    <option value="GAGAL" {{ $s->status == 'GAGAL' ? 'selected' : '' }}>TOLAK</option>
                </select>
                
                <button type="submit" class="btn btn-sm btn-primary shadow-sm" style="border-radius: 8px;">
                    <i class="fas fa-save"></i> Kemaskini
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection