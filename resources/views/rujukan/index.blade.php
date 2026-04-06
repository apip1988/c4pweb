@extends('layouts.app')

@section('content')
<style>
    .card-pink { background-color: #FFD1DC; border: none; border-radius: 20px; }
    .card-blue { background-color: #B3E5FC; border: none; border-radius: 20px; }
    .card-orange { background-color: #FFCCBC; border: none; border-radius: 20px; }
    .card-purple { background-color: #E1BEE7; border: none; border-radius: 20px; }
    .stat-number { font-size: 2.5rem; font-weight: bold; color: #444; }
    .table-custom { border-radius: 15px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
</style>

<div class="container py-4">
    <h2 class="font-weight-bold mb-4" style="color: #3051a0;">e-RUJUKAN</h2>

    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card card-pink p-3 shadow-sm text-center">
                <small class="font-weight-bold text-uppercase">Jumlah SPG</small>
                <div class="stat-number">{{ $stats['spg'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-blue p-3 shadow-sm text-center">
                <small class="font-weight-bold text-uppercase">Jumlah Surat</small>
                <div class="stat-number">{{ $stats['surat'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-orange p-3 shadow-sm text-center">
                <small class="font-weight-bold text-uppercase">Jumlah Guideline</small>
                <div class="stat-number">{{ $stats['guideline'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-purple p-3 shadow-sm text-center">
                <small class="font-weight-bold text-uppercase">Minit Mesyuarat</small>
                <div class="stat-number">{{ $stats['minit'] }}</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px;">
        <form action="{{ route('rujukan.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="small font-weight-bold">Jenis Dokumen</label>
                    <select name="type" class="form-control rounded-pill">
                        <option value="ALL">SEMUA</option>
                        <option value="SPG">SPG</option>
                        <option value="Surat">Surat / Polisi / Pekeliling</option>
                        <option value="Guideline">Guideline</option>
                        <option value="Minit Mesyuarat">Minit Mesyuarat</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="small font-weight-bold">Tahun</label>
                    <input type="number" name="year" class="form-control rounded-pill" placeholder="Cth: 2024">
                </div>
                <div class="col-md-5 mb-3">
                    <label class="small font-weight-bold">Dikeluarkan Oleh</label>
                    <input type="text" name="publisher" class="form-control rounded-pill" placeholder="Cth: Menteri Kesihatan / KPK">
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block rounded-pill shadow">CARI</button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive table-custom bg-white p-3">
        <table class="table table-hover">
            <thead class="bg-light">
                <tr class="small text-uppercase">
                    <th>Bil</th>
                    <th>Jenis</th>
                    <th>Tajuk Dokumen</th>
                    <th>Dari Siapa</th>
                    <th>Tahun</th>
                    <th>Fail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $key => $doc)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><span class="badge badge-info">{{ $doc->type }}</span></td>
                    <td class="font-weight-bold">{{ $doc->title }}</td>
                    <td>{{ $doc->publisher }}</td>
                    <td>{{ $doc->year }}</td>
                    <td>
                        <a href="{{ asset($doc->file_path) }}" target="_blank" class="text-danger"><i class="fas fa-file-pdf fa-lg"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection