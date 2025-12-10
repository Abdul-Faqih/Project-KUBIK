@extends('user.layout.mobile')

@section('title', 'Register')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    {{-- WRAPPER LAYAR --}}
    <div class="min-h-screen flex justify-center items-start pt-5 px-4 pb-10 bg-white">

        <div class="w-full max-w-[360px]">

            {{-- === HEADER === --}}
            <div class="flex items-center gap-3 mb-8">
                <button type="button" onclick="openBackModal()"
                    class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition-colors">
                    <span class="material-symbols-rounded text-[28px] text-[#2A2A2A]">
                        arrow_back
                    </span>
                </button>

                <h1 class="text-xl font-bold text-[#2A2A2A]">
                    Register as {{ $role }}
                </h1>
            </div>

            {{-- === FORM === --}}
            <form action="{{ route('user.register.submit') }}" method="POST" id="registerForm">
                @csrf

                {{-- Hidden Input Role --}}
                <input type="hidden" name="role" value="{{ $role }}">

                {{-- === ISI FORM === --}}

                <div class="mb-4 space-y-1">
                    <input type="text" name="name" class="input-auth" placeholder="Full Name" value="{{ old('name') }}"
                        autocomplete="off">
                </div>

                {{-- UBAH DISINI: Validasi Phone Number --}}
                <div class="mb-4 space-y-1">
                    <input type="tel" name="phone_number" id="phoneNumber" class="input-auth" placeholder="Phone Number"
                        value="{{ old('phone_number') }}" autocomplete="off"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"> {{-- Hanya izinkan angka saat mengetik
                    --}}
                </div>

                {{-- STUDENT --}}
                @if($role === 'Student')
                    <div class="mb-4 space-y-1">
                        <input type="text" name="nim" class="input-auth" placeholder="Student ID (NIM)" value="{{ old('nim') }}"
                            autocomplete="off">
                    </div>

                    <div class="mb-4 relative space-y-1">
                        <select name="enrollment" class="input-auth appearance-none pr-12 cursor-pointer">
                            <option value="">Enrollment Year</option>
                            @for($i = 2020; $i <= 2025; $i++)
                                <option value="{{ $i }}" {{ old('enrollment') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <span
                            class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    </div>

                    <div class="mb-4 relative space-y-1">
                        <select name="program" class="input-auth appearance-none pr-12 cursor-pointer">
                            <option value="">Study Program</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog }}" {{ old('program') == $prog ? 'selected' : '' }}>{{ $prog }}</option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    </div>
                @endif

                {{-- LECTURER --}}
                @if($role === 'Lecturer')
                    <div class="mb-4 space-y-1">
                        <input type="text" name="nip" class="input-auth" placeholder="Lecturer NIP" value="{{ old('nip') }}"
                            autocomplete="off">
                    </div>
                @endif

                {{-- STAFF --}}
                @if($role === 'Staff')
                    <div class="mb-4 space-y-1">
                        <input type="text" name="nip" class="input-auth" placeholder="Staff NIP" value="{{ old('nip') }}"
                            autocomplete="off">
                    </div>

                    <div class="mb-4 relative space-y-1">
                        <select name="unit" class="input-auth appearance-none pr-12 cursor-pointer">
                            <option value="">Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    </div>

                    <div class="mb-4 relative space-y-1">
                        <select name="department" class="input-auth appearance-none pr-12 cursor-pointer">
                            <option value="">Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A] pointer-events-none">expand_more</span>
                    </div>
                @endif

                {{-- EMAIL --}}
                <div class="mb-4 space-y-1">
                    <input type="email" name="email" id="emailInput" class="input-auth"
                        placeholder="Email Address (@pradita.ac.id)" value="{{ old('email') }}" autocomplete="off">
                    <p class="text-[11px] text-gray-400 ml-2 mt-1 italic">*Must use @student.pradita.ac.id or @pradita.ac.id
                    </p>
                </div>

                {{-- PASSWORD (TEXT SHOW/HIDE) --}}
                <div class="mb-4 space-y-1">
                    <div class="relative w-full">
                        <input type="password" name="password" id="registerPassword" class="input-auth pr-16"
                            placeholder="Password">
                        <span id="toggleRegisterPassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#AEAEAE] cursor-pointer font-medium select-none">
                            Show
                        </span>
                    </div>
                </div>

                {{-- CONFIRM PASSWORD (TEXT SHOW/HIDE) --}}
                <div class="mb-10 space-y-1">
                    <div class="relative w-full">
                        <input type="password" name="password_confirm" id="confirmPassword" class="input-auth pr-16"
                            placeholder="Confirm Password">
                        <span id="toggleConfirmPassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#AEAEAE] cursor-pointer font-medium select-none">
                            Show
                        </span>
                    </div>
                </div>

                {{-- BUTTON --}}
                <button type="button" id="submitBtn" disabled onclick="validateAndOpenModal()"
                    class="w-full bg-[#E0E0E0] text-[#A0A0A0] py-3.5 rounded-xl font-bold text-[16px] tracking-wide cursor-not-allowed transition-colors duration-300">
                    Register Now
                </button>

            </form>
        </div>

    </div>

    {{-- =========================================== --}}
    {{-- TOAST NOTIFICATION --}}
    {{-- =========================================== --}}
    <div id="toast"
        class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-full shadow-lg z-[60] transition-all duration-300 opacity-0 pointer-events-none translate-y-[-20px] flex items-center gap-2 w-max max-w-[90%]">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span id="toast-message" class="text-sm font-semibold">Error Message!</span>
    </div>

    {{-- =========================================== --}}
    {{-- MODAL KONFIRMASI REGISTER --}}
    {{-- =========================================== --}}
    <div id="registerModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-[85%] max-w-[320px] p-6 text-center transform scale-90 transition-transform duration-300"
            id="registerModalContent">

            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#F26E21]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-2">Confirm Registration</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure all data is correct and you want to register?</p>

            <div class="flex gap-3">
                <button onclick="closeRegisterModal()"
                    class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button onclick="submitRealForm()"
                    class="flex-1 py-2.5 bg-[#F26E21] text-white rounded-xl font-semibold shadow-md hover:bg-orange-600 transition">
                    Yes, Register
                </button>
            </div>
        </div>
    </div>

    {{-- =========================================== --}}
    {{-- MODAL KONFIRMASI BACK --}}
    {{-- =========================================== --}}
    <div id="backModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-[85%] max-w-[320px] p-6 text-center transform scale-90 transition-transform duration-300"
            id="backModalContent">

            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-2">Leave Registration?</h3>
            <p class="text-sm text-gray-500 mb-6">If you leave now, your data will be lost. Are you sure?</p>

            <div class="flex gap-3">
                <button onclick="closeBackModal()"
                    class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">
                    Stay
                </button>
                <button onclick="confirmBack()"
                    class="flex-1 py-2.5 bg-red-500 text-white rounded-xl font-semibold shadow-md hover:bg-red-600 transition">
                    Leave
                </button>
            </div>
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

        .input-auth::placeholder {
            color: #B0B0B0;
            font-weight: 400;
        }

        .input-auth:focus {
            outline: none;
            background-color: #FFFFFF;
            border-color: #F26E21;
            box-shadow: 0 4px 12px rgba(242, 110, 33, 0.1);
        }
    </style>

    {{-- SCRIPTS --}}
    <script>
        // --- TOAST FUNCTION ---
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');

            toastMsg.innerText = message;
            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');

            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');
            }, 4000);
        }

        // --- CEK ERROR DARI SERVER (SESSION) ---
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function () {
                showToast("{{ $errors->first() }}");
            });
        @endif
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                showToast("{{ session('error') }}");
            });
        @endif

        // --- MAIN SCRIPT ---
        document.addEventListener('DOMContentLoaded', function () {
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

        // --- VALIDASI CLIENT SIDE SEBELUM MODAL MUNCUL ---
        function validateAndOpenModal() {
            const emailInput = document.getElementById('emailInput').value;
            const phoneInput = document.getElementById('phoneNumber').value;
            const pass = document.getElementById('registerPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;

            // UBAH DISINI: Validasi Phone Number (Hanya Angka & Panjang 7-13)
            // Note: Meskipun 'oninput' sudah memfilter huruf, kita validasi lagi panjangnya di sini
            const phoneRegex = /^[0-9]+$/;
            if (!phoneRegex.test(phoneInput)) {
                showToast("Phone number must contain only numbers!");
                return;
            }
            if (phoneInput.length < 7 || phoneInput.length > 13) {
                showToast("Phone number must be between 7 and 13 digits!");
                return;
            }

            // Validasi Email Pradita
            if (!emailInput.endsWith('@student.pradita.ac.id') && !emailInput.endsWith('@pradita.ac.id')) {
                showToast("Email must use @student.pradita.ac.id or @pradita.ac.id");
                return;
            }

            // Validasi Password Match
            if (pass !== confirmPass) {
                showToast("Passwords do not match!");
                return;
            }

            // Jika lolos, buka modal
            openRegisterModal();
        }

        // --- MODAL LOGIC REGISTER ---
        const regModal = document.getElementById('registerModal');
        const regContent = document.getElementById('registerModalContent');

        function openRegisterModal() {
            regModal.classList.remove('hidden');
            setTimeout(() => {
                regModal.classList.remove('opacity-0');
                regContent.classList.remove('scale-90');
                regContent.classList.add('scale-100');
            }, 10);
        }

        function closeRegisterModal() {
            regModal.classList.add('opacity-0');
            regContent.classList.remove('scale-100');
            regContent.classList.add('scale-90');
            setTimeout(() => {
                regModal.classList.add('hidden');
            }, 300);
        }

        function submitRealForm() {
            document.getElementById('registerForm').submit();
        }

        // --- MODAL LOGIC BACK BUTTON ---
        const backModal = document.getElementById('backModal');
        const backContent = document.getElementById('backModalContent');

        function openBackModal() {
            backModal.classList.remove('hidden');
            setTimeout(() => {
                backModal.classList.remove('opacity-0');
                backContent.classList.remove('scale-90');
                backContent.classList.add('scale-100');
            }, 10);
        }

        function closeBackModal() {
            backModal.classList.add('opacity-0');
            backContent.classList.remove('scale-100');
            backContent.classList.add('scale-90');
            setTimeout(() => {
                backModal.classList.add('hidden');
            }, 300);
        }

        function confirmBack() {
            window.location.href = "{{ route('user.register.role') }}";
        }
    </script>

    {{-- POPUP SUKSES DARI SESSION --}}
    @if(session('register_success'))
        <div class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 backdrop-blur-sm">
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
            setTimeout(function () {
                window.location.href = "{{ route('user.login') }}";
            }, 3000);
        </script>
        <style>
            @keyframes progress {
                from {
                    width: 0%;
                }

                to {
                    width: 100%;
                }
            }

            .animate-progress {
                animation: progress 3s linear forwards;
            }
        </style>
    @endif

@endsection