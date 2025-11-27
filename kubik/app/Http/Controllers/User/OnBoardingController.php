<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OnBoardingController extends Controller
{
    public function screen1()
    {
        return view('user.onboarding.screen1');
    }

    public function screen2()
    {
        return view('user.onboarding.screen2');
    }

    public function screen3()
    {
        return view('user.onboarding.screen3');
    }

    public function finish()
    {
        // tandai user sudah pernah onboarding
        Session::put('user_onboarded', true);
        return redirect()->route('user.login');
    }
}
