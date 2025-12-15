<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Asset;
use Carbon\Carbon;

class UpdateAssetStatus extends Command
{
    protected $signature = 'assets:update-status';
    protected $description = 'Update status asset: Borrowed saat mulai, Available saat Completed';

    public function handle()
    {
        // 1. Set Waktu ke WIB
        $now = Carbon::now('Asia/Jakarta');
        $nowStr = $now->toDateTimeString();

        $this->info("------------------------------------------------");
        $this->info("Current Time (WIB): " . $nowStr);

        // =========================================================
        // SKENARIO 2 (DULUAN): KEMBALIKAN ASET (Status Booking Completed)
        // =========================================================
        // Kita jalankan ini DULUAN agar jika ada konflik, Skenario 1 (Start) yang akan menimpa hasilnya.
        
        $bookingsCompleted = Booking::where('status', 'Completed')
            ->with('bookingAssets') 
            ->get();

        foreach ($bookingsCompleted as $booking) {
            foreach ($booking->bookingAssets as $bookingAsset) {
                
                $assetId = trim($bookingAsset->id_asset);

                // CEK PENGAMAN: Apakah aset ini sedang dipakai oleh booking LAIN yang aktif?
                // Jika ya, JANGAN diubah jadi Available.
                $isCurrentlyActive = Booking::where('status', 'Approved')
                    ->where('id_booking', '!=', $booking->id_booking) // Bukan booking ini
                    ->where('start_time', '<=', $nowStr)
                    ->where('end_time', '>', $nowStr) // Masih dalam periode pinjam
                    ->whereHas('bookingAssets', function($q) use ($assetId) {
                        $q->where('id_asset', $assetId);
                    })
                    ->exists();

                if ($isCurrentlyActive) {
                    // Skip aset ini, karena sedang dipinjam orang lain
                    continue; 
                }

                // Jika aman, baru ubah ke Available
                $affected = Asset::where('id_asset', $assetId)
                    ->where('status', '!=', 'Available')
                    ->update(['status' => 'Available']);

                if ($affected > 0) {
                    $this->info(" -> [END] Asset {$assetId} is now AVAILABLE.");
                }
            }
        }

        // =========================================================
        // SKENARIO 1 (BELAKANGAN): START PINJAM (UBAH KE BORROWED)
        // =========================================================
        
        $bookingsToStart = Booking::where('status', 'Approved')
            ->where('start_time', '<=', $nowStr)
            ->with('bookingAssets')
            ->get();

        $updatedCount = 0;

        foreach ($bookingsToStart as $booking) {
            
            // [DEBUG] Validasi relasi
            if ($booking->bookingAssets->isEmpty()) {
                // $this->warn(" -> Booking {$booking->id_booking} has NO ASSETS linked.");
                continue;
            }

            foreach ($booking->bookingAssets as $bookingAsset) {
                
                $assetId = trim($bookingAsset->id_asset); 

                // Langsung update ke tabel assets
                $affected = Asset::where('id_asset', $assetId)
                    ->where('status', '!=', 'Borrowed')
                    ->update(['status' => 'Borrowed']);
                
                if ($affected > 0) {
                    $this->info(" -> [START] Asset {$assetId} is now BORROWED.");
                    $updatedCount++;
                }
            }
        }

        if ($updatedCount == 0 && $bookingsToStart->count() > 0) {
            // Log opsional
        }

        $this->info("------------------------------------------------");
    }
}