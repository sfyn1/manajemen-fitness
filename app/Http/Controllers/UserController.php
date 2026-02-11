<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // <--- WAJIB ADA: Ini kunci perbaikannya

class UserController extends Controller
{
    // 1. TAMPILKAN DAFTAR USER (Admin, Owner, Coach)
    public function index()
    {
        // Ambil user selain Member, urutkan dari yang terbaru
        $users = User::whereIn('role', ['admin', 'owner', 'coach'])
                    ->latest()
                    ->get();

        return view('admin.users.index', compact('users'));
    }

    // 2. SIMPAN USER BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,owner,coach', 
            'phone_number' => 'required|numeric',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'must_change_password' => false, 
        ]);

        return redirect()->back()->with('success', 'Akun berhasil dibuat!');
    }

    // 3. HAPUS USER (Perbaikan Logic)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // PERBAIKAN DISINI:
        // Kita gunakan Auth::id() yang lebih stabil daripada auth()->user()->id
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }
}