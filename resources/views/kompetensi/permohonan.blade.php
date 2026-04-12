@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert" style="border-radius: 15px;">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <div class="card shadow-lg" style="border-radius: 20px; border: none; overflow: hidden;">
                <div class="card-header bg-primary text-white p-4 text-center">
                    <h4 class="mb-0"><i class="fas fa-file-signature mr-2"></i> Borang Permohonan Peperiksaan Kompetensi</h4>
                </div>

                <div class="card-body p-5">
                    <form action="{{ url('/kompetensi/hantar-permohonan') }}" method="POST">
                        @csrf
                        
                        <div class="alert alert-info border-0 shadow-sm p-4" style="border-radius: 15px;">
                            <h5 class="font-weight-bold mb-3"><i class="fas fa-user-check mr-2"></i> Pengesahan Maklumat Pemohon</h5>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4 text-muted">Nama:</div>
                                <div class="col-sm-8 font-weight-bold">{{ Auth::user()->name }}</div>
                                
                                <div class="col-sm-4 text-muted">No. IC:</div>
                                <div class="col-sm-8 font-weight-bold">{{ Auth::user()->ic_number }}</div>
                                
                                <div class="col-sm-4 text-muted">Emel:</div>
                                <div class="col-sm-8 font-weight-bold">{{ Auth::user()->email }}</div>

                                <div class="col-sm-4 text-muted">Sektor:</div>
                                <div class="col-sm-8 font-weight-bold">{{ Auth::user()->sektor }}</div>

                                <div class="col-sm-4 text-muted">PTJ:</div>
                                <div class="col-sm-8 font-weight-bold">{{ Auth::user()->ptj_sekarang }}</div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted small">Dengan menekan butang di bawah, saya mengesahkan maklumat di atas adalah benar.</p>
                            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow">
                                <i class="fas fa-paper-plane mr-2"></i> HANTAR PERMOHONAN SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection