<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'user_notifications';
    protected $primaryKey = 'id_notification';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_notification',
        'id_user',
        'message',
        'is_read',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // Notifikasi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /* ===========================
       HELPERS
    ============================ */

    // Helper: tandai notifikasi sebagai dibaca
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Helper: cek apakah notif sudah dibaca
    public function isRead()
    {
        return (bool) $this->is_read;
    }

    // Helper: ambil waktu tampil format rapi
    public function timeAgo()
    {
        return $this->created_at->diffForHumans();
    }
}