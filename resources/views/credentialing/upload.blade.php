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
        </div>
    </div>
</div>
@endsection