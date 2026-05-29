<?php

namespace App\Http\Controllers;

use App\Models\PtPackage;
use Illuminate\Http\Request;

class PtPackageController extends Controller
{
    public function index()
    {
        $packages = PtPackage::orderBy('session_count')->get();
        return view('admin.pt_packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'session_count'    => 'required|integer|in:5,10,20,30',
            'price'            => 'required|numeric|min:1',
            'duration_minutes' => 'required|integer|in:60,120',
            'description'      => 'nullable|string',
        ]);

        $data = $request->only([
            'name', 'session_count', 'price', 'duration_minutes', 'description'
        ]);
        $data['validity_days'] = 30; // Default dummy value as it is no longer used

        PtPackage::create($data);

        return redirect()->route('admin.pt-packages.index')
            ->with('success', 'Paket PT berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $package = PtPackage::findOrFail($id);

        $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'required|numeric|min:1',
            'duration_minutes' => 'required|integer|in:60,120',
            'description'      => 'nullable|string',
        ]);

        $data = $request->only([
            'name', 'price', 'duration_minutes', 'description'
        ]);
        $data['validity_days'] = 30; // Default dummy value

        $package->update($data);

        return redirect()->route('admin.pt-packages.index')
            ->with('success', 'Paket PT berhasil diperbarui!');
    }

    public function toggleActive($id)
    {
        $package = PtPackage::findOrFail($id);
        $package->update(['is_active' => !$package->is_active]);

        $status = $package->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Paket \"{$package->name}\" berhasil {$status}.");
    }

    public function destroy($id)
    {
        $package = PtPackage::findOrFail($id);

        // Cek apakah ada langganan aktif yang pakai paket ini
        if ($package->subscriptions()->whereIn('status', ['pending', 'active'])->exists()) {
            return back()->with('error', 'Tidak bisa hapus paket yang masih digunakan member aktif.');
        }

        $package->delete();
        return back()->with('success', 'Paket PT berhasil dihapus.');
    }
}
