<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckMemberExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek: Login + Role Member + Punya Data Member
        if ($user && $user->role === 'member' && $user->member) {
            
            // Ambil tanggal expire dari database
            $expiryDate = Carbon::parse($user->member->expiry_date);
            
            // Cek apakah HARI INI sudah melewati tanggal expire
            // (isPast() bernilai true jika tanggal sudah lewat)
            if ($expiryDate->isPast()) {
                
                // Izinkan akses ke halaman logout dan halaman expired itu sendiri (supaya tidak loop)
                if (!$request->routeIs('member.expired') && !$request->routeIs('logout')) {
                    return redirect()->route('member.expired');
                }
            }
        }

        return $next($request);
    }
}