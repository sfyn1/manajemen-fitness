<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class MemberController extends Controller
{
    // 1. FITUR MENAMPILKAN DAFTAR MEMBER
    public function index()
    {
        // Ambil semua user yang role-nya 'member', beserta data detail member-nya
        // 'with' digunakan untuk teknik Eager Loading (biar query ringan)
        $members = User::where('role', 'member')->with('member')->latest()->get();

        // Kirim data ke tampilan (View) - Nanti kita buat View-nya
        return view('admin.members.index', compact('members'));
    }

    // 2. FITUR MENAMPILKAN FORM TAMBAH MEMBER
    public function create()
    {
        return view('admin.members.create');
    }

// 3. FITUR MENYIMPAN DATA MEMBER BARU (Logic Penting!)
public function store(Request $request)
{
    // ... (Validasi tetap sama) ...

    // 1. GENERATE PASSWORD ACAK (8 Karakter)
    // Contoh hasil: 'k9LmP2xQ'
    $generatedPassword = Str::random(8); 

    DB::transaction(function () use ($request, $generatedPassword) {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 2. GUNAKAN PASSWORD ACAK TADI
            'password' => Hash::make($generatedPassword), 
            'role' => 'member',
        ]);

        $expiryDate = date('Y-m-d', strtotime("+$request->duration months", strtotime($request->join_date)));

        Member::create([
            'user_id' => $user->id, 
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'join_date' => $request->join_date,
            'expiry_date' => $expiryDate, 
            'status' => 'active',
        ]);
    });

    // 3. KIRIM PASSWORD KE VIEW AGAR BISA DILIHAT ADMIN
    return redirect()->route('admin.members.index')
        ->with('success', 'Member berhasil didaftarkan!')
        ->with('new_password', $generatedPassword); // Bawa password mentah
}

    // 4. MENAMPILKAN FORM EDIT
    public function edit($id)
    {
        // Cari user berdasarkan ID, jika tidak ada tampilkan error 404
        $user = User::with('member')->findOrFail($id);
        
        return view('admin.members.edit', compact('user'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input (email boleh sama kalau punya sendiri)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone_number' => 'required',
            'gender' => 'required',
            // Kita tidak update join_date & expiry_date di sini dulu (itu nanti fitur perpanjangan)
        ]);

        DB::transaction(function () use ($request, $user) {
            // Update Tabel Users
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update Tabel Members
            $user->member->update([
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'gender' => $request->gender,
            ]);
        });

        return redirect()->route('admin.members.index')->with('success', 'Data member berhasil diperbarui!');
    }

    // 6. HAPUS DATA MEMBER
    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user (Data member otomatis ikut terhapus karena fitur cascade di database)
        $user->delete();

        return redirect()->route('admin.members.index')->with('success', 'Data member berhasil dihapus!');
    }

    // 7. TAMPILKAN KARTU MEMBER (QR CODE)
    public function card($id)
    {
        $user = User::with('member')->findOrFail($id);
        
        // Kita generate data sederhana untuk QR, misal: "MEMBER-123"
        // Atau pakai ID membernya langsung agar aman saat di-scan
        $qrData = $user->member->id; 

        return view('admin.members.card', compact('user', 'qrData'));
    }

    // 8. (REVISI) DOWNLOAD PDF DARI GAMBAR (SUPAYA TAMPILAN SAMA PERSIS)
    public function printPdfImage(Request $request)
    {
        $imageData = $request->input('image');
        $memberName = $request->input('name');

        // Bersihkan header data URI (data:image/jpeg;base64,...)
        // agar bisa dibaca oleh dompdf jika perlu, atau langsung di view
        
        $pdf = Pdf::loadView('admin.members.pdf_preview', compact('imageData'));
        
        // Set ukuran kertas sesuai kartu ID Card (Landscape)
        // 85.6mm x 53.98mm = approx 242.6 x 153 points
        $pdf->setPaper([0, 0, 242.65, 153], 'portrait'); 

        return $pdf->download('Kartu-Member-'.$memberName.'.pdf');
    }
}