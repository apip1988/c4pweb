<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Default redirect jika tidak masuk ke fungsi authenticated
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * FUNGSI KHAS: Redirect mengikut ROLE selepas Login
     */
    protected function authenticated(Request $request, $user)
    {
        // Jika User adalah ADMIN, hantar ke Dashboard Admin
        if ($user->role == 'ADMIN') {
            return redirect('/admin/dashboard');
        }

        // Jika User biasa, hantar ke Dashboard User
        return redirect('/user/dashboard');
    }

    // Tambah/Tukar fungsi logout dalam LoginController jika perlu
public function logout(Request $request)
{
    $this->guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // Ini akan hantar Afif balik ke halaman UTAMA
}

}