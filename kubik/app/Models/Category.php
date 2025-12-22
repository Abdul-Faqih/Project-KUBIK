<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use HasFactory;
    use LogsActivity; // <--- Pasang Trait

    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_category',
        'name',
        'updated_at',
    ];

    // Konfigurasi Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name']) // Catat jika nama kategori berubah
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('category');
    }

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 category → banyak asset_masters
    public function assetMasters()
    {
        return $this->hasMany(AssetMaster::class, 'id_category', 'id_category');
    }

    public function assets()
    {
        return $this->hasManyThrough(
            Asset::class,        // model akhir
            AssetMaster::class,  // model perantara
            'id_category',       // FK di asset_masters yg menuju categories
            'id_master',         // FK di assets yg menuju asset_masters
            'id_category',       // PK di categories
            'id_master'          // PK di asset_masters
        );
    }

    /* ===========================
       HELPERS
    ============================ */

    // Helper: total asset master di kategori ini
    public function totalAssetMasters()
    {
        return $this->assetMasters()->count();
    }

    // Helper: ambil semua asset master aktif (stock tersedia > 0)
    public function availableAssetMasters()
    {
        return $this->assetMasters()->where('stock_available', '>', 0)->get();
    }
}
