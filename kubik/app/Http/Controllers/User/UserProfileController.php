<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        if (!user()) {
            return redirect()->route('user.login')->with('error', 'Please login first.');
        }

        $userId = session('user_id');

        // Latest booking
        $latestBooking = Booking::with(['assets.master'])
        ->where('id_user', $userId)
        ->orderBy('created_at', 'desc')
        ->first();


        return view('user.profile.index', compact('latestBooking'));
    }

    public function details()
    {
        if (!user()) {
        return redirect()->route('user.login')->with('error', 'Please login first.');
    }

    $user = \App\Models\User::where('id_user', session('user_id'))->first();

    // Mask phone number → 08**-****-*98
    $maskedPhone = null;
    if ($user->phone_number) {
        $maskedPhone = substr($user->phone_number, 0, 2)
            . str_repeat('*', max(0, strlen($user->phone_number) - 4))
            . substr($user->phone_number, -2);
    }

    return view('user.profile.details', compact('user', 'maskedPhone'));
    }

    public function settings()
    {
    $user = \App\Models\User::find(session('user_id'));

    return view('user.profile.settings', compact('user'));
    }
    public function history()
    {
        return view('user.profile.history');
    }
    

}
