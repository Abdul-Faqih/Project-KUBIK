@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail User')

@section('content')

    <div class="-mt-5">

        {{-- Breadcrumb --}}
        <p class="text-base text-[#2A2A2A] mb-3">
            <a href="{{ route('admin.dashboard.user_management') }}" class="text-[#F26E21] hover:underline">User Management</a>
            > {{ $user->name }}
        </p>

        <div class="bg-[#FBFBFB] rounded-2xl shadow-md px-10 py-8 relative">

            {{-- HEADER --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-[#F26E21] mb-1">{{ $user->name }}</h1>
            </div>

            {{-- FORM DETAILS (READONLY) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">

                {{-- LEFT COLUMN --}}
                <div class="flex flex-col gap-4">
                    {{-- ID (Database ID) --}}
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">ID User</label>
                        <input type="text" value="{{ $user->id_user }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Email</label>
                        <input type="text" value="{{ $user->email }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>

                    {{-- PASSWORD (HIDDEN) --}}
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Password</label>
                        <input type="password" value="DummyPassword123"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600 tracking-widest" disabled>
                    </div>

                    {{-- CREATED AT --}}
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Created At</label>
                        <input type="text"
                            value="{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y, H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="flex flex-col gap-4">
                    {{-- ROLE --}}
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Role</label>
                        <input type="text" value="{{ $user->role }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>

                    {{-- === CONDITIONAL FIELDS BERDASARKAN ROLE === --}}
                    
                    {{-- 1. STUDENT --}}
                    @if($user->role === 'Student')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">NIM</label>
                                <input type="text" value="{{ $user->nim ?? '-' }}"
                                    class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                            </div>
                            <div>
                                <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Enrollment</label>
                                <input type="text" value="{{ $user->enrollment ?? '-' }}"
                                    class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Study Program</label>
                            <input type="text" value="{{ $user->program ?? '-' }}"
                                class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                        </div>
                    
                    {{-- 2. LECTURER --}}
                    @elseif($user->role === 'Lecturer')
                        <div>
                            <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">NIP</label>
                            <input type="text" value="{{ $user->nip ?? '-' }}"
                                class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                        </div>

                    {{-- 3. STAFF --}}
                    @elseif($user->role === 'Staff')
                        <div>
                            <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">NIP</label>
                            <input type="text" value="{{ $user->nip ?? '-' }}"
                                class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Unit</label>
                                <input type="text" value="{{ $user->unit ?? '-' }}"
                                    class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                            </div>
                            <div>
                                <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Department</label>
                                <input type="text" value="{{ $user->department ?? '-' }}"
                                    class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                            </div>
                        </div>
                    @endif
                    {{-- =========================================== --}}


                    {{-- LAST UPDATED --}}
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Last Updated</label>
                        <input type="text"
                            value="{{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d M Y, H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                </div>

            </div>

            {{-- HISTORY TABLE --}}
            <div class="mt-12">
                <h3 class="text-[#F26E21] text-lg font-semibold mb-4 border-l-4 border-[#F26E21] pl-3">
                    Booking / Permission History
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[#2A2A2A] font-semibold">
                            <tr>
                                <th class="py-2 px-3  text-center">ID</th>
                                <th class="py-2 px-3 ">Processed By (Admin)</th>
                                <th class="py-2 px-3  text-center">Submitted at</th>
                                <th class="py-2 px-3  text-center">Returning at</th>
                                <th class="py-2 px-3  text-center">Time (Start - End)</th>
                                <th class="py-2 px-3  text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody class="text-[#2A2A2A]">
                            @forelse ($user->bookings as $booking)
                                <tr class="hover:bg-[#F26E21] hover:text-white transition cursor-pointer"
                                    onclick="window.location='{{ route('admin.permissions.detail', $booking->id_booking) }}'">
                                    
                                    {{-- ID BOOKING --}}
                                    <td class="py-2 px-3  text-center font-medium">{{ $booking->id_booking }}</td>

                                    {{-- ADMIN NAME --}}
                                    <td class="py-2 px-3 ">
                                        {{ $booking->admin->name ?? '-' }}
                                    </td>

                                    {{-- SUBMITTED AT --}}
                                    <td class="py-2 px-3  text-center">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}
                                    </td>

                                    {{-- RETURNING AT --}}
                                    <td class="py-2 px-3  text-center">
                                        {{ $booking->return_at ? \Carbon\Carbon::parse($booking->return_at)->format('d/m/Y H:i') : '-' }}
                                    </td>

                                    {{-- TIME --}}
                                    <td class="py-2 px-3  text-center">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="py-2 px-3  text-center">
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
                                        No bookings history found.
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