<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminNotification;

class AdminNotificationController extends Controller
{
    public function checkNotifications()
    {
        // Pastikan helper admin() berfungsi, jika tidak ganti dengan Auth::guard('admin')->user()
        if (!admin())
            return response()->json(['found' => false]);

        $adminId = admin()->id_admin;

        // Ambil notif terlama yang belum dibaca (FIFO queue)
        $notif = AdminNotification::where('id_admin', $adminId)
            ->where('is_read', 0) // Gunakan 0 untuk false agar aman
            ->orderBy('created_at', 'asc')
            ->first();

        if ($notif) {
            // Tandai sudah dibaca
            $notif->is_read = 1;
            $notif->save(); // Gunakan save() agar trigger update timestamp bekerja normal

            return response()->json([
                'found' => true,
                'message' => $notif->message,
                'time' => $notif->created_at->diffForHumans()
            ]);
        }

        return response()->json(['found' => false]);
    }
}