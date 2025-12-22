<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Asset;
use App\Models\AssetMaster;
use App\Models\Booking;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\BookingAsset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class UserBookingControlle extends Controller
{
    public function showForm()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // === BYPASS UNTUK POPUP SUKSES ===
        // Jika session 'booking_success' ada, kita render view kosong saja (atau dengan data dummy)
        // supaya modal sukses bisa muncul tanpa error query keranjang kosong.
        if (session('booking_success')) {
            return view('user.form', [
                'rooms' => collect([]),
                'groupedItems' => []
            ]);
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
                'asset_masters.stock_available', // <--- PENTING: Ambil stok tersedia dari master
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
                    'max_stock' => $item->stock_available, // <--- Simpan max stock ke array
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
        // 1. VALIDASI
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
            // Pastikan method generateBookingId() ada di class ini
            $newBookingId = $this->generateBookingId();

            $startDateTime = $request->start_date . ' ' . $request->start_time . ':00';
            $endDateTime = $request->end_date . ' ' . $request->end_time . ':00';

            // 2. CREATE BOOKING
            $booking = Booking::create([
                'id_booking' => $newBookingId,
                'id_user' => $user_id,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'status' => 'Pending',
            ]);

            // 3. INSERT ASSETS (PIVOT)
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

            // 4. HANDLE FILE UPLOAD
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = $newBookingId . '_' . time() . '.' . $file->getClientOriginalExtension();

                $destinationPath = public_path('uploads/attachments');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);
                $booking->update(['attachment' => $fileName]);
            }

            // 5. HAPUS KERANJANG
            Cart::where('id_user', $user_id)->delete();

            // === 6. NOTIFIKASI ADMIN (FIX UNTUK TRIGGER) ===
            // Pastikan model Admin sudah di-import: use App\Models\Admin;
            // Pastikan model AdminNotification sudah di-import: use App\Models\AdminNotification;

            $userName = session('user_name') ?? 'A User';
            $admins = Admin::all();
            $notifData = [];
            $now = now();

            foreach ($admins as $admin) {
                $notifData[] = [
                    // PENTING: Set 'null' agar kolom ini masuk query SQL.
                    // Trigger database kemudian akan menimpa 'null' ini dengan ID acak.
                    'id_notification' => null,

                    'id_admin' => $admin->id_admin,
                    'message' => "User <b>{$userName}</b> has submitted a Permission with ID: <b class='text-[#F26E21]'>{$newBookingId}</b>.",
                    'is_read' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (!empty($notifData)) {
                AdminNotification::insert($notifData);
            }
            // ======================================

            DB::commit();

            return back()->with('booking_success', $newBookingId);

        } catch (\Exception $e) {
            DB::rollBack();
            // Tampilkan error jika terjadi kegagalan sistem
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ... (Fungsi cancelBooking & generateBookingId biarkan saja, tidak berubah) ...

    public function cancelBooking($id)
    {
        try {
            $booking = Booking::where('id_booking', $id)->firstOrFail();
            if ($booking->id_user != session('user_id')) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }
            if ($booking->status == 'Pending') {
                $booking->update(['status' => 'Canceled']);
                // GANTI DISINI: Kirim ID booking agar bisa dipakai di link See Details
                return redirect()->back()->with('successCanceled', $booking->id_booking);
            } else {
                return redirect()->back()->with('error', 'Booking cannot be canceled (current status: ' . $booking->status . ').');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error canceling booking: ' . $e->getMessage());
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