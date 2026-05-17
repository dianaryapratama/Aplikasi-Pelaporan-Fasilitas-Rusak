<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaAuthController extends Controller
{
    public function showLogin()
    {
        return view('warga.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

       // Proses verifikasi akun
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // UBAH BARIS INI: Arahkan ke dashboard warga, bukan lapor.web
            return redirect()->intended(route('warga.dashboard')); 
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak ditemukan.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}