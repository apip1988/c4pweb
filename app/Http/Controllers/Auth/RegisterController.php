<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    // Selepas daftar, hantar ke dashboard
    protected function redirectTo()
{
    // Jika user yang baru daftar ini adalah ADMIN
    if (auth()->user()->role == 'ADMIN') {
        return '/';
    }

    // Jika user biasa, hantar ke dashboard pemohon sahaja
    return '/user/dashboard'; 
}

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
{
    // Padam dd('DATA SAMPAI KE VALIDATOR!'); tadi sebelum save
    return Validator::make($data, [
        'name'            => 'required|string|max:255',
        'email'           => 'required|string|email|max:255|unique:users',
        'password'        => 'required|string|min:6|confirmed',
        'ic_number'       => 'required|string|unique:users',
        'phone'           => 'required', // Ikut nama dalam skrin hitam Afif
        'no_lpp'          => 'required',
        'sektor'          => 'required',
        'ptj_sekarang'    => 'required',
        'tarikh_lantikan' => 'required',
    ]);
}

protected function create(array $data)
{
    return User::create([
        'name'            => strtoupper($data['name']),
        'email'           => $data['email'],
        'password'        => bcrypt($data['password']),
        'ic_number'       => $data['ic_number'],
        'phone_number'    => $data['phone'], 
        'no_lpp'          => $data['no_lpp'],
        'sektor'          => $data['sektor'],
        'ptj_sekarang'    => strtoupper($data['ptj_sekarang']),
        'tarikh_lantikan' => $data['tarikh_lantikan'],
        'edu_diploma'     => '-',
        'role'            => 'USER'
    ]);
}
}