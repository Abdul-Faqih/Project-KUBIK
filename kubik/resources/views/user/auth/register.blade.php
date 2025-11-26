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
            <input type="text" name="name"
                class="w-full h-[52px] pl-5 border border-[#CFCFCF] text-[#2A2A2A] rounded-xl
                       placeholder-[#CFCFCF] focus:outline-none focus:border-[#F26E21]"
                placeholder="Insert Your Full Name">
        </div>

        <!-- EMAIL -->
        <div class="w-full relative mb-4">
            <input type="email" name="email"
                class="w-full h-[52px] pl-5 border border-[#CFCFCF] text-[#2A2A2A] rounded-xl
                       placeholder-[#CFCFCF] focus:outline-none focus:border-[#F26E21]"
                placeholder="Insert Your Email">
        </div>

        <!-- PASSWORD -->
        <div class="w-full relative mb-2">
            <input type="password" name="password" id="registerPassword"
                class="w-full h-[52px] pl-5 pr-16 border border-[#CFCFCF] text-[#2A2A2A]
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
        <button type="submit"
            class="w-full bg-[#F26E21] text-white py-3 rounded-xl font-semibold mb-1">
            Sign Up
        </button>

    </form>

    <p class="text-sm text-[#2A2A2A]">
        Already have an account?
        <a href="{{ route('user.login') }}" class="text-[#F26E21]">Log In</a>
    </p>

</div>

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
