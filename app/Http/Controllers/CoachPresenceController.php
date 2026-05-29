<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\CoachPresence;
use Carbon\Carbon;

class CoachPresenceController extends Controller
{
    // 1. HALAMAN ADMIN: LIHAT DAFTAR LAPORAN COACH
    public function index(Request $request)
    {
        // Default hari ini, atau ambil dari filter tanggal
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();
        
        // Translate hari ke Indonesia (Senin, Selasa...)
        Carbon::setLocale('id');
        $dayName = $date->translatedFormat('l');

        // Ambil Jadwal Rutin pada HARI tersebut
        $schedules = Schedule::with(['coach', 'classType'])
                             ->where('day', $dayName)
                             ->orderBy('start_time')
                             ->paginate(15);

        return view('admin.presences.coach', compact('schedules', 'date'));
    }

    // 2. ADMIN APPROVE (KONFIRMASI SELESAI & BUAT TRANSAKSI KELAS)
    public function approve($id)
    {
        // Cari data presensi berdasarkan ID yang dikirim
        $presence = CoachPresence::findOrFail($id);
        
        // Ubah status jadi Approved
        $presence->update([
            'status' => 'approved'
        ]);

        // LOGIKA TAMBAHAN: Buat Transaksi Pemasukan Kelas
        $schedule = Schedule::with('classType')->findOrFail($presence->schedule_id);
        $totalMembers = \App\Models\Booking::where('schedule_id', $schedule->id)
            ->where('date', Carbon::parse($presence->date)->format('Y-m-d'))
            ->count();
            
        $classPrice = $schedule->classType->price;

        // Jika ada member yang ikut dan harga kelas > 0, catat sebagai pemasukan
        if ($totalMembers > 0 && $classPrice > 0) {
            $totalIncome = $totalMembers * $classPrice;

            $transaction = \App\Models\Transaction::create([
                'invoice_number' => 'INV-CLS-' . date('dmy') . '-' . rand(1000, 9999),
                'user_id' => null, // Pembayaran kolektif di tempat
                'grand_total' => $totalIncome,
                'status' => 'paid',
                'payment_method' => 'cash',
                'transaction_date' => now(),
            ]);

            \App\Models\TransactionItem::create([
                'transaction_id' => $transaction->id,
                'itemable_id' => $schedule->classType->id,
                'itemable_type' => \App\Models\ClassType::class,
                'name' => 'Tiket Kelas ' . $schedule->classType->name,
                'price' => $classPrice,
                'quantity' => $totalMembers,
                'subtotal' => $totalIncome,
            ]);
        }

        return back()->with('success', 'Sesi disetujui. Gaji coach dan pemasukan kelas telah tercatat.');
    }
    
    // 3. ADMIN REJECT (OPSIONAL - JIKA FOTO TIDAK JELAS)
    public function reject($id)
    {
        $presence = CoachPresence::findOrFail($id);
        $presence->update(['status' => 'rejected']);
        
        return back()->with('error', 'Laporan sesi ditolak.');
    }
}