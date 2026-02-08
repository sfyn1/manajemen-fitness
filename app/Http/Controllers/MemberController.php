<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // 1. FITUR MENAMPILKAN DAFTAR MEMBER
    public function index()
    {
        // Ambil semua user yang role-nya 'member', beserta data detail member-nya
        // 'with' digunakan untuk teknik Eager Loading (biar query ringan)
        $members = User::where('role', 'member')->with('member')->latest()->get();

        // Kirim data ke tampilan (View) - Nanti kita buat View-nya
        return view('admin.members.index', compact('members'));
    }

    // 2. FITUR MENAMPILKAN FORM TAMBAH MEMBER
    public function create()
    {
        return view('admin.members.create');
    }

    // 3. FITUR MENYIMPAN DATA MEMBER BARU (Logic Penting!)
    public function store(Request $request)
    {
        // A. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'gender' => 'required',
            'join_date' => 'required|date',
            'duration' => 'required|integer', // Durasi paket dalam bulan (1 bulan, 3 bulan, dst)
        ]);

        // B. Mulai Transaksi Database
        // Gunanya: Jika ada error saat simpan detail, akun login juga batal dibuat.
        DB::transaction(function () use ($request) {
            
            // Langkah 1: Buat Akun Login (Tabel Users)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'), // Password default
                'role' => 'member',
            ]);

            // Hitung kapan masa aktif berakhir berdasarkan durasi yang dipilih
            $expiryDate = date('Y-m-d', strtotime("+$request->duration months", strtotime($request->join_date)));

            // Langkah 2: Buat Data Detail Member (Tabel Members)
            Member::create([
                'user_id' => $user->id, // Ambil ID dari user yang baru dibuat di atas
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'gender' => $request->gender,
                'join_date' => $request->join_date,
                'expiry_date' => $expiryDate, // Otomatis terisi
                'status' => 'active',
            ]);
        });

        // C. Kembali ke halaman daftar member dengan pesan sukses
        return redirect()->route('members.index')->with('success', 'Member berhasil didaftarkan!');
    }

    // 4. MENAMPILKAN FORM EDIT
    public function edit($id)
    {
        // Cari user berdasarkan ID, jika tidak ada tampilkan error 404
        $user = User::with('member')->findOrFail($id);
        
        return view('admin.members.edit', compact('user'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input (email boleh sama kalau punya sendiri)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone_number' => 'required',
            'gender' => 'required',
            // Kita tidak update join_date & expiry_date di sini dulu (itu nanti fitur perpanjangan)
        ]);

        DB::transaction(function () use ($request, $user) {
            // Update Tabel Users
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update Tabel Members
            $user->member->update([
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'gender' => $request->gender,
            ]);
        });

        return redirect()->route('admin.members.index')->with('success', 'Data member berhasil diperbarui!');
    }

    // 6. HAPUS DATA MEMBER
    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user (Data member otomatis ikut terhapus karena fitur cascade di database)
        $user->delete();

        return redirect()->route('admin.members.index')->with('success', 'Data member berhasil dihapus!');
    }
}