@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li><i class="fas fa-exclamation-triangle mr-2"></i> {{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif
<div class="row justify-content-center">
    <div class="col-md-8">
        <h4 class="section-title mb-4">
            <i class="fas fa-upload mr-2"></i> PENGURUSAN MUAT NAIK DOKUMEN
        </h4>

        <div class="card card-custom shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.document.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Muat Naik Untuk Modul:</label>
                        <select name="module_type" id="module_type" class="form-control form-control-lg custom-select border-primary" onchange="toggleForm()">
                            <option value="CREDENTIALING">e-CREDENTIALING</option>
                            <option value="RUJUKAN">e-RUJUKAN (SPG/Surat/Guideline/Minit)</option>
                        </select>
                    </div>

                    <hr>

                    <div id="form-content">
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Tajuk Penuh Dokumen</label>
                            <input type="text" name="title" class="form-control" placeholder="Cth: SPG Perkhidmatan PPP Bil 1/2026" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 field-rujukan" style="display:none;">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Jenis Dokumen (e-Rujukan)</label>
                                    <select name="type" class="form-control">
                                        <option value="SPG">SPG</option>
                                        <option value="Surat">Surat / Polisi / Pekeliling</option>
                                        <option value="Guideline">Guideline</option>
                                        <option value="Minit Mesyuarat">Minit Mesyuarat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 field-rujukan" style="display:none;">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Dikeluarkan Oleh / Dari Siapa</label>
                                    <input type="text" name="publisher" class="form-control" placeholder="Cth: KKM / C4P">
                                </div>
                            </div>

                            <div class="col-md-6 field-rujukan" style="display:none;">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Tahun</label>
                                    <input type="number" name="year" class="form-control" value="{{ date('Y') }}">
                                </div>
                            </div>

                            <div class="col-md-12 field-credentialing">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Disiplin (Credentialing)</label>
                                    <select name="discipline" class="form-control">
                                        <option value="PHCAS">PHCAS</option>
                                        <option value="EMERGENCY">EMERGENCY MEDICINE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Muat Naik Fail (PDF Sahaja)</label>
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="customFile" accept="application/pdf" required>
                                <label class="custom-file-label" for="customFile">Pilih fail...</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm font-weight-bold py-3 mt-3">
                        <i class="fas fa-save mr-2"></i> SIMPAN & PAPARKAN DOKUMEN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleForm() {
        var type = document.getElementById('module_type').value;
        var rujukanFields = document.querySelectorAll('.field-rujukan');
        var credentialFields = document.querySelectorAll('.field-credentialing');

        if (type === 'RUJUKAN') {
            rujukanFields.forEach(f => f.style.display = 'block');
            credentialFields.forEach(f => f.style.display = 'none');
        } else {
            rujukanFields.forEach(f => f.style.display = 'none');
            credentialFields.forEach(f => f.style.display = 'block');
        }
    }

    document.querySelector('.custom-file-input').addEventListener('change',function(e){
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endsection