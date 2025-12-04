@extends('user.layout.mobile')

@section('title', 'Login')

@section('content')

<div class="flex flex-col items-center mt-28">

    <!-- LOGO -->
    <img src="{{ asset('images/logo_full.png') }}" class="w-[300px] mt-12 mb-6">

    @if(session('error'))
        <p class="text-red-500 text-sm mb-2">{{ session('error') }}</p>
    @endif

    <!-- LOGIN FORM -->
    <form method="POST" action="{{ route('user.login') }}" class="w-full">
        @csrf

        <!-- EMAIL INPUT -->
        <div class="w-full relative mb-4">
            <input type="email" name="email"
                class="w-full h-[52px] pl-5 border border-[#CFCFCF] text-[#2A2A2A] rounded-xl
                       placeholder-[#CFCFCF] focus:outline-none focus:border-1 focus:border-[#F26E21]"
                placeholder="Insert Your Email">
        </div>

        <!-- PASSWORD INPUT -->
        <div class="w-full relative mb-2">
            <input type="password" name="password" id="loginPassword"
                class="w-full h-[52px] pl-5 pr-16 border border-[#CFCFCF] text-[#2A2A2A]
                       rounded-xl placeholder-[#CFCFCF] focus:outline-none focus:border-[#F26E21]"
                placeholder="Insert Your Password">

            <!-- SHOW/HIDE -->
            <span id="toggleLoginPassword"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#AEAEAE] cursor-pointer">
                Show
            </span>
        </div>

        <div class="w-full text-right pr-1 mb-6">
            <a class="text-[#F26E21] text-sm">Forgot Password?</a>
        </div>

        <!-- LOGIN BUTTON -->
        <button type="submit"
            class="w-full bg-[#F26E21] text-white py-3 rounded-xl text-base font-semibold mb-1">
            Log In
        </button>

    </form>

    <p class="text-sm text-[#2A2A2A]">
        Don't have account?
        <a href="{{ route('user.register.role') }}" class="text-[#F26E21]">Sign Up</a>
    </p>

</div>

<script>
    const loginPass = document.getElementById('loginPassword');
    const toggleLoginPass = document.getElementById('toggleLoginPassword');

    toggleLoginPass.addEventListener('click', () => {
        const isHidden = loginPass.type === 'password';
        loginPass.type = isHidden ? 'text' : 'password';
        toggleLoginPass.textContent = isHidden ? 'Hide' : 'Show';
    });
</script>

@endsection
