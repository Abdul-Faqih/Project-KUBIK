@extends('user.layout.mobile')

@section('title', 'Home')

@section('content')

    <!-- HEADER -->
    <div class="w-full flex items-center justify-between -mt-3 px-1 mb-5">

        <!-- LEFT: CAMPUS LOGO (5732x2481 → scaled) -->
        <div class="flex items-center">
            <a href="{{ route('user.home') }}">
                <img src="{{ asset('images/kampus_berwarna.png') }}" class="w-[120px] h-auto object-contain">
            </a>
        </div>

        <!-- RIGHT: ACCOUNT ICON -->
        <a href="#" class="flex items-start justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40" fill="#F26E21">
                <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="mt-3 text-center">
        <p class="text-lg text-[#2A2A2A]">
            Welcome, <span class="font-semibold">{{ session('user_name') }}</span>
        </p>
    </div>

@endsection