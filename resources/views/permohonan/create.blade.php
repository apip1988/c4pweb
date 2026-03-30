@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-header bg-primary text-white text-center py-4" style="border-radius: 20px 20px 0 0;">
                    <h4 class="font-weight-bold mb-0 text-uppercase">Borang Permohonan Ujian Penilaian Kompetensi</h4>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ url('/permohonan/hantar') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label class="font-weight-bold">NAMA PENUH <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control text-uppercase" placeholder="SEPERTI DALAM KAD PENGENALAN" required>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">NO. KAD PENGENALAN <span class="text-danger">*</span></label>
                                <input type="text" name="ic_number" class="form-control" placeholder="CONTOH: 900101105544" maxlength="12" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">ALAMAT EMEL <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="CONTOH: ali@gmail.com" required>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">NO. TELEFON <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" placeholder="CONTOH: 0123456789" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">NO. LPP <span class="text-danger">*</span></label>
                                <input type="text" name="no_lpp" class="form-control" placeholder="CONTOH: 12345" required>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label class="font-weight-bold">ALAMAT PTJ (TEMPAT BERTUGAS) <span class="text-danger">*</span></label>
                                <textarea name="alamat_ptj" class="form-control" rows="3" placeholder="SILA ISI ALAMAT PENUH TEMPAT BERTUGAS" required></textarea>
                            </div>

                            

                            <div class="col-md-12 form-group mb-4">
                                <label class="font-weight-bold">CATATAN (JIKA ADA)</label>
                                <textarea name="catatan" class="form-control" rows="2" placeholder="Sila nyatakan jika ada sebarang makluman tambahan..."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm font-weight-bold" style="border-radius: 10px; background-color: #3051a0;">
                            HANTAR PERMOHONAN <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success_hantar'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'PERMOHONAN BERJAYA DIHANTAR!',
        text: "{{ session('success_hantar') }}",
        confirmButtonColor: '#3051a0',
        confirmButtonText: 'KEMBALI KE UTAMA',
        // Tambah glassmorphism sikit bagi nampak premium
        background: 'rgba(255, 255, 255, 0.9)',
        didOpen: (modal) => {
            modal.style.backdropFilter = 'blur(10px)';
            modal.style.borderRadius = '20px';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url('/') }}";
        }
    });
</script>
@endif
@endsection