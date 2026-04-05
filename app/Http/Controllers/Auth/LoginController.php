<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect jika tidak masuk ke fungsi authenticated
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * FUNGSI KHAS: Redirect mengikut ROLE selepas Login
     */
    protected function authenticated(Request $request, $user)
    {
        // 1. Jika User adalah ADMIN, hantar ke Dashboard Admin
        if ($user->role == 'ADMIN') {
            return redirect('/admin/dashboard');
        }

        // 2. Jika User BIASA, hantar ke Laman UTAMA (Sesuai permintaan Afif)
        return redirect('/');
    }

    /**
     * Fungsi Logout: Hantar balik ke UTAMA
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); 
    }
}