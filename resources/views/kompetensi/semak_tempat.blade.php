@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center shadow-sm p-5 bg-white" style="border-radius: 20px; border: 2px solid #3051a0;">
            <i class="fas fa-map-marker-alt fa-4x text-primary mb-4"></i>
            <h3 class="font-weight-bold" style="color: #3051a0;">Semakan Penempatan Ujian</h3>
            <p class="text-muted">Sila masukkan No. Kad Pengenalan tanpa tanda '-'</p>
            
            {{-- Pastikan action dan method sepadan dengan web.php --}}
            <form action="{{ route('kompetensi.proses_semak_tempat') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="font-weight-bold">MASUKKAN NO. KAD PENGENALAN (TANPA '-') :</label>
        <input type="text" name="ic" class="form-control form-control-lg text-center" 
               placeholder="Contoh: 900101105522" maxlength="12" required>
    </div>
    <button type="submit" class="btn btn-primary btn-lg btn-block shadow">
        <i class="fas fa-search mr-2"></i> SEMAK TEMPAT UJIAN
    </button>
</form>

            <div class="mt-4">
                <a href="{{ url('/') }}" class="text-muted small"><i class="fas fa-arrow-left"></i> Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
</div>

{{-- --- MASUKKAN KOD POPUP DI BAWAH INI --- --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error_tempat'))
<script>
    Swal.fire({
        toast: false,
        icon: 'error',
        title: 'MAKLUMAN PENEMPATAN',
        // Guna 'html' supaya tulisan <b> (bold) Afif berfungsi
        html: "{!! session('error_tempat') !!}", 
        position: 'center',
        showConfirmButton: true,
        confirmButtonText: 'SAYA FAHAM',
        confirmButtonColor: '#3051a0',
        
        /* GAYA GLASSMORPHISM */
        background: 'rgba(220, 38, 38, 0.95)', 
        color: '#fff',
        width: '550px',
        padding: '2rem',
        
        didOpen: (modal) => {
            modal.style.backdropFilter = 'blur(15px)';
            modal.style.webkitBackdropFilter = 'blur(15px)';
            modal.style.border = '1px solid rgba(255, 255, 255, 0.3)';
            modal.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.5)';
            modal.style.borderRadius = '20px';

            const content = modal.querySelector('.swal2-html-container');
            if (content) {
                content.style.fontSize = '16px';
                content.style.lineHeight = '1.6';
                content.style.textAlign = 'center';
            }
        }
    });
</script>
@endif
@endsection