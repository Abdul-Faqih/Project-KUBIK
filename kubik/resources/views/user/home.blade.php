@extends('user.layout.mobile')

@section('title', 'Home')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    {{-- Bagian Atas Halaman --}}
    <div class="w-full flex items-center justify-between mt-3 px-6 mb-3">

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

    <div class="w-full overflow-hidden relative">

        <button id="adsPrev"
            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/60 hover:bg-white text-[#F26E21] px-2 py-1 rounded-full z-20">
            ‹
        </button>

        <button id="adsNext"
            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/60 hover:bg-white text-[#F26E21] px-2 py-1 rounded-full z-20">
            ›
        </button>

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

        <div class="flex justify-end mt-3 gap-2 px-5">
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full cursor-pointer"></span>
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full cursor-pointer"></span>
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full cursor-pointer"></span>
        </div>
    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="px-4 mt-5 mb-10">

        {{-- HEADER CARD --}}
        <div class="bg-[#FFA826] text-white rounded-t-2xl px-5 py-3 flex justify-between items-center">
            <p class="font-medium text-base">Borrowing History</p>

            <a href="{{ route('user.rentals.history') }}">
                <span class="material-symbols-rounded text-white text-[28px] leading-none">
                    chevron_right
                </span>
            </a>
        </div>

        {{-- BODY CARD --}}
        <div class="bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] rounded-b-2xl px-5 py-6 border-x border-b border-[#E5E5E5]">

            {{-- CASE 1: TIDAK ADA ACTIVITY --}}
            @if(!$latestBooking)
                <p class="text-base text-[#9A9A9A] mb-4 text-center">
                    You don’t have any rental history yet.
                </p>

            {{-- CASE 2: ADA ACTIVITY --}}
            @else
                <div class="text-left">

                    {{-- TITLE: ID Booking --}}
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h2 class="text-lg font-bold text-[#2A2A2A]">
                                {{ $latestBooking->id_booking }}
                            </h2>
                            <p class="text-[13px] text-[#9A9A9A]">Latest Booking</p>
                        </div>
                        
                        {{-- STATUS STYLE BARU (Bullet Point) --}}
                        <div class="flex items-center gap-2 mt-1">
                            @if($latestBooking->status === 'Pending')
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <span class="text-[14px] font-bold text-yellow-600">Pending</span>

                            @elseif($latestBooking->status === 'Approved')
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                <span class="text-[14px] font-bold text-green-600">Approved</span>

                            @elseif($latestBooking->status === 'Rejected')
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <span class="text-[14px] font-bold text-red-600">Rejected</span>

                            @else
                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                <span class="text-[14px] font-bold text-blue-600">Completed</span>
                            @endif
                        </div>
                    </div>

                    {{-- TIME SLOT --}}
                    <div class="flex items-center gap-2 mb-5">
                        <div class="flex items-center gap-2 bg-[#F5F5F5] px-3 py-1.5 rounded-full">
                            <span class="material-symbols-rounded text-[18px] text-[#6A6A6A]">schedule</span>
                            <span class="text-[14px] font-medium text-[#2A2A2A]">
                                {{ \Carbon\Carbon::parse($latestBooking->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($latestBooking->end_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    {{-- VIEW DETAIL BUTTON --}}
                    <a href="{{ route('user.rentals.detail', $latestBooking->id_booking) }}?from=profile"
                        class="block w-full text-center border border-[#F26E21] text-[#F26E21] py-2.5 rounded-xl font-bold text-[15px] hover:bg-orange-50 transition-colors">
                        View Detail
                    </a>

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

        <div class="flex gap-4 overflow-x-auto no-scrollbar py-2">

            @foreach ($availability->take(7) as $item)
                @php
                    $total = $item->stock_total;
                    $available = $item->assets->where('status', 'Available')->count();
                    $image = $item->image_asset
                        ? asset('uploads/assetmasters/' . $item->image_asset)
                        : asset('images/noimage.png');
                @endphp

                <div onclick="openDetail('{{ $item->id_master }}')"
                    class="min-w-[180px] h-[260px] bg-white rounded-2xl shadow-md p-3 border border-[#F1F1F1] flex flex-col cursor-pointer">


                    {{-- IMAGE --}}
                    <img src="{{ $image }}" class="w-full h-[120px] object-cover rounded-xl mb-3">

                    {{-- CONTENT --}}
                    <div class="flex-grow">
                        <p class="font-semibold text-sm text-[#2A2A2A] leading-tight line-clamp-2 h-[36px]">
                            {{ $item->name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $available }} of {{ $total }} available
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm {{ $available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>

                </div>
            @endforeach

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

                <div onclick="openDetail('{{ $room->id_master }}')"
                    class="min-w-[180px] h-[260px] bg-white rounded-2xl shadow-md p-3 border border-[#F1F1F1] flex flex-col cursor-pointer">


                    {{-- IMAGE --}}
                    <img src="{{ $image }}" class="w-full h-[120px] object-cover rounded-xl mb-3">

                    {{-- CONTENT --}}
                    <div class="flex-grow">
                        <p class="font-semibold text-sm text-[#2A2A2A] leading-tight line-clamp-2 h-[36px]">
                            {{ $room->name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $available }} of {{ $total }} available
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm {{ $available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>

                </div>
            @endforeach

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

                <div class="flex-shrink-0 mr-5">
                    <img src="{{ asset('images/feedback_icon.png') }}" class="w-28   h-28 object-contain">
                </div>

                <div class="flex-auto text-white flex flex-col gap-7">
                    <p class="text-xl opacity-90 leading-tight mb-3">
                        Having trouble using the app? Report it now!
                    </p>

                    <a href="#"
                        class="inline-block px-5 py-2 rounded-2xl text-sm font-medium text-center bg-white text-[#F26E21] transition">
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


    {{-- LOGIKA JS ASLI UNTUK SLIDER, DIBIARKAN DI SINI --}}
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

    {{-- 🟢 PANGGIL KOMPONEN CART LOGIC (Fly Button dan Modal Cart List) 🟢 --}}
    {{-- Catatan: $cartCount harus dilewatkan dari HomeController --}}
    @include('user.components.cart', ['cartCount' => $cartCount ?? 0])

    {{-- 🟢 PANGGIL KOMPONEN MODAL DETAIL ASET 🟢 --}}
    @include('user.components.asset_detail', ['itemsJson' => array_merge($itemsJson->toArray(), $roomsJson->toArray())])

@endsection