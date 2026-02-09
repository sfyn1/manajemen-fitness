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
            'name' => 'required',
            'class_type_id' => 'required|exists:class_types,id', // Validasi harus pilih kelas
        ]);

        Coach::create($request->all());

        return redirect()->back()->with('success', 'Data Coach berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Coach::find($id)->delete();
        return redirect()->back()->with('success', 'Coach dihapus.');
    }
}