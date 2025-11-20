<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Type;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        // Pastikan tanggal diambil dari query, default hari ini
        $selectedDate = $request->input('date')
            ? Carbon::parse($request->input('date'))
            : Carbon::today();

        // Total semua aset (tidak dibatasi tanggal)
        $totalAssets = Asset::count();

        // Total permintaan peminjaman (Pending) di tanggal terpilih
        $loanDemand = Booking::where('status', 'Pending')
            ->whereDate('created_at', $selectedDate)
            ->count();

        // Total peminjaman aktif (Approved) di tanggal terpilih
        $activeLoan = Booking::where('status', 'Approved')
            ->whereDate('created_at', $selectedDate)
            ->count();

        // Total aset yang sedang dipinjam (Borrowed) di tanggal terpilih
        $activeAssets = Asset::where('status', 'Borrowed')
            ->whereDate('updated_at', $selectedDate)
            ->count();

        // Ambil aktivitas di tanggal terpilih
        $activities = Booking::with('user')
            ->whereDate('created_at', $selectedDate)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                // Tentukan apakah pengembalian terlambat
                $item->is_late = false;
                if ($item->status === 'Completed' && $item->end_time && $item->return_at) {
                    $diffHours = Carbon::parse($item->end_time)
                        ->diffInHours(Carbon::parse($item->return_at), false);
                    $item->is_late = $diffHours >= 1;
                }
                return $item;
            });

        // ========== Asset Distribution ==========
        $assetLabels = ['Rooms', 'Items'];
        $assetCounts = [
            Asset::whereHas('master.type', fn($q) => $q->where('name', 'Rooms'))->count(),
            Asset::whereHas('master.type', fn($q) => $q->where('name', 'Items'))->count(),
        ];

        // ========== Loan Activities ==========
        $loanMonths = collect(range(1, 6))->map(fn($m) => Carbon::now()->subMonths(6 - $m)->format('M'));
        $loanBorrowing = [];
        $loanRejecting = [];
        $loanUsed = [];
        $loanLateReturning = [];

        foreach (range(1, 6) as $i) {
            $month = Carbon::now()->subMonths(6 - $i);

            $loanBorrowing[] = Booking::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->where('status', 'Completed')
                ->count();

            $loanRejecting[] = Booking::whereMonth('updated_at', $month->month)
                ->whereYear('updated_at', $month->year)
                ->where('status', 'Rejected')
                ->count();

            $loanUsed[] = DB::table('booking_assets')
                ->join('bookings', 'bookings.id_booking', '=', 'booking_assets.id_booking')
                ->whereIn('bookings.status', ['Approved', 'Completed'])
                ->whereMonth('bookings.created_at', $month->month)
                ->whereYear('bookings.created_at', $month->year)
                ->distinct('booking_assets.id_asset')
                ->count('booking_assets.id_asset');

            $loanLateReturning[] = Booking::where('status', 'Completed')
                ->whereMonth('updated_at', $month->month)
                ->whereYear('updated_at', $month->year)
                ->whereNotNull('end_time')
                ->whereNotNull('return_at')
                ->whereRaw('TIMESTAMPDIFF(HOUR, end_time, return_at) >= 1')
                ->count();
        }

        return view('admin.dashboard.home', compact(
            'selectedDate',
            'totalAssets',
            'loanDemand',
            'activeLoan',
            'activeAssets',
            'activities',
            'assetLabels',
            'assetCounts',
            'loanMonths',
            'loanBorrowing',
            'loanRejecting',
            'loanUsed',
            'loanLateReturning'
        ));
    }

public function assets()
{
    $types = Type::orderBy('id_type')->get();
    $categories = Category::orderBy('id_category')->get();
    $assets = Asset::with(['master.type', 'master.category'])->get();
    
    return view('admin.dashboard.assets', compact('types', 'categories', 'assets'));
}
public function filterAssets(Request $request)
{
    $query = Asset::with(['master.type', 'master.category']);

    // Pencarian (ID asset atau nama master)
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('id_asset', 'like', "%$search%")
              ->orWhereHas('master', fn($q) => $q->where('name', 'like', "%$search%"));
    }

    // Filter berdasarkan type
    if ($request->filled('type')) {
        $query->whereHas('master.type', fn($q) => $q->where('name', $request->type));
    }

    // Filter berdasarkan category
    if ($request->filled('category')) {
        $query->whereHas('master.category', fn($q) => $q->where('name', $request->category));
    }

    $assets = $query->get();

    return response()->json([
        'html' => view('admin.dashboard.partials.asset_table', compact('assets'))->render(),
    ]);
}

}