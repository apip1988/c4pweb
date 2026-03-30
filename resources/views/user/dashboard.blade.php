@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body text-center p-5">
                    <h2 class="font-weight-bold text-primary">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-muted">Anda telah berjaya mendaftar ke Portal Perkhidmatan PPP.</p>
                    <hr>
                    <div class="alert alert-info">
                        Sila klik butang di bawah untuk mula memohon ujian.
                    </div>
                    <a href="{{ url('/kompetensi/permohonan') }}" class="btn btn-success btn-lg rounded-pill px-5 shadow">
                        <i class="fas fa-edit"></i> BORANG PERMOHONAN UJIAN
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection