<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id_booking';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_booking',
        'id_user',
        'id_admin',
        'start_time',
        'end_time',
        'return_at',
        'late_return',
        'attachment',
        'note',
        'status',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 booking → milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // 1 booking → milik 1 admin (yang menyetujui)
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    // 1 booking → punya banyak booking_assets
    public function bookingAssets()
    {
        return $this->hasMany(BookingAsset::class, 'id_booking', 'id_booking');
    }

    // 1 booking → punya banyak asset lewat booking_assets
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'booking_assets', 'id_booking', 'id_asset');
    }

    /* ===========================
       HELPERS
    ============================ */

    // Helper: cek apakah booking sedang aktif
    public function isActive()
    {
        return in_array($this->status, ['Pending', 'Approved']);
    }

    // Helper: cek apakah booking sudah selesai
    public function isCompleted()
    {
        return $this->status === 'Completed';
    }

    // Helper: hitung total asset yang dipinjam
    public function totalAssets()
    {
        return $this->assets()->count();
    }

    // Helper: lama pinjam dalam hari
    public function durationDays()
    {
        return Carbon::parse($this->start_time)->diffInDays(Carbon::parse($this->end_time));
    }

    // Helper: cek apakah terlambat
    public function isLate()
    {
        return $this->late_return !== null && $this->late_return > 0;
    }

    // Helper: tampilkan status dengan format label
    public function statusLabel()
    {
        switch ($this->status) {
            case 'Pending': return '🕒 Waiting Approval';
            case 'Approved': return '✅ Approved';
            case 'Rejected': return '❌ Rejected';
            case 'Completed': return '📦 Completed';
            default: return 'Unknown';
        }
    }

    // Helper: update status booking
    public function updateStatus($newStatus)
    {
        $this->update([
            'status' => $newStatus,
            'updated_at' => now(),
        ]);
    }
}
