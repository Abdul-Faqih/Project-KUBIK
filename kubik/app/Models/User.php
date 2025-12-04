<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = true;         // AUTO INCREMENT
    protected $keyType = 'int';          // INTEGER PK

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'nim',
        'nip',
        'enrollment',
        'program',
        'unit',
        'department'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // AUTO-HASH PASSWORD
    //public function setPasswordAttribute($value)
    //{
        //if (!empty($value)) {
            //$this->attributes['password'] = Hash::make($value);
        //}
    //}

    // RELATIONS
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_user', 'id_user');
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'id_user', 'id_user');
    }
}
