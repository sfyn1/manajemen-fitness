<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\ClassType; // Panggil Model Kelas
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index()
    {
        // Ambil data Coach beserta info Kelasnya (Eager Loading)
        $coaches = Coach::with('classType')->get();
        
        // Ambil semua data Kelas untuk Pilihan di Form Tambah
        $classTypes = ClassType::all();

        return view('admin.coaches.index', compact('coaches', 'classTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:coaches,user_id',
            'class_type_id' => 'required',
            // 'phone_number' tidak perlu divalidasi dari request karena diambil dari DB
        ]);

        // 1. Cari Data User berdasarkan ID yang dipilih
        $user = \App\Models\User::findOrFail($request->user_id);

        // 2. Simpan ke tabel Coaches (Nama & No HP diambil otomatis)
        \App\Models\Coach::create([
            'user_id' => $user->id,
            'name' => $user->name,
            
            // AMBIL NO HP DARI USER
            // Jika user tidak punya no hp, isi '-' atau biarkan null (tergantung struktur DB Anda)
            'phone_number' => $user->phone_number ?? '-', 
            
            'class_type_id' => $request->class_type_id,
        ]);

        return redirect()->route('admin.coaches.index')
            ->with('success', 'Data Pelatih berhasil ditambahkan! Nama & No HP disinkronkan dari Akun.');
    }

    public function destroy($id)
    {
        Coach::find($id)->delete();
        return redirect()->back()->with('success', 'Coach dihapus.');
    }
}