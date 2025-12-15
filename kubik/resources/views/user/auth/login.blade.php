@extends('user.layout.mobile')

@section('title', 'Login')

@section('content')

    <div class="flex flex-col items-center mt-28">

        <img src="{{ asset('images/logo_full.png') }}" class="w-[300px] mt-12 mb-6">

        {{-- BAGIAN INI DIHAPUS (Pesan Error Teks Biasa) --}}
        {{-- @if(session('error'))
        <p class="text-red-500 text-sm mb-2">{{ session('error') }}</p>
        @endif --}}

        {{-- Tambahkan ID pada form untuk validasi JS --}}
        <form id="loginForm" method="POST" action="{{ route('user.login') }}" class="w-full">
            @csrf

            <div class="w-full relative mb-4">
                {{-- Tambahkan ID pada input email --}}
                <input type="email" name="email" id="email" class="w-full h-[52px] pl-5 border border-[#CFCFCF] text-[#2A2A2A] rounded-xl
                                placeholder-[#CFCFCF] focus:outline-none focus:border-1 focus:border-[#F26E21]"
                    placeholder="Insert Your Email">
            </div>

            <div class="w-full relative mb-2">
                <input type="password" name="password" id="loginPassword" class="w-full h-[52px] pl-5 pr-16 border border-[#CFCFCF] text-[#2A2A2A]
                                rounded-xl placeholder-[#CFCFCF] focus:outline-none focus:border-[#F26E21]"
                    placeholder="Insert Your Password">

                <span id="toggleLoginPassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#AEAEAE] cursor-pointer">
                    Show
                </span>
            </div>

            <div class="w-full text-right pr-1 mb-6">
                <a class="text-[#F26E21] text-sm">Forgot Password?</a>
            </div>

            {{-- UBAH DISINI: type="button" dan onclick="validateLogin()" --}}
            <button type="button" onclick="validateLogin()"
                class="w-full bg-[#F26E21] text-white py-3 rounded-xl text-base font-semibold mb-1">
                Log In
            </button>

        </form>

        <p class="text-sm text-[#2A2A2A]">
            Don't have account?
            <a href="{{ route('user.register.role') }}" class="text-[#F26E21]">Sign Up</a>
        </p>

    </div>

    {{-- =========================================== --}}
    {{-- TOAST NOTIFICATION (Hidden by default) --}}
    {{-- =========================================== --}}
    <div id="toast"
        class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-full shadow-lg z-50 transition-all duration-300 opacity-0 pointer-events-none translate-y-[-20px] flex items-center gap-2">
        {{-- Icon Tanda Seru / Warning --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span id="toast-message" class="text-sm font-semibold">Error Message!</span>
    </div>

    <script>
        // --- SHOW/HIDE PASSWORD LOGIC ---
        const loginPass = document.getElementById('loginPassword');
        const toggleLoginPass = document.getElementById('toggleLoginPassword');

        toggleLoginPass.addEventListener('click', () => {
            const isHidden = loginPass.type === 'password';
            loginPass.type = isHidden ? 'text' : 'password';
            toggleLoginPass.textContent = isHidden ? 'Hide' : 'Show';
        });

        // --- TOAST LOGIC ---
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');

            toastMsg.innerText = message;
            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');

            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');
            }, 3000); // Hilang setelah 3 detik
        }

        // --- VALIDASI CLIENT SIDE (NEW) ---
        function validateLogin() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('loginPassword').value;

            if (!email || !password) {
                showToast("Please fill all fields");
            } else {
                document.getElementById('loginForm').submit();
            }
        }

        // --- CEK SESSION ERROR DARI LARAVEL ---
        // Jika controller mengirim redirect()->with('error', 'Pesan Error'), maka toast muncul otomatis
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                showToast("{{ session('error') }}");
            });
        @endif
    </script>

@endsection