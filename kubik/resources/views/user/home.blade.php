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
    <a href="#" class="flex items-start justify-start">
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

            <div onclick="openDetail('{{ $room->id_master }}')"
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

Tentu, saya akan memberikan kode full untuk home.blade.php yang sudah mencakup:

Struktur HTML yang Anda berikan.

Modal Detail dengan tombol Add dan Counter berbentuk pil yang sudah diperbaiki.

Logika JavaScript yang lengkap agar fungsi openDetail(id) dan cart logic berjalan dengan benar.

Perbaikan kecil pada loop Room Availability ($item->name menjadi $room->name).

Berikut adalah kode lengkapnya:

HTML

@extends('user.layout.mobile')

@section('title', 'Home')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <div class="w-full flex items-center justify-between mt-3 px-6 mb-3">

        <div class="flex items-center">
            <a href="{{ route('user.home') }}">
                <img src="{{ asset('images/kampus_berwarna.png') }}" class="w-[100px] h-auto object-contain">
            </a>
        </div>

        <a href="#" class="flex items-start justify-start">
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
    <div class="mt-6 px-4">

        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-[#FFE2C7]">

            <div class="bg-[#f6a124] text-white px-4 py-3 flex justify-between items-center">
                <p class="text-base font-medium">
                    Recent Activity
                </p>
            </div>

            @if($recent)
                <div class="px-5 py-4">

                    <h2 class="text-xl font-semibold text-[#2A2A2A]">
                        {{ $recent->id_booking }}
                    </h2>

                    <div class="flex items-center gap-1.5 mt-3 text-sm text-[#2A2A2A]">

                        <div class="flex items-center gap-1 bg-[#F1F1F1] px-3 py-1 rounded-full">
                            <span>⏱</span>
                            <span>
                                {{ \Carbon\Carbon::parse($recent->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($recent->end_time)->format('H:i') }}
                            </span>
                        </div>

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

                    <a href="#"
                        class="block w-full text-center border border-[#F26E21] text-[#F26E21] py-3 rounded-xl mt-6 font-medium">
                        See all activity
                    </a>

                </div>
            @else

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
                            {{ $room->name }} {{-- DIPERBAIKI: Menggunakan $room->name --}}
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

    {{-- DETAIL MODAL --}}
    <div id="detailModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-end z-50 hidden transition-all">

        <div id="detailContent"
            class="w-full max-w-[430px] bg-white rounded-t-[32px] pb-10 translate-y-full transition-all duration-300">

            {{-- HEADER --}}
            <div class="bg-[#F26E21] text-white rounded-t-[32px] px-5 py-4 flex justify-between items-center">
                <div>
                    <p id="detailType" class="text-sm opacity-80"></p>
                    <h2 id="detailTitle" class="text-2xl font-bold mt-1 leading-tight"></h2>
                </div>

                <button onclick="closeDetail()">
                    <span class="text-white text-3xl font-bold">×</span>
                </button>
            </div>

            {{-- IMAGE --}}
            <div class="px-5 mt-4">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <img id="detailImage" class="w-full h-[250px] object-cover">
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="px-5 mt-5">
                <div class="flex justify-between text-sm mb-4">
                    <span id="detailStatus" class="font-semibold"></span>
                    <span id="detailCount" class="opacity-70"></span>
                </div>

                <h3 class="text-lg font-semibold mb-1">Detail</h3>
                <p id="detailDescription" class="text-sm text-gray-700 leading-snug"></p>
            </div>

            {{-- 🟢 CART CONTROLS (DITAMBAHKAN DAN DIPERBAIKI) 🟢 --}}
            <div class="mt-6 px-5">

                {{-- NORMAL BUTTON (ADD) --}}
                <button id="addBtn"
                    class="w-full bg-[#F26E21] text-white py-3 m rounded-xl text-lg font-semibold shadow-md hidden transition active:scale-95">
                    Add
                </button>

                {{-- COUNTER (Menggunakan desain pill-shaped terbaru) --}}
                <div id="counterBox" class="flex items-center justify-end w-full select-none hidden">

                    {{-- Container untuk Counter (dengan background dan rounded-full) --}}
                    <div
                        class="flex items-center justify-between gap-1 bg-white rounded-full shadow-md p-1">

                        {{-- MINUS --}}
                        <button id="minusBtn"
                            class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white text-xl font-bold shadow-md active:scale-90 transition p-0">
                            –
                        </button>

                        {{-- QUANTITY (Teks di tengah) --}}
                        <span id="qtyText" class="px-2 flex items-center justify-center text-lg font-semibold text-center">
                            1
                        </span>

                        {{-- PLUS --}}
                        <button id="plusBtn"
                            class="w-8 h-8 rounded-full bg-[#F26E21] flex items-center justify-center text-white text-xl font-bold shadow-md active:scale-90 transition p-0">
                            +
                        </button>

                    </div>

                </div>

            </div>
            {{-- 🟢 AKHIR CART CONTROLS 🟢 --}}

        </div>
    </div>


    {{-- FEEDBACK SECTION --}}
    <div class="mt-5 px-0 pb-10">

        <div class="w-full bg-[#F26E21] p-6 mx-auto py-10" style="max-width: 430px;">

            <div class="flex items-center">

                <div class="flex-shrink-0 mr-5">
                    <img src="{{ asset('images/feedback_icon.png') }}" class="w-28   h-28 object-contain">
                </div>

                <div class="flex-auto text-white flex flex-col gap-7"> <p class="text-xl opacity-90 leading-tight mb-3">
                        Having trouble using the app? Report it now!
                    </p>

                    <a href="#"
                        class="inline-block px-5 py-2  rounded-full text-sm font-medium text-center bg-white text-[#F26E21] transition">
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


    {{-- 🟢 SCRIPT LOGIC (LENGKAP DAN DIPERBAIKI) 🟢 --}}
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

        const itemData = @json($itemsJson);
        const roomData = @json($roomsJson);
        const allData = [...itemData, ...roomData];

        // VARIABEL GLOBAL UNTUK CART LOGIC
        let currentMaster = null;
        let maxAvailable = 0;


        function updateUI() {
            // Hanya jalankan jika ada item yang sedang dibuka
            if (!currentMaster) return;

            fetch("{{ route('user.cart.count') }}?id_master=" + currentMaster)
                .then(res => res.json())
                .then(data => {
                    let qty = data.count;

                    const addBtn = document.getElementById("addBtn");
                    const counterBox = document.getElementById("counterBox");
                    const qtyText = document.getElementById("qtyText");
                    const plusBtn = document.getElementById("plusBtn");

                    if (!addBtn || !counterBox || !qtyText || !plusBtn) return;

                    qtyText.innerText = qty;

                    // Tampilkan Add Button jika qty 0, atau Counter jika qty > 0
                    if (qty === 0) {
                        addBtn.classList.remove("hidden");
                        counterBox.classList.add("hidden");
                    } else {
                        addBtn.classList.add("hidden");
                        counterBox.classList.remove("hidden");
                    }

                    // Matikan tombol plus jika jumlah keranjang sudah mencapai maksimum yang tersedia
                    plusBtn.disabled = qty >= maxAvailable;
                    plusBtn.classList.toggle('opacity-50', qty >= maxAvailable); // Efek visual disabled
                });
        }

        function openDetail(id) {

            const item = allData.find(i => i.id_master == id);
            if (!item) return;

            // SET VARIABEL CART (PENTING UNTUK LOGIC DI BAWAH)
            currentMaster = id;
            maxAvailable = item.assets.filter(a => a.status === "Available").length;

            document.getElementById("detailType").innerText = item.type;
            document.getElementById("detailTitle").innerText = item.name;

            document.getElementById("detailImage").src =
                item.image_asset ? `/uploads/assetmasters/${item.image_asset}` : `/images/noimage.png`;

            const available = item.assets.filter(a => a.status === "Available").length;

            document.getElementById("detailStatus").innerText =
                available > 0 ? "Available" : "Unavailable";

            document.getElementById("detailStatus").style.color =
                available > 0 ? "#22c55e" : "#ef4444";

            document.getElementById("detailCount").innerText =
                `${available} of ${item.assets.length} Available`;

            document.getElementById("detailDescription").innerText =
                item.description ?? "-";

            // Panggil updateUI untuk menampilkan Add/Counter yang benar
            updateUI();

            document.getElementById("detailModal").classList.remove("hidden");

            setTimeout(() => {
                document.getElementById("detailContent").classList.remove("translate-y-full");
            }, 10);
        }

        function closeDetail() {
            document.getElementById("detailContent").classList.add("translate-y-full");
            setTimeout(() => {
                document.getElementById("detailModal").classList.add("hidden");
            }, 300);
        }

        document.getElementById("detailModal").addEventListener("click", function (e) {
            const modalBox = document.getElementById("detailContent");
            if (!modalBox.contains(e.target)) closeDetail();
        });


        // ===================================
        // CART LOGIC LISTENERS
        // ===================================
        document.addEventListener('DOMContentLoaded', () => {

            // ========= ADD =========
            const addBtn = document.getElementById("addBtn");
            if (addBtn) {
                addBtn.onclick = function () {
                    fetch("{{ route('user.cart.add') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ id_master: currentMaster })
                    })
                        .then(res => res.json())
                        .then(() => updateUI());
                };
            }

            // ========= PLUS =========
            const plusBtn = document.getElementById("plusBtn");
            if (plusBtn) {
                plusBtn.onclick = function () {
                    fetch("{{ route('user.cart.add') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ id_master: currentMaster })
                    })
                        .then(res => res.json())
                        .then(() => updateUI());
                };
            }

            // ========= MINUS =========
            const minusBtn = document.getElementById("minusBtn");
            if (minusBtn) {
                minusBtn.onclick = function () {
                    fetch("{{ route('user.cart.remove') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ id_master: currentMaster })
                    })
                        .then(res => res.json())
                        .then(() => updateUI());
                };
            }
        });
    </script>
    {{-- 🟢 AKHIR SCRIPT LOGIC 🟢 --}}

@endsection