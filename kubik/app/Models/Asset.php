<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

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

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 asset → milik 1 asset_master
    public function master()
    {
        return $this->belongsTo(AssetMaster::class, 'id_master', 'id_master');
    }

    // 1 asset → bisa ada di banyak booking lewat booking_assets
    public function bookingAssets()
    {
        return $this->hasMany(BookingAsset::class, 'id_asset', 'id_asset');
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
