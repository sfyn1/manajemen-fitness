<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
    use Illuminate\Support\Facades\Session;

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
        // 1. Ambil ID Session saat ini sebelum dihapus
        $sessionId = Session::getId();

        // 2. Proses Logout standar Laravel
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. HAPUS PAKSA DARI DATABASE (Fitur Tambahan)
        // Ini akan menghapus baris di tabel sessions sesuai ID tadi
        DB::table('sessions')->where('id', $sessionId)->delete();

        // 4. Redirect ke halaman login
        return redirect()->route('login');
    }

    // 4. PINTU MASUK PINTAR (DASHBOARD REDIRECT)
    public function dashboard()
    {
        $user = Auth::user();

        // Cek Role dan Arahkan ke Tempat yang Benar
        if ($user->role === 'admin') {
            return redirect()->route('admin.members.index');
        }
        
        if ($user->role === 'owner') {
            return redirect()->route('owner.dashboard');
        }
        
        if ($user->role === 'member') {
            return redirect()->route('member.dashboard');
        }

        if ($user->role === 'coach') {
            return redirect()->route('coach.dashboard');
        }

        return redirect('/');
    }

    // 5. TAMPILKAN FORM GANTI PASSWORD (MEMBER)
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // 6. PROSES GANTI PASSWORD (PERBAIKAN)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed', 
        ]);

        // PERBAIKAN: Gunakan cara update yang lebih eksplisit & aman
        User::where('id', Auth::id())->update([
            'password' => Hash::make($request->password),
            'must_change_password' => 0 // Gunakan 0 atau false
        ]);

        return redirect()->route('member.dashboard')
            ->with('success', 'Password berhasil diperbarui! Selamat datang.');
    }

    // 7. TAMPILKAN HALAMAN EXPIRED
    public function showExpiredPage()
    {
        // Pastikan hanya member expired yang bisa lihat ini
        // Kalau member aktif iseng buka link ini, lempar balik ke dashboard
        $user = Auth::user();
        if ($user->member && \Carbon\Carbon::parse($user->member->expiry_date)->isFuture()) {
            return redirect()->route('member.dashboard');
        }

        return view('member.expired');
    }
}