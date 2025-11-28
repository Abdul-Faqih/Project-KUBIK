@extends('user.layout.mobile')

@section('title', 'Welcome')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <!-- IMAGE FULL BLEED -->
    <img src="{{ asset('images/onboarding_asset (1).png') }}"
         class="w-full object-cover">

    <!-- CARD -->
    <div class="bg-white w-full rounded-t-[32px] mt-3 pt-3 pb-16 px-6 text-center">

        <h1 class="text-2xl font-semibold text-[#F26E21] leading-snug">
            Use your loans responsibly.
        </h1>

        <p class="text-base text-[#6A6A6A] mt-9 mb-10">
            Ensure that inventory is used as needed and returned on time.
        </p>

        <a href="{{ route('user.onboarding.2') }}"
            class="block w-full border border-[#F26E21] text-[#F26E21]
                   py-3 rounded-xl mt-8 text-base font-medium">
            Next
        </a>

    </div>

@endsection
