<?php

use App\Models\User;
use Illuminate\Support\Facades\Session;

if (!function_exists('user')) {
    function user()
    {
        if (!Session::has('user_id')) {
            return null;
        }

        return User::where('id_user', Session::get('user_id'))->first();
    }
}
