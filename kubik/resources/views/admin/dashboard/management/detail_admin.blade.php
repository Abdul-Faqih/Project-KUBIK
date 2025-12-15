@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Admin')

@section('content')

    <div class="-mt-5">

        <p class="text-base text-[#2A2A2A] mb-3">
            {{-- Sesuaikan route ini dengan route index admin management kamu --}}
            <a href="{{ route('admin.dashboard.admin_management') }}" class="text-[#F26E21] hover:underline">Admin
                Management</a>
            > {{ $admin->name }}
        </p>

        <div class="bg-[#FBFBFB] rounded-2xl shadow-md px-10 py-8 relative">

            <div class="mb-6 pb-4">
                <h1 class="text-xl font-bold text-[#F26E21] mb-1">{{ $admin->name }}</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">

                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">ID Admin</label>
                        <input type="text" value="{{ $admin->id_admin }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Name</label>
                        <input type="text" value="{{ $admin->name }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Email</label>
                        <input type="text" value="{{ $admin->email }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Role</label>
                        <input type="text" value="{{ $admin->role }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Created At</label>
                        <input type="text"
                            value="{{ $admin->created_at ? \Carbon\Carbon::parse($admin->created_at)->format('d M Y, H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Last Updated</label>
                        <input type="text"
                            value="{{ $admin->updated_at ? \Carbon\Carbon::parse($admin->updated_at)->format('d M Y, H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                </div>

            </div>

            <div class="mt-12">
                <h3 class="text-[#F26E21] text-lg font-semibold mb-4 border-l-4 border-[#F26E21] pl-3">
                    Handled Permissions History
                </h3>

                <div class="overflow-x-auto rounded-lg ">
                    <table class="w-full text-sm text-left">
                        <thead class=" text-[#2A2A2A] font-semibold  ">
                            <tr>
                                <th class="py-3 px-4 text-center">ID</th>
                                <th class="py-3 px-4">User Name</th>
                                <th class="py-3 px-4 text-center">Submitted at</th>
                                <th class="py-3 px-4 text-center">Returning at</th>
                                <th class="py-3 px-4 text-center">Time (Start - End)</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody class="text-[#2A2A2A]">
                            {{-- Looping Data Booking yg di-handle admin ini --}}
                            @forelse ($admin->bookings as $booking)
                                <tr class=" hover:bg-[#F26E21] hover:text-white transition cursor-pointer"
                                    onclick="window.location='{{ route('admin.permissions.detail', $booking->id_booking) }}'">

                                    <td class="py-3 px-4 text-center font-medium">{{ $booking->id_booking }}</td>

                                    <td class="py-3 px-4">
                                        {{ $booking->user->name ?? 'Unknown User' }}
                                    </td>

                                    <td class="py-3 px-4 text-center">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="py-3 px-4 text-center">
                                        {{ $booking->return_at ? \Carbon\Carbon::parse($booking->return_at)->format('d/m/Y H:i') : '-' }}
                                    </td>

                                    <td class="py-3 px-4 text-center">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </td>

                                    <td class="py-3 px-4 text-center">
                                        @php
                                            $statusColors = [
                                                'Pending' => 'bg-yellow-100 text-yellow-600',
                                                'Approved' => 'bg-green-100 text-green-600',
                                                'Rejected' => 'bg-red-100 text-red-600',
                                                'Completed' => 'bg-blue-100 text-blue-600',
                                                'Canceled' => 'bg-gray-100 text-gray-600',
                                            ];
                                            $colorClass = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $colorClass }} shadow-sm">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-400 italic">
                                        No permissions handled by this admin yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

@endsection