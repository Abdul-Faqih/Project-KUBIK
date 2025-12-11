<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard | KUBIK')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
</head>

<body class="bg-[#ECEFF3] min-h-screen flex flex-col font-sans">

    {{-- ================= SIDE NAVBAR (DISABLED) ================= --}}
    <aside class="w-64 bg-white shadow-lg h-screen fixed top-0 left-0 p-6 flex flex-col space-y-6">

        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo2.png') }}" class="w-40 h-full">
        </div>

        <nav class="flex flex-col space-y-3 flex-grow">

            <a href="{{ route('admin.dashboard.home') }}" class="text-base font-medium px-2 py-2 rounded-lg 
            {{ request()->routeIs('admin.dashboard.home') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }} 
            hover:text-[#F26E21] transition">
                Home
            </a>

            <a href="{{ route('admin.dashboard.assets') }}" class="text-base font-medium px-2 py-2 rounded-lg 
            {{ request()->routeIs('admin.dashboard.assets*', 'admin.assetmasters*', 'admin.assets*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }} 
            hover:text-[#F26E21] transition">
                Assets
            </a>

            {{-- LOGIC: Hanya Tampilkan Types & Categories jika Role == Super-Admin --}}
            @php
                $adminId = session('admin_id');
                $currentRole = $adminId ? \App\Models\Admin::where('id_admin', $adminId)->value('role') : null;
            @endphp

            @if($currentRole === 'Super-Admin')

                <a href="{{ route('admin.dashboard.types') }}" class="text-base font-medium px-2 py-2 rounded-lg
                        {{ request()->routeIs('admin.dashboard.types*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }}
                         hover:text-[#F26E21] transition">
                    Types
                </a>

                <a href="{{ route('admin.dashboard.categories') }}" class="text-base font-medium px-2 py-2 rounded-lg
                        {{ request()->routeIs('admin.dashboard.categories*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }}
                         hover:text-[#F26E21] transition">
                    Categories
                </a>

            @endif
            {{-- END LOGIC --}}

            <a href="{{ route('admin.dashboard.permissions') }}" class="text-base font-medium px-2 py-2 rounded-lg
            {{ request()->routeIs('admin.dashboard.permissions*', 'admin.permissions*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }}
             hover:text-[#F26E21] transition">
                Permissions
            </a>
        </nav>


        <div class="pt-6 border-t border-gray-200">
            <a href="{{ route('admin.logout') }}"
                class="text-base font-medium px-3 py-2 rounded-lg text-red-500 hover:text-[#F26E21] transition block text-left">
                Log-out
            </a>
        </div>

    </aside>


    <main class="flex-1 p-8 ml-64">
        @yield('content')
    </main>

</body>

</html>