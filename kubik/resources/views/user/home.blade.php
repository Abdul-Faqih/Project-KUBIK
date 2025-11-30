@extends('user.layout.mobile')

@section('title', 'Home')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <!-- HEADER -->
    <div class="w-full flex items-center justify-between mt-3 px-6 mb-3">

        <!-- LEFT: CAMPUS LOGO (5732x2481 → scaled) -->
        <div class="flex items-center">
            <a href="{{ route('user.home') }}">
                <img src="{{ asset('images/kampus_berwarna.png') }}" class="w-[100px] h-auto object-contain">
            </a>
        </div>

        <!-- RIGHT: ACCOUNT ICON -->
        <a href="{{ route('user.profile') }}" class="flex items-start justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="#F26E21">
                <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </a>

    </div>

    <!-- ADS SECTION -->
    <div class="w-full overflow-hidden relative">

        <!-- LEFT ARROW -->
        <button id="adsPrev"
            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/60 hover:bg-white text-[#F26E21] px-2 py-1 rounded-full z-20">
            ‹
        </button>

        <!-- RIGHT ARROW -->
        <button id="adsNext"
            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/60 hover:bg-white text-[#F26E21] px-2 py-1 rounded-full z-20">
            ›
        </button>

        <!-- SLIDES -->
        <div id="adsSlider" class="relative w-full h-[200px] overflow-hidden">

            <div class="ads-slide w-full h-full absolute inset-0">
                <img src="{{ asset('images/ads/ADS1.PNG') }}" class="w-full h-full object-cover">
            </div>

            <div class="ads-slide w-full h-full absolute inset-0 hidden">
                <img src="{{ asset('images/ads/ADS2.PNG') }}" class="w-full h-full object-cover">
            </div>

            <div class="ads-slide w-full h-full absolute inset-0 hidden">
                <img src="{{ asset('images/ads/ADS3.PNG') }}" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- DOTS -->
        <div class="flex justify-end mt-3 gap-2 px-5">
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full cursor-pointer"></span>
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full cursor-pointer"></span>
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full cursor-pointer"></span>
        </div>
    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="mt-6 px-4">

        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-[#FFE2C7]">

            <!-- TITLE BAR -->
            <div class="bg-[#f6a124] text-white px-4 py-3 flex justify-between items-center">
                <p class="text-base font-medium">
                    Recent Activity
                </p>
            </div>

            @if($recent)
                <!-- CONTENT -->
                <div class="px-5 py-4">

                    <h2 class="text-xl font-semibold text-[#2A2A2A]">
                        {{ $recent->id_booking }}
                    </h2>

                    <div class="flex items-center gap-1.5 mt-3 text-sm text-[#2A2A2A]">

                        <!-- TIME ICON -->
                        <div class="flex items-center gap-1 bg-[#F1F1F1] px-3 py-1 rounded-full">
                            <span>⏱</span>
                            <span>
                                {{ \Carbon\Carbon::parse($recent->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($recent->end_time)->format('H:i') }}
                            </span>
                        </div>

                        <!-- STATUS ICON -->
                        <div class="flex items-center gap-1 text-base">
                            @if($recent->status === 'Pending')
                                <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-600">Pending</span>
                            @elseif($recent->status === 'Rejected')
                                <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-600">Rejected</span>
                            @elseif($recent->status === 'Approved')
                                <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-600">Approved</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-600">Completed</span>
                            @endif
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <a href="#"
                        class="block w-full text-center border border-[#F26E21] text-[#F26E21] py-3 rounded-xl mt-6 font-medium">
                        See all activity
                    </a>

                </div>
            @else

                <!-- NO ACTIVITY -->
                <div class="px-5 py-6 text-center text-[#6A6A6A]">
                    No activity yet.
                </div>
            @endif
        </div>
    </div>

    {{-- ITEM AVAILABILITY SECTION --}}
    <div class="mt-10 px-4">

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-[#2A2A2A]">Item Availability</h2>
            <a href="{{ route('user.availability') }}" class="text-[#F26E21] text-sm font-medium">View All</a>
        </div>

        <!-- CAROUSEL -->
        <div class="flex gap-4 overflow-x-auto no-scrollbar py-2">

            @foreach ($availability->take(7) as $item)
                @php
                    $total = $item->stock_total;
                    $available = $item->assets->where('status', 'Available')->count();
                    $image = $item->image_asset
                        ? asset('uploads/assetmasters/' . $item->image_asset)
                        : asset('images/noimage.png');
                @endphp

                <div class="min-w-[180px] h-[260px] bg-white rounded-2xl shadow-md p-3 border border-[#F1F1F1] flex flex-col">

                    <!-- IMAGE -->
                    <img src="{{ $image }}" class="w-full h-[110px] object-cover rounded-xl mb-3">

                    <!-- CONTENT -->
                    <div class="flex-grow">

                        <!-- NAME FIX HEIGHT -->
                        <p class="font-semibold text-[#2A2A2A] text-sm leading-tight line-clamp-2 h-[38px]">
                            {{ $item->name }}
                        </p>

                        <!-- STOCK -->
                        <p class="text-xs text-[#6A6A6A] mt-1">
                            {{ $available }} of {{ $total }} items in stock
                        </p>

                    </div>

                    <!-- FOOTER -->
                    <div class="flex justify-between items-center mt-3">

                        <span class="text-sm {{ $available > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $available > 0 ? 'Available' : 'Unavailable' }}
                        </span>

                        <button class="w-7 h-7 bg-[#F26E21] rounded-full"></button>
                    </div>

                </div>
            @endforeach

            <!-- ARROW BUTTON (CENTERED VERTICALLY) -->
            <div class="flex items-center justify-center min-w-[70px]">
                <a href="{{ route('user.availability') }}" class="flex items-center justify-center">
                    <div
                        class="w-12 h-12 bg-[#F26E21] rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        ›
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- ROOM AVAILABILITY SECTION --}}
    <div class="mt-5 px-4">

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-[#2A2A2A]">Room Availability</h2>
            <a href="{{ route('user.availability') }}" class="text-[#F26E21] text-sm font-medium">View All</a>
        </div>

        <div class="flex gap-4 overflow-x-auto no-scrollbar py-2">

            @foreach ($roomAvailability->take(7) as $room)
                @php
                    $total = $room->stock_total;
                    $available = $room->assets->where('status', 'Available')->count();
                    $image = $room->image_asset
                        ? asset('uploads/assetmasters/' . $room->image_asset)
                        : asset('images/noimage.png');
                @endphp

                <div class="min-w-[180px] h-[260px] bg-white rounded-2xl shadow-md p-3 border border-[#F1F1F1] flex flex-col">

                    <img src="{{ $image }}" class="w-full h-[110px] object-cover rounded-xl mb-3">

                    <div class="flex-grow">
                        <p class="font-semibold text-[#2A2A2A] text-sm leading-tight line-clamp-2 h-[38px]">
                            {{ $room->name }}
                        </p>

                        <p class="text-xs text-[#6A6A6A] mt-1">
                            {{ $available }} of {{ $total }} rooms available
                        </p>
                    </div>

                    <div class="flex justify-between items-center mt-3">
                        <span class="text-sm {{ $available > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $available > 0 ? 'Available' : 'Unavailable' }}
                        </span>

                        <button class="w-7 h-7 bg-[#F26E21] rounded-full"></button>
                    </div>

                </div>
            @endforeach

            <!-- ARROW MORE -->
            <div class="flex items-center justify-center min-w-[70px]">
                <a href="{{ route('user.availability') }}" class="flex items-center justify-center">
                    <div
                        class="w-12 h-12 bg-[#F26E21] rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        ›
                    </div>
                </a>
            </div>

        </div>

    </div>

    {{-- FEEDBACK SECTION --}}
    <div class="mt-5 px-0 pb-10">

        <div class="w-full bg-[#F26E21] p-6 mx-auto py-10" style="max-width: 430px;">

            <div class="flex items-center">

                <!-- ICON -->
                <div class="flex-shrink-0 mr-5">
                    <img src="{{ asset('images/feedback_icon.png') }}" class="w-28   h-28 object-contain">
                </div>

                <!-- TEXT + BUTTON -->
                <div class="flex-auto text-white flex flex-col gap-7"> <!-- FLEX-COL + GAP -->

                    <p class="text-xl opacity-90 leading-tight mb-3">
                        Having trouble using the app? Report it now!
                    </p>

                    <a href="#" class="inline-block px-5 py-2  rounded-full text-sm font-medium text-center bg-white text-[#F26E21] transition">
                        Submit your feedback
                    </a>

                </div>

            </div>

        </div>

    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>


    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.ads-slide');
        const dots = document.querySelectorAll('.ads-dot');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('hidden', i !== index);
            });

            dots.forEach((dot, i) => {
                dot.style.backgroundColor = (i === index) ? "#F26E21" : "#CFCFCF";
            });

            currentSlide = index;
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % slides.length);
        }

        function prevSlide() {
            showSlide((currentSlide - 1 + slides.length) % slides.length);
        }

        // AUTO SLIDE
        let autoSlide = setInterval(nextSlide, 4000);

        // RESTART AUTO SLIDE WHEN USER INTERACTS
        function restartAutoSlide() {
            clearInterval(autoSlide);
            autoSlide = setInterval(nextSlide, 4000);
        }

        // DOT CLICK
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                restartAutoSlide();
            });
        });

        // ARROW BUTTONS
        document.getElementById('adsNext').addEventListener('click', () => {
            nextSlide();
            restartAutoSlide();
        });

        document.getElementById('adsPrev').addEventListener('click', () => {
            prevSlide();
            restartAutoSlide();
        });

        // INIT
        showSlide(0);
    </script>


@endsection