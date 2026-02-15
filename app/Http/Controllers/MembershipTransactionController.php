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
    public function index()
    {
        // Ambil transaksi yang punya item berupa MembershipPackage
        $transactions = Transaction::whereHas('items', function($q) {
            $q->where('itemable_type', 'App\Models\MembershipPackage');
        })->with('user', 'items')->latest()->get();

        return view('admin.billing.index', compact('transactions'));
    }

    // 2. FORM PERPANJANG MEMBERSHIP
    public function create()
    {
        $members = User::where('role', 'member')->get();
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
    public function printPdf()
    {
        // Ambil data transaksi khusus membership
        $transactions = Transaction::whereHas('items', function($q) {
            $q->where('itemable_type', 'App\Models\MembershipPackage');
        })->with('user', 'items')->latest()->get();

        $totalIncome = $transactions->sum('grand_total');

        // Load View PDF
        $pdf = Pdf::loadView('admin.billing.pdf', compact('transactions', 'totalIncome'));
        
        // Download atau Stream (Tampil di browser)
        return $pdf->stream('Laporan-Membership-' . date('Y-m-d') . '.pdf');
    }
}