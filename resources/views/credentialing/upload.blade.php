@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0" style="border-radius: 20px;">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center" style="border-radius: 20px 20px 0 0;">
            <h5 class="mb-0"><i class="fas fa-file-upload mr-2"></i> PENGURUSAN DOKUMEN SISTEM</h5>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item mr-2">
                    <a class="nav-link active shadow-sm" id="pills-credential-tab" data-toggle="pill" href="#pills-credential" role="tab">
                        <i class="fas fa-certificate mr-1"></i> URUS CREDENTIALING
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bg-info text-white shadow-sm" id="pills-rujukan-tab" data-toggle="pill" href="#pills-rujukan" role="tab">
                        <i class="fas fa-book mr-1"></i> URUS RUJUKAN
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                
                <div class="tab-pane fade show active" id="pills-credential" role="tabpanel">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="font-weight-bold text-primary mb-3">Muat Naik Dokumen Credentialing</h6>
                        <form action="{{ route('credentialing.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold">Disiplin</label>
                                    <select name="discipline" class="form-control" required>
                                        @foreach($disciplines as $d) <option value="{{ $d }}">{{ $d }}</option> @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold">Jenis Dokumen</label>
                                    <select name="document_type" class="form-control" required>
                                        @foreach($docTypes as $doc) <option value="{{ $doc }}">{{ $doc }}</option> @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small font-weight-bold">Tajuk Dokumen</label>
                                    <input type="text" name="title" class="form-control font-weight-bold" placeholder="Contoh: Buku Log Cardio 2026" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small font-weight-bold">Fail (PDF)</label>
                                    <input type="file" name="file" class="form-control-file" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm mt-2">UPLOAD KE CREDENTIALING</button>
                        </form>
                    </div>

                    <h6 class="mt-5 font-weight-bold text-secondary">Senarai Fail Credentialing</h6>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-bordered table-hover bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>Disiplin</th>
                                    <th>Tajuk</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $credentialDocs = \App\CredentialingDocument::orderBy('created_at', 'desc')->get(); @endphp
                                @foreach($credentialDocs as $item)
                                <tr>
                                    <td><small>{{ $item->discipline }}</small></td>
                                    <td>{{ $item->title }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('credentialing.destroy', $item->id) }}" class="btn btn-xs text-danger" onclick="return confirm('Padam fail ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-rujukan" role="tabpanel">
                    <div class="p-3 border rounded bg-light" style="border-left: 5px solid #17a2b8 !important;">
                        <h6 class="font-weight-bold text-info mb-3">Muat Naik Dokumen Rujukan</h6>
                        <form action="{{ route('admin.rujukan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold">Jenis Dokumen</label>
                                    <select name="document_type" class="form-control" required>
                                        <option value="SPG">SPG</option>
                                        <option value="Surat">Surat / Pekeliling</option>
                                        <option value="Guideline">Guideline</option>
                                        <option value="Minit Mesyuarat">Minit Mesyuarat</option>
                                        <option value="Polisi">Polisi</option>
                                    </select>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="small font-weight-bold">Dikeluarkan Oleh (Penerbit)</label>
                                    <input type="text" name="publisher" class="form-control" placeholder="Cth: MKM / KKM" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="small font-weight-bold">Tahun</label>
                                    <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small font-weight-bold">Tajuk Rujukan</label>
                                    <input type="text" name="title" class="form-control font-weight-bold" placeholder="Cth: Surat Pekeliling Ketua Pengarah Kesihatan Bil 1/2026" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small font-weight-bold">Fail (PDF)</label>
                                    <input type="file" name="file" class="form-control-file" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info px-4 shadow-sm mt-2 text-white">UPLOAD KE e-RUJUKAN</button>
                        </form>
                    </div>

                    <h6 class="mt-5 font-weight-bold text-secondary">Senarai Fail e-Rujukan</h6>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-bordered table-hover bg-white text-dark">
                            <thead class="bg-light">
                                <tr>
                                    <th>Jenis</th>
                                    <th>Tajuk Rujukan</th>
                                    <th>Tahun</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rujukanDocs = \App\RujukanDocument::orderBy('created_at', 'desc')->get(); @endphp
                                @foreach($rujukanDocs as $r)
                                <tr>
                                    <td><span class="badge badge-info">{{ $r->type }}</span></td>
                                    <td>{{ $r->title }}</td>
                                    <td>{{ $r->year }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.rujukan.destroy', $r->id) }}" class="btn btn-xs text-danger" onclick="return confirm('Padam fail rujukan ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div> <div class="mt-4 text-center">
                <a href="{{ route('credentialing.index') }}" class="btn btn-link text-muted small"><i class="fas fa-arrow-left"></i> Kembali ke Portal Awam</a>
            </div>

        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link.active { background-color: #343a40; color: white; }
    .nav-pills .nav-link { color: #495057; font-weight: bold; font-size: 13px; }
    .btn-xs { padding: 1px 5px; font-size: 12px; }
</style>
@endsection