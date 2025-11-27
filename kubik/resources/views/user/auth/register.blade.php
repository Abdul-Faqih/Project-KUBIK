@extends('user.layout.mobile')

@section('title', 'Register')

@section('content')

    <div class="flex flex-col items-center mt-16">

        <img src="{{ asset('images/logo_full.png') }}" class="w-[300px] mt-12 mb-6">

        @if(session('error'))
            <p class="text-red-500 text-sm mb-2">{{ session('error') }}</p>
        @endif

        <!-- REGISTER FORM -->
        <form method="POST" action="{{ route('user.register') }}" class="w-full">
            @csrf

            <!-- NAME -->
            <div class="w-full relative mb-4">
                <input type="text" name="name" class="w-full h-[52px] pl-5 border border-[#CFCFCF] text-[#2A2A2A] rounded-xl
                           placeholder-[#CFCFCF] focus:outline-none focus:border-[#F26E21]"
                    placeholder="Insert Your Full Name">
            </div>

            <!-- EMAIL -->
            <div class="w-full relative mb-4">
                <input type="email" name="email" class="w-full h-[52px] pl-5 border border-[#CFCFCF] text-[#2A2A2A] rounded-xl
                           placeholder-[#CFCFCF] focus:outline-none focus:border-[#F26E21]"
                    placeholder="Insert Your Email">
            </div>

            <!-- PASSWORD -->
            <div class="w-full relative mb-2">
                <input type="password" name="password" id="registerPassword" class="w-full h-[52px] pl-5 pr-16 border border-[#CFCFCF] text-[#2A2A2A]
                           rounded-xl placeholder-[#CFCFCF] focus:outline-none focus:border-[#F26E21]"
                    placeholder="Insert Your Password">

                <span id="toggleRegisterPassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#AEAEAE] cursor-pointer">
                    Show
                </span>
            </div>

            <!-- CHECKBOX -->
            <label class="flex items-start mt-1 mb-6 cursor-pointer select-none">
                <input type="checkbox" class="w-4 h-4">
                <span class="ml-2 text-sm text-[#2A2A2A] leading-tight">
                    I have read the <span class="text-[#F26E21]">Terms and Conditions</span> &
                    <span class="text-[#F26E21]">Privacy Policy.</span>
                </span>
            </label>

            <!-- BUTTON -->
            <button type="submit" class="w-full bg-[#F26E21] text-white py-3 rounded-xl font-semibold mb-1">
                Sign Up
            </button>

        </form>

        <p class="text-sm text-[#2A2A2A]">
            Already have an account?
            <a href="{{ route('user.login') }}" class="text-[#F26E21]">Log In</a>
        </p>

    </div>

    @if(session('registered'))
        <!-- OVERLAY -->
        <div id="successPopup" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

            <div class="bg-white rounded-2xl px-6 py-6 w-[300px] text-center shadow-lg">

                <!-- ICON -->
                <div class="w-14 h-14 mx-auto rounded-full bg-green-500 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- TEXT -->
                <h2 class="text-lg font-semibold text-[#2A2A2A]">Registration Successful</h2>
                <p class="text-sm text-[#6A6A6A] mt-1 mb-5">Your account has been successfully created. <br> </p>

                <!-- BUTTON TO LOGIN -->
                <a href="{{ route('user.login') }}" class="block w-full bg-[#F26E21] text-white py-2.5 rounded-xl font-medium">
                    Go to Login
                </a>

                <p id="autoRedirectText" class="text-xs text-[#6A6A6A] mt-2">
                    Redirecting in 5 seconds...
                </p>

            </div>

        </div>

        <script>
            // Auto redirect
            setTimeout(() => {
                window.location.href = "{{ route('user.login') }}";
            }, 5000);
        </script>
    @endif


    <script>
        const regPass = document.getElementById('registerPassword');
        const toggleRegPass = document.getElementById('toggleRegisterPassword');

        toggleRegPass.addEventListener('click', () => {
            const isHidden = regPass.type === 'password';
            regPass.type = isHidden ? 'text' : 'password';
            toggleRegPass.textContent = isHidden ? 'Hide' : 'Show';
        });
    </script>

@endsection