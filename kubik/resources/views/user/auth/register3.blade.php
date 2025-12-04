@extends('user.layout.mobile')

@section('title', 'Register – Step 3')

@section('content')

<div class="px-6 mt-10">

    {{-- BACK --}}
    <a href="{{ route('user.register.step2') }}"
       class="material-symbols-rounded text-[28px] text-[#2A2A2A] mb-4 inline-block">
        arrow_back
    </a>

    {{-- STEP INDICATOR --}}
    <div class="flex gap-2 mb-6">
        <div class="w-3 h-3 rounded-full bg-[#CFCFCF]"></div>
        <div class="w-3 h-3 rounded-full bg-[#CFCFCF]"></div>
        <div class="w-3 h-3 rounded-full bg-[#F26E21]"></div>
    </div>

    <h1 class="text-xl font-semibold text-[#2A2A2A] mb-4">Create Your Account</h1>

    <form action="{{ route('user.register.step3') }}" method="POST">
        @csrf

        <input type="email" name="email" class="input-auth mb-4" placeholder="Email" required>
        <input type="password" name="password" class="input-auth mb-4" placeholder="Password" required>
        <input type="password" name="password_confirm" class="input-auth mb-6" placeholder="Confirm Password" required>

        {{-- CHECKBOX --}}
        <label class="flex items-start cursor-pointer mb-6">
            <input type="checkbox" name="agree" class="w-4 h-4 mt-1" required>
            <span class="ml-2 text-sm leading-tight text-[#2A2A2A]">
                I have read the
                <span class="text-[#F26E21]">Terms and Conditions</span> &
                <span class="text-[#F26E21]">Privacy Policy.</span>
            </span>
        </label>

        <button type="submit"
                class="w-full bg-[#22C55E] text-white py-3 rounded-xl font-semibold">
            Sign Up
        </button>
    </form>

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
            <p class="text-sm text-[#6A6A6A] mt-1 mb-5">
                Your account has been successfully created.
            </p>

            <!-- BUTTON TO LOGIN -->
            <a href="{{ route('user.login') }}"
               class="block w-full bg-[#F26E21] text-white py-2.5 rounded-xl font-medium">
                Go to Login
            </a>

            <p id="autoRedirectText" class="text-xs text-[#6A6A6A] mt-2">
                Redirecting in 5 seconds...
            </p>

        </div>

    </div>

    <script>
        // Auto redirect after 5 seconds
        setTimeout(() => {
            window.location.href = "{{ route('user.login') }}";
        }, 5000);
    </script>
@endif

@endsection
