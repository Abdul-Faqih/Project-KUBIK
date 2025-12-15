@extends('user.layout.mobile')

@section('title', 'Notification')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    {{-- BACK + TITLE --}}
    <div class="flex items-center gap-3 mb-6 mt-6 px-4">
        {{-- Ikon Back --}}
        <a href="{{ route('user.profile') }}" class="material-symbols-rounded text-[26px] text-[#2A2A2A]">arrow_back</a>

        {{-- Teks Notification --}}
        <h1 class="text-lg font-semibold text-[#2A2A2A]">Notification</h1>
    </div>