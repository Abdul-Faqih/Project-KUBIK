<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Admin - KUBIK</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#ECEFF3] flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white w-[400px] rounded-3xl shadow-md px-10 py-10 text-center">
        <!-- Logo -->
        {{-- <div class="mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto w-14 h-14">
        </div> --}}

        <!-- Title -->
        <h1 class="text-[28px] font-bold text-[#F26E21] mb-2">Sign up</h1>
        <p class="text-[#AEAEAE] text-sm mb-8">Please insert your full name</p>

        <!-- Error -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 text-sm rounded-lg py-2 px-3 mb-5">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('admin.register.store') }}" class="space-y-4">
            @csrf

            <input type="text" name="name" value="{{ old('name') }}" 
                placeholder="Masukan Nama Lengkap"
                class="w-full text-sm py-3 px-4 rounded-xl bg-[#FBFBFB] border border-[#FBFBFB] text-[#2A2A2A] focus:outline-none focus:ring-2 focus:ring-[#F26E21]" required>

            <input type="email" name="email" value="{{ old('email') }}" 
                placeholder="Masukan Email"
                class="w-full text-sm py-3 px-4 rounded-xl bg-[#FBFBFB] border border-[#FBFBFB] text-[#2A2A2A] focus:outline-none focus:ring-2 focus:ring-[#F26E21]" required>

            <input type="password" name="password"
                placeholder="Masukan Kata Sandi"
                class="w-full text-sm py-3 px-4 rounded-xl bg-[#FBFBFB] border border-[#FBFBFB] text-[#2A2A2A] focus:outline-none focus:ring-2 focus:ring-[#F26E21]" required>

            <button type="submit"
                class="w-full bg-[#F26E21] hover:bg-[#e36017] transition text-white font-semibold py-3 rounded-xl">
                Daftar
            </button>

            <p class="text-sm text-[#AEAEAE] mt-6">
                Already have an account?
                <a href="{{ route('admin.login') }}" class="text-[#F26E21] hover:underline font-semibold">Sign in</a>
            </p>
        </form>
    </div>

</body>
</html>
