<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductTransactionController extends Controller
{
    // 1. RIWAYAT PENJUALAN PRODUK
    public function index()
    {
        $transactions = Transaction::whereHas('items', function($q) {
            $q->where('itemable_type', 'App\Models\Product');
        })->with('items')->latest()->paginate(20);

        return view('admin.product_sales.index', compact('transactions'));
    }

    // 2. FORM JUAL PRODUK
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('admin.product_sales.create', compact('products'));
    }

    // 3. PROSES JUAL & KURANGI STOK
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);

            // Cek Stok
            if ($product->stock < $request->quantity) {
                return back()->with('error', 'Stok tidak cukup! Sisa: ' . $product->stock);
            }

            // A. KURANGI STOK
            $product->decrement('stock', $request->quantity);

            // B. BUAT TRANSAKSI
            $totalPrice = $product->price * $request->quantity;
            
            $transaction = Transaction::create([
                'invoice_number' => 'INV-PRD-' . date('dmy') . '-' . rand(1000, 9999),
                'user_id' => null, // Pembeli produk bisa siapa saja (Tamu)
                'grand_total' => $totalPrice,
                'status' => 'paid',
                'payment_method' => 'cash',
                'transaction_date' => now(),
            ]);

            // C. SIMPAN DETAIL
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'itemable_id' => $product->id,
                'itemable_type' => Product::class,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'subtotal' => $totalPrice,
            ]);

            DB::commit();
            return redirect()->route('admin.product-sales.index')->with('success', 'Produk terjual & stok berkurang!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function printPdf()
    {
        // Ambil data transaksi khusus produk
        $transactions = Transaction::whereHas('items', function($q) {
            $q->where('itemable_type', 'App\Models\Product');
        })->with('items')->latest()->get();

        $totalIncome = $transactions->sum('grand_total');

        $pdf = Pdf::loadView('admin.product_sales.pdf', compact('transactions', 'totalIncome'));
        return $pdf->stream('Laporan-Penjualan-Produk-' . date('Y-m-d') . '.pdf');
    }
}