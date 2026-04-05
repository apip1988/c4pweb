@extends('layouts.app')

@section('content')
<style>
    /* 🎨 TEMA WARNA HIJAU AMO/PPP */
    :root { 
        --primary: #1e7e34; 
        --secondary: #145523; 
        --light-bg: #f4f7f6;
    }

    .auth-wrapper { 
        min-height: 85vh; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        padding: 20px; 
        background: var(--light-bg); 
    }
    
    .auth-container { 
        width: 100%; 
        max-width: 450px; /* Lebih kecil untuk Login */
        background: #fff; 
        border-radius: 20px; 
        overflow: hidden; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
    }

    .auth-header { 
        background: linear-gradient(135deg, var(--primary), var(--secondary)); 
        color: white; 
        padding: 30px; 
        text-align: center; 
    }

    .auth-header h3 { font-weight: 800; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; }
    .auth-header p { font-size: 0.9rem; opacity: 0.9; }

    .form-panel { padding: 40px; }

    .input-box { margin-bottom: 20px; position: relative; }
    .input-box label { 
        font-size: 12px; 
        font-weight: 700; 
        color: var(--primary); 
        margin-bottom: 8px; 
        display: block; 
        text-transform: uppercase;
    }

    .input-box input { 
        width: 100%; 
        height: 48px; 
        padding: 0 45px 0 15px; 
        background: #f8f9fa; 
        border: 1px solid #ddd; 
        border-radius: 10px; 
        font-size: 16px;
        transition: 0.3s;
    }

    .input-box input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 0.2rem rgba(30, 126, 52, 0.1); outline: none; }

    .eye-btn { 
        position: absolute; 
        right: 15px; 
        top: 38px; 
        cursor: pointer; 
        color: #888; 
        font-size: 18px;
    }

    .btn-auth { 
        width: 100%; 
        background: var(--primary); 
        border: none; 
        height: 50px; 
        border-radius: 10px; 
        color: #fff; 
        font-weight: 700; 
        margin-top: 10px; 
        cursor: pointer; 
        font-size: 1rem; 
        text-transform: uppercase;
        transition: 0.3s;
    }

    .btn-auth:hover { background: var(--secondary); transform: translateY(-2px); }

    .auth-footer { text-align: center; margin-top: 25px; font-size: 0.9rem; color: #666; }
    .auth-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }

    /* Alert Error Styling */
    .alert-custom {
        background: #fee2e2;
        color: #dc2626;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.85rem;
        border-left: 5px solid #dc2626;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-header">
            <h3>LOG MASUK</h3>
            <p>Portal Semakan Keputusan PRPA</p>
        </div>

        <div class="form-panel">
            
            @if ($errors->any())
                <div class="alert-custom">
                    <strong>Ralat:</strong> Emel atau Kata Laluan salah.
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="input-box">
                    <label>Alamat Emel</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@kkm.gov.my" required autofocus>
                </div>

                <div class="input-box">
                    <label>Kata Laluan</label>
                    <input type="password" name="password" id="log-pass" placeholder="******" required>
                    <i class="fas fa-eye eye-btn" onclick="tengok('log-pass', this)"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small text-muted">Lupa Laluan?</a>
                </div>

                <button type="submit" class="btn-auth">MASUK SEKARANG</button>
            </form>

            <div class="auth-footer">
                Belum mempunyai akaun? <br>
                <a href="{{ route('register') }}">DAFTAR AKAUN DI SINI</a>
            </div>
        </div>
    </div>
</div>

<script>
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