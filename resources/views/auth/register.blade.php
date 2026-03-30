@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Maaf! Pendaftaran gagal kerana:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white p-4" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0"><i class="fas fa-user-plus mr-2"></i> PENDAFTARAN AKAUN PENGGUNA</h4>
                    <small>Sila lengkapkan semua maklumat di bawah untuk pendaftaran sistem.</small>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
    <?php echo csrf_field(); ?>

    <input type="text" name="name" required>
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <input type="password" name="password_confirmation" required>
    <input type="text" name="ic_number" required>
    <input type="text" name="phone_number" required>
    <input type="text" name="sektor" required>
    
    <button type="submit">DAFTAR</button>
</form>
                </div>
            </div>
            <p class="text-center mt-3 text-muted">Sudah mempunyai akaun? <a href="{{ route('login') }}">Log Masuk di sini</a></p>
        </div>
    </div>
</div>
@endsection