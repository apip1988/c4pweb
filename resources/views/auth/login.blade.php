@extends('layouts.app')

@section('content')
<style>
    :root { --primary: #3051a0; --secondary: #4a69bd; }
    .auth-wrapper { min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 20px; background: #f4f7f6; }
    .auth-container { position: relative; width: 900px; height: 620px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); display: flex; }

    /* Panel Biru */
    .side-panel { flex: 1; background: linear-gradient(-45deg, var(--primary), var(--secondary)); color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; text-align: center; z-index: 5; }
    
    /* Panel Borang */
    .form-panel { flex: 1.4; background: white; padding: 40px; display: flex; flex-direction: column; justify-content: center; z-index: 10; }

    .title { font-size: 1.8rem; color: var(--primary); margin-bottom: 20px; font-weight: 700; text-align: center; }
    .reg-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; width: 100%; }
    .full-w { grid-column: span 2; }

    /* Input & Eye Icon */
    .input-box { width: 100%; position: relative; margin-bottom: 5px; }
    .input-box input, .input-box select { width: 100%; height: 45px; padding: 0 40px 0 15px; background: #f0f2f5; border: 1px solid #ddd; border-radius: 10px; font-size: 0.9rem; outline: none; }
    .input-box input:focus { border-color: var(--primary); background: #fff; }
    
    .eye-btn { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888; font-size: 0.9rem; z-index: 20; }

    .btn-auth { width: 100%; background: var(--primary); border: none; height: 50px; border-radius: 10px; color: #fff; font-weight: 600; margin-top: 20px; cursor: pointer; font-size: 1rem; transition: 0.3s; }
    .btn-auth:hover { background: var(--secondary); transform: translateY(-2px); }
    .btn-outline { background: none; border: 2px solid #fff; padding: 10px 30px; border-radius: 40px; color: #fff; font-weight: 600; cursor: pointer; margin-top: 20px; transition: 0.3s; }
    .btn-outline:hover { background: #fff; color: var(--primary); }

    /* Toggle Logic */
    #register-form-section { display: none; }
    .show-register #login-form-section { display: none; }
    .show-register #register-form-section { display: block; }
    .show-register .side-panel { order: 2; }
</style>

<div class="auth-wrapper" id="mainWrapper">
    <div class="auth-container" id="authBox">
        
        <div class="side-panel">
            <div id="text-login">
                <h3>Baru di sini?</h3>
                <p>Daftar akaun untuk mula menggunakan portal.</p>
                <button class="btn-outline" onclick="pusing(true)">DAFTAR</button>
            </div>
            <div id="text-register" style="display:none;">
                <h3>Dah Daftar?</h3>
                <p>Log masuk untuk ke dashboard anda.</p>
                <button class="btn-outline" onclick="pusing(false)">LOG MASUK</button>
            </div>
        </div>

        <div class="form-panel">
            <div id="login-form-section">
                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    <h2 class="title">Log Masuk</h2>
                    <div class="input-box" style="margin-bottom:15px;">
                        <input type="email" name="email" placeholder="Alamat Emel" required>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" id="log-pass" placeholder="Kata Laluan" required>
                        <i class="fas fa-eye eye-btn" onclick="tengok('log-pass', this)"></i>
                    </div>
                    <button type="submit" class="btn-auth">MASUK</button>
                </form>
            </div>

            <div id="register-form-section">
                <form action="{{ route('register') }}" method="POST">
                    {{ csrf_field() }}
                    <h2 class="title">Daftar Akaun</h2>
                    
                    <div class="reg-grid">
                        <div class="input-box full-w">
                            <input type="text" name="name" placeholder="Nama Penuh (Besar)" required>
                        </div>
                        <div class="input-box">
                            <input type="email" name="email" placeholder="Emel Rasmi" required>
                        </div>
                        <div class="input-box">
                            <input type="text" name="ic_number" placeholder="No. IC (88...)" required>
                        </div>
                        <div class="input-box">
                            <input type="password" name="password" id="reg-pass" placeholder="Laluan" required>
                            <i class="fas fa-eye eye-btn" onclick="tengok('reg-pass', this)"></i>
                        </div>
                        <div class="input-box">
                            <input type="password" name="password_confirmation" id="conf-pass" placeholder="Sahkan" required>
                            <i class="fas fa-eye eye-btn" onclick="tengok('conf-pass', this)"></i>
                        </div>
                        <div class="input-box"><input type="text" name="phone" placeholder="Telefon" required></div>
                        <div class="input-box"><input type="text" name="no_lpp" placeholder="No. LPP" required></div>
                        <div class="input-box">
                            <select name="sektor" required>
                                <option value="" disabled selected>Sektor</option>
                                <option value="AWAM">AWAM</option>
                                <option value="SWASTA">SWASTA</option>
                            </select>
                        </div>
                        <div class="input-box"><input type="text" name="ptj_sekarang" placeholder="PTJ" required></div>
                        <div class="input-box full-w">
                            <small style="color: #666; font-weight: bold;">TARIKH LANTIKAN PERTAMA:</small>
                            <input type="date" name="tarikh_lantikan" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-auth">DAFTAR SEKARANG</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function pusing(isReg) {
        const box = document.getElementById('mainWrapper');
        const tLogin = document.getElementById('text-login');
        const tReg = document.getElementById('text-register');
        
        if(isReg) {
            box.classList.add('show-register');
            tLogin.style.display = 'none';
            tReg.style.display = 'block';
        } else {
            box.classList.remove('show-register');
            tLogin.style.display = 'block';
            tReg.style.display = 'none';
        }
    }

    function tengok(id, icon) {
        const input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection