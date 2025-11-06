<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Export semua data booking jadi file CSV
     */
    public function exportBookings()
    {
        $bookings = Booking::with('user')->get();

        $filename = 'loan_report_' . Carbon::now()->format('Ymd_His') . '.csv';

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['ID Booking', 'User', 'Status', 'Tanggal Pinjam', 'Tanggal Kembali']);

        foreach ($bookings as $b) {
            fputcsv($handle, [
                $b->id_booking,
                $b->user?->name ?? 'Unknown',
                $b->status,
                $b->start_time,
                $b->return_at,
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
