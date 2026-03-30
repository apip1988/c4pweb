@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 style="font-weight: 800; color: #3051a0; text-transform: uppercase; letter-spacing: 2px;">
            Sistem Pengurusan Terpadu (Admin)
        </h1>
        <p class="text-muted">Selamat Datang, {{ Auth::user()->name }}. Sila pilih modul tugasan anda.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 20px; transition: 0.3s;">
                <div class="card-body p-4 text-center">
                    <div style="width: 80px; height: 80px; background: #ffeaa7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-id-card-alt fa-2x text-warning"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark">E-KOMPETENSI</h5>
                    <p class="small text-muted">Sahkan permohonan & urus keputusan ujian calon.</p>
                    
                    @if($notifikasi_kompetensi > 0)
                        <div class="badge badge-danger p-2 mb-3 animated pulse infinite">
                            {{ $notifikasi_kompetensi }} PERMOHONAN BARU
                        </div>
                    @endif
                    
                    <div class="btn-group w-100">
                        <a href="{{ route('admin.permohonan') }}" class="btn btn-warning font-weight-bold">Sah Permohonan</a>
                        <a href="{{ route('admin.kompetensi.index') }}" class="btn btn-outline-warning">Urus Calon</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div style="width: 80px; height: 80px; background: #dff9fb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark">BUTIRAN AHLI</h5>
                    <p class="small text-muted">Pengurusan data peribadi dan pendaftaran anggota.</p>
                    <a href="#" class="btn btn-primary btn-block rounded-pill">Buka Modul</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div style="width: 80px; height: 80px; background: #c7ecee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-chart-bar fa-2x text-info"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark">E-KPI</h5>
                    <p class="small text-muted">Analisis prestasi dan pencapaian tahunan.</p>
                    <a href="#" class="btn btn-info btn-block rounded-pill">Buka Modul</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .pulse { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
</style>
@endsection