<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AssetMaster;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Asset;

class HomeController extends Controller
{
    public function index()
    {
        return $this->home();
    }

    // Home Page
    public function home()
    {
        if (!user()) {
            return redirect()->route('user.login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');

        // Ambil booking terbaru user
        $latestBooking = Booking::with(['assets.master'])
            ->where('id_user', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        // --- QUERY HELPER: Ambil Booking yang Approved & Belum Selesai ---
        $bookingQuery = function ($q) {
            $q->select('bookings.id_booking', 'start_time', 'end_time', 'status')
                ->where('status', 'Approved')
                ->where('end_time', '>', now()) // Hanya booking masa depan
                ->orderBy('start_time', 'asc');
        };

        // Availability — ONLY ITEMS TYPE (Load assets.bookings)
        $availability = AssetMaster::with(['assets.bookings' => $bookingQuery, 'type'])
            ->whereHas('type', function ($q) {
                $q->where('name', 'Items');
            })
            ->get();

        // Room Availability (Load assets.bookings)
        $roomAvailability = AssetMaster::with(['assets.bookings' => $bookingQuery, 'type'])
            ->whereHas('type', fn($q) => $q->where('name', 'Rooms'))
            ->get();

        // JSON for item carousel
        $itemsJson = $availability->map(function ($i) {
            return [
                'id_master' => $i->id_master,
                'name' => $i->name,
                'description' => $i->description,
                'image_asset' => $i->image_asset,
                'stock_total' => $i->total,
                'id_type' => $i->id_type,
                'assets' => $i->assets->map(fn($a) => [
                    'status' => $a->status,
                    'bookings' => $a->bookings // <-- Data booking dikirim ke JS
                ]),
            ];
        });

        // JSON for room carousel
        $roomsJson = $roomAvailability->map(function ($i) {
            return [
                'id_master' => $i->id_master,
                'name' => $i->name,
                'description' => $i->description,
                'image_asset' => $i->image_asset,
                'assets' => $i->assets->map(fn($a) => [
                    'status' => $a->status,
                    'bookings' => $a->bookings // <-- Data booking dikirim ke JS
                ]),
                'type' => 'Room'
            ];
        });

        return view('user.home', compact(
            'latestBooking',
            'availability',
            'roomAvailability',
            'itemsJson',
            'roomsJson'
        ));
    }

    // Availability Page
    public function availability(Request $request)
    {
        if (!user()) {
            return redirect()->route('user.login')->with('error', 'Please login first.');
        }

        $search = $request->search;
        $filterType = $request->type;
        $startDate = $request->start_date;
        $startTime = $request->start_time;
        $endDate = $request->end_date;
        $endTime = $request->end_time;

        $types = Type::all();

        // Query Booking Filter
        $bookingQuery = function ($q) {
            $q->select('bookings.id_booking', 'start_time', 'end_time', 'status')
                ->where('status', 'Approved')
                ->where('end_time', '>', now())
                ->orderBy('start_time', 'asc');
        };

        // Load AssetMaster dengan assets dan bookings
        $items = AssetMaster::with(['assets.bookings' => $bookingQuery, 'type'])
            ->when($search, fn($q) => $q->where('name', 'LIKE', "%$search%"))
            ->when($filterType, fn($q) => $q->where('id_type', $filterType))
            ->orderBy('name', 'asc')
            ->get();

        // JSON CLEAN VERSION FOR JAVASCRIPT
        $itemsJson = $items->map(function ($i) {
            return [
                'id_master' => $i->id_master,
                'name' => $i->name,
                'description' => $i->description,
                'image_asset' => $i->image_asset,
                'stock_total' => $i->total,
                'id_type' => $i->id_type,
                'assets' => $i->assets->map(fn($a) => [
                    'status' => $a->status,
                    'bookings' => $a->bookings // <-- Data booking dikirim ke JS
                ]),
            ];
        });

        $cartCount = Cart::where('id_user', session('user_id'))->count();

        return view('user.availability.index', compact(
            'items',
            'types',
            'search',
            'filterType',
            'startDate',
            'startTime',
            'endDate',
            'endTime',
            'itemsJson',
            'cartCount'
        ));
    }

    public function addToCart(Request $request)
    {
        if (!user())
            return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate(['id_master' => 'required']);
        $userId = session('user_id');
        $master = $request->id_master;

        $asset = Asset::where('id_master', $master)
            ->where('status', 'Available')
            ->whereNotIn('id_asset', function ($q) use ($userId) {
                $q->select('id_asset')->from('carts')->where('id_user', $userId);
            })
            ->orderBy('id_asset', 'asc')
            ->first();

        if (!$asset)
            return response()->json(['error' => 'No asset available']);

        Cart::create([
            'id_user' => $userId,
            'id_asset' => $asset->id_asset
        ]);

        return response()->json(['success' => true]);
    }

    public function removeFromCart(Request $request)
    {
        if (!user())
            return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate(['id_master' => 'required']);
        $userId = session('user_id');
        $master = $request->id_master;

        $cartItem = Cart::where('id_user', $userId)
            ->whereIn('id_asset', function ($q) use ($master) {
                $q->select('id_asset')->from('assets')->where('id_master', $master);
            })
            ->orderBy('id', 'desc')
            ->first();

        if ($cartItem)
            $cartItem->delete();

        return response()->json(['success' => true]);
    }

    public function checkCartState(Request $request)
    {
        $request->validate(['id_master' => 'required']);
        $userId = session('user_id');

        $count = Cart::where('id_user', $userId)
            ->whereIn('id_asset', function ($q) use ($request) {
                $q->select('id_asset')->from('assets')->where('id_master', $request->id_master);
            })
            ->count();

        return response()->json(['count' => $count]);
    }

    public function checkTotalCartCount()
    {
        if (!user())
            return response()->json(['count' => 0]);
        $userId = session('user_id');
        $count = Cart::where('id_user', $userId)->count();
        return response()->json(['count' => $count]);
    }

    public function getCartList()
    {
        if (!user())
            return response()->json([], 401);
        $userId = session('user_id');

        $cartItems = Cart::where('id_user', $userId)
            ->join('assets', 'carts.id_asset', '=', 'assets.id_asset')
            ->join('asset_masters', 'assets.id_master', '=', 'asset_masters.id_master')
            ->select(
                'assets.id_asset',
                'assets.id_master',
                'asset_masters.name',
                'asset_masters.id_master as master_id',
                'asset_masters.id_type',
                'asset_masters.stock_available'
            )
            ->orderBy('carts.id', 'asc')
            ->get();

        return response()->json($cartItems);
    }
}