<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAsset extends Model
{
    use HasFactory;

    protected $table = 'booking_assets';
    public $timestamps = false;

    protected $fillable = [
        'id_booking',
        'id_asset',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // Satu relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }

    // Satu relasi ke Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_asset', 'id_asset');
    }

    /* ===========================
       HELPERS
    ============================ */

    // Helper: ambil info ringkas aset dalam booking ini
    public function assetSummary()
    {
        return $this->asset
            ? "{$this->asset->id_asset} ({$this->asset->status})"
            : 'Asset not found';
    }

    // Helper: ambil nama booking untuk keperluan laporan
    public function bookingCode()
    {
        return $this->booking ? $this->booking->id_booking : 'N/A';
    }
}
