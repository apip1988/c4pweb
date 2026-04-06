<div class="tab-pane fade show active" id="pills-credential" role="tabpanel">
    <div class="p-3 border rounded bg-light">
        <h6 class="font-weight-bold text-primary mb-3">Muat Naik Dokumen Credentialing</h6>
        <form action="{{ route('credentialing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="small font-weight-bold">Pilih Disiplin</label>
                    <select name="discipline" class="form-control" required>
                        <option value="" disabled selected>-- Sila Pilih Disiplin --</option>
                        
                        <option value="Peri-Operative Care">Peri-Operative Care</option>
                        
                        <optgroup label="Emergency Medicine & Trauma Services">
                            <option value="EMTS - AMO & Nurses">Emergency: AMO & Nurses</option>
                            <option value="EMTS - Lecturer & Clinical Instructor">Emergency: Lecturer & Clinical Instructor</option>
                        </optgroup>

                        <option value="Ophthalmology">Ophthalmology</option>

                        <optgroup label="Dialysis Care">
                            <option value="Dialysis - Haemodialysis">Dialysis: Haemodialysis</option>
                        </optgroup>

                        <option value="Pre Hospital Care Services">Pre Hospital Care Services</option>

                        <optgroup label="Anaesthesiology & Intensive Care">
                            <option value="Anaesthesia">Anaesthesia</option>
                            <option value="Peri-Anaesthesia">Peri-Anaesthesia</option>
                            <option value="Intensive Care">Intensive Care</option>
                        </optgroup>

                        <option value="Orthopaedics Services">Orthopaedics Services</option>

                        <optgroup label="Cardio">
                            <option value="Cardiovascular Perfusion">Cardiovascular Perfusion</option>
                            <option value="Cardiology">Cardiology</option>
                        </optgroup>

                        <option value="Endoscopy Services">Endoscopy Services</option>
                        <option value="Peri-Anaesthesia Care (P.A.C)">Peri-Anaesthesia Care (P.A.C)</option>
                        <option value="Circumcision (Dorsal Slit)">Circumcision (Dorsal Slit Technique)</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="small font-weight-bold">Jenis Dokumen</label>
                    <select name="document_type" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Jenis --</option>
                        <option value="Borang Credentialing">Borang Credentialing</option>
                        <option value="Borang Recredentialing">Borang Recredentialing</option>
                        <option value="Carta Alir">Carta Alir</option>
                        <option value="Kriteria">Kriteria</option>
                        <option value="Log Book">Log Book</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="small font-weight-bold">Tajuk Penuh Dokumen (Untuk Paparan User)</label>
                    <input type="text" name="title" class="form-control font-weight-bold" placeholder="Cth: Borang Credentialing Kecemasan 2026" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="small font-weight-bold">Muat Naik Fail (PDF Sahaja)</label>
                    <input type="file" name="file" class="form-control-file" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm mt-2">SIMPAN DOKUMEN CREDENTIALING</button>
        </form>
    </div>

    </div>