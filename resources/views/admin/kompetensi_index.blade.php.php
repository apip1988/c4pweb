@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">Tambah Keputusan Baru</div>
                <div class="card-body">
                    <form action="{{ url('/admin/kompetensi/store') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Nama Penuh</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>No. IC (Tanpa -)</label>
                            <input type="text" name="ic_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tarikh Penilaian</label>
                            <input type="date" name="tarikh_penilaian" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Keputusan</label>
                            <select name="keputusan" class="form-control">
                                <option value="LULUS">LULUS</option>
                                <option value="GAGAL">GAGAL</option>
                                <option value="TIDAK HADIR">TIDAK HADIR</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No. Siri (Jika ada)</label>
                            <input type="text" name="siri_no" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-3">SIMPAN DATA</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">Senarai Keputusan Dalam Database</div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="bg-light">
                                <th>Nama</th>
                                <th>IC</th>
                                <th>Keputusan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($senarai as $s)
                            <tr>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->ic_number }}</td>
                                <td><strong>{{ $s->keputusan }}</strong></td>
                                <td>
                                    <a href="{{ url('/admin/kompetensi/delete/'.$s->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Betul nak padam?')">Hapus</a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berjaya!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
</script>
@endif
@endsection