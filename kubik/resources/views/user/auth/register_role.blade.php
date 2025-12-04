@extends('user.layout.register')

@section('title', 'Select Role')

@section('content')

{{-- 
    WRAPPER UTAMA
    min-h-[100dvh] : Menggunakan Dynamic Viewport Height (Supaya pas di layar HP dengan address bar)
    flex flex-col justify-center : Memusatkan secara vertikal
--}}
<div class="min-h-[100dvh] w-full flex flex-col justify-center items-center px-6 bg-white">

    {{-- 
        KONTEN WRAPPER 
        -mt-10 : INI KUNCINYA. 
        Kita tarik konten naik sekitar 40px ke atas. 
        Ini mengkompensasi berat visual logo dan membuat tampilan benar-benar terlihat di tengah.
    --}}
    <div class="w-full max-w-[360px] flex flex-col items-center -mt-10">

        <img src="{{ asset('images/logo_full.png') }}" class="w-[220px] mb-10">

        <h1 class="text-lg font-semibold text-center mb-6">Select Your Role</h1>

        <form action="{{ route('user.register.form.open') }}" method="POST" id="roleForm" class="w-full">
            @csrf
            <input type="hidden" name="selected_role" id="selectedRole">

            <div class="space-y-4">

                <div class="role-card flex items-center gap-4 px-4 py-4 rounded-xl border border-[#E5E5E5] cursor-pointer transition"
                    data-role="Student">
                    <img src="{{ asset('images/icon_student.png') }}" class="w-10">
                    <span class="font-medium text-[#2A2A2A] text-base">Student</span>
                </div>

                <div class="role-card flex items-center gap-4 px-4 py-4 rounded-xl border border-[#E5E5E5] cursor-pointer transition"
                    data-role="Lecturer">
                    <img src="{{ asset('images/icon_lecturer.png') }}" class="w-10">
                    <span class="font-medium text-[#2A2A2A] text-base">Lecturer</span>
                </div>

                <div class="role-card flex items-center gap-4 px-4 py-4 rounded-xl border border-[#E5E5E5] cursor-pointer transition"
                    data-role="Staff">
                    <img src="{{ asset('images/icon_staff.png') }}" class="w-10">
                    <span class="font-medium text-[#2A2A2A] text-base">Staff</span>
                </div>

            </div>

            <button type="submit" id="continueBtn"
                disabled
                class="w-full bg-[#E0E0E0] text-[#9A9A9A] py-3.5 rounded-xl font-bold mt-10 cursor-not-allowed transition duration-300">
                Continue
            </button>

        </form>

        {{-- FOOTER LINK --}}
        <p class="text-sm text-[#2A2A2A] mt-2 text-center">
            Already have an account?
            <a href="{{ route('user.login') }}" class="text-[#F26E21] font-medium">Log In</a>
        </p>

    </div>

</div>

<script>
    const cards = document.querySelectorAll(".role-card");
    const selectedRole = document.getElementById("selectedRole");
    const continueBtn = document.getElementById("continueBtn");

    cards.forEach(card => {
        card.addEventListener("click", function () {
            // Reset style semua card
            cards.forEach(c => c.classList.remove("border-[#F26E21]", "bg-[#FFF2E9]"));
            
            // Set style card yang dipilih
            this.classList.add("border-[#F26E21]", "bg-[#FFF2E9]");

            // Set value input hidden
            selectedRole.value = this.dataset.role;

            // Enable tombol
            continueBtn.disabled = false;
            continueBtn.classList.remove("bg-[#E0E0E0]", "text-[#9A9A9A]", "cursor-not-allowed");
            continueBtn.classList.add("bg-[#F26E21]", "text-white", "hover:bg-[#d65a15]");
        });
    });
</script>

@endsection