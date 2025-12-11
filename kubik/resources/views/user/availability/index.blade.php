@extends('user.layout.mobile')

@section('title', 'Availability')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <div class="px-4 pt-5 pb-10 w-full max-w-[430px] mx-auto">

        {{-- BACK + SEARCH --}}
        <div class="flex items-center mb-5">
            <a href="{{ route('user.home') }}" class="material-symbols-rounded text-[#2A2A2A] text-[26px] pr-2">
                arrow_back
            </a>

            <form class="flex-1 mr-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search"
                    class="w-full h-10 bg-[#EFEFEF] rounded-xl px-4 text-sm focus:outline-none">
            </form>
            {{-- Date Filter Icon --}}
            <button type="button" onclick="openDateTimeModal()"
                class="relative w-10 h-10 flex items-center justify-center text-[#F26E21]">

                {{-- SVG Calendar Icon (Heroicons Outline) --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>

                {{-- Notification Dot --}}
                @if($startDate && $startTime && $endDate && $endTime)
                    {{-- Saya tambahkan border putih agar titik hijau terlihat terpisah rapi dari ikon --}}
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                @endif
            </button>
        </div>

        {{-- FILTER type --}}
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

                    // Calculate available count based on date filter
                    if ($startDate && $startTime && $endDate && $endTime) {
                        // When date filter is active, count assets that are available for the date range
                        $startDateTime = $startDate . ' ' . $startTime . ':00';
                        $endDateTime = $endDate . ' ' . $endTime . ':00';

                        $availableCount = $item->assets->filter(function ($asset) use ($startDateTime, $endDateTime) {
                            // Only count if asset is available and not booked during the period
                            if ($asset->status !== 'Available') {
                                return false;
                            }

                            // Check if this asset is booked during the specified period
                            $isBooked = DB::table('booking_assets')
                                ->join('bookings', 'booking_assets.id_booking', '=', 'bookings.id_booking')
                                ->where('booking_assets.id_asset', $asset->id_asset)
                                ->whereIn('bookings.status', ['Approved'])
                                ->where(function ($query) use ($startDateTime, $endDateTime) {
                                    $query->where('bookings.start_time', '<', $endDateTime)
                                        ->where('bookings.end_time', '>', $startDateTime);
                                })
                                ->exists();

                            return !$isBooked;
                        })->count();

                        // Check if this asset type is available for the selected time period
                        $isAvailableForPeriod = $availableCount > 0;
                    } else {
                        // Default: count assets with 'Available' status
                        $availableCount = $item->assets->where('status', 'Available')->count();
                        $isAvailableForPeriod = $availableCount > 0;
                    }

                    // MODIFIKASI: Cek jika image_asset ada DAN tidak kosong
                    $image = ($item->image_asset && file_exists(public_path('uploads/assetmasters/' . $item->image_asset)))
                        ? asset('uploads/assetmasters/' . $item->image_asset)
                        : asset('images/no_images.png'); // Pastikan nama file default benar (noimage.png atau no_images.png)
                @endphp

                <div onclick="openDetail('{{ $item->id_master }}')"
                    class="bg-white rounded-2xl shadow-md border border-[#F1F1F1] p-3 flex flex-col h-[250px] cursor-pointer {{ !$isAvailableForPeriod ? 'opacity-60' : '' }}">

                    {{-- Gambar --}}
                    <img src="{{ $image }}" class="w-full h-[120px] object-cover rounded-xl mb-3"
                        onerror="this.onerror=null;this.src='{{ asset('images/noimage.png') }}';">
                    {{-- Tambahan onerror untuk jaga-jaga jika file fisik hilang --}}

                    <div class="flex-grow">
                        <p class="font-semibold text-sm text-[#2A2A2A] leading-tight line-clamp-2 h-[36px]">
                            {{ $item->name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            @if($startDate && $startTime && $endDate && $endTime)
                                {{ $availableCount }} of {{ $total }} available for selected period
                            @else
                                {{ $availableCount }} of {{ $total }} available
                            @endif
                        </p>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm {{ $isAvailableForPeriod ? 'text-green-600' : 'text-red-600' }}">
                            @if($startDate && $startTime && $endDate && $endTime)
                                {{ $isAvailableForPeriod ? 'Available' : 'Booked' }}
                            @else
                                {{ $availableCount ? 'Available' : 'Unavailable' }}
                            @endif
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

    {{-- Date Time Filter Modal --}}
    <div id="dateTimeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 w-full max-w-[400px] mx-4">
            <h3 class="text-lg font-semibold text-[#2A2A2A] mb-4">Select Date & Time Range</h3>

            <form method="GET" action="{{ route('user.availability') }}">
                {{-- Preserve existing filters --}}
                @if($search)
                    <input type="hidden" name="search" value="{{ $search }}">
                @endif
                @if($filterType)
                    <input type="hidden" name="type" value="{{ $filterType }}">
                @endif

                <div class="space-y-4">
                    {{-- Start Date & Time --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date & Time</label>
                        <div class="flex gap-2">
                            <input type="date" name="start_date" required
                                class="flex-1 h-10 border border-gray-300 rounded-lg px-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#F26E21]">
                            <input type="time" name="start_time" required
                                class="flex-1 h-10 border border-gray-300 rounded-lg px-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#F26E21]">
                        </div>
                    </div>

                    {{-- End Date & Time --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date & Time</label>
                        <div class="flex gap-2">
                            <input type="date" name="end_date" required
                                class="flex-1 h-10 border border-gray-300 rounded-lg px-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#F26E21]">
                            <input type="time" name="end_time" required
                                class="flex-1 h-10 border border-gray-300 rounded-lg px-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#F26E21]">
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeDateTimeModal()"
                        class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-xl text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-[#F26E21] text-white py-2 px-4 rounded-xl text-sm font-medium">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDateTimeModal() {
            document.getElementById('dateTimeModal').classList.remove('hidden');
        }

        function closeDateTimeModal() {
            document.getElementById('dateTimeModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('dateTimeModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDateTimeModal();
            }
        });
    </script>

@endsection