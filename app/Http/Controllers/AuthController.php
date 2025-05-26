<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', 
        ]);


        return redirect()->route('login.form')->with('success', 'Register berhasil, silakan login!');
    }


    public function login(Request $request)
    {
        // validasi
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // cek login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            // ⛔ Cegah login jika bukan admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout(); // keluarin user
                return back()->withErrors([
                    'email' => 'Akun ini tidak diizinkan login melalui website.',
                ]);
            }
    
            // ✅ Jika admin, lanjut
            return redirect()->route('dashboard');
        }
    
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}
