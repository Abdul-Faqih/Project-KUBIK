<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Booking;

class AdminManagementController extends Controller
{
    //index
    public function index()
    {
        // Pastikan model Admin diimport
        $admins = Admin::all();

        return view('admin.dashboard.admin_management', compact('admins'));
    }

    // detail admin
    public function detail($id)
    {
        // 1. Ambil data admin berdasarkan ID
        // 2. Load relasi 'bookings' (booking yang di-handle admin ini) beserta user-nya
        // Pastikan di Model Admin ada fungsi: public function bookings() { return $this->hasMany(Booking::class, 'id_admin'); }
        
        $admin = Admin::with(['bookings'])->where('id_admin', $id)->firstOrFail();

        return view('admin.dashboard.management.detail_admin', compact('admin'));
    }
}
