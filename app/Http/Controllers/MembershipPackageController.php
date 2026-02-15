<?php

namespace App\Http\Controllers;

use App\Models\MembershipPackage;
use Illuminate\Http\Request;

class MembershipPackageController extends Controller
{
    public function index()
    {
        $packages = MembershipPackage::all();
        return view('admin.membership_packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.membership_packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'duration_in_days' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        MembershipPackage::create($request->all());

        return redirect()->route('admin.membership-packages.index')
            ->with('success', 'Paket berhasil dibuat.');
    }

    public function edit($id)
    {
        $package = MembershipPackage::findOrFail($id);
        return view('admin.membership_packages.edit', compact('package'));
    }

    // INI BAGIAN PENTING AGAR ADMIN BISA UBAH HARGA
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'duration_in_days' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $package = MembershipPackage::findOrFail($id);
        $package->update($request->all());

        return redirect()->route('admin.membership-packages.index')
            ->with('success', 'Paket & Harga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        MembershipPackage::findOrFail($id)->delete();
        return redirect()->route('admin.membership-packages.index')
            ->with('success', 'Paket dihapus.');
    }
}