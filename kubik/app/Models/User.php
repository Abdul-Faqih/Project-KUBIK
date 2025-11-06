<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'name',
        'email',
        'phone_number',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 user → banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_user', 'id_user');
    }

    // 1 user → banyak notifikasi user
    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'id_user', 'id_user');
    }

    /* ===========================
       ACCESSORS & HELPERS
    ============================ */

    // Encrypt password saat diset
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Helper: total booking user
    public function totalBookings()
    {
        return $this->bookings()->count();
    }

    // Helper: booking aktif user
    public function activeBookings()
    {
        return $this->bookings()->whereIn('status', ['Pending', 'Approved'])->get();
    }
}
