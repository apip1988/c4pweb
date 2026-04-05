@extends('layouts.app')

@section('content')
<style>
    .reg-container {
        max-width: 900px;
        margin: 50px auto;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        font-family: 'sans-serif', Arial, Helvetica;
    }
    .reg-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 30px;
        text-align: center;
    }
    .reg-body {
        padding: 40px;
    }
    .reg-section-title {
        color: #007bff;
        font-weight: bold;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
        margin: 25px 0 15px 0;
        text-transform: uppercase;
        font-size: 14px;
    }
    .reg-grid {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .reg-group {
        padding: 0 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
    }
    .w-100 { width: 100%; }
    .w-50 { width: 50%; }
    .w-33 { width: 33.33%; }

    .reg-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #333;
        font-size: 13px;
    }
    .reg-group input, .reg-group select {
        width: 100%;
        height: 45px;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 14px;
    }
    .reg-btn {
        width: 100%;
        background: #007bff;
        color: white;
        border: none;
        padding: 15px;
        border-radius: 10px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
        transition: 0.3s;
    }
    .reg-btn:hover { background: #0056b3; }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .w-50, .w-33 { width: 100%; }
        .reg-body { padding: 20px; }
    }
</style>

<div class="reg-container">
    <div class="reg-header">
        <h2 style="margin:0;">PENDAFTARAN AKAUN</h2>
        <p style="margin:5px 0 0 0; opacity:0.8;">Sila lengkapkan maklumat anda di bawah</p>
    </div>

    <div class="reg-body">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="reg-section-title" style="margin-top:0;">A. Maklumat Akaun & Peribadi</div>
            <div class="reg-grid">
                <div class="reg-group w-100">
                    <label>Nama Penuh (HURUF BESAR)</label>
                    <input type="text" name="name" placeholder="CONTOH: AHMAD BIN ALI" required>
                </div>
                <div class="reg-group w-50">
                    <label>Alamat Emel</label>
                    <input type="email" name="email" placeholder="nama@emel.com" required>
                </div>
                <div class="reg-group w-50">
                    <label>No. Kad Pengenalan</label>
                    <input type="text" name="ic_number" placeholder="92010101XXXX" maxlength="12" required>
                </div>
                <div class="reg-group w-50">
                    <label>No. Telefon</label>
                    <input type="text" name="phone" placeholder="0123456789" required>
                </div>
                <div class="reg-group w-50">
                    <label>No. LPP</label>
                    <input type="text" name="no_lpp" placeholder="MASUKKAN NO LPP" required>
                </div>
            </div>

            <div class="reg-section-title">B. Perkhidmatan & Akademik</div>
            <div class="reg-grid">
                <div class="reg-group w-33">
                    <label>Sektor</label>
                    <select name="sektor" required>
                        <option value="AWAM">AWAM</option>
                        <option value="SWASTA">SWASTA</option>
                    </select>
                </div>
                <div class="reg-group w-33">
                    <label>PTJ (Tempat Bertugas)</label>
                    <input type="text" name="ptj_sekarang" placeholder="HOSPITAL/KLINIK" required>
                </div>
                <div class="reg-group w-33">
                    <label>Tarikh Lantikan</label>
                    <input type="date" name="tarikh_lantikan" required>
                </div>
                <div class="reg-group w-33">
                    <label>Diploma</label>
                    <input type="text" name="edu_diploma" value="TIADA" required>
                </div>
                <div class="reg-group w-33">
                    <label>Ijazah</label>
                    <input type="text" name="edu_ijazah" value="TIADA" required>
                </div>
                <div class="reg-group w-33">
                    <label>Sarjana (Master/PhD)</label>
                    <input type="text" name="edu_master" value="TIADA" required>
                    <input type="hidden" name="edu_post_basic" value="TIADA">
                    <input type="hidden" name="edu_phd" value="TIADA">
                </div>
            </div>

            <div class="reg-section-title">C. Keselamatan</div>
            <div class="reg-grid">
                <div class="reg-group w-50">
                    <label>Kata Laluan</label>
                    <input type="password" name="password" required>
                </div>
                <div class="reg-group w-50">
                    <label>Sahkan Kata Laluan</label>
                    <input type="password" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="reg-btn">DAFTAR AKAUN SEKARANG</button>
        </form>

        <div style="text-align:center; margin-top:20px;">
            <p>Sudah mempunyai akaun? <a href="{{ route('login') }}" style="color:#007bff; font-weight:bold; text-decoration:none;">Log Masuk</a></p>
        </div>
    </div>
</div>
@endsection