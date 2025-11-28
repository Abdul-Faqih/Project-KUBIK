@extends('user.layout.mobile')

@section('title', 'Welcome')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <!-- IMAGE FULL BLEED -->
    <img src="{{ asset('images/onboarding_asset (2).png') }}" class="w-full object-cover">

    <!-- CARD -->
    <div class="bg-white w-full rounded-t-[32px] mt-3 pt-3 px-6 text-center">

        <h1 class="text-2xl font-semibold text-[#F26E21] leading-snug">
            Request & Schedule Your Needs
        </h1>

        <p class="text-base text-[#6A6A6A] mt-1 mb-10">
            Select your preferred needs and schedule, then await verification from the administrator.
        </p>

        <a href="{{ route('user.onboarding.3') }}" class="block w-full border border-[#F26E21] text-[#F26E21]
                       py-3 rounded-xl mt-8 text-base font-medium">
            Next
        </a>

    </div>

@endsection