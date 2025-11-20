<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard | KUBIK')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#ECEFF3] min-h-screen flex flex-col font-sans">

    {{-- ================= SIDE NAVBAR (DISABLED) ================= --}}
    <aside class="w-64 bg-white shadow-lg h-screen fixed top-0 left-0 p-6 flex flex-col space-y-6">

        <!-- Logo -->
        <div class="flex items-center space-x-2 mb-8">
            <img src="{{ asset('images/logo.png') }}" class="w-12 h-12">
        </div>

        <!-- Main Navigation -->
        <nav class="flex flex-col space-y-3 flex-grow">

            <!-- Home -->
            <a href="{{ route('admin.dashboard.home') }}" class="text-base font-medium px-2 py-2 rounded-lg 
            {{ request()->routeIs('admin.dashboard.home') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }} 
            hover:text-[#F26E21] transition">
                Home
            </a>

            <!-- Assets -->
            <a href="{{ route('admin.dashboard.assets') }}" class="text-base font-medium px-2 py-2 rounded-lg 
            {{ request()->routeIs('admin.dashboard.assets') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }} 
            hover:text-[#F26E21] transition">
                Assets
            </a>

            <!-- Type -->
            <a href="#"
                class="text-base font-medium px-2 py-2 rounded-lg text-[#AEAEAE] hover:text-[#F26E21] transition">
                Types
            </a>

            <!-- Category -->
            <a href="#"
                class="text-base font-medium px-2 py-2 rounded-lg text-[#AEAEAE] hover:text-[#F26E21] transition">
                Categories
            </a>

            <!-- Permissions -->
            <a href="{{ route('admin.dashboard.permissions') }}" class="text-base font-medium px-2 py-2 rounded-lg 
            {{ request()->routeIs('admin.dashboard.permissions') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }} 
            hover:text-[#F26E21] transition">
                Permissions
            </a>

            <!-- Account -->
            <a href="#"
                class="text-base font-medium px-3 py-2 rounded-lg text-[#AEAEAE] hover:text-[#F26E21] transition">
                Account
            </a>
        </nav>


        <div class="pt-6 border-t border-gray-200">
            <a href="{{ route('admin.logout') }}"
                class="text-base font-medium px-3 py-2 rounded-lg text-red-500 hover:text-[#F26E21] transition block text-left">
                Log-out
            </a>
        </div>

    </aside>


    <!-- ================= CONTENT ================= -->
    <main class="flex-1 p-8 ml-64">
        @yield('content')
    </main>

</body>

</html>