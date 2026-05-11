<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // --- LOGIKA AUTO-GENERATE USERNAME ---
        // 1. Ambil teks sebelum @ (contoh: rika.nurul@gmail.com -> rika.nurul)
        $baseUsername = explode('@', $request->email)[0];
        
        // 2. Buat jadi huruf kecil semua dan hapus karakter aneh jika ada
        $username = strtolower(str_replace([' ', '.'], '_', $baseUsername));

        // 3. Cek apakah username ini sudah ada yang pakai?
        // Jika ada, tambahkan angka random di belakangnya
        if (User::where('username', $username)->exists()) {
            $username = $username . rand(10, 99);
        }
        // --------------------------------------

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $username, // Masukkan username yang sudah kita buat tadi
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function showLogin()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Jika admin, langsung ke dashboard admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}