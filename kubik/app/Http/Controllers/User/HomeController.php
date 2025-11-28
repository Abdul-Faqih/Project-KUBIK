<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // ========== AUTH CHECK ==========
        if (!user()) {
            return redirect()->route('user.login')
                ->with('error', 'Please login first.');
        }

        return view('user.home');
    }
}
