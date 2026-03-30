@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert" style="border-radius: 15px;">
        <strong>Berjaya!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg" style="border-radius: 20px; border: none; overflow: hidden;">
                <div class="card-header bg-primary text-white p-4">
                    <h4 class="mb-0"><i class="fas fa-file-signature mr-2"></i> Borang Permohonan Baru</h4>
                </div>

                <div class="card-body p-5">
                    <form action="{{ url('/kompetensi/hantar-permohonan') }}" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="alert alert-info border-0 shadow-sm" style="border-radius: 15px;">
    <h5 class="font-weight-bold"><i class="fas fa-user-check"></i> Pengesahan Maklumat Pemohon</h5>
    <hr>
    <p>Nama: <b>{{ Auth::user()->name }}</b></p>
    <p>No. IC: <b>{{ Auth::user()->ic_number }}</b></p>
    <p>Emel: <b>{{ Auth::user()->email }}</b></p>
    <p>Sektor: <b>{{ Auth::user()->sektor }}</b></p>
    <p>PTJ: <b>{{ Auth::user()->ptj_sekarang }}</b></p>
    
    <form action="{{ url('/kompetensi/hantar-permohonan') }}" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
            HANTAR PERMOHONAN SEKARANG
        </button>
    </form>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection