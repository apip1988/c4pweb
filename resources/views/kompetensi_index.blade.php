@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow rounded">
        <a class="navbar-brand font-weight-bold" href="{{ url('/home') }}">MENU UTAMA</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link text-white">Admin: <strong>{{ Auth::user()->name }}</strong></span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm ml-3" href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         LOG KELUAR
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white font-weight-bold">Tambah Keputusan & Penempatan</div>
                <div class="card-body">
                    <form action="{{ url('/admin/kompetensi/store') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="form-group">
                            <label>Nama Penuh</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>No. IC</label>
                            <input type="text" name="ic_number" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mod Ujian</label>
                                    <select name="jenis_ujian" class="form-control">
                                        <option value="FIZIKAL">FIZIKAL</option>
                                        <option value="MAYA">MAYA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keputusan</label>
                                    <select name="status" class="form-control">
                                        <option value="LAYAK">LAYAK</option>
                                        <option value="LULUS">LULUS</option>
                                        <option value="GAGAL">GAGAL</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tarikh Ujian (Teks)</label>
                            <input type="text" name="tarikh_ujian" class="form-control" placeholder="Cth: 20 MAC 2026">
                        </div>

                        <div class="form-group">
                            <label>Masa / Sesi</label>
                            <input type="text" name="masa_ujian" class="form-control" placeholder="Cth: 9:00 PAGI">
                        </div>

                        <div class="form-group">
                            <label>Lokasi (Jika Fizikal)</label>
                            <input type="text" name="tempat_ujian" class="form-control">
                        </div>

                        <hr>
                        <small class="text-muted">Maklumat asal (Audit):</small>
                        <div class="form-group">
                            <label>No. Siri</label>
                            <input type="text" name="siri_no" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-block font-weight-bold shadow-sm">SIMPAN DATA</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <form action="{{ url('/admin/kompetensi') }}" method="GET">
                        <div class="form-row">
                            <div class="col-md-7">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama / IC..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info btn-block">CARI</button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ url('/admin/kompetensi') }}" class="btn btn-secondary btn-block">RESET</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ url('/admin/kompetensi/export') }}" class="btn btn-success btn-block">EXCEL</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama & IC</th>
                                <th>Mod</th>
                                <th>Tarikh / Masa / Tempat</th>
                                <th>Status</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($senarai as $s)
                            <tr>
                                <td>
                                    <strong>{{ strtoupper($s->nama) }}</strong><br>
                                    <small class="text-muted">{{ $s->ic_number }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $s->jenis_ujian == 'FIZIKAL' ? 'badge-primary' : 'badge-danger' }}">
                                        {{ isset($s->jenis_ujian) ? $s->jenis_ujian : 'FIZIKAL' }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        <strong>T:</strong> {{ isset($s->tarikh_ujian) ? $s->tarikh_ujian : '-' }}<br>
                                        <strong>M:</strong> {{ isset($s->masa_ujian) ? $s->masa_ujian : '-' }}<br>
                                        <strong>L:</strong> {{ isset($s->tempat_ujian) ? $s->tempat_ujian : '-' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge {{ $s->status == 'LULUS' ? 'badge-success' : 'badge-warning' }}">
                                        {{ isset($s->status) ? $s->status : 'LAYAK' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('/kompetensi/cetak/'.$s->ic_number) }}" class="btn btn-info btn-sm" target="_blank">Slip</a>
                                    <a href="{{ url('/admin/kompetensi/delete/'.$s->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">Tiada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection