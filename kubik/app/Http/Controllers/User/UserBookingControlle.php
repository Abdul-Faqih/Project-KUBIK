<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Asset;
use App\Models\AssetMaster;
use App\Models\Booking;
use App\Models\BookingAsset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File; // Tambahkan ini untuk manajemen file

class UserBookingControlle extends Controller
{
    public function showForm()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session('user_id');

        $cartItems = Cart::where('carts.id_user', $userId)
            ->join('assets', 'carts.id_asset', '=', 'assets.id_asset')
            ->join('asset_masters', 'assets.id_master', '=', 'asset_masters.id_master')
            ->leftJoin('types', 'asset_masters.id_type', '=', 'types.id_type')
            ->select(
                'assets.id_asset',
                'asset_masters.name',
                'asset_masters.id_master',
                'types.name as type_name'
            )
            ->orderBy('asset_masters.name', 'asc')
            ->get();

        $rooms = $cartItems->filter(fn($item) => $item->type_name === 'Rooms');

        $itemsRaw = $cartItems->filter(fn($item) => $item->type_name !== 'Rooms');
        $groupedItems = [];
        foreach ($itemsRaw as $item) {
            $masterId = $item->id_master;
            if (!isset($groupedItems[$masterId])) {
                $groupedItems[$masterId] = [
                    'name' => $item->name,
                    'master_id' => $masterId,
                    'assets' => []
                ];
            }
            $groupedItems[$masterId]['assets'][] = $item->id_asset;
        }

        if ($rooms->isEmpty() && empty($groupedItems)) {
            return redirect()->route('user.availability')->with('error', 'Keranjang kosong.');
        }

        return view('user.form', [
            'rooms' => $rooms,
            'groupedItems' => $groupedItems
        ]);
    }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'assets' => 'required|array',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:5000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user_id = session('user_id');
            $newBookingId = $this->generateBookingId();

            $startDateTime = $request->start_date . ' ' . $request->start_time . ':00';
            $endDateTime = $request->end_date . ' ' . $request->end_time . ':00';

            $booking = Booking::create([
                'id_booking' => $newBookingId,
                'id_user' => $user_id,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'status' => 'Pending',
            ]);

            $assets = $request->input('assets', []);
            $bookingAssetsData = [];

            foreach ($assets as $asset_id) {
                $bookingAssetsData[] = [
                    'id_booking' => $newBookingId,
                    'id_asset' => $asset_id,
                ];
            }

            if (!empty($bookingAssetsData)) {
                BookingAsset::insert($bookingAssetsData);
            }

            // REVISI POIN 4: Upload ke public/uploads/attachments
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = $newBookingId . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Tentukan path tujuan di folder public
                $destinationPath = public_path('uploads/attachments');
                
                // Pastikan folder ada
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Pindahkan file
                $file->move($destinationPath, $fileName);

                // Simpan path relatif ke database
                $booking->update(['attachment' => $fileName]);
            }

            Cart::where('id_user', $user_id)->delete();
            DB::commit();

            return redirect()->route('user.home')->with('success', 'Permintaan peminjaman berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    private function generateBookingId()
    {
        $lastBooking = Booking::orderBy('created_at', 'desc')->lockForUpdate()->first();
        $lastNumber = 0;
        if ($lastBooking) {
            $lastNumber = (int) substr($lastBooking->id_booking, 4);
        }
        $newNumber = $lastNumber + 1;
        return 'PMT-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}