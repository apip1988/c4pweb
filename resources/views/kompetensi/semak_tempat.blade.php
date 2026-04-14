@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(45deg, #3051a0, #5072c4);">
                    <img src="{{ asset('img/logo_kkm.png') }}" alt="Logo KKM" style="width: 80px;" class="mb-2">
                    <h4 class="font-weight-bold mb-0">SEMAKAN MAKLUMAT</h4>
                    <p class="mb-0 small text-uppercase">Penempatan Ujian Penilaian Kompetensi</p>
                </div>

                <div class="card-body p-5">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <p class="text-center text-muted mb-4">Sila masukkan nombor kad pengenalan anda tanpa tanda sempang ( - ).</p>

                    <form action="{{ route('kompetensi.proses_semak_tempat') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">NO. KAD PENGENALAN :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-id-card text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" 
                                       name="ic" 
                                       class="form-control form-control-lg border-left-0" 
                                       placeholder="Contoh: 900101105522" 
                                       maxlength="12" 
                                       required 
                                       style="border-radius: 0 10px 10px 0; font-size: 1.1rem; letter-spacing: 2px;">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm" style="border-radius: 10px; font-weight: 700; height: 55px; background: #3051a0;">
                            <i class="fas fa-search mr-2"></i> SEMAK PENEMPATAN
                        </button>
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <small class="text-muted">Portal Penolong Pegawai Perubatan &copy; {{ date('Y') }}</small>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ url('/') }}" class="text-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Laman Utama</a>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }
    .form-control:focus {
        border-color: #3051a0;
        box-shadow: none;
    }
    .btn-primary:hover {
        background: #254080 !important;
        transform: translateY(-2px);
        transition: 0.3s;
    }
</style>
@endsection