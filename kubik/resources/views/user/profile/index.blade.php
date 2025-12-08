@extends('user.layout.mobile')

@section('title', 'Account')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    {{-- BACK + TITLE --}}
    <div class="flex items-center gap-3 mb-6 mt-6 px-4">
        {{-- Ikon Back --}}
        <a href="{{ route('user.home') }}" class="material-symbols-rounded text-[26px] text-[#2A2A2A]">arrow_back</a>

        {{-- Teks Account --}}
        <h1 class="text-lg font-semibold text-[#2A2A2A]">Account</h1>

        {{-- Ikon Notifikasi (Tambahkan class ml-auto di sini) --}}
        {{-- <a href="#" class="ml-auto">
            <span class="items-end material-symbols-rounded text-[#F26E21] text-[28px]">
                notifications
            </span>
        </a> --}}
    </div>

    {{-- AVATAR + NAME --}}
    <div class="flex flex-col items-center text-center mb-8 px-4">

        @php
            $user = user();
            // Default gambar
            $iconPath = asset('images/icon_student.png');

            // Cek Role
            if ($user->role === 'Lecturer') {
                $iconPath = asset('images/icon_lecturer.png');
            } elseif ($user->role === 'Staff') {
                $iconPath = asset('images/icon_staff.png');
            }
        @endphp

        {{-- Container Gambar Bulat --}}
        <div
            class="w-[100px] h-[100px] rounded-full bg-[#FFF2E9] border-2 border-[#FFE0C2] flex items-center justify-center shadow-sm overflow-hidden p-4">
            <img src="{{ $iconPath }}" alt="{{ $user->role }}" class="w-full h-full object-contain">
        </div>

        {{-- Nama User --}}
        <p class="mt-3 text-lg font-bold text-[#2A2A2A]">
            {{ $user->name }}
        </p>

        {{-- Role Badge --}}
        <span class="text-base font-medium text-[#F26E21] mt-1 bg-orange-50 px-3 py-0.5 rounded-full">
            {{ $user->role }}
        </span>
    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="px-4 mb-10">

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
        <div
            class="bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] rounded-b-2xl px-5 py-6 border-x border-b border-[#E5E5E5]">

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


    {{-- PERSONAL SECTION --}}
    <div class="px-4">

        <h2 class="text-base font-bold text-[#2A2A2A] mb-3">Personal</h2>

        {{-- PROFILE --}}
        <a href="{{ route('user.profile.details') }}"
            class="flex justify-between items-center py-4 border-b border-[#E5E5E5]">
            <div class="flex items-center gap-4">
                <span class="material-symbols-rounded text-[24px] text-[#2A2A2A]">person</span>
                <span class="text-[#2A2A2A] text-base font-medium">Profile</span>
            </div>
            <span class="material-symbols-rounded text-[24px] text-[#B4B4B4]">chevron_right</span>
        </a>

        {{-- HISTORY --}}
        <a href="{{ route('user.rentals.history') }}"
            class="flex justify-between items-center py-4 border-b border-[#E5E5E5]">
            <div class="flex items-center gap-4">
                <span class="material-symbols-rounded text-[24px] text-[#2A2A2A]">history</span>
                <span class="text-[#2A2A2A] text-base font-medium">Borrowing History</span>
            </div>
            <span class="material-symbols-rounded text-[24px] text-[#B4B4B4]">chevron_right</span>
        </a>

    </div>

    {{-- OTHERS SECTION --}}
    <div class="px-4 mt-8 pb-10">

        <h2 class="text-base font-bold text-[#2A2A2A] mb-3">Others</h2>

        {{-- SETTINGS (PERBAIKAN DISINI) --}}
        {{-- Link route diubah dari 'user.profile.settings' menjadi 'user.settings.index' --}}
        {{-- <a href="{{ route('user.profile.settings') }}"
            class="flex justify-between items-center py-4 border-b border-[#E5E5E5]">
            <div class="flex items-center gap-4">
                <span class="material-symbols-rounded text-[24px] text-[#2A2A2A]">settings</span>
                <span class="text-[#2A2A2A] text-base font-medium">Account Settings</span>
            </div>
            <span class="material-symbols-rounded text-[24px] text-[#B4B4B4]">chevron_right</span>
        </a> --}}

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('user.logout') }}">
            @csrf
            <button type="button" onclick="openLogoutModal()"
                class="w-full flex justify-between items-center py-4 border-b border-[#E5E5E5] text-left">

                <div class="flex items-center gap-4">
                    <span class="material-symbols-rounded text-[24px] text-red-600">logout</span>
                    <span class="text-red-600 text-base font-medium">Logout</span>
                </div>
                <span class="material-symbols-rounded text-[24px] text-[#B4B4B4]">chevron_right</span>
            </button>
        </form>

    </div>

    {{-- LOGOUT MODAL --}}
    <div id="logoutModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">

        <div class="bg-white rounded-2xl w-[85%] p-6 text-center shadow-lg">

            <h2 class="text-lg font-bold text-[#2A2A2A] mb-2">
                Logout Confirmation
            </h2>

            <p class="text-base text-[#6A6A6A] mb-6">
                Are you sure you want to logout?
            </p>

            <div class="flex gap-3 justify-center">
                <button onclick="closeLogoutModal()"
                    class="flex-1 py-3 border border-[#B4B4B4] text-[#2A2A2A] rounded-xl text-base font-medium">
                    Cancel
                </button>

                <form method="POST" action="{{ route('user.logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-[#F26E21] text-white rounded-xl text-base font-medium">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }
    </script>

@endsection