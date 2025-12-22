<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Asset extends Model
{
    use HasFactory;
    use LogsActivity; // <--- Pasang Trait

    protected $table = 'assets';
    protected $primaryKey = 'id_asset';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_asset',
        'id_master',
        'status',
        'condition',
        'updated_at',
    ];

    // Konfigurasi Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id_master', 'status', 'condition']) // Kolom yang dicatat perubahannya
            ->logOnlyDirty() // Hanya catat jika ada yang berubah
            ->dontSubmitEmptyLogs()
            ->useLogName('asset'); // Nama log (opsional, memudahkan filter)
    }

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 asset → milik 1 asset_master
    public function master()
    {
    return $this->belongsTo(AssetMaster::class, 'id_master', 'id_master');
    }
    
    // 1 asset → bisa ada di banyak booking lewat booking_assets
    public function booking()
    {
        return $this->hasMany(BookingAsset::class, 'id_asset', 'id_asset');
    }

    public function bookings()
    {
        // Relasi ke Booking melalui tabel pivot 'booking_assets'
        return $this->belongsToMany(Booking::class, 'booking_assets', 'id_asset', 'id_booking');
    }
    
    /* ===========================
       HELPERS
    ============================ */

    // Helper: cek apakah asset sedang dipinjam
    public function isBorrowed()
    {
        return $this->status === 'Borrowed';
    }

    // Helper: ubah status asset ke Available
    public function markAvailable()
    {
        $this->update([
            'status' => 'Available',
        ]);
    }

    // Helper: ubah status asset ke Borrowed
    public function markBorrowed()
    {
        $this->update([
            'status' => 'Borrowed',
        ]);
    }

    // Helper: ubah kondisi asset
    public function updateCondition($condition)
    {
        $this->update([
            'condition' => $condition,
        ]);
    }
}
