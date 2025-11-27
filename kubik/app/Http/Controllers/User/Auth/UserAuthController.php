<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid email or password!');
        }

        Session::put('user_id', $user->id_user);
        Session::put('user_name', $user->name);

        return redirect()->route('user.home');
    }

    public function showRegister()
    {
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return redirect()->route('user.register')->with('registered', true);
    }

    public function logout()
    {
        Session::forget(['user_id', 'user_name']);
        return redirect()->route('user.login');
    }
}
