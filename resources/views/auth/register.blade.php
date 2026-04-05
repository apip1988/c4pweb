@extends('layouts.app')

@section('content')
<style>
    :root { --primary-hijau: #3DED97; --dark-hijau: #2ebc7a; --bg-light: #f4f7f6; }
    .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; background: var(--bg-light); }
    .auth-container { width: 100%; max-width: 850px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .auth-header { background: linear-gradient(135deg, var(--primary-hijau), var(--dark-hijau)); color: #1a1a1a; padding: 30px; text-align: center; }
    .form-panel { padding: 40px; }
    .reg-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .full-w { grid-column: span 2; }
    .section-title { grid-column: span 2; border-bottom: 2px solid var(--primary-hijau); color: var(--dark-hijau); font-weight: 800; margin-top: 20px; padding-bottom: 5px; font-size: 14px; }
    
    .input-box { position: relative; margin-bottom: 5px; }
    .input-box label { font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; display: block; }
    .input-box input { width: 100%; height: 48px; padding: 0 45px 0 15px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 10px; font-size: 14px; }
    
    /* Tombol Mata SVG */
    .eye-toggle { position: absolute; right: 15px; top: 38px; cursor: pointer; color: #666; display: flex; align-items: center; justify-content: center; height: 48px; z-index: 5; }
    .eye-toggle:hover { color: var(--dark-hijau); }

    .btn-auth { width: 100%; background: var(--primary-hijau); border: none; height: 55px; border-radius: 10px; color: #1a1a1a; font-weight: 800; margin-top: 30px; cursor: pointer; font-size: 16px; transition: 0.3s; }
    .btn-auth:hover { background: var(--dark-hijau); color: white; transform: translateY(-2px); }

    @media (max-width: 768px) { .reg-grid { grid-template-columns: 1fr; } .full-w, .section-title { grid-column: span 1; } .form-panel { padding: 20px; } }
</style>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-header">
            <h3>PENDAFTARAN PORTAL PPP</h3>
            <p>Daftar akaun utama untuk mengakses modul-modul sistem</p>
        </div>
        <div class="form-panel">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="reg-grid">
                    <div class="section-title">A. PROFIL PENGGUNA</div>
                    <div class="input-box full-w">
                        <label>Nama Penuh (HURUF BESAR)</label>
                        <input type="text" name="name" required placeholder="NAMA SEPERTI DALAM KAD PENGENALAN">
                    </div>
                    <div class="input-box">
                        <label>Alamat Emel</label>
                        <input type="email" name="email" required placeholder="Cth: afif@kkm.gov.my">
                    </div>
                    <div class="input-box">
                        <label>No. Kad Pengenalan</label>
                        <input type="text" name="ic_number" maxlength="12" required placeholder="900101XXXXXXXX">
                    </div>
                    <div class="input-box">
                        <label>No. Telefon</label>
                        <input type="text" name="phone" required placeholder="01XXXXXXXX">
                    </div>
                    <div class="input-box">
                        <label>No. LPP</label>
                        <input type="text" name="no_lpp" required placeholder="LPPXXXXX">
                    </div>

                    <div class="section-title">B. PERKHIDMATAN & AKADEMIK</div>
                    <div class="input-box">
                        <label>Sektor</label>
                        <select name="sektor" style="width:100%; height:48px; border-radius:10px; border:1px solid #ddd; padding:0 15px; background:#f8f9fa;" required>
                            <option value="AWAM">AWAM (KERAJAAN)</option>
                            <option value="SWASTA">SWASTA</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label>Tempat Bertugas (PTJ)</label>
                        <input type="text" name="ptj_sekarang" required placeholder="HOSPITAL / KLINIK">
                    </div>
                    <div class="input-box">
                        <label>Tarikh Lantikan Pertama</label>
                        <input type="date" name="tarikh_lantikan" required>
                    </div>
                    <div class="input-box">
                        <label>Diploma</label>
                        <input type="text" name="edu_diploma" value="TIADA" required>
                    </div>
                    <div class="input-box">
                        <label>Ijazah</label>
                        <input type="text" name="edu_ijazah" value="TIADA" required>
                    </div>
                    <div class="input-box">
                        <label>Sarjana (Master/PhD)</label>
                        <input type="text" name="edu_master" value="TIADA" required>
                        <input type="hidden" name="edu_post_basic" value="TIADA">
                        <input type="hidden" name="edu_phd" value="TIADA">
                    </div>

                    <div class="section-title">C. KESELAMATAN</div>
                    <div class="input-box">
                        <label>Kata Laluan</label>
                        <input type="password" name="password" id="pass1" required>
                        <div class="eye-toggle" onclick="intip('pass1', 'eye1')">
                            <svg id="eye1" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </div>
                    </div>
                    <div class="input-box">
                        <label>Sahkan Kata Laluan</label>
                        <input type="password" name="password_confirmation" id="pass2" required>
                        <div class="eye-toggle" onclick="intip('pass2', 'eye2')">
                            <svg id="eye2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-auth">DAFTAR AKAUN SEKARANG</button>
            </form>
            <p class="text-center mt-4">Sudah ada akaun? <a href="{{ route('login') }}" style="color: var(--dark-hijau); font-weight: bold;">Log Masuk</a></p>
        </div>
    </div>
</div>

<script>
function intip(inputId, eyeId) {
    const box = document.getElementById(inputId);
    const svg = document.getElementById(eyeId);
    if (box.type === "password") {
        box.type = "text";
        // Tukar icon ke mata tutup
        svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        box.type = "password";
        // Tukar icon ke mata buka
        svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
}
</script>
@endsection