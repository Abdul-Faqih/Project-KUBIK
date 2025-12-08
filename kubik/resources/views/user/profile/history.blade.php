@extends('user.layout.mobile')

@section('title', 'History')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    {{-- ======================================================== --}}
    {{-- FIXED TOP AREA (HEADER + FILTER) --}}
    {{-- ======================================================== --}}
    <div class="fixed pb-3 top-0 left-0 w-full bg-white shadow-sm z-50">

        {{-- HEADER ROW: BACK BUTTON + SEARCH BAR --}}
        <div class="px-5 mt-6 flex items-center gap-3">
            <a href="{{ route('user.profile') }}" class="material-symbols-rounded text-[#2A2A2A] text-[26px]">
                arrow_back
            </a>

            <div class="flex-1 bg-[#F5F5F5] rounded-full flex items-center px-3">
                <span class="material-symbols-rounded text-[#9A9A9A] mr-2 text-[18px]">search</span>
                <input type="text" placeholder="Search"
                    class="bg-transparent w-full focus:outline-none text-[#2A2A2A] text-[13px] font-medium placeholder-[#9A9A9A] leading-none">
            </div>

            <span class="material-symbols-rounded text-[#2A2A2A] text-[26px]">more_vert</span>
        </div>

        {{-- FILTER ROW (STATUS BOOKING) --}}
        <div class="mt-5 ">
            <form method="GET">
                {{-- Pertahankan parameter search jika ada (opsional) --}}
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                    {{-- TOMBOL ALL --}}
                    <button name="status" value=""
                        class="ml-5 px-4 py-1 rounded-full border text-sm transition-colors duration-200 {{ !$filterStatus ? 'bg-[#F26E21] text-white border-[#F26E21]' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                        All
                    </button>

                    {{-- LOOP STATUS --}}
                    @php
                        $statuses = ['Pending', 'Approved', 'Completed', 'Rejected'];
                    @endphp

                    @foreach ($statuses as $status)
                        <button name="status" value="{{ $status }}"
                            class="px-4 py-1 rounded-full border text-sm whitespace-nowrap transition-colors duration-200 {{ $filterStatus == $status ? 'bg-[#F26E21] text-white border-[#F26E21]' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                            {{ $status }}
                        </button>
                    @endforeach
                </div>
            </form>
        </div>

    </div>

    {{-- ======================================================== --}}
    {{-- CONTENT AREA --}}
    {{-- ======================================================== --}}
    {{-- Padding Top (pt) diperbesar ke 160px karena header sekarang lebih tinggi ada filternya --}}
    <div class="px-5 pt-[160px] pb-6 bg-white min-h-screen">

        <div class="space-y-5">
            @forelse($bookings as $item)
                @include('user.profile.components.booking_card', ['item' => $item])
            @empty
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center pt-10 pb-10">
                    {{-- 1. Icon Illustration --}}
                    <div class="w-24 h-24 bg-[#FFF4EC] rounded-full flex items-center justify-center mb-5">
                        <span class="material-symbols-rounded text-[#F26E21] text-[42px]">
                            event_busy
                        </span>
                    </div>

                    {{-- 2. Text Message --}}
                    <h3 class="text-[#2A2A2A] font-bold text-xl mb-2">
                        No activity yet
                    </h3>
                    <p class="text-[#9A9A9A] text-base text-center px-8 leading-relaxed">
                        @if(request('status'))
                            Nothing booking with status
                            <span class=" text-base font-semibold text-[#F26E21]">{{ request('status') }}</span>.
                        @else
                        @endif
                    </p>

                    {{-- 3. Action Button (Opsional: Arahkan ke halaman Home/Booking) --}}
                    @if(!request('status'))
                        <a href="{{-- route('user.home') --}}"
                            class="mt-6 px-6 py-3 bg-[#F26E21] text-white text-sm font-medium rounded-full shadow-lg shadow-orange-100 active:scale-95 transition-transform">
                            Buat Booking Baru
                        </a>
                    @else
                        {{-- Tombol Reset Filter jika sedang memfilter --}}
                        <a href="{{ url()->current() }}"
                            class="mt-6 px-6 py-2 border border-[#F26E21] text-[#F26E21] text-sm font-medium rounded-full active:bg-orange-50 transition-colors">
                            Reset Filter
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

    </div>

@endsection