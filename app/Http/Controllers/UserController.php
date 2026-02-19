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
        // 1. VALIDASI DATA
        $request->validate([
            'name' => 'required|string|max:255',
            
            // TAMBAHKAN VALIDASI UNIK UNTUK EMAIL
            'email' => 'required|string|email|max:255|unique:users,email', 
            
            // VALIDASI UNIK UNTUK NO HP (Yang tadi)
            'phone_number' => 'required|numeric|unique:users,phone_number', 
            
            'role' => 'required|in:admin,owner,coach,member',
            'password' => 'required|string|min:6',
        ], [
            // PESAN ERROR BAHASA INDONESIA (SUPAYA TIDAK BINGUNG)
            'email.unique' => 'Email ini sudah digunakan oleh akun lain. Mohon gunakan email berbeda.',
            'phone_number.unique' => 'Nomor WhatsApp ini sudah terdaftar. Gunakan nomor lain.',
        ]);

        // 2. SIMPAN DATA
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            // ...
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