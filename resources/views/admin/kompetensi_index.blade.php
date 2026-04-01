@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="card shadow border-0 mb-4" style="border-radius: 15px;">
        <div class="card-header bg-primary text-white font-weight-bold text-uppercase small">Kemaskini Statistik Dashboard</div>
        <div class="card-body p-3">
            <form action="{{ url('/admin/profil/store') }}" method="POST">
                {{ csrf_field() }}
                @php $val = $senarai_stats->pluck('jumlah', 'kategori')->toArray(); @endphp
                <div class="form-row">
                    @foreach(['Lelaki','Perempuan','Perubatan','Kesihatan','Awam','Swasta','JKN','PKD','HOSPITAL','KLINIK','KADER','IPKKM','NG MERS999'] as $b)
                    <div class="col-md-2 mb-2">
                        <label class="small font-weight-bold">{{ $b }}</label>
                        <input type="number" name="stats[{{ $b }}]" class="form-control form-control-sm" value="{{ isset($val[$b]) ? $val[$b] : 0 }}">
                    </div>
                    @endforeach
                    <div class="col-md-12 text-right mt-2"><button type="submit" class="btn btn-primary btn-sm shadow font-weight-bold">SIMPAN DASHBOARD</button></div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow border-0 mb-3" style="border-radius: 15px;">
        <div class="card-header bg-success text-white font-weight-bold text-uppercase small">Daftar Penempatan Calon Baru</div>
        <div class="card-body p-3">
            <form action="{{ url('/admin/kompetensi/store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-row text-uppercase">
                    <div class="col-md-4 mb-2"><label class="small font-weight-bold">Nama Penuh</label><input type="text" name="nama" class="form-control form-control-sm" required></div>
                    <div class="col-md-2 mb-2"><label class="small font-weight-bold">No. IC</label><input type="text" name="ic_number" class="form-control form-control-sm" maxlength="12" required></div>
                    <div class="col-md-2 mb-2"><label class="small font-weight-bold">Mod Ujian</label><select name="jenis_ujian" class="form-control form-control-sm"><option value="FIZIKAL">FIZIKAL</option><option value="MAYA">MAYA</option></select></div>
                    <div class="col-md-2 mb-2"><label class="small font-weight-bold">Tarikh</label><input type="text" name="tarikh_ujian" class="form-control form-control-sm"></div>
                    <div class="col-md-2 mb-2"><label class="small font-weight-bold">Masa</label><input type="text" name="masa_ujian" class="form-control form-control-sm"></div>
                    <div class="col-md-9 mb-2"><label class="small font-weight-bold">Lokasi Pusat Ujian</label><input type="text" name="tempat_ujian" class="form-control form-control-sm"></div>
                    <div class="col-md-3 text-right" style="margin-top: 25px;"><button type="submit" class="btn btn-success btn-sm btn-block shadow font-weight-bold">DAFTAR CALON</button></div>
                </div>
            </form>
        </div>
    </div>

    <div class="text-right mb-4">
        <button type="button" class="btn btn-dark btn-sm px-4 shadow font-weight-bold" data-toggle="modal" data-target="#modalSenarai">LIHAT SENARAI DATABASE</button>
    </div>
</div>

