@extends('user.layout.mobile')

@section('title', 'Account Settings')

@section('content')

{{-- BACK + TITLE --}}
    <div class="flex items-center gap-3 mb-6 mt-2 px-2">
        <a href="{{ route('user.profile') }}" class="material-symbols-rounded text-[26px] text-[#2A2A2A]">arrow_back</a>
        <h1 class="text-lg font-semibold text-[#2A2A2A]">Account Settings</h1>
    </div>

{{-- SETTINGS LIST --}}
<div class="px-4">

    {{-- CHANGE / ADD PHONE NUMBER --}}
    <a href="{{ route('user.settings.phone') }}"
       class="flex justify-between items-center py-5 border-b border-[#E5E5E5]"> {{-- py-4 jadi py-5 biar lebih lega --}}

        <div class="flex items-center gap-4"> {{-- gap-3 jadi gap-4 --}}
            {{-- Icon dibesarkan jadi 28px --}}
            <span class="material-symbols-rounded text-[28px] text-[#2A2A2A]">
                phone_iphone
            </span>

            <div>
                {{-- Judul jadi text-base --}}
                <p class="text-base font-medium text-[#2A2A2A]">
                    {{ $user->phone_number ? 'Change Phone Number' : 'Add Phone Number' }}
                </p>

                {{-- Subtext jadi text-sm --}}
                <p class="text-sm text-[#6A6A6A] mt-0.5">
                    {{ $user->phone_number 
                        ? substr($user->phone_number, 0, 2).'•••••'.substr($user->phone_number, -2) 
                        : 'No phone number added yet' }}
                </p>
            </div>
        </div>

        {{-- Chevron dibesarkan jadi 26px --}}
        <span class="material-symbols-rounded text-[26px] text-[#B4B4B4]">chevron_right</span>
    </a>


    {{-- CHANGE PASSWORD --}}
    <a href="{{ route('user.settings.password') }}"
       class="flex justify-between items-center py-5 border-b border-[#E5E5E5]">

        <div class="flex items-center gap-4">
            <span class="material-symbols-rounded text-[28px] text-[#2A2A2A]">
                key
            </span>

            <div>
                <p class="text-base font-medium text-[#2A2A2A]">Change Password</p>
                <p class="text-sm text-[#6A6A6A] mt-0.5">Update your account password</p>
            </div>
        </div>

        <span class="material-symbols-rounded text-[26px] text-[#B4B4B4]">chevron_right</span>
    </a>

</div>

{{-- WARNING BOX --}}
<div class="px-4 mt-8">
    <div class="bg-[#FFECEC] border border-[#FF9A9A] text-[#D83434] rounded-xl p-4 flex gap-3 items-start">
        {{-- Icon warning dibesarkan --}}
        <span class="material-symbols-rounded text-[24px] flex-shrink-0 mt-0.5">
            error
        </span>
        {{-- Teks warning jadi text-sm --}}
        <p class="text-sm leading-snug">
            Account settings here are only for your Kubik App account, 
            not for Pradita University SIAKAD.
        </p>
    </div>
</div>

@endsection