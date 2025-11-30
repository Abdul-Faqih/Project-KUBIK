@extends('user.layout.mobile')

@section('title', 'Availability')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <div class="px-4 pt-5 pb-10 w-full max-w-[430px] mx-auto">

        {{-- BACK + SEARCH --}}
        <div class="flex items-center mb-5">
            <a href="{{ route('user.home') }}" class="mr-3">
                <span class="text-2xl font-bold">‹</span>
            </a>

            <form class="flex-1">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search"
                    class="w-full h-10 bg-[#EFEFEF] rounded-xl px-4 text-sm focus:outline-none">
            </form>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="mb-4">
            <div class="flex gap-3 overflow-x-auto no-scrollbar">

                <button name="type" value="" class="px-4 py-1 rounded-full border text-sm
                    {{ !$filterType ? 'bg-[#F26E21] text-white' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                    All
                </button>

                @foreach ($types as $type)
                    <button name="type" value="{{ $type->id_type }}"
                        class="px-4 py-1 rounded-full border text-sm whitespace-nowrap
                        {{ $filterType == $type->id_type ? 'bg-[#F26E21] text-white' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                        {{ $type->name }}
                    </button>
                @endforeach
            </div>
        </form>

        {{-- ========== GRID 2 COLUMNS FIXED ========== --}}
        <div class="grid grid-cols-2 gap-4">

            @foreach($items as $item)
                @php
                    $available = $item->assets->where('status', 'Available')->count();
                    $total = $item->assets->count();
                    $image = $item->image_asset
                        ? asset('uploads/assetmasters/' . $item->image_asset)
                        : asset('images/noimage.png');
                @endphp

                <div class="bg-white rounded-2xl shadow-md border border-[#F1F1F1]
                                p-3 flex flex-col h-[230px]">

                    {{-- IMAGE --}}
                    <img src="{{ $image }}" class="w-full h-[95px] object-cover rounded-xl mb-3">

                    {{-- CONTENT --}}
                    <div class="flex-grow">
                        <p class="font-semibold text-sm text-[#2A2A2A] leading-tight line-clamp-2 h-[36px]">
                            {{ $item->name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $available }} of {{ $total }} items available
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm {{ $available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $available ? 'Available' : 'Unavailable' }}
                        </span>

                        <button class="w-7 h-7 bg-[#F26E21] rounded-full"></button>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

@endsection