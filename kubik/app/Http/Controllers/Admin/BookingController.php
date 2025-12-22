<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * LIST PAGE
     */
    public function index()
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $bookings = Booking::with(['user', 'admin'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.dashboard.booking', compact('bookings'));
    }

    /**
     * FILTER BOOKING (AJAX)
     */
    public function filter(Request $request)
    {
        if (!admin()) {
            return response()->json(['html' => 'Unauthorized'], 401);
        }

        $query = Booking::with(['user', 'admin']);

        // SEARCH
        if ($request->search) {
            $query->where('id_booking', 'LIKE', "%{$request->search}%")
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%{$request->search}%");
                });
        }

        // STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // SORTING created_at
        $sortOrder = $request->sort === "asc" ? "asc" : "desc";
        $query->orderBy('updated_at', $sortOrder);

        $bookings = $query->get();

        return response()->json([
            'html' => view('admin.dashboard.partials.booking_table', compact('bookings'))->render()
        ]);
    }

    /**
     * PERMISSION DETAIL
     */
    public function show($id_booking)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $booking = Booking::with(['user', 'admin', 'assets'])
            ->where('id_booking', $id_booking)
            ->firstOrFail();

        return view('admin.dashboard.permissions.permission_detail', compact('booking'));
    }

    /**
     * REMOVE ITEM (DETACH ASSET)
     */
    public function removeItem($id_booking, $id_asset)
    {
        if (!admin())
            return redirect()->route('admin.login');

        $booking = Booking::findOrFail($id_booking);

        // Hanya boleh hapus jika status masih Pending
        if ($booking->status !== 'Pending') {
            return back()->with('error', 'Cannot remove items from processed booking.');
        }

        // Cek sisa barang, jika tinggal 1 jangan dihapus (harus reject booking sekalian)
        if ($booking->assets()->count() <= 1) {
            return back()->with('error', 'Cannot remove the last item. Please reject the booking instead.');
        }

        // Hapus relasi asset dari booking ini
        $booking->assets()->detach($id_asset);

        return back()->with('success', 'Item removed from booking list.');
    }

    /**
     * ACCEPT REQUEST
     */
    public function accept(Request $request, $id_booking)
    {
        if (!admin())
            return redirect()->route('admin.login');

        $booking = Booking::where('id_booking', $id_booking)->firstOrFail();

        $booking->status = 'Approved';
        $booking->note = $request->note ?? $booking->note;
        $booking->id_admin = admin()->id_admin; // aman
        $booking->updated_at = now();
        $booking->save();

        return redirect()->route('admin.permissions.detail', $id_booking)
            ->with('success', 'Booking successfully approved!');
    }

    /**
     * REJECT REQUEST
     */
    public function reject(Request $request, $id_booking)
    {
        if (!admin())
            return redirect()->route('admin.login');

        $booking = Booking::where('id_booking', $id_booking)->firstOrFail();

        $booking->status = 'Rejected';
        $booking->note = $request->note ?? $booking->note;
        $booking->id_admin = admin()->id_admin;
        $booking->updated_at = now();
        $booking->save();

        return redirect()->route('admin.permissions.detail', $id_booking)
            ->with('success', 'Booking successfully rejected!');
    }

    /**
     * UPDATE VIA EDIT (STATUS + NOTE)
     */
    public function update(Request $request, $id_booking)
    {
        if (!admin())
            return redirect()->route('admin.login');

        $booking = Booking::where('id_booking', $id_booking)->firstOrFail();

        $booking->status = $request->status;
        $booking->note = $request->note;
        $booking->id_admin = admin()->id_admin;
        $booking->updated_at = now();
        $booking->save();

        return redirect()->route('admin.permissions.detail', $id_booking)
            ->with('success', 'Booking updated successfully!');
    }
}
