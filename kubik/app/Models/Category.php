<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

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
