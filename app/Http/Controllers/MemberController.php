<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
// Pastikan Import Model Paket Membership ada
use App\Models\MembershipPackage; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    // 2. FITUR MENAMPILKAN FORM TAMBAH MEMBER (UPDATED: Kirim Data Paket)
    public function create()
    {
        // Ambil data paket untuk dropdown
        $packages = MembershipPackage::all();
        
        return view('admin.members.create', compact('packages'));
    }

    // 3. FITUR MENYIMPAN DATA MEMBER BARU (UPDATED: Logika Paket Membership)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'gender' => 'required',
            'join_date' => 'required|date',
            'package_id' => 'required|exists:membership_packages,id', // Pastikan ID paket ada
            
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'student_card_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. GENERATE PASSWORD
        $generatedPassword = Str::random(8); 

        // 3. AMBIL DATA PAKET (PERBAIKAN DISINI)
        $package = MembershipPackage::findOrFail($request->package_id);
        
        // Gunakan nama kolom yang BENAR: duration_in_days
        $durationDays = (int) $package->duration_in_days; 

        // 4. HITUNG TANGGAL KADALUARSA
        // Rumus: Tanggal Gabung + Durasi Paket
        $expiryDate = date('Y-m-d', strtotime("+$durationDays days", strtotime($request->join_date)));

        DB::transaction(function () use ($request, $generatedPassword, $expiryDate, $package) {
            
            // Simpan User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($generatedPassword), 
                'role' => 'member',
                'must_change_password' => true,
            ]);

            // Upload Foto
            $photoPath = $request->file('photo')->store('members/faces', 'public');
            $ktpPath = $request->file('ktp_image')->store('members/ktp', 'public');
            
            $studentCardPath = null;
            if ($request->hasFile('student_card_image')) {
                $studentCardPath = $request->file('student_card_image')->store('members/student', 'public');
            }

            // Simpan Member
            Member::create([
                'user_id' => $user->id, 
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'gender' => $request->gender,
                'join_date' => $request->join_date,
                'expiry_date' => $expiryDate, // Tanggal yang sudah benar
                'status' => 'active',
                'photo' => $photoPath,
                'ktp_image' => $ktpPath,
                'student_card_image' => $studentCardPath,
            ]);
        });

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil didaftarkan dengan Paket ' . $package->name . '!')
            ->with('wa_data', [
                'name'     => $request->name,
                'phone'    => $request->phone_number,
                'email'    => $request->email,
                'password' => $generatedPassword
            ]);
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

    // 9. FITUR LIHAT DETAIL MEMBER
    public function show($id)
    {
        $user = User::with('member')->findOrFail($id);
        return view('admin.members.show', compact('user'));
    }
}