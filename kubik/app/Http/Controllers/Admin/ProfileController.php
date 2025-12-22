<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Booking;

class ProfileController extends Controller
{

    // detail admin
    public function detail($id)
    {
        // 1. Ambil data admin berdasarkan ID
        // 2. Load relasi 'bookings' (booking yang di-handle admin ini) beserta user-nya
        // Pastikan di Model Admin ada fungsi: public function bookings() { return $this->hasMany(Booking::class, 'id_admin'); }

        $admin = Admin::with(['bookings'])->where('id_admin', $id)->firstOrFail();

        return view('admin.dashboard.profile', compact('admin'));
    }

    // FILTER PERMISSIONS (AJAX)
    public function filterPermissions(Request $request, $id_admin)
    {
        $query = Booking::with('user')
            ->where('id_admin', $id_admin); // Hanya booking yg di-handle admin ini

        // 1. Search (ID Booking atau Nama User)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_booking', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // 2. Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Sort Date
        $sort = $request->get('sort', 'desc'); // Default desc
        $query->orderBy('created_at', $sort);

        $bookings = $query->get();

        // Render Partial View (Hanya baris tabel)
        $html = view('admin.dashboard.partials.permission_table_rows', compact('bookings'))->render();

        return response()->json(['html' => $html]);
    }
}
