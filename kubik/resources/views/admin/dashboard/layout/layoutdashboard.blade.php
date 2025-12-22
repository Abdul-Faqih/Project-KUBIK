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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght@300;400;500&display=swap" />
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

            <a href="{{ route('admin.dashboard.permissions') }}" class="text-base font-medium px-2 py-2 rounded-lg
            {{ request()->routeIs('admin.dashboard.permissions*', 'admin.permissions*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }}
             hover:text-[#F26E21] transition">
                Permissions
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

                <a href="{{ route('admin.dashboard.admin_management') }}" class="text-base font-medium px-2 py-2 rounded-lg
                            {{ request()->routeIs('admin.dashboard.admin_management*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }}
                             hover:text-[#F26E21] transition">
                    Admin Management
                </a>

                <a href="{{ route('admin.dashboard.user_management') }}" class="text-base font-medium px-2 py-2 rounded-lg
                            {{ request()->routeIs('admin.dashboard.user_management*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }}
                             hover:text-[#F26E21] transition">
                    User Management
                </a>

            @endif
            {{-- END LOGIC --}}
            <a href="{{ route('admin.dashboard.profile', $adminId) }}" class="text-base font-medium px-2 py-2 rounded-lg 
            {{ request()->routeIs('admin.dashboard.profile*') ? 'text-[#F26E21] bg-[#FFF3EC]' : 'text-[#AEAEAE]' }} 
            hover:text-[#F26E21] transition">
                Details Profile
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
    
    {{-- TOAST NOTIFICATION --}}
    <div id="adminToast"
        class="fixed top-24 right-5 z-[9999] transition-transform duration-500 transform translate-x-[150%] max-w-sm w-full bg-white border-l-4 border-[#F26E21] rounded-lg shadow-lg p-4 flex items-start gap-3">

        {{-- Icon --}}
        <div class="flex-shrink-0 pt-0.5">
            <span class="material-symbols-rounded text-[#F26E21] text-2xl">notifications_active</span>
        </div>

        {{-- Content --}}
        <div class="flex-1">
            <h4 class="text-sm font-bold text-gray-800 mb-1">New Permission Found</h4>
            <p id="toastMessageBody" class="text-sm text-gray-600 leading-snug">
                {{-- Pesan dari JS --}}
            </p>
            <p id="toastTime" class="text-xs text-gray-400 mt-2">Just now</p>
        </div>

        {{-- Close Button --}}
        <button onclick="hideAdminToast()" class="text-gray-400 hover:text-gray-600 transition">
            <span class="material-symbols-rounded text-xl">close</span>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cek setiap 5 detik
            setInterval(checkAdminNotifications, 5000);
        });

        function checkAdminNotifications() {
            fetch("{{ route('admin.notifications.check') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.found) {
                        showAdminToast(data.message, data.time);
                    }
                })
                .catch(err => console.error('Notif error:', err));
        }

        const toast = document.getElementById('adminToast');
        let hideTimeout;

        function showAdminToast(msg, time) {
            document.getElementById('toastMessageBody').innerHTML = msg;
            document.getElementById('toastTime').innerText = time;

            // Slide In (Show)
            toast.classList.remove('translate-x-[150%]');
            toast.classList.add('translate-x-0');

            // Mainkan suara 'ting' (Opsional, pastikan file ada di public/sounds/)
            // new Audio('/sounds/notification.mp3').play().catch(() => {});

            // Reset timer jika ada notif baru menimpa yang lama
            if (hideTimeout) clearTimeout(hideTimeout);

            // Auto hide 5 detik
            hideTimeout = setTimeout(hideAdminToast, 5000);
        }

        function hideAdminToast() {
            // Slide Out (Hide)
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-[150%]');
        }
    </script>
</body>

</html>