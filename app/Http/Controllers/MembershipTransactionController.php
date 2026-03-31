<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MembershipPackage;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipTransactionController extends Controller
{
    // 1. RIWAYAT TRANSAKSI MEMBERSHIP
    public function index(Request $request)
    {
        $selectedMonth = $request->month ?? date('Y-m');
        $year = date('Y', strtotime($selectedMonth));
        $month = date('m', strtotime($selectedMonth));

        // Ambil data transaksi
        $transactions = Transaction::with(['user']) 
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->get();

        // --- TAMBAHKAN BARIS INI KEMBALI ---
        // Menghitung total pendapatan bulan ini (Ganti 'total_amount' dengan nama kolom harga/total di tabel transactions Anda jika berbeda)
        $totalIncome = $transactions->sum('total_amount'); 

        // Jangan lupa tambahkan 'totalIncome' ke dalam compact
        return view('admin.billing.index', compact('transactions', 'selectedMonth', 'totalIncome'));
    }

    // 2. FORM PERPANJANG MEMBERSHIP
    public function create()
    {
        // Ambil users dengan role member dan eager load member relation
        $members = User::where('role', 'member')
            ->with('member')
            ->get()
            ->filter(function ($user) {
                return $user->member !== null;
            });
        
        // Foreach untuk update status dan tambahkan ke array
        $membersArray = [];
        foreach ($members as $user) {
            // Update status jika expired
            $user->member->updateStatusIfExpired();
            
            // Reload untuk dapat data terbaru
            $user->refresh();
            
            $membersArray[] = $user;
        }
        
        // Convert ke collection dan sort
        $members = collect($membersArray)->sortByDesc(function ($user) {
            return $user->member->isExpired();
        })->values();
        
        $packages = MembershipPackage::all();
        return view('admin.billing.create', compact('members', 'packages'));
    }

    // 3. PROSES SIMPAN & PERPANJANG OTOMATIS
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:membership_packages,id',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            $package = MembershipPackage::findOrFail($request->package_id);

            // A. BUAT TRANSAKSI
            $invoiceNumber = 'INV-MEM-' . date('dmy') . '-' . rand(1000, 9999);
            
            $transaction = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => $user->id,
                'grand_total' => $package->price,
                'status' => 'paid',
                'payment_method' => 'cash',
                'transaction_date' => now(),
            ]);

            // B. SIMPAN DETAIL ITEM
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'itemable_id' => $package->id,
                'itemable_type' => MembershipPackage::class, // Polymorphic
                'name' => $package->name,
                'price' => $package->price,
                'quantity' => 1,
                'subtotal' => $package->price,
            ]);

            // C. UPDATE MASA AKTIF MEMBER (INTI LOGIKA)
            $memberData = $user->member;
            if ($memberData) {
                $currentExpiry = Carbon::parse($memberData->expiry_date);
                
                // Jika sudah expired, hitung dari hari ini. Jika belum, tambah dari tanggal expired terakhir.
                if ($currentExpiry->isPast()) {
                    $newExpiry = Carbon::now()->addDays($package->duration_in_days);
                } else {
                    $newExpiry = $currentExpiry->addDays($package->duration_in_days);
                }

                $memberData->update([
                    'expiry_date' => $newExpiry,
                    'status' => 'active'
                ]);
            }

            DB::commit();
            return redirect()->route('admin.billing.index')->with('success', 'Membership berhasil diperpanjang!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function printPdf(Request $request)
    {
        $selectedMonth = $request->month ?? date('Y-m');
        $year = date('Y', strtotime($selectedMonth));
        $month = date('m', strtotime($selectedMonth));

        // Ambil data transaksi
        $transactions = Transaction::with(['user']) 
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->get();

        // --- TAMBAHKAN BARIS INI KEMBALI ---
        $totalIncome = $transactions->sum('total_amount');

        // Jangan lupa tambahkan 'totalIncome' ke dalam compact
        $pdf = Pdf::loadView('admin.billing.pdf', compact('transactions', 'selectedMonth', 'totalIncome'));
        return $pdf->stream('Laporan-Billing-'.$selectedMonth.'.pdf');
    }
}