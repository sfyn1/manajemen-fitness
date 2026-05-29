<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\ClassType;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index()
    {
        // Pisahkan PT dan Group Coach untuk tampilan
        $personalTrainers = Coach::where('coach_type', 'personal_trainer')
            ->with('user')
            ->get();

        $groupCoaches = Coach::where('coach_type', 'group_coach')
            ->with(['user', 'classType', 'schedules'])
            ->get();

        $classTypes = ClassType::all();

        return view('admin.coaches.index', compact('personalTrainers', 'groupCoaches', 'classTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id|unique:coaches,user_id',
            'coach_type' => 'required|in:personal_trainer,group_coach',
        ]);

        // Validasi tambahan berdasarkan tipe
        if ($request->coach_type === 'personal_trainer') {
            $request->validate([
                'base_salary'          => 'required|numeric|min:1',
                'contract_start_date'  => 'required|date',
                'contract_end_date'    => 'required|date|after:contract_start_date',
            ]);
        } else {
            $request->validate([
                'session_rate'  => 'required|numeric|min:1',
                'class_type_id' => 'required|exists:class_types,id',
            ]);
        }

        $user = \App\Models\User::findOrFail($request->user_id);

        $data = [
            'user_id'      => $user->id,
            'name'         => $user->name,
            'phone_number' => $user->phone_number ?? '-',
            'coach_type'   => $request->coach_type,
        ];

        if ($request->coach_type === 'personal_trainer') {
            $data['base_salary']          = $request->base_salary;
            $data['contract_start_date']  = $request->contract_start_date;
            $data['contract_end_date']    = $request->contract_end_date;
        } else {
            $data['session_rate']  = $request->session_rate;
            $data['class_type_id'] = $request->class_type_id;
        }

        Coach::create($data);

        return redirect()->route('admin.coaches.index')
            ->with('success', 'Data Pelatih berhasil ditambahkan!');
    }


    public function destroy($id)
    {
        $coach = Coach::findOrFail($id);

        // Cek apakah ada langganan PT aktif
        if ($coach->isPersonalTrainer() && $coach->ptSubscriptions()->whereIn('status', ['pending', 'active'])->exists()) {
            return back()->with('error', 'Tidak bisa hapus PT yang masih memiliki member aktif.');
        }

        $coach->delete();
        return redirect()->back()->with('success', 'Coach berhasil dihapus.');
    }
}