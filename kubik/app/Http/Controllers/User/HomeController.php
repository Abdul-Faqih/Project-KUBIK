<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AssetMaster;
use App\Models\Type;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return $this->home(); // ← langsung panggil fungsi home()
    }

    public function home()
    {
        // ===== AUTH CHECK =====
        if (!user()) {
            return redirect()->route('user.login')
                ->with('error', 'Please login first.');
        }

        // Ambil id user
        $userId = session('user_id');

        // Ambil booking terbaru user
        $recent = Booking::where('id_user', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Availability — ambil semua master asset
        // Asset Availability — ONLY ITEMS TYPE
        $availability = AssetMaster::with(['assets', 'type'])
            ->whereHas('type', function ($q) {
                $q->where('name', 'Items');   // <--- filter type items
            })
            ->get();

        //Room Availability
        $roomAvailability = AssetMaster::with(['assets', 'type'])
            ->whereHas('type', fn($q) => $q->where('name', 'Rooms'))
            ->get();

        return view('user.home', compact('recent', 'availability', 'roomAvailability'));
    }

    public function availability(Request $request)
    {
        if (!user()) {
            return redirect()->route('user.login')->with('error', 'Please login first.');
        }

        $search = $request->search;
        $filterType = $request->type; // new

        // Ambil semua type
        $types = Type::all();

        // Query Asset Masters
        $items = AssetMaster::with('assets', 'type')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })
            ->when($filterType, function ($q) use ($filterType) {
                $q->where('id_type', $filterType);
            })
            ->orderBy('name', 'asc')
            ->get();

        return view('user.availability.index', compact('items', 'types', 'search', 'filterType'));
    }


}
