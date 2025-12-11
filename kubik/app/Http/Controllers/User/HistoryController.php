<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = user()->id_user;

        // 1. AMBIL FILTER DARI URL (Default: kosong/all)
        $filterStatus = $request->input('status');

        // 2. QUERY RAW
        $query = DB::table('bookings')
            ->join('booking_assets', 'bookings.id_booking', '=', 'booking_assets.id_booking')
            ->join('assets', 'booking_assets.id_asset', '=', 'assets.id_asset')
            ->join('asset_masters', 'assets.id_master', '=', 'asset_masters.id_master')
            ->join('types', 'asset_masters.id_type', '=', 'types.id_type')
            ->where('bookings.id_user', $userId)
            ->select(
                'bookings.*',
                'asset_masters.name as asset_name',
                'asset_masters.image_asset',
                'types.name as category_name'
            )
            ->distinct()
            ->orderBy('bookings.created_at', 'desc');

        // APPLIES FILTER JIKA ADA
        if (!empty($filterStatus)) {
            $query->where('bookings.status', $filterStatus);
        }

        $rawBookings = $query->get();

        // 3. GROUPING (Proses Data)
        $bookings = $rawBookings->groupBy('id_booking')->map(function ($group) {
            $displayItem = $group->first();
            $displayItem->total_items = $group->count();

            // Logic Prioritas Ruangan
            $room = $group->first(function ($item) {
                return stripos($item->category_name, 'Room') !== false || stripos($item->category_name, 'Ruangan') !== false;
            });

            if ($room) {
                $displayItem->asset_name = $room->asset_name;
                $displayItem->category_name = $room->category_name;
                $displayItem->image_asset = $room->image_asset;
            }

            return $displayItem;
        });

        // Kirim $filterStatus ke view agar tombol bisa tetap aktif (berwarna oranye)
        return view('user.profile.history', compact('bookings', 'filterStatus'));
    }

    public function detail($id)
    {
        // 1. HEADER BOOKING
        $booking = DB::table('bookings')
            ->where('id_booking', $id)
            ->where('id_user', user()->id_user)
            ->first();

        if (!$booking) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        // 2. ITEM DETAIL (DIPERBAIKI)
        $items = DB::table('booking_assets')
            ->join('assets', 'booking_assets.id_asset', '=', 'assets.id_asset')
            ->join('asset_masters', 'assets.id_master', '=', 'asset_masters.id_master')
            ->join('types', 'asset_masters.id_type', '=', 'types.id_type')
            ->where('booking_assets.id_booking', $id)
            ->select(
                'asset_masters.name as asset_name',
                'types.name as category_name',
                'asset_masters.image_asset',
                DB::raw('count(*) as total_qty') // <--- Tambahkan ini untuk menghitung jumlah
            )
            ->groupBy('asset_masters.name', 'types.name', 'asset_masters.image_asset') // <--- Grouping berdasarkan nama barang
            ->get();

        // 3. PISAHKAN RUANGAN & BARANG (Biarkan tetap sama)
        $ruangan = $items->filter(function ($item) {
            return stripos($item->category_name, 'Room') !== false || stripos($item->category_name, 'Ruangan') !== false;
        });

        $barang = $items->filter(function ($item) {
            return stripos($item->category_name, 'Room') === false && stripos($item->category_name, 'Ruangan') === false;
        });

        return view('user.profile.history_detail', compact('booking', 'ruangan', 'barang'));
    }

    public function processReturn(Request $request, $id)
    {
        $request->validate([
            'proof_return' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = DB::table('bookings')->where('id_booking', $id)->first();

        if (!$booking) {
            return back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        if ($request->hasFile('proof_return')) {
            $file = $request->file('proof_return');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/proofs'), $fileName);

            DB::table('bookings')
                ->where('id_booking', $id)
                ->update([
                    'status' => 'Completed',
                    'proof_return' => $fileName,
                    'updated_at' => now()
                ]);

            // GANTI DISINI: Kirim ID booking agar bisa dipakai di link See Details
            return back()->with('successReturn', $id);
        }

        return back()->with('error', 'Gagal mengupload bukti foto.');
    }
}