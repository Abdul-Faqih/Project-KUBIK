@extends('user.layout.mobile')

@section('title', 'Profile')

@section('content')
@section('wrapperClass', 'onboarding-wrapper')

<div class="flex items-center gap-3 mb-6 mt-6 px-2">
    <a href="{{ route('user.profile') }}" class="material-symbols-rounded text-[26px] text-[#2A2A2A]">arrow_back</a>
    <h1 class="text-lg font-semibold text-[#2A2A2A]">Profile</h1>
</div>

<div class="px-4 pb-10"> {{-- Tambah pb-10 biar scroll bawah ga mentok --}}

    <h2 class="text-base font-semibold text-[#2A2A2A] mb-2">Personal Data</h2>

    @php
        $user = user(); // helper
        $phone = $user->phone_number ?? '-';

        // MASKING NOMOR
        if(strlen($phone) >= 4){
            $maskedPhone = substr($phone, 0, 4) . str_repeat('*', strlen($phone) - 6) . substr($phone, -2);
        } else {
            $maskedPhone = $phone;
        }
    @endphp

    {{-- FULL NAME --}}
    <div class="flex items-center py-4 border-b border-[#E5E5E5]">
        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
            <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">person</span>
        </div>
        <div class="ml-4">
            <p class="text-sm text-[#6A6A6A]">Full Name</p>
            <p class="text-base font-medium text-[#2A2A2A]">{{ $user->name }}</p>
        </div>
    </div>

    {{-- PHONE NUMBER --}}
    <div class="flex items-center py-4 border-b border-[#E5E5E5]">
        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
            <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">call</span>
        </div>
        <div class="ml-4">
            <p class="text-sm text-[#6A6A6A]">Phone Number</p>
            <p class="text-base font-medium text-[#2A2A2A]">{{ $maskedPhone }}</p>
        </div>
    </div>

    {{-- EMAIL (FIXED OVERLOAD) --}}
    <div class="flex items-center py-4 border-b border-[#E5E5E5]">
        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
            <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">mail</span>
        </div>
        <div class="ml-4 w-full overflow-hidden"> {{-- Tambah overflow-hidden --}}
            <p class="text-sm text-[#6A6A6A]">Email</p>
            {{-- Tambahkan 'break-all' agar email panjang turun ke bawah --}}
            <p class="text-base font-medium text-[#2A2A2A] break-all leading-tight pr-2">
                {{ $user->email }}
            </p>
        </div>
    </div>

    {{-- ROLE-BASED FIELDS --}}
    @if($user->role === 'Student')

        {{-- NIM --}}
        <div class="flex items-center py-4 border-b border-[#E5E5E5]">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
                <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">badge</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-[#6A6A6A]">NIM</p>
                <p class="text-base font-medium text-[#2A2A2A]">{{ $user->nim }}</p>
            </div>
        </div>

        {{-- ENROLLMENT --}}
        <div class="flex items-center py-4 border-b border-[#E5E5E5]">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
                <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">event</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-[#6A6A6A]">Enrollment Year</p>
                <p class="text-base font-medium text-[#2A2A2A]">{{ $user->enrollment }}</p>
            </div>
        </div>

        {{-- PROGRAM --}}
        <div class="flex items-center py-4 border-b border-[#E5E5E5]">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
                <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">menu_book</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-[#6A6A6A]">Study Program</p>
                <p class="text-base font-medium text-[#2A2A2A]">{{ $user->program }}</p>
            </div>
        </div>

    @elseif($user->role === 'Lecturer')

        {{-- NIP --}}
        <div class="flex items-center py-4 border-b border-[#E5E5E5]">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
                <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">badge</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-[#6A6A6A]">NIP</p>
                <p class="text-base font-medium text-[#2A2A2A]">{{ $user->nip }}</p>
            </div>
        </div>

    @elseif($user->role === 'Staff')

        {{-- NIP --}}
        <div class="flex items-center py-4 border-b border-[#E5E5E5]">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
                <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">badge</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-[#6A6A6A]">NIP</p>
                <p class="text-base font-medium text-[#2A2A2A]">{{ $user->nip }}</p>
            </div>
        </div>

        {{-- UNIT --}}
        <div class="flex items-center py-4 border-b border-[#E5E5E5]">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
                <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">apartment</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-[#6A6A6A]">Unit</p>
                <p class="text-base font-medium text-[#2A2A2A]">{{ $user->unit }}</p>
            </div>
        </div>

        {{-- DEPARTMENT --}}
        <div class="flex items-center py-4 border-b border-[#E5E5E5]">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-[#F8F8F8]">
                <span class="material-symbols-rounded text-[26px] text-[#2A2A2A]">account_tree</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-[#6A6A6A]">Department</p>
                <p class="text-base font-medium text-[#2A2A2A]">{{ $user->department }}</p>
            </div>
        </div>

    @endif

</div> {{-- Penutup DIV px-4 --}}

@endsection