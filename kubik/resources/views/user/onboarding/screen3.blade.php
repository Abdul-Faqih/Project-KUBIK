@extends('user.layout.mobile')

@section('title', 'Welcome')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <!-- IMAGE FULL BLEED -->
    <img src="{{ asset('images/onboarding_asset (3).png') }}"
         class="w-full object-cover">

    <!-- CARD -->
    <div class="bg-white w-full rounded-t-[32px] mt-3 pt-10 pb-16 px-6 text-center">

        <h1 class="text-2xl font-semibold text-[#F26E21] leading-snug">
            Sign Up or Log In to Get Started!
        </h1>

        <p class="text-base text-[#6A6A6A] mt-10 mb-10">
            Click Sign Up to create a new account or Log In to begin using the app.
        </p>

        <div class="flex justify-between gap-3 mt-8">

            <a href="{{ route('user.register') }}"
               class="w-1/2 text-center bg-[#F26E21] text-white py-3 rounded-xl font-medium">
                Sign Up
            </a>

            <a href="{{ route('user.login') }}"
               class="w-1/2 text-center border border-[#F26E21] text-[#F26E21] py-3 rounded-xl font-medium">
                Log in
            </a>

        </div>

    </div>

@endsection
