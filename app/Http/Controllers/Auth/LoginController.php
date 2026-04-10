<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('username',$request->username)->first();

        if(!$user){
            return back()->with('error','Username tidak ditemukan');
        }

        if(!Hash::check($request->password,$user->password_hash)){
            return back()->with('error','Password salah');
        }

        Auth::login($user);

        return redirect()->route($user->dashboardRouteName());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
