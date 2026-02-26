<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Coach;
use App\Models\ClassType;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Product;
use App\Models\Presence;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('q');
            
            if (empty($query) || strlen($query) < 1) {
                return response()->json(['error' => 'Query tidak boleh kosong'], 400);
            }

            $results = [];

        // 1. Cari di Member
        $members = Member::with('user')
            ->where(function($q) use ($query) {
                $q->whereHas('user', function($subQ) use ($query) {
                    $subQ->where('name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%");
                })
                ->orWhere('phone_number', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get();
        
        if ($members->count() > 0) {
            $results['members'] = [
                'title' => 'Member',
                'icon' => 'feather-users',
                'items' => $members->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->user->name ?? 'N/A',
                        'subtitle' => $item->user->email ?? $item->phone_number,
                        'url' => route('admin.members.index') . '?search=' . urlencode($item->user->name ?? '') . '#member-' . $item->id
                    ];
                })
            ];
        }

        // 2. Cari di Coach
        $coaches = Coach::with('user')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhereHas('user', function($subQ) use ($query) {
                      $subQ->where('email', 'like', "%{$query}%")
                        ->orWhere('phone_number', 'like', "%{$query}%");
                  });
            })
            ->limit(5)
            ->get(['id', 'user_id', 'name', 'phone_number']);
        
        if ($coaches->count() > 0) {
            $results['coaches'] = [
                'title' => 'Coach',
                'icon' => 'feather-users',
                'items' => $coaches->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'subtitle' => $item->user->email ?? $item->phone_number,
                        'url' => route('admin.coaches.index') . '?search=' . urlencode($item->name) . '#coach-' . $item->id
                    ];
                })
            ];
        }

        // 3. Cari di Class Type
        $classTypes = ClassType::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name']);
        
        if ($classTypes->count() > 0) {
            $results['classtypes'] = [
                'title' => 'Tipe Kelas',
                'icon' => 'feather-layers',
                'items' => $classTypes->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'subtitle' => 'Class Type',
                        'url' => route('admin.classtypes.index') . '?search=' . urlencode($item->name) . '#classtype-' . $item->id
                    ];
                })
            ];
        }

        // 4. Cari di Schedule
        $schedules = Schedule::with('coach', 'classType')
            ->where(function($q) use ($query) {
                $q->whereHas('coach', function($subQ) use ($query) {
                    $subQ->where('name', 'like', "%{$query}%");
                })
                ->orWhereHas('classType', function($subQ) use ($query) {
                    $subQ->where('name', 'like', "%{$query}%");
                });
            })
            ->limit(5)
            ->get(['id', 'coach_id', 'class_type_id', 'day', 'start_time', 'end_time']);
        
        if ($schedules->count() > 0) {
            $results['schedules'] = [
                'title' => 'Jadwal',
                'icon' => 'feather-calendar',
                'items' => $schedules->map(function($item) {
                    $coachName = $item->coach->name ?? 'N/A';
                    return [
                        'id' => $item->id,
                        'name' => ($item->coach->name ?? 'N/A') . ' - ' . ($item->classType->name ?? 'N/A'),
                        'subtitle' => $item->day . ' ' . $item->start_time . ' - ' . $item->end_time,
                        'url' => route('admin.schedules.index') . '?search=' . urlencode($coachName) . '#schedule-' . $item->id
                    ];
                })
            ];
        }

        // 5. Cari di User
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'email']);
        
        if ($users->count() > 0) {
            $results['users'] = [
                'title' => 'Pengguna',
                'icon' => 'feather-user-check',
                'items' => $users->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'subtitle' => $item->email,
                        'url' => route('admin.users.index') . '?search=' . urlencode($item->name) . '#user-' . $item->id
                    ];
                })
            ];
        }

        // 6. Cari di Product
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('category', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'price']);
        
        if ($products->count() > 0) {
            $results['products'] = [
                'title' => 'Produk',
                'icon' => 'feather-package',
                'items' => $products->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'subtitle' => 'Rp ' . number_format($item->price, 0, ',', '.'),
                        'url' => route('admin.products.index') . '?search=' . urlencode($item->name) . '#product-' . $item->id
                    ];
                })
            ];
        }

        // 7. Cari di Presence
        $presences = Presence::with('member.user')
            ->whereHas('member.user', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'member_id', 'check_in_time', 'status']);
        
        if ($presences->count() > 0) {
            $results['presences'] = [
                'title' => 'Presensi',
                'icon' => 'feather-check-circle',
                'items' => $presences->map(function($item) {
                    $memberName = $item->member->user->name ?? 'N/A';
                    return [
                        'id' => $item->id,
                        'name' => $memberName,
                        'subtitle' => $item->check_in_time ?? 'Belum check-in',
                        'url' => route('admin.presences.history') . '?search=' . urlencode($memberName) . '#presence-' . $item->id
                    ];
                })
            ];
        }

        if (empty($results)) {
            return response()->json(['results' => [], 'message' => 'Tidak ada hasil yang ditemukan']);
        }

        return response()->json(['results' => $results]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
