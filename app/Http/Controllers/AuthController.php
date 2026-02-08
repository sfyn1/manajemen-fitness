<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil data user yang sedang login
            $user = Auth::user();

            // LOGIKA PENGARAHAN (REDIRECT) BERDASARKAN ROLE
            // Ini "Resepsionis" yang mengantar ke ruangan masing-masing
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.members.index');
                    break;
                case 'owner':
                    return redirect()->route('owner.dashboard');
                    break;
                case 'pt':
                    return redirect()->route('pt.dashboard');
                    break;
                case 'coach':
                    return redirect()->route('coach.dashboard');
                    break;
                case 'member':
                    return redirect()->route('member.dashboard');
                    break;
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}