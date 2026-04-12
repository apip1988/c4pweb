@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h3 class="font-weight-bold mb-4"><i class="fas fa-users-cog mr-2"></i> PENGURUSAN CALON PEPERIKSAAN KOMPETENSI</h3>

    @if(session('success'))
        <div class="alert alert-success shadow-sm" style="border-radius: 10px;">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
        <div class="card-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-user-plus mr-2"></i> 1. Senarai Nama Calon Peperiksaan (Baru)</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kompetensi.sahkan') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead class="bg-light">
                            <tr>
                                <th width="50"><input type="checkbox" onclick="toggle(this, 'ids1')"></th>
                                <th>Nama</th>
                                <th>IC</th>
                                <th>Sektor / PTJ</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai_baru as $baru)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $baru->id }}" class="ids1"></td>
                                <td>{{ strtoupper($baru->name) }}</td>
                                <td>{{ $baru->ic_number }}</td>
                                <td>{{ $baru->sektor }} <br> <small class="text-muted">{{ $baru->ptj_sekarang }}</small></td>
                                <td class="text-center">
                                    <button type="submit" name="ids[]" value="{{ $baru->id }}" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" onclick="return confirm('Sahkan calon ini?')">
                                        <i class="fas fa-check-circle"></i> SAHKAN
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($senarai_baru->count() > 0)
                    <button type="submit" class="btn btn-outline-success shadow-sm rounded-pill px-4 mt-2">
                        <i class="fas fa-check-double mr-1"></i> Sahkan Calon (Bulk)
                    </button>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
        <div class="card-header bg-info text-white" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-map-marker-alt mr-2"></i> 2. Semakan Tempat & Kelayakan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kompetensi.kemaskini_penempatan') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="font-weight-bold">Tarikh Peperiksaan</label>
                        <input type="date" name="tarikh_ujian" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Masa</label>
                        <input type="time" name="masa_ujian" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Medium</label>
                        <select name="medium" class="form-control" onchange="toggleMedium(this)">
                            <option value="FIZIKAL">FIZIKAL</option>
                            <option value="MAYA">MAYA</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="input_lokasi">
                        <label class="font-weight-bold">Lokasi / Pautan</label>
                        <input type="text" name="lokasi_fizikal" class="form-control" placeholder="Masukkan Tempat/Link">
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Status Layak</label>
                        <select name="status_layak" class="form-control">
                            <option value="LAYAK">LAYAK</option>
                            <option value="TIDAK LAYAK">TIDAK LAYAK</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead class="bg-light">
                            <tr>
                                <th width="50"><input type="checkbox" onclick="toggle(this, 'ids2')"></th>
                                <th>Nama / IC</th>
                                <th>PTJ / Negeri</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai_tempat as $tempat)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $tempat->id }}" class="ids2"></td>
                                <td>{{ $tempat->nama }} <br