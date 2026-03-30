@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            
            <h2 class="font-weight-bold mb-3">DIREKTORI PENOLONG PEGAWAI PERUBATAN (PPP)</h2>
            <p class="text-muted mb-5">Sila masukkan maklumat carian anda di bawah untuk menyemak profil PPP.</p>

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card border-0 shadow" style="border-radius: 20px;">
                <div class="card-body p-5">
                    
                    <h5 class="font-weight-bold text-left mb-4">Carian PPP</h5>
                    
                    <form action="{{ route('direktori.carian_ppp.hasil') }}" method="GET">
    
    <input type="text" name="kata_kunci" class="form-control" required placeholder="No. LPP / Nama / No. IC">

    <button type="submit" class="btn btn-primary mt-3">CARI SEKARANG</button>
</form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection