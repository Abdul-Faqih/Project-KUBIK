<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $table = 'admin_notifications';
    protected $primaryKey = 'id_notification';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_notification',
        'id_admin',
        'message',
        'is_read',
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // Notifikasi milik satu admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    /* ===========================
       HELPERS
    ============================ */

    // Tandai notifikasi sebagai dibaca
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Cek apakah notif sudah dibaca
    public function isRead()
    {
        return (bool) $this->is_read;
    }

    // Helper: tampilkan waktu relatif (misal "2 hours ago")
    public function timeAgo()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : '-';
    }
}
