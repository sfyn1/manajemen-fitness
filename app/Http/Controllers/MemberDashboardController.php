<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presence;
use Carbon\Carbon;

class MemberDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $member = $user->member; // Relasi dari User ke Member

        // Build query untuk riwayat kehadiran
        $query = Presence::where('member_id', $member->id);

        // Filter berdasarkan pencarian tanggal dan jam
        if ($request->filled('search_date')) {
            $query->whereDate('created_at', $request->search_date);
        }

        if ($request->filled('search_time')) {
            // Format: HH:MM
            $query->whereTime('created_at', 'like', $request->search_time . '%');
        }

        // Ambil semua riwayat kehadiran (atau yang sudah difilter) diurutkan terbaru
        $recentPresences = $query->latest()->get();

        // Hitung sisa hari membership
        $expiryDate = Carbon::parse($member->expiry_date);
        $daysLeft = Carbon::now()->diffInDays($expiryDate, false); // false agar bisa negatif jika expired
        
        // Tentukan status badge
        $statusBadge = 'bg-success';
        $statusText = 'AKTIF';
        
        if ($daysLeft < 0) {
            $statusBadge = 'bg-danger';
            $statusText = 'EXPIRED';
        } elseif ($daysLeft <= 7) {
            $statusBadge = 'bg-warning text-dark';
            $statusText = 'SEGERA HABIS (' . ceil($daysLeft) . ' Hari)';
        }

        return view('member.dashboard', compact('user', 'member', 'recentPresences', 'statusBadge', 'statusText', 'expiryDate'));
    }
}