@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 small">
                    <li class="breadcrumb-item"><a href="{{ url('/prpa') }}">PRPA</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Semak Keputusan</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-4 border-0">
                    <i class="fas fa-user-graduate fa-3x mb-3"></i>
                    <h4 class="font-weight-bold mb-0">SEMAKAN KEPUTUSAN KURSUS</h4>
                    <p class="small mb-0 opacity-75">Pre-Hospital Care & Ambulance Life Support (PHCALS)</p>
                </div>
                
                <div class="card-body p-5">
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('prpa.semak.hasil') }}" method="GET">
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-secondary">Masukkan No. Kad Pengenalan:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-id-card text-primary"></i></span>
                                </div>
                                <input type="text" name="ic_nombor" class="form-control form-control-lg border-left-0 bg-light" 
                                       placeholder="Contoh: 880101105069" required maxlength="12">
                            </div>
                            <small class="text-muted mt-2 d-block">* Masukkan nombor tanpa sengketa (-)</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow rounded-pill font-weight-bold py-3">
                            <i class="fas fa-search mr-2"></i> SEMAK KEPUTUSAN SEKARANG
                        </button>
                    </form>
                </div>
                
                <div class="card-footer bg-light text-center py-3 border-0">
                    <p class="small text-muted mb-0">Masalah semakan? Sila hubungi <a href="{{ url('/prpa#prpa-hubungi') }}">Sekretariat PRPA</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection