<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Tambahan untuk upload file
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    // 1. FITUR MENAMPILKAN DAFTAR MEMBER
    public function index()
    {
        $members = User::where('role', 'member')->with('member')->latest()->get();
        return view('admin.members.index', compact('members'));
    }

    // 2. FITUR MENAMPILKAN FORM TAMBAH MEMBER
    public function create()
    {
        return view('admin.members.create');
    }

    // 3. FITUR MENYIMPAN DATA MEMBER BARU (UPDATED: Upload KTP & Pelajar)
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            // Password tidak divalidasi karena digenerate otomatis
            'phone_number' => 'required',
            'gender' => 'required',
            'duration' => 'required|integer',
            'join_date' => 'required|date',
            
            // --- TAMBAHAN VALIDASI FOTO ---
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib
            'student_card_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. GENERATE PASSWORD ACAK (Sistem Lama)
        $generatedPassword = Str::random(8); 

        DB::transaction(function () use ($request, $generatedPassword) {
            
            // Simpan User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($generatedPassword), 
                'role' => 'member',
            ]);

            $expiryDate = date('Y-m-d', strtotime("+$request->duration months", strtotime($request->join_date)));

            // --- PROSES UPLOAD FOTO ---
            // 1. Upload Foto Wajah
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('members/faces', 'public');
            }

            $ktpPath = null;
            if ($request->hasFile('ktp_image')) {
                // Simpan ke storage/app/public/members/ktp
                $ktpPath = $request->file('ktp_image')->store('members/ktp', 'public');
            }

            $studentCardPath = null;
            if ($request->hasFile('student_card_image')) {
                // Simpan ke storage/app/public/members/student
                $studentCardPath = $request->file('student_card_image')->store('members/student', 'public');
            }

            // Simpan Member
            Member::create([
                'user_id' => $user->id, 
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'gender' => $request->gender,
                'join_date' => $request->join_date,
                'expiry_date' => $expiryDate, 
                'status' => 'active',
                // Masukkan path foto ke database
                'photo' => $photoPath,
                'ktp_image' => $ktpPath,
                'student_card_image' => $studentCardPath,
            ]);
        });

        // Redirect dengan Password Baru
        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil didaftarkan!')
            ->with('new_password', $generatedPassword);
    }

    // 4. MENAMPILKAN FORM EDIT
    public function edit($id)
    {
        $user = User::with('member')->findOrFail($id);
        return view('admin.members.edit', compact('user'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone_number' => 'required',
            'gender' => 'required',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

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
        $user = User::with('member')->findOrFail($id);

        // Hapus file foto dari storage jika ada (Biar server tidak penuh)
        if ($user->member->ktp_image) {
            Storage::disk('public')->delete($user->member->ktp_image);
        }
        if ($user->member->student_card_image) {
            Storage::disk('public')->delete($user->member->student_card_image);
        }

        $user->delete();

        return redirect()->route('admin.members.index')->with('success', 'Data member berhasil dihapus!');
    }

    // 7. TAMPILKAN KARTU MEMBER (QR CODE)
    public function card($id)
    {
        $user = User::with('member')->findOrFail($id);
        $qrData = $user->member->id; 

        return view('admin.members.card', compact('user', 'qrData'));
    }

    // 8. DOWNLOAD PDF DARI GAMBAR
    public function printPdfImage(Request $request)
    {
        $imageData = $request->input('image');
        $memberName = $request->input('name');

        $pdf = Pdf::loadView('admin.members.pdf_preview', compact('imageData'));
        $pdf->setPaper([0, 0, 242.65, 153], 'portrait'); 

        return $pdf->download('Kartu-Member-'.$memberName.'.pdf');
    }

    // 9. FITUR LIHAT DETAIL MEMBER (BIODATA LENGKAP)
    public function show($id)
    {
        $user = User::with('member')->findOrFail($id);
        return view('admin.members.show', compact('user'));
    }
}