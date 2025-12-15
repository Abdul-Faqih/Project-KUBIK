<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    // 1. HALAMAN UTAMA
    public function index()
    {
        // Default: Urutkan terbaru
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard.user_management', compact('users'));
    }

    // 2. LOGIK FILTER (AJAX)
    public function filter(Request $request)
    {
        $query = User::query();

        // A. Search (Name, NIM, or NIP)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%") // Asumsi kolom NIM ada
                  ->orWhere('nip', 'LIKE', "%{$search}%"); // Asumsi kolom NIP ada
            });
        }

        // B. Filter Role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // C. Sort Date
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('created_at', $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $users = $query->get();

        // Render Partial View
        $html = view('admin.dashboard.partials.user_table', compact('users'))->render();

        return response()->json(['html' => $html]);
    }

    // DETAIL USER
    public function detail($id)
    {
        // Ambil data user beserta booking-nya
        // Load juga relasi 'admin' di dalam booking untuk melihat siapa yang memproses booking tsb
        $user = User::with(['bookings.admin'])->findOrFail($id);

        return view('admin.dashboard.management.detail_user', compact('user'));
    }
}