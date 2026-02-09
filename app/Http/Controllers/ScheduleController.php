<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ClassType;
use App\Models\Coach;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // TAMPILKAN JADWAL
    public function index()
    {
        // Urutkan jadwal agar rapi (Senin -> Minggu)
        // Kita gunakan trik FIELD() mysql untuk mengurutkan hari
        $schedules = Schedule::with(['classType', 'coach'])
            ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time')
            ->get();

        // Ambil Data untuk Form Tambah (Dropdown)
        $classTypes = ClassType::all();
        $coaches = Coach::all();

        return view('admin.schedules.index', compact('schedules', 'classTypes', 'coaches'));
    }

    // SIMPAN JADWAL BARU
    public function store(Request $request)
    {
        $request->validate([
            'class_type_id' => 'required',
            'coach_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        Schedule::create($request->all());

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // HAPUS JADWAL
    public function destroy($id)
    {
        Schedule::find($id)->delete();
        return redirect()->back()->with('success', 'Jadwal dihapus.');
    }
}