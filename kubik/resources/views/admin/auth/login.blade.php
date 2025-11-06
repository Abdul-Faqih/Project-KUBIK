<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Admin - KUBIK</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#ECEFF3] flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white w-[400px] rounded-3xl shadow-md px-10 py-10 text-center">
        <!-- Logo -->
        {{-- <div class="mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto w-14 h-14">
        </div> --}}

        <!-- Title -->
        <h1 class="text-[28px] font-bold text-[#F26E21] mb-2">Sign in</h1>
        <p class="text-[#AEAEAE] text-sm mb-8">Please insert your full name</p>

        <!-- Error Message -->
        @if (session('error'))
            <div class="bg-red-100 text-red-600 text-sm rounded-lg py-2 px-3 mb-5">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Masukan Email"
                value="{{ old('email') }}"
                class="w-full text-sm py-3 px-4 rounded-xl bg-[#FBFBFB] border border-[#FBFBFB] text-[#2A2A2A] focus:outline-none focus:ring-2 focus:ring-[#F26E21]" required>

            <input type="password" name="password" placeholder="Masukan Kata Sandi"
                class="w-full text-sm py-3 px-4 rounded-xl bg-[#FBFBFB] border border-[#FBFBFB] text-[#2A2A2A] focus:outline-none focus:ring-2 focus:ring-[#F26E21]" required>

            <div class="text-right">
                <a href="#" class="text-[#F26E21] text-sm hover:underline">Forgot password?</a>
            </div>

            <button type="submit"
                class="w-full bg-[#F26E21] hover:bg-[#e36017] transition text-white font-semibold py-3 rounded-xl">
                Masuk
            </button>
        </form>

        <p class="text-sm text-[#AEAEAE] mt-6">
            Don’t have an account?
            <a href="{{ route('admin.register') }}" class="text-[#F26E21] hover:underline font-semibold">Sign up</a>
        </p>
    </div>

</body>
</html>
