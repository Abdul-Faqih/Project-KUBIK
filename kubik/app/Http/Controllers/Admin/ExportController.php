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
     * Export data booking dengan pemisahan kolom Room dan Item
     */
    public function exportBookings()
    {
        // 1. Load semua relasi yang dibutuhkan:
        // - user & admin
        // - assets -> master -> type (Untuk membedakan mana Room mana Item)
        $bookings = Booking::with(['user', 'admin', 'assets.master.type'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'loan_report_' . Carbon::now()->format('Ymd_His') . '.csv';

        $handle = fopen('php://temp', 'r+');
        fputs($handle, "\xEF\xBB\xBF"); // BOM untuk Excel

        // 2. Header CSV (Dipisah List Room dan List Item)
        fputcsv($handle, [
            'ID',
            'User Name',
            'Admin Name',
            'Status',
            'Submitted At',
            'Start Time',
            'End Time',
            'List Room',  // Kolom Khusus Room
            'List Item'   // Kolom Khusus Item
        ]);

        foreach ($bookings as $b) {

            $rooms = [];
            $items = [];

            // 3. Looping setiap asset dalam booking untuk dipilah
            foreach ($b->assets as $asset) {
                // Format String: (ID) Nama
                $assetString = "({$asset->id_asset}) " . ($asset->master->name ?? 'Unknown');

                // Ambil nama type (asumsi relasi: asset->master->type->name)
                // Kita gunakan str_contains atau stripos untuk cek apakah "Room" atau "Item"
                $typeName = $asset->master->type->name ?? '';

                if (stripos($typeName, 'Room') !== false) {
                    $rooms[] = $assetString;
                } else {
                    // Masukkan ke item jika bukan Room
                    $items[] = $assetString;
                }
            }

            // Gabungkan array menjadi string (dipisah koma atau titik koma)
            $roomList = implode(', ', $rooms);
            $itemList = implode(', ', $items);

            // Format Tanggal
            $submittedAt = $b->created_at ? Carbon::parse($b->created_at)->format('Y-m-d H:i') : '-';
            $startTime = $b->start_time ? Carbon::parse($b->start_time)->format('Y-m-d H:i') : '-';
            $endTime = $b->end_time ? Carbon::parse($b->end_time)->format('Y-m-d H:i') : '-';

            // 4. Masukkan ke CSV
            fputcsv($handle, [
                $b->id_booking,
                $b->user->name ?? 'Unknown User',
                $b->admin->name ?? '-',
                $b->status,
                $submittedAt,
                $startTime,
                $endTime,
                $roomList, // Isi Kolom Room
                $itemList  // Isi Kolom Item
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