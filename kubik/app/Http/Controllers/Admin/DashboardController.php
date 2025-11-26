<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * ==============================
     *        DASHBOARD HOME
     * ==============================
     */
    public function home(Request $request)
    {
        // ========== AUTH CHECK ==========
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        // Selected date or today's date
        $selectedDate = $request->date
            ? Carbon::parse($request->date)
            : Carbon::today();

        // Total assets
        $totalAssets = Asset::count();

        // Loan demand (Pending)
        $loanDemand = Booking::where('status', 'Pending')
            ->whereDate('created_at', $selectedDate)
            ->count();

        // Active loan (Approved)
        $activeLoan = Booking::where('status', 'Approved')
            ->whereDate('created_at', $selectedDate)
            ->count();

        // Active borrowed assets
        $activeAssets = Asset::where('status', 'Borrowed')
            ->whereDate('updated_at', $selectedDate)
            ->count();

        // Recent activities
        $activities = Booking::with('user')
            ->whereDate('created_at', $selectedDate)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->is_late = false;

                if (
                    $item->status === 'Completed' &&
                    $item->end_time &&
                    $item->return_at
                ) {
                    $diffHours = Carbon::parse($item->end_time)
                        ->diffInHours(Carbon::parse($item->return_at), false);

                    $item->is_late = $diffHours >= 1;
                }

                return $item;
            });

        // ========== Asset Distribution Charts ==========
        $assetLabels = ['Rooms', 'Items'];
        $assetCounts = [
            Asset::whereHas('master.type', fn($q) => $q->where('name', 'Rooms'))->count(),
            Asset::whereHas('master.type', fn($q) => $q->where('name', 'Items'))->count(),
        ];

        // ========== Loan Activity Chart (Last 6 months) ==========
        $loanMonths = collect(range(1, 6))->map(fn($m) => Carbon::now()->subMonths(6 - $m)->format('M'));

        $loanBorrowing = [];
        $loanRejecting = [];
        $loanUsed = [];
        $loanLateReturning = [];

        foreach (range(1, 6) as $i) {
            $month = Carbon::now()->subMonths(6 - $i);

            // Completed loans
            $loanBorrowing[] = Booking::where('status', 'Completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Rejected loans
            $loanRejecting[] = Booking::where('status', 'Rejected')
                ->whereYear('updated_at', $month->year)
                ->whereMonth('updated_at', $month->month)
                ->count();

            // Used assets
            $loanUsed[] = DB::table('booking_assets')
                ->join('bookings', 'bookings.id_booking', '=', 'booking_assets.id_booking')
                ->whereIn('bookings.status', ['Approved', 'Completed'])
                ->whereMonth('bookings.created_at', $month->month)
                ->whereYear('bookings.created_at', $month->year)
                ->distinct('booking_assets.id_asset')
                ->count('booking_assets.id_asset');

            // Late returning
            $loanLateReturning[] = Booking::where('status', 'Completed')
                ->whereNotNull('end_time')
                ->whereNotNull('return_at')
                ->whereYear('updated_at', $month->year)
                ->whereMonth('updated_at', $month->month)
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

    /**
     * ==============================
     *        ASSETS PAGE
     * ==============================
     */
    public function assets()
    {
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        $types = Type::orderBy('id_type')->get();
        $categories = Category::orderBy('id_category')->get();
        $assets = Asset::with(['master.type', 'master.category'])
            ->orderBy('id_asset')
            ->get();

        return view('admin.dashboard.assets', compact('types', 'categories', 'assets'));
    }

    /**
     * ==============================
     *        FILTER ASSETS (AJAX)
     * ==============================
     */
    public function filterAssets(Request $request)
    {
        if (!admin()) {
            return response()->json(['html' => 'Unauthorized']);
        }

        $query = Asset::with(['master.type', 'master.category']);

        // Search
        if ($request->search) {
            $query->where('id_asset', 'like', "%{$request->search}%")
                ->orWhereHas(
                    'master',
                    fn($q) =>
                    $q->where('name', 'like', "%{$request->search}%")
                );
        }

        // Filter type
        if ($request->type) {
            $query->whereHas(
                'master.type',
                fn($q) =>
                $q->where('name', $request->type)
            );
        }

        // Filter category
        if ($request->category) {
            $query->whereHas(
                'master.category',
                fn($q) =>
                $q->where('name', $request->category)
            );
        }

        $assets = $query->orderBy('id_asset')->get();

        return response()->json([
            'html' => view('admin.dashboard.partials.asset_table', compact('assets'))->render()
        ]);
    }
}
