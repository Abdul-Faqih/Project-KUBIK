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

        return back()->with('error', 'Your email or password is incorrect!!');
    }

    // Logout
    public function logout()
    {
        Session::forget(['admin_id', 'admin_name']);

        return redirect()->route('admin.login');
    }

    // 1. Show Add Admin Form
    public function showCreate()
    {
        // Generate Simple CAPTCHA (4 angka acak)
        $captcha = rand(1000, 9999);

        // Simpan kode di session untuk validasi nanti
        session(['admin_register_captcha' => $captcha]);

        return view('admin.dashboard.management.add_admin', compact('captcha'));
    }

    // 2. Store New Admin
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:admins,email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@pradita.ac.id')) {
                        $fail('The email must be a valid @pradita.ac.id address.');
                    }
                },
            ],
            // Tambahkan 'confirmed' untuk mengecek password_confirmation
            'password' => 'required|string|min:6|confirmed',
            // Validasi Captcha
            'captcha' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != session('admin_register_captcha')) {
                        $fail('Incorrect security code. Please try again.');
                    }
                },
            ],
        ]);

        // Hapus session captcha setelah validasi sukses
        session()->forget('admin_register_captcha');

        // Generate ID Random
        $randomId = rand(100000000, 999999999);

        // Create Admin
        Admin::create([
            'id_admin' => $randomId,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Admin',
        ]);

        return redirect()->route('admin.dashboard.admin_management')
            ->with('success', 'New admin has been registered successfully!');
    }
}
