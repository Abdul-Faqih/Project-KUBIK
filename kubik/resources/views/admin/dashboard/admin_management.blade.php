@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Admin Management')

@section('content')
    <div class="grid">

        <div class="bg-white rounded-2xl shadow p-6 mt-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-[#F26E21] text-xl font-semibold">Admin List</h3>

                {{-- Pastikan route 'admin.create' atau yang sesuai sudah ada, jika belum ganti jadi '#' --}}
                <a href="{{ route('admin.dashboard.admin_management.create') }}"
                    class="text-[#F26E21] font-semibold text-sm hover:text-[#FBFBFB] hover:bg-[#F26E21] py-1 px-2 rounded-md transition">
                    + Add
                </a>
            </div>

            <div
                class="overflow-y-auto max-h-[72vh] scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md">

                <table class="w-full">
                    <thead class="text-[#2A2A2A] sticky top-0 bg-white text-base">
                        <tr>
                            <th class="py-2 px-3 text-center">ID</th>
                            <th class="py-2 px-3 text-left">Name</th>
                            <th class="py-2 px-3 text-left">Email</th>
                            <th class="py-2 px-3 text-center">Role</th>
                            <th class="py-2 px-3 text-center">Created At</th>
                            <th class="py-2 px-3 text-center">Last Updated</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Pastikan dari controller variabel yang dikirim bernama $admins --}}
                        @forelse($admins as $admin)
                            <tr class="hover:bg-[#F26E21] transition hover:text-white text-sm cursor-pointer"
                                onclick="window.location='{{ route('admin.dashboard.admin_management.detail', $admin->id_admin) }}'">

                                <td class="py-2 px-3 text-center">{{ $admin->id_admin }}</td>
                                <td class="py-2 px-3 text-left">{{ $admin->name }}</td>
                                <td class="py-2 px-3 text-left">{{ $admin->email }}</td>

                                <td class="py-2 px-3 text-center">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold 
                                                {{ $admin->role == 'Super-Admin' ? 'bg-purple-100 text-purple-600' : 'bg-orange-100 text-orange-600' }}">
                                        {{ $admin->role }}
                                    </span>
                                </td>

                                <td class="py-2 px-3 text-center">
                                    {{ $admin->created_at ? \Carbon\Carbon::parse($admin->created_at)->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="py-2 px-3 text-center">
                                    {{ $admin->updated_at ? \Carbon\Carbon::parse($admin->updated_at)->format('d/m/Y H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-[#AEAEAE]">No admin data found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>
@endsection