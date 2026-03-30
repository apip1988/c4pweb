@extends('layouts.app')

@section('content')
<div class="container text-center" style="margin-top: 50px;">
    <div class="card shadow" style="max-width: 600px; margin: 0 auto; padding: 40px; border-top: 5px solid #3051a0;">
        <h2 style="color: #3051a0; font-weight: bold;">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="text-muted">Sistem Pengurusan Keputusan Penilaian Kompetensi (PPT) 2026</p>
        <hr>
        
        <div class="row mt-4">
            <div class="col-md-12 mb-3">
                <a href="{{ url('/admin/kompetensi') }}" class="btn btn-primary btn-lg btn-block" style="background-color: #3051a0;">
                    BUKA DASHBOARD ADMIN
                </a>
            </div>
            <div class="col-md-12">
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-block" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    LOG KELUAR SISTEM
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection