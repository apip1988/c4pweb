@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0" style="border-radius: 20px;">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Muat Naik Dokumen Credentialing</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('credentialing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Disiplin</label>
                        <select name="discipline" class="form-control" required>
                            @foreach($disciplines as $d) <option value="{{ $d }}">{{ $d }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Jenis Dokumen</label>
                        <select name="document_type" class="form-control" required>
                            @foreach($docTypes as $doc) <option value="{{ $doc }}">{{ $doc }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Tajuk Dokumen (Akan dipaparkan kepada user)</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Buku Log Cardio 2026" required>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label>Pilih Fail (PDF Sahaja)</label>
                        <input type="file" name="file" class="form-control-file" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success px-5">SIMPAN & UPLOAD</button>
                <a href="{{ route('credentialing.index') }}" class="btn btn-link">Kembali ke Portal</a>
            </form>
            <hr class="my-5">

<h5 class="font-weight-bold text-danger mb-3">Senarai Dokumen Sedia Ada</h5>
<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="thead-light">
            <tr>
                <th>Disiplin</th>
                <th>Tajuk Dokumen</th>
                <th class="text-center">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @php $allDocs = \App\CredentialingDocument::orderBy('created_at', 'desc')->get(); @endphp
            @foreach($allDocs as $item)
            <tr>
                <td><small>{{ $item->discipline }}</small></td>
                <td>{{ $item->title }}</td>
                <td class="text-center">
                    <a href="{{ route('credentialing.destroy', $item->id) }}" 
                       class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('Adakah anda pasti nak padam dokumen ini?')">
                        <i class="fas fa-trash"></i> Padam
                    </a>
                </td>
            </tr>
            @endforeach
            @if($allDocs->isEmpty())
            <tr>
                <td colspan="3" class="text-center text-muted">Tiada dokumen dijumpai.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
        </div>
    </div>
</div>
@endsection