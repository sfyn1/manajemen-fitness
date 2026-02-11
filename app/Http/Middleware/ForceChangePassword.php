<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForceChangePassword
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek: Jika User Login + Role Member + Wajib Ganti Password
        if ($user && $user->role === 'member' && $user->must_change_password) {
            
            // PENTING: Jangan blokir halaman ganti password itu sendiri (biar gak loop)
            // Dan jangan blokir proses logout
            if (!$request->routeIs('member.change-password.*') && !$request->routeIs('logout')) {
                return redirect()->route('member.change-password.form')
                    ->with('warning', 'Demi keamanan, Anda wajib mengganti password sebelum melanjutkan.');
            }
        }

        return $next($request);
    }
}