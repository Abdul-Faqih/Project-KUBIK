@extends('user.layout.mobile')

@section('title', 'Register - Step 1')

@section('content')

<div class="flex flex-col mt-16 w-full">

    <!-- LOGO -->
    <img src="{{ asset('images/logo_full.png') }}" class="w-[260px] mx-auto mb-10">

    <!-- STEP INDICATOR -->
    <div class="text-center mb-8">
        <p class="text-sm font-medium text-[#6A6A6A]">Step 1 of 3</p>

        <div class="flex justify-center gap-2 mt-2">
            <span class="w-3 h-3 rounded-full bg-[#F26E21]"></span>
            <span class="w-3 h-3 rounded-full bg-[#E0E0E0]"></span>
            <span class="w-3 h-3 rounded-full bg-[#E0E0E0]"></span>
        </div>
    </div>

    <!-- FORM -->
    <form method="POST" action="{{ route('user.register.step1.post') }}" class="w-full">
        @csrf

        <!-- FULL NAME -->
        <div class="w-full mb-4">
            <input type="text" name="name" id="nameInput"
                class="input-auth"
                placeholder="Insert Your Full Name">
        </div>

        <!-- PHONE NUMBER -->
        <div class="w-full mb-4">
            <input type="text" name="phone_number" id="phoneInput"
                class="input-auth"
                placeholder="Insert Your Phone Number">
        </div>

        <!-- ROLE -->
        <div class="w-full mb-6 relative">
            <select name="role" id="roleSelect"
                class="input-auth pr-12 appearance-none">
                <option value="">Select Your Role</option>
                <option value="Student">Student</option>
                <option value="Lecturer">Lecturer</option>
                <option value="Staff">Staff</option>
            </select>

            <!-- DROPDOWN ARROW -->
            <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[#9A9A9A]">
                expand_more
            </span>
        </div>

        <!-- NEXT BUTTON -->
        <button type="submit"
            id="nextBtn"
            class="w-full h-[52px] rounded-xl font-semibold bg-[#CFCFCF] t  ext-[#9A9A9A] cursor-not-allowed transition">
            Next
        </button>
    </form>

    <!-- ALREADY HAVE ACCOUNT -->
    <p class="text-sm text-[#2A2A2A] mt-3 text-center">
        Already have an account?
        <a href="{{ route('user.login') }}" class="text-[#F26E21] font-medium">Log In</a>
    </p>
</div>

@endsection

<!-- CUSTOM INPUT STYLE -->
<style>
.input-auth {
    @apply w-full h-[52px] px-5 border border-[#CFCFCF] rounded-xl bg-white
           text-[#2A2A2A] placeholder-[#CFCFCF]
           focus:outline-none focus:border-[#F26E21];
}
.input-auth.filled {
    border-color: #F26E21 !important;
}
</style>

<!-- INPUT & BUTTON SCRIPT -->
<script>
// INPUT ELEMENTS
const nameInput = document.getElementById('nameInput');
const phoneInput = document.getElementById('phoneInput');
const roleSelect = document.getElementById('roleSelect');
const nextBtn = document.getElementById('nextBtn');

// BORDER ORANGE WHEN FILLED
function updateBorder(el) {
    if (el.value.trim() !== "") el.classList.add("filled");
    else el.classList.remove("filled");
}

// ENABLE / DISABLE BUTTON
function validateForm() {
    if (
        nameInput.value.trim() !== "" &&
        phoneInput.value.trim() !== "" &&
        roleSelect.value !== ""
    ) {
        nextBtn.disabled = false;
        nextBtn.classList.remove("bg-[#CFCFCF]", "text-[#9A9A9A]", "cursor-not-allowed");
        nextBtn.classList.add("bg-[#F26E21]", "text-white", "cursor-pointer");
    } else {
        nextBtn.disabled = true;
        nextBtn.classList.add("bg-[#CFCFCF]", "text-[#9A9A9A]", "cursor-not-allowed");
        nextBtn.classList.remove("bg-[#F26E21]", "text-white", "cursor-pointer");
    }
}

// LISTENERS
[nameInput, phoneInput].forEach(el => {
    el.addEventListener('input', () => {
        updateBorder(el);
        validateForm();
    });
});

roleSelect.addEventListener('change', () => {
    updateBorder(roleSelect);
    validateForm();
});
</script>
