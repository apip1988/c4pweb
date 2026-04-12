@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <h3 class="font-weight-bold mb-4">
        <i class="fas fa-users-cog mr-2"></i> PENGURUSAN CALON PEPERIKSAAN KOMPETENSI
    </h3>

    @if(session('success'))
        <div class="alert alert-success shadow-sm" style="border-radius: 15px;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <br>

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
                                <th>Nama Calon</th>
                                <th>No. Kad Pengenalan</th>
                                <th>Sektor / PTJ</th>
                                <th class="text-center">Tindakan Individu</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($senarai_baru as $baru)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $baru->id }}" class="ids1">
                                </td>
                                <td>
                                    <strong>{{ strtoupper($baru->name) }}</strong>
                                </td>
                                <td>{{ $baru->ic_number }}</td>
                                <td>
                                    {{ $baru->sektor }} <br> 
                                    <small class="text-muted">{{ $baru->ptj_sekarang }}</small>
                                </td>
                                <td class="text-center">
                                    <button type="submit" name="ids[]" value="{{ $baru->id }}" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" onclick="return confirm('Sahkan calon ini sahaja?')">
                                        <i class="fas fa-check-circle mr-1"></i> SAHKAN
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <br>

                @if($senarai_baru->count() > 0)
                    <button type="submit" class="btn btn-outline-success shadow-sm rounded-pill px-4">
                        <i class="fas fa-check-double mr-1"></i> SAHKAN CALON (SECARA PUKAL / BULK)
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

                <div class="row mb-4 p-3 bg-light rounded" style="margin: 0 1px;">
                    <div class="col-md-3 mb-2">
                        <label class="font-weight-bold">Tarikh Peperiksaan</label>
                        <input type="date" name="tarikh_ujian" class="form-control" required>
                    </div>
                    
                    <div class="col-md-2 mb-2">
                        <label class="font-weight-bold">Masa</label>
                        <input type="time" name="masa_ujian" class="form-control" required>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label class="font-weight-bold">Medium</label>
                        <select name="medium" class="form-control" onchange="toggleMedium(this)">
                            <option value="FIZIKAL">FIZIKAL</option>
                            <option value="MAYA">MAYA</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="font-weight-bold">Lokasi / Pautan</label>
                        <input type="text" name="lokasi_fizikal" class="form-control" placeholder="Tempat atau Link">
                    </div>

                    <div class="col-md-2 mb-2">
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
                                <th>Nama / No. IC</th>
                                <th>PTJ / Alamat</th>
                                <th>Status Semasa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai_tempat as $tempat)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $tempat->id }}" class="ids2">
                                </td>
                                <td>
                                    {{ $tempat->nama }} <br> 
                                    <small class="text-primary font-weight-bold">{{ $tempat->ic_number }}</small>
                                </td>
                                <td>{{ $tempat->alamat_ptj }}</td>
                                <td>
                                    <span class="badge badge-warning px-3 py-2">BELUM DISET</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-info text-white shadow-sm rounded-pill px-4 mt-3">
                    <i class="fas fa-save mr-1"></i> HANTAR & KEMASKINI TEMPAT
                </button>

            </form>
        </div>
    </div>


    <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
        
        <div class="card-header bg-dark text-white" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-edit mr-2"></i> 3. Kemaskini Keputusan Peperiksaan</h5>
        </div>

        <div class="card-body">
            
            <form action="{{ route('kompetensi.kemaskini_keputusan') }}" method="POST">
                @csrf

                <div class="row mb-3 align-items-end">
                    <div class="col-md-4">
                        <label class="font-weight-bold text-muted">Pilih Keputusan Akhir:</label>
                        <select name="keputusan_pilihan" class="form-control border-primary">
                            <option value="LULUS">LULUS</option>
                            <option value="GAGAL">GAGAL</option>
                            <option value="TIDAK HADIR & GAGAL">TIDAK HADIR & GAGAL</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block rounded-pill shadow-sm">
                            <i class="fas fa-save mr-1"></i> SIMPAN KEPUTUSAN
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead class="bg-light">
                            <tr>
                                <th width="50"><input type="checkbox" onclick="toggle(this, 'ids3')"></th>
                                <th>Nama Calon</th>
                                <th>Lokasi / Tempat Ujian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai_keputusan->where('keputusan', 'DALAM PROSES') as $kptsn)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $kptsn->id }}" class="ids3">
                                </td>
                                <td>{{ $kptsn->nama }}</td>
                                <td>{{ $kptsn->tempat_ujian }}</td>
                                <td>
                                    <span class="badge badge-secondary px-3 py-2">Menunggu Keputusan</span>
                                </td>
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

        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-light text-center">
                            <th>Bil</th>
                            <th>Nama / No. IC</th>
                            <th>PTJ / Alamat</th>
                            <th>Keputusan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($senarai_keputusan->whereIn('keputusan', ['LULUS', 'GAGAL', 'TIDAK HADIR & GAGAL']) as $akhir)
                        
                        @php
                            $rowColor = 'white';
                            if($akhir->keputusan == 'LULUS') $rowColor = '#d4edda'; 
                            if($akhir->keputusan == 'GAGAL') $rowColor = '#f8d7da'; 
                            if($akhir->keputusan == 'TIDAK HADIR & GAGAL') $rowColor = '#fff3cd'; 
                        @endphp

                        <tr style="background-color: {{ $rowColor }};">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $akhir->nama }}</strong> <br> 
                                <small>{{ $akhir->ic_number }}</small>
                            </td>
                            <td>{{ $akhir->alamat_ptj }}</td>
                            <td class="text-center font-weight-bold">{{ $akhir->keputusan }}</td>
                            <td class="text-center">
                                <form action="{{ route('kompetensi.destroy', $akhir->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Padam rekod ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
        var checkboxes = document.getElementsByClassName(className);
        for(var i=0; i < checkboxes.length; i++) {
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