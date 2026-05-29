<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Coach;
use App\Models\ClassType;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Ambil semua jadwal (biarkan seperti codingan lama Anda)
        $schedules = Schedule::with(['classType', 'coach'])->orderBy('day')->orderBy('start_time')->get();
        
        // DATA UNTUK FORM TAMBAH
        $classTypes = \App\Models\ClassType::all();
        
        // PENTING: Kita kirim semua coach, nanti JavaScript yang akan memfilternya
        $coaches = \App\Models\Coach::all(); 

        return view('admin.schedules.index', compact('schedules', 'classTypes', 'coaches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time'    => 'required',
            'class_type_id' => 'required|exists:class_types,id',
            'coach_id'      => 'required|exists:coaches,id',
        ]);

        $classType = ClassType::findOrFail($request->class_type_id);
        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($classType->duration_minutes);

        Schedule::create([
            'day'           => $request->day,
            'start_time'    => $request->start_time,
            'end_time'      => $endTime->format('H:i:s'),
            'class_type_id' => $request->class_type_id,
            'coach_id'      => $request->coach_id,
        ]);

        return redirect()->back()->with('success', 'Jadwal rutin berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}