@extends('user.layout.mobile')

@section('title', 'Register')

@section('content')

{{-- 
    WRAPPER LAYAR 
    UBAH DISINI:
    1. 'items-center' diganti jadi 'items-start' (Biar nempel atas)
    2. Ditambah 'pt-10' (Biar turun dikit dari atas, jarak fix)
--}}
<div class="min-h-screen flex justify-center items-start pt-10 px-4 pb-10 bg-white">

    <div class="w-full max-w-[360px]">

        {{-- === HEADER === --}}
        {{-- Hapus -translate-y-24, biarkan natural karena sudah diatur pt-10 diatas --}}
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('user.register.role') }}" 
               class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition-colors">
                <span class="material-symbols-rounded text-[28px] text-[#2A2A2A]">
                    arrow_back
                </span>
            </a>

            <h1 class="text-xl font-bold text-[#2A2A2A]">
                Register as {{ $role }}
            </h1>
        </div>

        {{-- === FORM === --}}
        {{-- Hapus -translate-y-10 --}}
        <form action="{{ route('user.register.submit') }}" method="POST" id="registerForm">
            @csrf

            {{-- === ERROR ALERT SECTION === --}}
            @if ($errors->any() || session('error'))
                <div class="mb-6 bg-[#FFECEC] border border-[#FF9A9A] rounded-xl p-4 flex gap-3 items-start animate-pulse">
                    <span class="material-symbols-rounded text-[#D83434] text-[24px] mt-0.5 flex-shrink-0">
                        error
                    </span>
                    <div class="text-sm text-[#D83434]">
                        <p class="font-bold mb-1">Please fix the following errors:</p>
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            @if(session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif

            {{-- === ISI FORM === --}}
            
            <div class="mb-4 space-y-1">
                <input type="text" name="name" class="input-auth" placeholder="Full Name" value="{{ old('name') }}" autocomplete="off">
                @error('name') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4 space-y-1">
                <input type="text" name="phone_number" class="input-auth" placeholder="Phone Number" value="{{ old('phone_number') }}" autocomplete="off">
                @error('phone_number') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
            </div>

            {{-- STUDENT --}}
            @if($role === 'Student')
                <div class="mb-4 space-y-1">
                    <input type="text" name="nim" class="input-auth" placeholder="Student ID (NIM)" value="{{ old('nim') }}" autocomplete="off">
                    @error('nim') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 relative space-y-1">
                    <select name="enrollment" class="input-auth appearance-none pr-12 cursor-pointer">
                        <option value="">Enrollment Year</option>
                        @for($i = 2020; $i <= 2025; $i++)
                            <option value="{{ $i }}" {{ old('enrollment') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    @error('enrollment') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 relative space-y-1">
                    <select name="program" class="input-auth appearance-none pr-12 cursor-pointer">
                        <option value="">Study Program</option>
                        @foreach($programs as $prog)
                             <option value="{{ $prog }}" {{ old('program') == $prog ? 'selected' : '' }}>{{ $prog }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    @error('program') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- LECTURER --}}
            @if($role === 'Lecturer')
                <div class="mb-4 space-y-1">
                    <input type="text" name="nip" class="input-auth" placeholder="Lecturer NIP" value="{{ old('nip') }}" autocomplete="off">
                    @error('nip') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- STAFF --}}
            @if($role === 'Staff')
                <div class="mb-4 space-y-1">
                    <input type="text" name="nip" class="input-auth" placeholder="Staff NIP" value="{{ old('nip') }}" autocomplete="off">
                    @error('nip') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 relative space-y-1">
                    <select name="unit" class="input-auth appearance-none pr-12 cursor-pointer">
                        <option value="">Unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    @error('unit') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 relative space-y-1">
                    <select name="department" class="input-auth appearance-none pr-12 cursor-pointer">
                        <option value="">Department</option>
                         @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    @error('department') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- EMAIL --}}
            <div class="mb-4 space-y-1">
                <input type="email" name="email" class="input-auth" placeholder="Email Address" value="{{ old('email') }}" autocomplete="off">
                @error('email') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
            </div>

            {{-- PASSWORD (TEXT SHOW/HIDE) --}}
            <div class="mb-4 space-y-1">
                <div class="relative w-full">
                    <input type="password" name="password" id="registerPassword" 
                           class="input-auth pr-16" placeholder="Password">
                    <span id="toggleRegisterPassword"
                          class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#AEAEAE] cursor-pointer font-medium select-none">
                        Show
                    </span>
                </div>
                @error('password') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
            </div>

            {{-- CONFIRM PASSWORD (TEXT SHOW/HIDE) --}}
            <div class="mb-10 space-y-1">
                <div class="relative w-full">
                    <input type="password" name="password_confirm" id="confirmPassword" 
                           class="input-auth pr-16" placeholder="Confirm Password">
                    <span id="toggleConfirmPassword"
                          class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#AEAEAE] cursor-pointer font-medium select-none">
                        Show
                    </span>
                </div>
                @error('password_confirm') <span class="text-red-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
            </div>

            {{-- BUTTON --}}
            <button type="submit" id="submitBtn" disabled
                class="w-full bg-[#E0E0E0] text-[#A0A0A0] py-3.5 rounded-xl font-bold text-[16px] tracking-wide cursor-not-allowed transition-colors duration-300">
                Register Now
            </button>

        </form>
    </div>

