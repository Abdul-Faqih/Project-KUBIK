<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Session;

if (!function_exists('admin')) {

    /**
     * Ambil data admin yang sedang login via Session
     */
    function admin()
    {
        if (!Session::has('admin_id')) {
            return null;
        }

        return Admin::where('id_admin', Session::get('admin_id'))->first();
    }
}
