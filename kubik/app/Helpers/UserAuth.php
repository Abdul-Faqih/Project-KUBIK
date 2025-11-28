<?php

use App\Models\User;
use Illuminate\Support\Facades\Session;

if (!function_exists('user')) {
    function user()
    {
        $id = Session::get('user_id');
        if (!$id) {
            return null;
        }

        return User::where('id_user', $id)->first();
    }
}
