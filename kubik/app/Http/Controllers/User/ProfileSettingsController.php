<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileSettingsController extends Controller
{
    /**
     * Jurus 1: Constructor Middleware
     * Memaksa controller ini memuat middleware auth, tidak peduli apa settingan di web.php
     */

    /**
     * Jurus 2: Cek Manual di Index
     */
    public function index()
    {
        // Cek paksa: Apakah ada user login?
        if (!Auth::check()) {
            // Kalau tidak ada, tendang ke login
            return redirect()->route('user.login')->with('error', 'Sesi habis, silakan login kembali.');
        }

        $user = Auth::user();

        // Cek ganda: Pastikan variabel $user benar-benar ada isinya sebelum dikirim
        if (!$user) {
             return redirect()->route('user.login');
        }

        return view('user.profile.settings', compact('user'));
    }

    // ... (Fungsi phoneForm, updatePhone, passwordForm, updatePassword biarkan sama seperti sebelumnya) ...
    // Pastikan copy-paste bagian bawahnya dari kode sebelumnya atau biarkan saja jika sudah ada.
    
    // Saya tulis ulang versi ringkasnya biar kamu tinggal copy-paste ALL FILE:

    public function phoneForm()
    {
        $user = Auth::user();
        return view('user.profile.phone', compact('user'));
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number,' . Auth::id()],
        ]);
        
        $user = Auth::user();
        $user->phone_number = $request->phone_number;
        $user->save();

        return redirect()->route('user.settings.index')->with('success', 'Phone number has been updated successfully!');
    }

    public function passwordForm()
    {
        return view('user.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided current password does not match our records.'],
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.settings.index')->with('success', 'Password has been updated successfully!');
    }
}