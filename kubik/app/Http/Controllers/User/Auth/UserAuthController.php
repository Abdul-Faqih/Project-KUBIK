<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Penting untuk keamanan password
use Illuminate\Support\Facades\Session;

class UserAuthController extends Controller
{
    /* ==========================
                LOGIN
    ========================== */

    public function showLogin()
    {
        // Cek jika user sudah login (asumsi helper user() sudah anda buat)
        // Jika helper user() belum ada, ganti jadi: if(Session::has('user_id'))
        if (Session::has('user_id')) {
            return redirect()->route('user.home');
        }

        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek user dan password hash
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid email or password!');
        }

        Session::put('user_id', $user->id_user);
        Session::put('user_name', $user->name);

        return redirect()->route('user.home');
    }

    /* ==========================
            REGISTER FLOW
       (SELECT ROLE → FORM)
    ========================== */

    // 1. SELECT ROLE PAGE
    public function selectRole()
    {
        return view('user.auth.register_role');
    }

    // 2. OPEN REGISTER FORM (GET & POST handled here)
    public function createRegisterForm(Request $request)
    {
        // A. Jika method POST (dari halaman Select Role)
        if ($request->isMethod('post')) {
            $request->validate([
                'selected_role' => 'required|in:Student,Lecturer,Staff'
            ]);
            session(['register_role' => $request->selected_role]);
        }

        // B. Ambil Role dari Session
        $role = session('register_role');

        // Jika user tembak URL tanpa pilih role, tendang balik
        if (!$role) {
            return redirect()->route('user.register.role');
        }

        // C. Data Dropdown (Disimpan di sini agar View bersih)
        $programs = [
            'Accounting',
            'Architecture',
            'Business Information System',
            'Civil Engineering',
            'Culinary Arts',
            'Hospitality & Tourism',
            'Informatics',
            'Information Systems',
            'Information Technology',
            'Interior Design',
            'Management',
            'Urban Planning',
            'Visual Communication Design'
        ];
        sort($programs); // Urutkan A-Z

        $units = [
            'Academic Administration',
            'Admission',
            'Facilities',
            'Finance',
            'Human Resources',
            'IT Support',
            'Library',
            'Marketing',
            'Procurement',
            'Security',
            'Student Affairs'
        ];
        sort($units);

        $departments = [
            'Academic',
            'Communication',
            'Finance',
            'HR',
            'IT',
            'Informatics',
            'Information Systems',
            'Management',
            'Marketing'
        ];
        sort($departments);

        // --- TAMBAHAN: GENERATE CAPTCHA (Angka Random 6 Digit) ---
        $captcha = rand(100000, 999999);
        // Simpan hasil ke session untuk divalidasi nanti
        session(['captcha_code' => $captcha]);

        // D. Tampilkan View (Kirim $captcha ke view)
        return view('user.auth.register_form', compact('role', 'programs', 'units', 'departments', 'captcha'));
    }

    // 3. SUBMIT FINAL REGISTER
    public function submitRegister(Request $request)
    {
        $role = session('register_role');

        if (!$role) {
            return redirect()->route('user.register.role');
        }

        // BASIC VALIDATION
        $rules = [
            'name' => 'required|max:100',
            'phone_number' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'captcha' => 'required', // --- TAMBAHAN: Rule Captcha wajib diisi
        ];

        // ROLE SPECIFIC VALIDATION
        if ($role === 'Student') {
            $rules['nim'] = 'required';
            $rules['enrollment'] = 'required';
            $rules['program'] = 'required';
        } elseif ($role === 'Lecturer') {
            $rules['nip'] = 'required';
        } elseif ($role === 'Staff') {
            $rules['nip'] = 'required';
            $rules['unit'] = 'required';
            $rules['department'] = 'required';
        }

        $validated = $request->validate($rules);

        // --- TAMBAHAN: VALIDASI CAPTCHA ---
        // Cek apakah input user sama dengan session yg dibuat di halaman form
        if ($request->captcha != session('captcha_code')) {
            return back()->withErrors(['captcha' => 'Incorrect CAPTCHA code! Please try again.'])->withInput();
        }

        // BUILD USER DATA
        $data = [
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // PENTING: Password di-hash!
            'role' => $role,
        ];

        if ($role === 'Student') {
            $data['nim'] = $validated['nim'];
            $data['enrollment'] = $validated['enrollment'];
            $data['program'] = $validated['program'];
        } elseif ($role === 'Lecturer') {
            $data['nip'] = $validated['nip'];
        } elseif ($role === 'Staff') {
            $data['nip'] = $validated['nip'];
            $data['unit'] = $validated['unit'];
            $data['department'] = $validated['department'];
        }

        // SAVE TO DATABASE
        User::create($data);

        // --- UPDATE LOGIC UNTUK POPUP ---

        // JANGAN hapus session role dulu, karena kita redirect back ke form.
        // session()->forget('register_role'); 
        // Hapus session captcha setelah dipakai
        session()->forget('captcha_code');

        // Redirect kembali ke form dengan trigger sukses untuk popup
        return redirect()->back()->with('register_success', true);
    }

    /* ==========================
                LOGOUT
    ========================== */

    public function logout()
    {
        Session::forget(['user_id', 'user_name']);
        // Hapus session role juga saat logout biar bersih
        Session::forget('register_role');

        return redirect()->route('user.login');
    }
}