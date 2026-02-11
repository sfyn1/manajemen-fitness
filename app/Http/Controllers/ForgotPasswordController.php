<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // 1. TAMPILKAN FORM INPUT EMAIL
    public function showEmailForm()
    {
        return view('auth.forgot-password.email');
    }

    // 2. PROSES KIRIM OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $user = User::where('email', $request->email)->first();

        // Simpan OTP ke Database
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        // Kirim Email
        Mail::to($user->email)->send(new OtpMail($otp));

        // Simpan email di session untuk langkah selanjutnya
        session(['reset_email' => $user->email]);

        return redirect()->route('password.otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email Anda (Cek Log jika localhost).');
    }

    // 3. TAMPILKAN FORM INPUT OTP
    public function showOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.forgot-password.otp');
    }

    // 4. VERIFIKASI OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user || $user->otp_code != $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah!']);
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta ulang.']);
        }

        // OTP Benar -> Beri izin akses halaman reset
        session(['otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    // 5. TAMPILKAN FORM RESET PASSWORD
    public function showResetForm()
    {
        if (!session('reset_email') || !session('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.forgot-password.reset');
    }

    // 6. PROSES UPDATE PASSWORD BARU
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expires_at' => null,
            'must_change_password' => false // Sekalian matikan ini kalau ada
        ]);

        // Hapus session
        $request->session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login.');
    }
}