<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        // Jika admin sudah login → langsung ke dashboard
        if (admin()) {
            return redirect()->route('admin.dashboard.home');
        }

        return view('admin.auth.login');
    }

    // Login process
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            Session::put('admin_id', $admin->id_admin);
            Session::put('admin_name', $admin->name);

            return redirect()->route('admin.dashboard.home');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // Logout
    public function logout()
    {
        Session::forget(['admin_id', 'admin_name']);

        return redirect()->route('admin.login');
    }
}
