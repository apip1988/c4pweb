@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 30px;">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2 style="font-weight: 800; color: #3051a0; text-transform: uppercase;">
                <i class="fas fa-users-cog"></i> Pengurusan Calon Kompetensi
            </h2>
            <hr>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm" style="border-left: 5px solid #3051a0; border-radius: 15px;">
                <div class="card-body">
                    <h6 class="text-muted">JUMLAH CALON</h6>
                    <h3 style="font-weight: 800;">{{ count($calons) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-9 text-right mb-4">
            <button class="btn btn-primary shadow" data-toggle="modal" data-target="#addCalonModal" style="border-radius: 10px; padding: 12px 25px; font-weight: 600;">
                <i class="fas fa-plus"></i> TAMBAH CALON BARU
            </button>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm" style="border-radius: 20px; border: none;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa; color: #3051a0;">
                                <tr>
                                    <th class="p-4">NAMA PENUH</th>
                                    <th>NO. K/P</th>
                                    <th>NO. LPP</th>
                                    <th>SEKTOR</th>
                                    <th>PTJ</th>
                                    <th class="text-center">TINDAKAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calons as $c)
                                <tr>
                                    <td class="p-4"><strong>{{ strtoupper($c->name) }}</strong></td>
                                    <td>{{ $c->ic_number }}</td>
                                    <td>{{ $c->no_lpp }}</td>
                                    <td><span class="badge badge-info">{{ $c->sektor }}</span></td>
                                    <td>{{ $c->ptj_sekarang }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="{{ url('/admin/kompetensi/delete/'.$c->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Adakah anda pasti mahu memadam calon ini?')" title="Padam"><i class="fas fa-trash"></i></a>
                                        </div>
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
</div>

<div class="modal fade" id="addCalonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header" style="background: #3051a0; color: white;">
                <h5 class="modal-title">DAFTAR CALON KOMPETENSI BARU</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('/admin/kompetensi/store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Nama Penuh (Huruf Besar)</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No. Kad Pengenalan</label>
                            <input type="text" name="ic_number" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No. LPP</label>
                            <input type="text" name="no_lpp" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Sektor</label>
                            <select name="sektor" class="form-control" required>
                                <option value="AWAM">AWAM</option>
                                <option value="SWASTA">SWASTA</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>PTJ Sekarang</label>
                            <input type="text" name="ptj_sekarang" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">SIMPAN REKOD</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection