<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            Session::flash('error', 'Email Salah');
            return redirect('/');
        }

        // Jika Hash atau password tidak sesuai
        $user = User::where([['email', $request->email], ['status', 1]])->first();
        if (!Hash::check($request->password, $user->password)) {
            Session::flash('error', 'Password Salah');
        }

        $request->session()->regenerate();
        return redirect('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
