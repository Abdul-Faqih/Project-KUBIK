<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';
    protected $primaryKey = 'id_type';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_type',
        'name',
        'updated_at',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 type → banyak asset_masters
    public function assetMasters()
    {
        return $this->hasMany(AssetMaster::class, 'id_type', 'id_type');
    }

    public function assets()
    {
        return $this->hasManyThrough(
            Asset::class,        // model anak terakhir
            AssetMaster::class,  // model perantara
            'id_type',           // FK di asset_masters yg mengarah ke types
            'id_master',         // FK di assets yg mengarah ke asset_masters
            'id_type',           // PK di types
            'id_master'          // PK di asset_masters
        );
    }

    /* ===========================
       HELPERS
    ============================ */

    // Helper: total asset master dalam tipe ini
    public function totalAssetMasters()
    {
        return $this->assetMasters()->count();
    }

    // Helper: ambil asset master aktif (stock_available > 0)
    public function availableAssetMasters()
    {
        return $this->assetMasters()->where('stock_available', '>', 0)->get();
    }
}
