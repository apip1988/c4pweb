@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0 mx-auto" style="max-width: 800px; border-radius: 15px;">
        <div class="card-header bg-white py-4 text-center border-0">
            <h4 class="font-weight-bold" style="color: #3051a0;">MAKLUMAT PENEMPATAN UJIAN</h4>
        </div>
        <div class="card-body p-5">
            
            <div class="mb-4">
                <p class="mb-1 text-muted small text-uppercase">Nama Calon:</p>
                <h5 class="font-weight-bold">{{ $carian->nama }}</h5>
                
                <p class="mb-1 text-muted small text-uppercase mt-3">No. Kad Pengenalan:</p>
                <h5 class="font-weight-bold">{{ $carian->ic_number }}</h5>
            </div>

            <hr>

            <div class="p-4 my-4 rounded" style="background: #f8f9fa; border-left: 5px solid #3051a0;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-muted">TARIKH UJIAN</label>
                        {{-- Guna isset() supaya tidak ralat jika kolum tiada --}}
                        <h6 class="font-weight-bold">{{ isset($carian->tarikh_ujian) ? $carian->tarikh_ujian : 'Akan Dimaklumkan' }}</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-muted">MASA / SESI</label>
                        <h6 class="font-weight-bold">{{ isset($carian->masa_ujian) ? $carian->masa_ujian : 'Akan Dimaklumkan' }}</h6>
                    </div>
                    <div class="col-md-12">
                        <label class="small font-weight-bold text-muted">LOKASI / TEMPAT</label>
                        <h5 class="font-weight-bold text-primary">
                            @if($carian->jenis_ujian == 'MAYA')
                                <i class="fas fa-laptop-house mr-2"></i> SECARA MAYA (ONLINE)
                            @else
                                {{ isset($carian->tempat_ujian) ? $carian->tempat_ujian : 'Bilik Mesyuarat KKM' }}
                            @endif
                        </h5>
                    </div>
                </div>
            </div>

            @if($carian->jenis_ujian == 'MAYA')
                <div class="alert alert-warning border-0 shadow-sm mb-4">
                    <p class="small mb-2 text-dark font-weight-bold">Ujian anda secara MAYA. Sila masukkan emel untuk pautan ujian:</p>
                    <form action="{{ url('/kompetensi/hantar-emel') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="ic_number" value="{{ $carian->ic_number }}">
                        <div class="input-group">
                            <input type="email" name="email_calon" class="form-control" placeholder="Emel anda..." required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-dark font-weight-bold">HANTAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="text-center mt-4 no-print">
                    <button onclick="window.print()" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                        <i class="fas fa-print mr-2"></i> CETAK SURAT
                    </button>
                </div>
            @endif

            {{-- --- BAHAGIAN BUTANG NAVIGASI (YANG AFIF MINTA) --- --}}
            <div class="text-center mt-5 no-print">
                <hr>
                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ url('/kompetensi/tempat') }}" class="btn btn-outline-primary px-4 mx-2 font-weight-bold shadow-sm" style="border-radius: 10px;">
                        <i class="fas fa-search mr-1"></i> SEMAK IC LAIN
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4 mx-2 font-weight-bold shadow-sm" style="border-radius: 10px;">
                        <i class="fas fa-home mr-1"></i> KEMBALI KE UTAMA
                    </a>
                </div>
            </div>

            <p class="text-center small text-muted mt-5">Sebarang pertanyaan sila hubungi: 03-8883-1477</p>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection