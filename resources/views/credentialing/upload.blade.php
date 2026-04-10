@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h4 class="section-title mb-4">
            <i class="fas fa-file-upload mr-2"></i> PENGURUSAN DOKUMEN CREDENTIALING
        </h4>

        <div class="card card-custom shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('credentialing.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Pilih Disiplin</label>
                        <select name="discipline" class="form-control form-control-lg custom-select @error('discipline') is-invalid @enderror" style="font-size: 15px;">
                            <option value="">-- Sila Pilih Disiplin --</option>
                            <option value="PHCAS">PRE-HOSPITAL CARE AND AMBULANCE SERVICES (PHCAS)</option>
                            <option value="EMERGENCY">EMERGENCY MEDICINE</option>
                        </select>
                        @error('discipline')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Jenis Dokumen</label>
                        <select name="document_type" class="form-control form-control-lg custom-select @error('document_type') is-invalid @enderror" style="font-size: 15px;">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Borang">Borang Credentialing</option>
                            <option value="Garis Panduan">Garis Panduan</option>
                            <option value="Manual">Manual Latihan</option>
                        </select>
                        @error('document_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Tajuk Penuh Dokumen (Untuk Paparan User)</label>
                        <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                               placeholder="Cth: Borang Credentialing PPP PHCAS 2026" value="{{ old('title') }}" style="font-size: 15px;">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Muat Naik Fail (PDF Sahaja)</label>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="customFile" accept="application/pdf">
                            <label class="custom-file-label" for="customFile">Pilih fail PDF...</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle mt-2"></i> Pastikan saiz fail tidak melebihi 5MB.</small>
                    </div>

                    <hr class="my-4">

                    <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm font-weight-bold py-3" 
                            style="background: linear-gradient(45deg, #2d5a27, #4caf50); border: none; border-radius: 12px;">
                        <i class="fas fa-save mr-2"></i> SIMPAN DOKUMEN CREDENTIALING
                    </button>
                    
                    <a href="{{ url()->previous() }}" class="btn btn-link btn-block text-muted mt-2">Batal & Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk tunjuk nama fail yang dipilih dalam input Bootstrap
    document.querySelector('.custom-file-input').addEventListener('change',function(e){
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })
</script>
@endsection