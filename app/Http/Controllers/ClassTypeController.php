<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use Illuminate\Http\Request;

class ClassTypeController extends Controller
{
    public function index()
    {
        $classTypes = ClassType::all();
        return view('admin.classtypes.index', compact('classTypes'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        ClassType::create($request->all());
        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        ClassType::find($id)->delete();
        return redirect()->back()->with('success', 'Kelas dihapus.');
    }
}