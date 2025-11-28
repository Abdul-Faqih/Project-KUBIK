@extends('user.layout.mobile')

@section('title', 'Home')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <!-- HEADER -->
    <div class="w-full flex items-center justify-between mt-3 px-6 mb-3">

        <!-- LEFT: CAMPUS LOGO (5732x2481 → scaled) -->
        <div class="flex items-center">
            <a href="{{ route('user.home') }}">
                <img src="{{ asset('images/kampus_berwarna.png') }}" class="w-[100px] h-auto object-contain">
            </a>
        </div>

        <!-- RIGHT: ACCOUNT ICON -->
        <a href="#" class="flex items-start justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="#F26E21">
                <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </a>

    </div>

    <!-- ADS SECTION -->
    <div class="w-full overflow-hidden">

        <!-- SLIDES -->
        <div id="adsSlider" class="relative w-full h-[200px] overflow-hidden">

            <div class="ads-slide w-full h-full absolute inset-0">
                <img src="{{ asset('images/ads/ADS1.PNG') }}" class="w-full h-full object-cover">
            </div>

            <div class="ads-slide w-full h-full absolute inset-0 hidden">
                <img src="{{ asset('images/ads/ADS2.PNG') }}" class="w-full h-full object-cover">
            </div>

            <div class="ads-slide w-full h-full absolute inset-0 hidden">
                <img src="{{ asset('images/ads/ADS3.PNG') }}" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- SLIDER DOTS -->
        <div class="flex justify-end mt-3 gap-2 px-5">
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full"></span>
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full"></span>
            <span class="ads-dot w-2 h-2 bg-[#CFCFCF] rounded-full"></span>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.ads-slide');
        const dots = document.querySelectorAll('.ads-dot');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('hidden', i !== index);
            });

            dots.forEach((dot, i) => {
                dot.style.backgroundColor = (i === index) ? "#F26E21" : "#CFCFCF";
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        showSlide(0);
        setInterval(nextSlide, 4000);
    </script>

@endsection