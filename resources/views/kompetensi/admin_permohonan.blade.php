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
            <form action="{{ url('/kompetensi/sahkan-permohonan') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead class="bg-light">
                            <tr>
                                <th width="50"><input type="checkbox" onclick="toggle(this, 'ids1')"></th>
                                <th>Nama</th>
                                <th>IC</th>
                                <th>Sektor / PTJ</th>
                                <th>Negeri</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai_baru as $baru)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $baru->id }}" class="ids1"></td>
                                <td>{{ $baru->name }}</td>
                                <td>{{ $baru->ic_number }}</td>
                                <td>{{ $baru->sektor }} <br> <small class="text-muted">{{ $baru->ptj_sekarang }}</small></td>
                                <td>{{ $baru->negeri ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-success shadow-sm rounded-pill px-4">
                    <i class="fas fa-check-circle mr-1"></i> Sahkan Calon (Bulk)
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
        <div class="card-header bg-info text-white" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-map-marker-alt mr-2"></i> 2. Semakan Tempat & Kelayakan</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/kompetensi/kemaskini-penempatan') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Tarikh Peperiksaan</label>
                        <input type="date" name="tarikh_ujian" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Masa</label>
                        <input type="time" name="masa_ujian" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Medium</label>
                        <select name="medium" class="form-control" onchange="toggleMedium(this)">
                            <option value="FIZIKAL">FIZIKAL</option>
                            <option value="MAYA">MAYA</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="input_lokasi">
                        <label>Lokasi / Pautan</label>
                        <input type="text" name="lokasi_fizikal" class="form-control" placeholder="Masukkan Tempat/Link">
                    </div>
                    <div class="col-md-2">
                        <label>Status Layak</label>
                        <select name="status_layak" class="form-control">
                            <option value="LAYAK">LAYAK</option>
                            <option value="TIDAK LAYAK">TIDAK LAYAK</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover border" id="tableTempat">
                        <thead class="bg-light">
                            <tr>
                                <th width="50"><input type="checkbox" onclick="toggle(this, 'ids2')"></th>
                                <th>Nama / IC</th>
                                <th>PTJ / Negeri</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai_tempat as $tempat)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $tempat->id }}" class="ids2"></td>
                                <td>{{ $tempat->nama }} <br> <small>{{ $tempat->ic_number }}</small></td>
                                <td>{{ $tempat->alamat_ptj }}</td>
                                <td><span class="badge badge-warning">BELUM DISET</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-info text-white shadow-sm rounded-pill px-4">
                    <i class="fas fa-save mr-1"></i> Hantar & Kemaskini Tempat
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
        <div class="card-header bg-dark text-white" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-edit mr-2"></i> 3. Kemaskini Keputusan Peperiksaan</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/kompetensi/kemaskini-keputusan-akhir') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <select name="keputusan_pilihan" class="form-control shadow-sm border-primary">
                            <option value="LULUS">LULUS</option>
                            <option value="GAGAL">GAGAL</option>
                            <option value="TIDAK HADIR & GAGAL">TIDAK HADIR & GAGAL</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block rounded-pill">Simpan Keputusan (Bulk)</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead class="bg-light">
                            <tr>
                                <th width="50"><input type="checkbox" onclick="toggle(this, 'ids3')"></th>
                                <th>Nama</th>
                                <th>Lokasi Peperiksaan</th>
                                <th>Status Semasa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai_keputusan->where('keputusan', 'DALAM PROSES') as $kptsn)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $kptsn->id }}" class="ids3"></td>
                                <td>{{ $kptsn->nama }}</td>
                                <td>{{ $kptsn->tempat_ujian }} <br> <small>{{ $kptsn->tarikh_ujian }}</small></td>
                                <td><span class="badge badge-secondary">Menunggu Keputusan</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-secondary text-white" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-poll mr-2"></i> 4. Senarai Nama Keputusan Peperiksaan Akhir</h5>
        </div>
        <div class="card-body text-center">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bil</th>
                            <th>Nama / IC</th>
                            <th>Negeri</th>
                            <th>Keputusan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($senarai_keputusan->whereIn('keputusan', ['LULUS', 'GAGAL', 'TIDAK HADIR & GAGAL']) as $akhir)
                        @php
                            $color = 'white';
                            if($akhir->keputusan == 'LULUS') $color = '#d4edda'; // Hijau
                            if($akhir->keputusan == 'GAGAL') $color = '#f8d7da'; // Merah
                            if($akhir->keputusan == 'TIDAK HADIR & GAGAL') $color = '#fff3cd'; // Oren (Yellowish)
                        @endphp
                        <tr style="background-color: {{ $color }};">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $akhir->nama }} <br> <small>{{ $akhir->ic_number }}</small></td>
                            <td>{{ $akhir->alamat_ptj }}</td>
                            <td class="font-weight-bold">{{ $akhir->keputusan }}</td>
                            <td>
                                <a href="{{ url('/kompetensi/destroy/'.$akhir->id) }}" class="text-danger" onclick="return confirm('Hapus data?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function toggle(source, className) {
        checkboxes = document.getElementsByClassName(className);
        for(var i=0, n=checkboxes.length; i<n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    function toggleMedium(sel) {
        var input = document.getElementsByName('lokasi_fizikal')[0];
        if(sel.value == 'MAYA') {
            input.placeholder = "Masukkan Pautan Google Meet / Zoom";
        } else {
            input.placeholder = "Masukkan Nama Tempat / Bilik";
        }
    }
</script>
@endsection