@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-11 col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-3 border-0">
                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                    <h5 class="font-weight-bold mb-0">SEMAKAN KEPUTUSAN</h5>
                    <p class="small mb-0 opacity-75">Kursus PHCALS</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('prpa.semak.hasil') }}" method="GET">
    <div class="form-group">
        <label>Masukkan No. Kad Pengenalan (Tanpa -)</label>
        <input type="text" name="ic_number" class="form-control" placeholder="Contoh: 881011035069" required>
    </div>
    <button type="submit" class="btn btn-success btn-block">SEMAK SEKARANG</button>
</form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ url('/prpa') }}" class="text-muted small text-decoration-none">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Laman PRPA
                </a>
            </div>
        </div>
    </div>
</div>
@endsection