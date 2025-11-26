<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('user.login');
        }

        return view('user.home'); // file nanti kamu isi
    }
}
