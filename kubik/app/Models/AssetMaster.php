<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMaster extends Model
{
    use HasFactory;

    protected $table = 'asset_masters';
    protected $primaryKey = 'id_master';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_master',
        'name',
        'description',
        'image_asset',
        'id_category',
        'id_type',
        'stock_total',
        'stock_available',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 asset master → banyak assets
    public function assets()
    {
        return $this->hasMany(Asset::class, 'id_master', 'id_master');
    }

    // 1 asset master → milik 1 kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    // 1 asset master → milik 1 type
    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type', 'id_type');
    }

    /* ===========================
       HELPERS
    ============================ */

    // Helper: ambil jumlah asset fisik dari asset table
    public function totalAssets()
    {
        return $this->assets()->count();
    }

    // Helper: ambil jumlah asset tersedia
    public function availableAssets()
    {
        return $this->assets()->where('status', 'Available')->count();
    }

    // Helper: cek apakah asset masih bisa dipinjam
    public function isAvailable()
    {
        return $this->stock_available > 0;
    }

    // Helper: update stock_available berdasarkan jumlah asset di tabel assets
    public function refreshStockAvailable()
    {
        $this->stock_available = $this->availableAssets();
        $this->save();
    }
}
