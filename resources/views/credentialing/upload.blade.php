@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle mr-2"></i> {{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-9">
            <h4 class="section-title mb-4">
                <i class="fas fa-upload mr-2"></i> PENGURUSAN MUAT NAIK DOKUMEN
            </h4>

            <div class="card card-custom shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.document.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-primary">Muat Naik Untuk Modul:</label>
                            <select name="module_type" id="module_type" class="form-control form-control-lg custom-select border-primary" onchange="toggleForm()" style="font-size: 16px; height: 50px;">
                                <option value="CREDENTIALING">e-CREDENTIALING</option>
                                <option value="RUJUKAN">e-RUJUKAN (SPG/Surat/Guideline/Minit)</option>
                            </select>
                        </div>

                        <hr class="my-4">

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Tajuk Penuh Dokumen</label>
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Cth: SPG Perkhidmatan PPP Bil 1/2026" required value="{{ old('title') }}">
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
                                    <label class="font-weight-bold">Tahun</label>
                                    <input type="number" name="year" class="form-control" value="{{ date('Y') }}">
                                </div>
                            </div>

                            <div class="col-md-12 field-rujukan" style="display:none;">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Dikeluarkan Oleh / Dari Siapa</label>
                                    <input type="text" name="publisher" class="form-control" placeholder="Cth: KKM / C4P">
                                </div>
                            </div>

                            <div class="col-md-12 field-credentialing">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Pilih Disiplin</label>
                                    <select name="discipline" class="form-control">
                                        <option value="Peri-Operative Care">Peri-Operative Care</option>
                                        <option value="Emergency Medicine & Trauma Services (AMO & Nurses)">Emergency Medicine & Trauma Services (AMO & Nurses)</option>
                                        <option value="Emergency Medicine & Trauma Services (Lecturer & Clinical Instructor)">Emergency Medicine & Trauma Services (Lecturer & Clinical Instructor)</option>
                                        <option value="Ophthalmology">Ophthalmology</option>
                                        <option value="Dialysis Care (Haemodialysis)">Dialysis Care (Haemodialysis)</option>
                                        <option value="Pre Hospital Care Services">Pre Hospital Care Services</option>
                                        <option value="Anaesthesiology & Intensive Care (Anaesthesia)">Anaesthesiology & Intensive Care (Anaesthesia)</option>
                                        <option value="Anaesthesiology & Intensive Care (Peri-Anaesthesia)">Anaesthesiology & Intensive Care (Peri-Anaesthesia)</option>
                                        <option value="Anaesthesiology & Intensive Care (Intensive Care)">Anaesthesiology & Intensive Care (Intensive Care)</option>
                                        <option value="Orthopaedics Services">Orthopaedics Services</option>
                                        <option value="Cardio (Cardiovascular Perfusion)">Cardio (Cardiovascular Perfusion)</option>
                                        <option value="Cardio (Cardiology)">Cardio (Cardiology)</option>
                                        <option value="Endoscopy Services">Endoscopy Services</option>
                                        <option value="Peri-Anaesthesia Care (P.A.C)">Peri-Anaesthesia Care (P.A.C)</option>
                                        <option value="Circumcision (Dorsal Slit Technique)">Circumcision (Dorsal Slit Technique)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 field-credentialing">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Jenis Dokumen (Credentialing)</label>
                                    <select name="document_type" class="form-control">
                                        <option value="Borang Credentialing">Borang Credentialing</option>
                                        <option value="Borang Recredentialing">Borang Recredentialing</option>
                                        <option value="Carta Alir">Carta Alir</option>
                                        <option value="Buku Log">Buku Log</option>
                                        <option value="Kriteria">Kriteria</option>
                                        <option value="Garis Panduan">Garis Panduan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <label class="font-weight-bold">Muat Naik Fail (PDF Sahaja)</label>
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="customFile" accept="application/pdf" required>
                                <label class="custom-file-label" for="customFile" style="height: 45px; line-height: 30px;">Pilih fail PDF...</label>
                            </div>
                            <small class="text-muted"><i class="fas fa-info-circle mt-2"></i> Pastikan saiz fail tidak melebihi 20MB.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow font-weight-bold py-3" style="border-radius: 12px; background: linear-gradient(45deg, #3051a0, #4a90e2); border: none;">
                            <i class="fas fa-save mr-2"></i> SIMPAN & PAPARKAN DOKUMEN
                        </button>
                    </form>
                </div>
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
            rujukanFields.forEach(f => { f.style.display = 'block'; });
            credentialFields.forEach(f => { f.style.display = 'none'; });
            // Disable required validation for hidden fields if needed
        } else {
            rujukanFields.forEach(f => { f.style.display = 'none'; });
            credentialFields.forEach(f => { f.style.display = 'block'; });
        }
    }

    // Nama fail muncul bila dipilih
    document.querySelector('.custom-file-input').addEventListener('change',function(e){
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });

    // Jalankan sekali masa page load
    window.onload = toggleForm;
</script>
@endsection