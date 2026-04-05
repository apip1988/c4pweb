@extends('layouts.app')

@section('content')
<style>
    :root { 
        --primary-hijau: #3DED97; 
        --dark-hijau: #2ebc7a; 
        --bg-light: #f4f7f6; 
    }
    
    .auth-wrapper { 
        min-height: 100vh; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        padding: 40px 20px; 
        background: var(--bg-light); 
    }

    .auth-container { 
        width: 100%; 
        max-width: 850px; 
        background: #fff; 
        border-radius: 20px; 
        overflow: hidden; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
    }

    .auth-header { 
        background: linear-gradient(135deg, var(--primary-hijau), var(--dark-hijau)); 
        color: #1a1a1a; 
        padding: 30px; 
        text-align: center; 
    }
    .auth-header h3 { font-weight: 800; margin-bottom: 5px; text-transform: uppercase; }

    .form-panel { padding: 40px; }

    .reg-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .full-w { grid-column: span 2; }
    
    .section-title { 
        grid-column: span 2; 
        border-bottom: 2px solid var(--primary-hijau); 
        color: var(--dark-hijau); 
        font-weight: 800; 
        margin-top: 20px; 
        padding-bottom: 5px; 
        font-size: 14px; 
    }

    .input-box label { 
        font-size: 12px; 
        font-weight: 700; 
        color: #555; 
        margin-bottom: 8px; 
        display: block; 
    }
    .input-box input, .input-box select { 
        width: 100%; 
        height: 48px; 
        padding: 0 15px; 
        background: #f8f9fa; 
        border: 1px solid #ddd; 
        border-radius: 10px; 
    }
    
    .btn-auth { 
        width: 100%; 
        background: var(--primary-hijau); 
        border: none; 
        height: 55px; 
        border-radius: 10px; 
        color: #1a1a1a; 
        font-weight: 800; 
        margin-top: 30px; 
        cursor: pointer; 
        font-size: 16px;
    }
    .btn-auth:hover { background: var(--dark-hijau); color: white; }

    @media (max-width: 768px) { 
        .reg-grid { grid-template-columns: 1fr; } 
        .full-w, .section-title { grid-column: span 1; } 
    }
</style>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-header">
            <h3>PENDAFTARAN AKAUN PORTAL</h3>
            <p>Daftar akaun untuk akses ke modul e-Kompetensi, Kursus, dan Semakan Ujian</p>
        </div>
        <div class="form-panel">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="reg-grid">
                    
                    <div class="section-title">A. MAKLUMAT PROFIL PENGGUNA</div>
                    
                    <div class="input-box full-w">
                        <label>Nama Penuh (HURUF BESAR)</label>
                        <input type="text" name="name" required placeholder="NAMA PENUH SEPERTI DALAM KAD PENGENALAN">
                    </div>

                    <div class="input-box">
                        <label>Alamat Emel</label>
                        <input type="email" name="email" required placeholder="emel@kkm.gov.my / gmail.com">
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
                        <input type="text" name="no_lpp" required placeholder="Cth: LPP12345">
                    </div>

                    <div class="section-title">B. MAKLUMAT PERKHIDMATAN & AKADEMIK</div>

                    <div class="input-box">
                        <label>Sektor</label>
                        <select name="sektor" required>
                            <option value="AWAM">AWAM (KERAJAAN)</option>
                            <option value="SWASTA">SWASTA</option>
                        </select>
                    </div>

                    <div class="input-box">
                        <label>Tempat Bertugas (PTJ)</label>
                        <input type="text" name="ptj_sekarang" required placeholder="HOSPITAL / KLINIK / IBU PEJABAT">
                    </div>

                    <div class="input-box">
                        <label>Tarikh Lantikan Pertama</label>
                        <input type="date" name="tarikh_lantikan" required>
                    </div>

                    <div class="input-box">
                        <label>Pendidikan Tertinggi (Diploma)</label>
                        <input type="text" name="edu_diploma" value="TIADA" required>
                    </div>

                    <div class="input-box">
                        <label>Pendidikan Tertinggi (Ijazah)</label>
                        <input type="text" name="edu_ijazah" value="TIADA" required>
                    </div>

                    <div class="input-box">
                        <label>Sarjana (Master/PhD)</label>
                        <input type="text" name="edu_master" value="TIADA" required>
                        <input type="hidden" name="edu_post_basic" value="TIADA">
                        <input type="hidden" name="edu_phd" value="TIADA">
                    </div>

                    <div class="section-title">C. KESELAMATAN AKAUN</div>

                    <div class="input-box">
                        <label>Kata Laluan</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="input-box">
                        <label>Sahkan Kata Laluan</label>
                        <input type="password" name="password_confirmation" required>
                    </div>

                </div>

                <button type="submit" class="btn-auth">DAFTAR AKAUN PORTAL</button>
            </form>
            <p class="text-center mt-4">Sudah ada akaun? <a href="{{ route('login') }}" style="color: var(--dark-hijau); font-weight: bold;">Log Masuk</a></p>
        </div>
    </div>
</div>
@endsection