<div class="modal fade" id="modalSenarai" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-dark text-white"><h5 class="modal-title font-weight-bold small">SENARAI CALON & KEPUTUSAN</h5><button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button></div>
            <div class="modal-body p-0">
                <div class="p-3 bg-light border-bottom"><input type="text" id="myInput" onkeyup="searchTable()" class="form-control" placeholder="Cari Nama, IC, Lokasi atau Keputusan..."></div>
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-sm table-hover table-striped mb-0" id="calonTable">
                        <thead class="bg-secondary text-white sticky-top small">
                            <tr><th>Nama & IC</th><th>Mod</th><th>Penempatan</th><th>Keputusan</th><th class="text-center">Aksi</th></tr>
                        </thead>
                        <tbody class="small">
                            @foreach($senarai as $s)
                            <tr>
                                <td><strong class="text-primary">{{ $s->nama }}</strong><br>{{ $s->ic_number }}</td>
                                <td>{{ $s->jenis_ujian }}</td>
                                <td>{{ $s->tarikh_ujian }} ({{ $s->masa_ujian }})<br>{{ $s->tempat_ujian }}</td>
                                <td>
                                    @if(isset($s->keputusan))
                                        @php $cl = ($s->keputusan=='LULUS'?'success':($s->keputusan=='GAGAL'?'danger':'dark')); @endphp
                                        <span class="badge badge-{{ $cl }} px-2">{{ $s->keputusan }}</span>
                                    @else
                                        <span class="text-muted font-italic">Belum Menduduki</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-xs btn-outline-info" onclick='editCalon(@json($s))'><i class="fas fa-edit"></i> EDIT</button>
                                    <a href="{{ url('/admin/kompetensi/delete/'.$s->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Padam?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-info text-white"><h5 class="modal-title font-weight-bold small">KEMASKINI MAKLUMAT & KEPUTUSAN</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
            <form action="{{ url('/admin/kompetensi/update') }}" method="POST">
                @csrf
                <div class="modal-body small">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group"><label class="font-weight-bold">Nama Calon</label><input type="text" name="nama" id="edit-nama" class="form-control text-uppercase"></div>
                    <div class="form-row">
                        <div class="col-6"><label class="font-weight-bold">No. IC</label><input type="text" name="ic_number" id="edit-ic" class="form-control"></div>
                        <div class="col-6"><label class="font-weight-bold">Mod Ujian</label><select name="jenis_ujian" id="edit-jenis" class="form-control"><option value="FIZIKAL">FIZIKAL</option><option value="MAYA">MAYA</option></select></div>
                    </div>
                    
                    <div class="form-group mt-3 p-2 bg-light rounded border">
                        <label class="font-weight-bold text-danger">SET KEPUTUSAN PEPERIKSAAN</label>
                        <select name="keputusan" id="edit-keputusan" class="form-control font-weight-bold">
                            <option value="">-- BELUM ADA KEPUTUSAN --</option>
                            <option value="LULUS">LULUS</option>
                            <option value="GAGAL">GAGAL</option>
                            <option value="TIDAK HADIR & GAGAL">TIDAK HADIR & GAGAL</option>
                        </select>
                    </div>

                    <div class="form-row"><div class="col-6"><label>Tarikh</label><input type="text" name="tarikh_ujian" id="edit-tarikh" class="form-control"></div><div class="col-6"><label>Masa</label><input type="text" name="masa_ujian" id="edit-masa" class="form-control"></div></div>
                    <div class="form-group mt-2"><label>Tempat</label><input type="text" name="tempat_ujian" id="edit-tempat" class="form-control"></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary btn-block font-weight-bold shadow">KEMASKINI DATA & KEPUTUSAN</button></div>
            </form>
        </div>
    </div>
</div>

<script>
function searchTable() {
  var input = document.getElementById("myInput"), filter = input.value.toUpperCase(), table = document.getElementById("calonTable"), tr = table.getElementsByTagName("tr");
  for (var i = 1; i < tr.length; i++) {
    tr[i].style.display = "none";
    var td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) { if (td[j] && (td[j].textContent || td[j].innerText).toUpperCase().indexOf(filter) > -1) { tr[i].style.display = ""; break; } }
  }
}
function editCalon(data) {
    $('#edit-id').val(data.id); $('#edit-nama').val(data.nama); $('#edit-ic').val(data.ic_number); $('#edit-jenis').val(data.jenis_ujian); $('#edit-keputusan').val(data.keputusan); $('#edit-tarikh').val(data.tarikh_ujian); $('#edit-masa').val(data.masa_ujian); $('#edit-tempat').val(data.tempat_ujian);
    $('#modalEdit').modal('show');
}
@if(session('open_modal'))
    $(document).ready(function(){ $('#modalSenarai').modal('show'); });
@endif
</script>
@endsection