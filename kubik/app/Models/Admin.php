<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable; // (Opsional: Biasanya Admin perlu extend ini untuk Auth, tapi saya ikuti struktur Anda)

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_admin',
        'name',
        'email',
        'password',
        'role', // <--- Kolom role telah ditambahkan di sini
    ];

    protected $hidden = [
        'password',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // 1 admin → banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_admin', 'id_admin');
    }

    // 1 admin → banyak notifikasi admin
    public function notifications()
    {
        return $this->hasMany(AdminNotification::class, 'id_admin', 'id_admin');
    }

    /* ===========================
       ACCESSORS & HELPERS
    ============================ */

    // Hash password otomatis
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Helper: total booking yang disetujui admin
    public function approvedBookings()
    {
        return $this->bookings()->where('status', 'Approved')->count();
    }

    // Helper: notifikasi belum dibaca
    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false)->get();
    }
}