</div>

{{-- Styles --}}
<style>
    .input-auth {
        width: 100%;
        height: 52px;
        padding-left: 1.25rem;
        border: 1.5px solid #F0F0F0;
        border-radius: 0.875rem;
        background-color: #FAFAFA;
        color: #2A2A2A;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }
    .input-auth::placeholder { color: #B0B0B0; font-weight: 400; }
    .input-auth:focus { outline: none; background-color: #FFFFFF; border-color: #F26E21; box-shadow: 0 4px 12px rgba(242, 110, 33, 0.1); }
</style>

{{-- SCRIPTS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const inputs = form.querySelectorAll('input, select');
        function checkInputs() {
            let allFilled = true;
            inputs.forEach(input => {
                if (input.offsetParent !== null) {
                    if (input.value.trim() === '') { allFilled = false; }
                }
            });
            if (allFilled) {
                submitBtn.removeAttribute('disabled');
                submitBtn.classList.remove('bg-[#E0E0E0]', 'text-[#A0A0A0]', 'cursor-not-allowed');
                submitBtn.classList.add('bg-[#F26E21]', 'text-white', 'hover:bg-[#d65a15]', 'cursor-pointer');
            } else {
                submitBtn.setAttribute('disabled', 'disabled');
                submitBtn.classList.add('bg-[#E0E0E0]', 'text-[#A0A0A0]', 'cursor-not-allowed');
                submitBtn.classList.remove('bg-[#F26E21]', 'text-white', 'hover:bg-[#d65a15]', 'cursor-pointer');
            }
        }
        inputs.forEach(input => { input.addEventListener('input', checkInputs); input.addEventListener('change', checkInputs); });
        checkInputs();

        function setupToggle(inputId, toggleId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);
            toggle.addEventListener('click', () => {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                toggle.textContent = isHidden ? 'Hide' : 'Show';
            });
        }
        setupToggle('registerPassword', 'toggleRegisterPassword');
        setupToggle('confirmPassword', 'toggleConfirmPassword');
    });
</script>

{{-- POPUP SUKSES --}}
@if(session('register_success'))
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-2xl shadow-2xl text-center max-w-sm w-[90%] transform scale-100 transition-all">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-rounded text-5xl text-green-600">check_circle</span>
            </div>
            <h2 class="text-2xl font-bold text-[#2A2A2A] mb-2">Registration Successful!</h2>
            <p class="text-[#9A9A9A] mb-6">Please wait, you will be redirected to the login page...</p>
            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2 overflow-hidden">
                <div class="bg-green-500 h-1.5 rounded-full animate-progress"></div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('user.login') }}"; 
        }, 3000);
    </script>
    <style>
        @keyframes progress { from { width: 0%; } to { width: 100%; } }
        .animate-progress { animation: progress 3s linear forwards; }
    </style>
@endif

@endsection