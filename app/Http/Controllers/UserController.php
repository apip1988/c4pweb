<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Dalam UserController.php

public function index()
{
    $users = \App\User::orderBy('created_at', 'desc')->get();
    // Kita hantar senarai role ke view
    $roles = ['SUPER ADMIN', 'ADMIN', 'VIP', 'USER']; 
    return view('admin.users.index', compact('users', 'roles'));
}

    public function updateRole(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->role = $request->role;
            $user->save();
            return back()->with('success', 'Role ' . $user->name . ' berjaya dikemaskini!');
        }
        return back()->with('error', 'User tidak dijumpai.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user && $user->id != auth()->id()) { // Takleh delete diri sendiri
            $user->delete();
            return back()->with('success', 'User berjaya dipadam.');
        }
        return back()->with('error', 'Gagal memadam user.');
    }
}