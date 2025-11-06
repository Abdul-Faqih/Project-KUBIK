<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     */
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_id', $admin->id_admin);
            Session::put('admin_name', $admin->name);

            return redirect()->route('admin.dashboard.home');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    /**
     * Tampilkan halaman register admin
     */
    public function showRegister()
    {
        return view('admin.auth.register');
    }

    /**
     * Proses registrasi admin baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Session::forget(['admin_id', 'admin_name']);
        return redirect()->route('admin.login');
    }
}
