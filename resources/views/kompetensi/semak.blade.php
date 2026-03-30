@extends('layouts.app')

@section('content')
<div class="container text-center" style="margin-top: 50px;">
    <div style="border: 2px solid #3051a0; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; background-color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h3 style="color: #3051a0; font-weight: bold;">SEMAKAN KEPUTUSAN PENILAIAN KOMPETENSI</h3>
        <p style="color: red; font-size: 12px; font-weight: bold;">** KEPUTUSAN AKAN DIKELUARKAN DALAM TEMPOH DUA MINGGU DARI TARIKH PENILAIAN **</p>
        
        <form action="{{ url('/kompetensi/hasil-semakan') }}" method="GET">
    {{-- Kita guna GET untuk semakan supaya user boleh bookmark atau refresh hasil --}}
    
    <div class="form-group text-center">
        <label class="font-weight-bold">Masukkan No. IC:</label>
        <input type="text" name="ic_nombor" class="form-control text-center" 
               placeholder="Contoh: 900101105544" required>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
            <i class="fas fa-search mr-2"></i> SEMAK KEPUTUSAN
        </button>
    </div>
</form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error_ic'))
<script>
    Swal.fire({
        // MATIKAN TOAST SUPAYA KOTAK BOLEH MEMBESAR
        toast: false, 
        icon: 'error',
        title: 'MAKLUMAN SISTEM',
        text: "{{ session('error_ic') }}",
        position: 'center', // Letak tengah terus, gerenti nampak
        showConfirmButton: true,
        confirmButtonText: 'SAYA FAHAM',
        confirmButtonColor: '#3051a0',
        
        /* GAYA GLASSMORPHISM TENGAH */
        background: 'rgba(220, 38, 38, 0.95)', 
        color: '#fff',
        width: '500px', // Lebar tetap yang selesa untuk teks panjang
        padding: '2rem',
        
        didOpen: (modal) => {
            modal.style.backdropFilter = 'blur(15px)';
            modal.style.webkitBackdropFilter = 'blur(15px)';
            modal.style.border = '1px solid rgba(255, 255, 255, 0.3)';
            modal.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.5)';
            modal.style.borderRadius = '20px';

            // Kecilkan sikit font mesej supaya muat cantik
            const content = modal.querySelector('.swal2-html-container');
            if (content) {
                content.style.fontSize = '15px';
                content.style.lineHeight = '1.6';
            }
        }
    });
</script>
@endif
@endsection