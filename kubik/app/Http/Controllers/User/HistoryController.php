<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index()
    {
        $userId = user()->id_user;

        // 1. QUERY RAW
        $rawBookings = DB::table('bookings')
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
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        // 2. GROUPING (Proses Data agar siap tampil)
        $bookings = $rawBookings->groupBy('id_booking')->map(function ($group) {
            
            // Ambil item pertama sebagai perwakilan
            $displayItem = $group->first();
            
            // Hitung total item
            $displayItem->total_items = $group->count();

            // LOGIC PRIORITAS RUANGAN (Biar Icon & Judul jadi Ruangan kalau ada)
            $room = $group->first(function($item) {
                return stripos($item->category_name, 'Room') !== false || stripos($item->category_name, 'Ruangan') !== false;
            });

            if ($room) {
                $displayItem->asset_name = $room->asset_name;
                $displayItem->category_name = $room->category_name;
                $displayItem->image_asset = $room->image_asset;
            }

            return $displayItem;
        });

        // 3. FILTER TAB SELESAI (PERBAIKAN DISINI)
        // Kita hanya ambil yang statusnya 'Completed'.
        // Yang 'Rejected' tidak akan masuk sini.
        $completedBookings = $bookings->filter(function ($item) {
            return $item->status == 'Completed'; 
        });

        return view('user.profile.history', compact('bookings', 'completedBookings'));
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

        // 2. ITEM DETAIL
        $items = DB::table('booking_assets')
            ->join('assets', 'booking_assets.id_asset', '=', 'assets.id_asset')
            ->join('asset_masters', 'assets.id_master', '=', 'asset_masters.id_master')
            ->join('types', 'asset_masters.id_type', '=', 'types.id_type')
            ->where('booking_assets.id_booking', $id)
            ->select(
                'asset_masters.name as asset_name',
                'types.name as category_name',
                'asset_masters.image_asset'
            )
            ->distinct()
            ->get();

        // 3. PISAHKAN RUANGAN & BARANG
        $ruangan = $items->filter(function($item) {
            return stripos($item->category_name, 'Room') !== false || stripos($item->category_name, 'Ruangan') !== false;
        });
        
        $barang = $items->filter(function($item) {
            return stripos($item->category_name, 'Room') === false && stripos($item->category_name, 'Ruangan') === false;
        });

        return view('user.profile.history_detail', compact('booking', 'ruangan', 'barang'));
    }
}