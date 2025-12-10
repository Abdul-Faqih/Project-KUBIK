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
                <button name="type" value=""
                    class="px-4 py-1 rounded-full border text-sm {{ !$filterType ? 'bg-[#F26E21] text-white' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                    All
                </button>

                @foreach ($types as $type)
                    <button name="type" value="{{ $type->id_type }}"
                        class="px-4 py-1 rounded-full border text-sm whitespace-nowrap {{ $filterType == $type->id_type ? 'bg-[#F26E21] text-white' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                        {{ $type->name }}
                    </button>
                @endforeach
            </div>
        </form>

        {{-- GRID --}}
        <div class="grid grid-cols-2 gap-4">
            @foreach ($items as $item)
                @php
                    // Ambil total dari $item->stock_total atau assets->count()
                    $total = $item->stock_total ?? $item->assets->count();
                    $available = $item->assets->where('status', 'Available')->count();

                    // MODIFIKASI: Cek jika image_asset ada DAN tidak kosong
                    $image = ($item->image_asset && file_exists(public_path('uploads/assetmasters/' . $item->image_asset)))
                        ? asset('uploads/assetmasters/' . $item->image_asset)
                        : asset('images/no_images.png'); // Pastikan nama file default benar (noimage.png atau no_images.png)
                @endphp

                <div onclick="openDetail('{{ $item->id_master }}')"
                    class="bg-white rounded-2xl shadow-md border border-[#F1F1F1] p-3 flex flex-col h-[250px] cursor-pointer">

                    {{-- Gambar --}}
                    <img src="{{ $image }}" class="w-full h-[120px] object-cover rounded-xl mb-3"
                        onerror="this.onerror=null;this.src='{{ asset('images/noimage.png') }}';">
                    {{-- Tambahan onerror untuk jaga-jaga jika file fisik hilang --}}

                    <div class="flex-grow">
                        <p class="font-semibold text-sm text-[#2A2A2A] leading-tight line-clamp-2 h-[36px]">
                            {{ $item->name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $available }} of {{ $total }} available
                        </p>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm {{ $available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Cart --}}
    @include('user.components.cart', ['cartCount' => $cartCount])

    {{-- Detail modal --}}
    @include('user.components.asset_detail', ['itemsJson' => $itemsJson])

@endsection