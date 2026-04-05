<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Selepas daftar, hantar ke dashboard yang betul
     */
    protected function redirectTo()
    {
        if (auth()->user()->role == 'ADMIN') {
            return '/';
        }
        return '/user/dashboard'; 
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Syarat-syarat Input (Validation)
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'password'        => 'required|string|min:6|confirmed',
            'ic_number'       => 'required|string|size:12|unique:users', // Wajib 12 digit
            'phone'           => 'required', 
            'no_lpp'          => 'required',
            'sektor'          => 'required',
            'ptj_sekarang'    => 'required',
            'tarikh_lantikan' => 'required|date',
            // Kita letak akademik ni sebagai 'required' supaya user isi
            'edu_diploma'     => 'required|string',
            'edu_post_basic'  => 'required|string',
            'edu_ijazah'      => 'required|string',
            'edu_master'      => 'required|string',
            'edu_phd'         => 'required|string',
        ]);
    }

    /**
     * Simpan data ke dalam database webc4p
     */
    protected function create(array $data)
    {
        return User::create([
            'name'            => strtoupper($data['name']),
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']), // Lebih moden dari bcrypt
            'ic_number'       => $data['ic_number'],
            'phone_number'    => $data['phone'], 
            'no_lpp'          => $data['no_lpp'],
            'sektor'          => $data['sektor'],
            'ptj_sekarang'    => strtoupper($data['ptj_sekarang']),
            'tarikh_lantikan' => $data['tarikh_lantikan'],
            // Maklumat Akademik
            'edu_diploma'     => $data['edu_diploma'],
            'edu_post_basic'  => $data['edu_post_basic'],
            'edu_ijazah'      => $data['edu_ijazah'],
            'edu_master'      => $data['edu_master'],
            'edu_phd'         => $data['edu_phd'],
            'role'            => 'USER', // Auto jadi USER biasa
        ]);
    }
}