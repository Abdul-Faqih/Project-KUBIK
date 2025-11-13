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

    <!-- ================= TOP NAVBAR ================= -->
    <header class="bg-white shadow-base w-full flex items-center justify-between px-6 py-3">
        <!-- Left section: Logo + Nav Tabs -->
        <div class="flex items-center space-x-7">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-11 h-11">
            </div>

            <!-- Navigation Tabs -->
            <nav class="flex space-x-6">
                <!-- Home -->
                <a href="{{ route('admin.dashboard.home') }}"
                    class="flex flex-col items-center {{ request()->routeIs('admin.dashboard.home') ? 'text-[#F26E21]' : 'text-[#AEAEAE]' }} hover:text-[#F26E21] transition">
                    <span class="text-base font-semibold">Home</span>
                </a>

                <!-- Assets -->
                <a href="{{ route('admin.dashboard.assets') }}"
                    class="flex flex-col items-center {{ request()->routeIs('admin.dashboard.assets') ? 'text-[#F26E21]' : 'text-[#AEAEAE]' }} hover:text-[#F26E21] transition">
                    <span class="text-base font-semibold">Assets</span>
                </a>

                <!-- Permissions -->
                <a href="{{ route('admin.dashboard.permissions') }}"
                    class="flex flex-col items-center {{ request()->routeIs('admin.dashboard.permissions') ? 'text-[#F26E21]' : 'text-[#AEAEAE]' }} hover:text-[#F26E21] transition">
                    <span class="text-base font-semibold">Permissions</span>
                </a>
            </nav>


        </div>

        <!-- Right section: User Info -->

        <div class="flex items-center space-x-4">

            <a href="{{ route('admin.logout') }}"
                class="flex flex-col items-center {{ request()->routeIs('admin.logout') ? 'text-[#F26E21]' : 'text-[#ff0000]' }} hover:text-[#aeaeae] transition">
                <span class="text-base">Log-out</span>
            </a>
        </div>
    </header>

    <!-- ================= CONTENT ================= -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</body>

</html>