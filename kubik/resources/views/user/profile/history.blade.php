@extends('user.layout.mobile')

@section('title', 'History')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

{{-- ======================================================== --}}
{{-- FIXED TOP AREA (HEADER + TABS) --}}
{{-- ======================================================== --}}
<div class="fixed top-0 left-0 w-full z-50 bg-white shadow-sm">
    
    {{-- HEADER ROW: BACK BUTTON + SEARCH BAR (Sejajar & Ramping) --}}
    <div class="px-5 mt-4 flex items-center gap-3">
        
        {{-- 1. Back Button (Style Arrow Back sama kayak Profile) --}}
        <a href="{{ route('user.profile') }}" class="material-symbols-rounded text-[#2A2A2A] text-[26px]">
            arrow_back
        </a>
        
        {{-- 2. Search Bar (Ramping / Slim) --}}
        <div class="flex-1 bg-[#F5F5F5] rounded-full flex items-center px-3 py-2"> {{-- py-2 bikin dia ramping --}}
            <span class="material-symbols-rounded text-[#9A9A9A] mr-2 text-[18px]">search</span>
            <input type="text" placeholder="Search" 
                   class="bg-transparent w-full focus:outline-none text-[#2A2A2A] text-[13px] font-medium placeholder-[#9A9A9A] leading-none">
        </div>
        
        {{-- 3. Menu Icon (Opsional, penyeimbang kanan) --}}
        <span class="material-symbols-rounded text-[#2A2A2A] text-[26px]">more_vert</span>
    </div>

    {{-- TABS --}}
    <div class="flex px-5 mt-3 border-b border-[#E5E5E5]">
        {{-- Tab Semua --}}
        <button onclick="switchTab('all')" id="tab-btn-all" 
            class="w-1/2 pb-3 text-center font-semibold text-[#F26E21] border-b-[3px] border-[#F26E21] transition-all text-[15px]">
            Semua
        </button>
        {{-- Tab Selesai --}}
        <button onclick="switchTab('completed')" id="tab-btn-completed" 
            class="w-1/2 pb-3 text-center font-semibold text-[#9A9A9A] border-b-[3px] border-transparent transition-all text-[15px]">
            Selesai
        </button>
    </div>

</div>

{{-- ======================================================== --}}
{{-- CONTENT AREA --}}
{{-- ======================================================== --}}
{{-- Padding Top (pt) diset 120px karena header sekarang pendek & compact --}}
<div class="px-5 pt-[150px] pb-6 bg-white min-h-screen"> 

    {{-- SECTION: SEMUA --}}
    <div id="content-all" class="space-y-5">
        @forelse($bookings as $item)
            @include('user.profile.components.booking_card', ['item' => $item])
        @empty
            @include('user.profile.components.empty_state_history')
        @endforelse
    </div>

    {{-- SECTION: SELESAI --}}
    <div id="content-completed" class="hidden space-y-5">
        @php
            $filteredCompleted = $bookings->where('status', 'Completed');
        @endphp

        @forelse($filteredCompleted as $item)
            @include('user.profile.components.booking_card', ['item' => $item])
        @empty
            @include('user.profile.components.empty_state_history')
        @endforelse
    </div>

</div>

{{-- JAVASCRIPT FOR TABS --}}
<script>
    function switchTab(tab) {
        const btnAll = document.getElementById('tab-btn-all');
        const btnCompleted = document.getElementById('tab-btn-completed');
        const contentAll = document.getElementById('content-all');
        const contentCompleted = document.getElementById('content-completed');

        if (tab === 'all') {
            btnAll.classList.replace('text-[#9A9A9A]', 'text-[#F26E21]');
            btnAll.classList.replace('border-transparent', 'border-[#F26E21]');
            btnCompleted.classList.replace('text-[#F26E21]', 'text-[#9A9A9A]');
            btnCompleted.classList.replace('border-[#F26E21]', 'border-transparent');
            contentAll.classList.remove('hidden');
            contentCompleted.classList.add('hidden');
        } else {
            btnCompleted.classList.replace('text-[#9A9A9A]', 'text-[#F26E21]');
            btnCompleted.classList.replace('border-transparent', 'border-[#F26E21]');
            btnAll.classList.replace('text-[#F26E21]', 'text-[#9A9A9A]');
            btnAll.classList.replace('border-[#F26E21]', 'border-transparent');
            contentCompleted.classList.remove('hidden');
            contentAll.classList.add('hidden');
        }
    }
</script>

@endsection