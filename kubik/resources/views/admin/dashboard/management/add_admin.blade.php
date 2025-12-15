@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Add Admin')

@section('content')
    <div class="-mt-5">
        {{-- Breadcrumb --}}
        <div class="text-base text-[#F26E21] mb-3">
            <a href="{{ route('admin.dashboard.admin_management') }}" class="hover:underline">Admin Management</a>
            <span class="text-[#2A2A2A]"> > Add Admin</span>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow p-8">
            <h2 class="text-[#F26E21] font-semibold text-lg mb-6">Add New Admin</h2>

            <form action="{{ route('admin.dashboard.admin_management.store') }}" method="POST">
                @csrf

                {{-- Name Input --}}
                <div class="mb-4">
                    <label class="block text-[#2A2A2A] text-base mb-1">Name</label>
                    <input name="name" type="text" placeholder="Full Name" value="{{ old('name') }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-[#F26E21] focus:ring-1 focus:ring-[#F26E21] focus:outline-none transition"
                        required />
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Input --}}
                <div class="mb-4">
                    <label class="block text-[#2A2A2A] text-base mb-1">Email</label>
                    <input name="email" type="email" placeholder="email@pradita.ac.id" value="{{ old('email') }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-[#F26E21] focus:ring-1 focus:ring-[#F26E21] focus:outline-none transition"
                        required />
                    <p class="text-xs text-[#AEAEAE] mt-1">*Must use @pradita.ac.id domain</p>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input (With Hide/Unhide) --}}
                <div class="mb-4">
                    <label class="block text-[#2A2A2A] text-base mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="passwordField" placeholder="Set Password"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 pr-12 text-base focus:border-[#F26E21] focus:ring-1 focus:ring-[#F26E21] focus:outline-none transition"
                            required />

                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-[#F26E21] transition">
                            <span id="showIcon" class="text-sm font-medium">Show</span>
                            <span id="hideIcon" class="hidden text-sm font-medium">Hide</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password Input (TAMBAHAN BARU) --}}
                <div class="mb-4">
                    <label class="block text-[#2A2A2A] text-base mb-1">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="confirmPasswordField"
                            placeholder="Retype Password"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 pr-12 text-base focus:border-[#F26E21] focus:ring-1 focus:ring-[#F26E21] focus:outline-none transition"
                            required />

                        <button type="button" id="toggleConfirmPassword"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-[#F26E21] transition">
                            <span id="showConfirmIcon" class="text-sm font-medium">Show</span>
                            <span id="hideConfirmIcon" class="hidden text-sm font-medium">Hide</span>
                        </button>
                    </div>
                </div>

                {{-- CAPTCHA (TAMBAHAN BARU) --}}
                <div class="mb-6">
                    <label class="block text-[#2A2A2A] text-base mb-1">Security Check</label>
                    <div class="flex items-center gap-3">
                        {{-- Kode Visual (Readonly) --}}
                        <div class="bg-gray-100 border border-[#ECEFF3] rounded-md px-4 py-2 select-none">
                            <span class="text-lg font-bold text-gray-600 tracking-widest strike-through"
                                style="text-decoration: line-through;">
                                {{ $captcha }}
                            </span>
                        </div>

                        {{-- Input User --}}
                        <input name="captcha" type="number" placeholder="Enter code"
                            class="flex-1 border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-[#F26E21] focus:ring-1 focus:ring-[#F26E21] focus:outline-none transition"
                            required />
                    </div>
                    <p class="text-xs text-[#AEAEAE] mt-1">Please enter the number shown in the box.</p>
                    @error('captcha')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('admin.dashboard.admin_management') }}"
                        class="px-4 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A] hover:bg-[#F5F5F5]">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-[#F26E21] text-white hover:bg-[#e65d1f] transition">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle Password Utama
        const passwordField = document.getElementById('passwordField');
        const toggleBtn = document.getElementById('togglePassword');
        const showIcon = document.getElementById('showIcon');
        const hideIcon = document.getElementById('hideIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordField.type === "password";
            passwordField.type = isPassword ? "text" : "password";
            showIcon.classList.toggle("hidden", isPassword);
            hideIcon.classList.toggle("hidden", !isPassword);
        });

        // Toggle Confirm Password (TAMBAHAN)
        const confirmPasswordField = document.getElementById('confirmPasswordField');
        const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');
        const showConfirmIcon = document.getElementById('showConfirmIcon');
        const hideConfirmIcon = document.getElementById('hideConfirmIcon');

        toggleConfirmBtn.addEventListener('click', () => {
            const isPassword = confirmPasswordField.type === "password";
            confirmPasswordField.type = isPassword ? "text" : "password";
            showConfirmIcon.classList.toggle("hidden", isPassword);
            hideConfirmIcon.classList.toggle("hidden", !isPassword);
        });
    </script>
@endsection