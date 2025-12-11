<table class="w-full">
    <thead class="text-[#2A2A2A] sticky top-0 bg-white text-base">
        <tr>
            <th class="py-2 px-3 text-center">ID Booking</th>
            <th class="py-2 px-3 text-center">User</th>
            <th class="py-2 px-3 text-center">Admin</th>
            <th class="py-2 px-3 text-center">Submitted At</th>
            <th class="py-2 px-3 text-center">Returning At</th>
            <th class="py-2 px-3 text-center">Start - End Time</th>
            <th class="py-2 px-3 text-center">Status</th>
            <th class="py-2 px-3 text-center">Note</th>
        </tr>
    </thead>

    <tbody>
        @forelse($bookings as $booking)
            <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white text-sm cursor-pointer"
                onclick="window.location='{{ route('admin.permissions.detail', $booking->id_booking) }}'">

                <td class="py-2 px-3 text-center">{{ $booking->id_booking }}</td>

                <td class="py-2 px-3 text-left">{{ $booking->user->name ?? 'Unknown' }}</td>

                <td class="py-2 px-3 text-center">{{ $booking->admin->name ?? '-' }}</td>

                <td class="py-2 px-3 text-center">
                    {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') ?? 'Unknown' }}
                </td>

                <td class="py-2 px-3 text-center">
                    {{ $booking->return_at ? \Carbon\Carbon::parse($booking->return_at)->format('d/m/Y H:i') : '-' }}
                </td>

                <td class="py-2 px-3 text-center">
                    {{ $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') : '-' }} -
                    {{ $booking->end_time ? \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i') : '-' }}
                </td>

                <td class="py-2 px-3 text-center">
                    @if($booking->status === 'Pending')
                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-600">Pending</span>
                    @elseif($booking->status === 'Rejected')
                        <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-600">Rejected</span>
                    @elseif($booking->status === 'Canceled')
                        <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-600">Canceled</span>
                    @elseif($booking->status === 'Approved')
                        <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">Approved</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-600">Completed</span>
                    @endif
                </td>

                <td class="py-2 px-3 text-left">
                    {{ $booking->note ?? '-' }}
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="7" class="py-4 text-center text-[#AEAEAE]">No booking data found.</td>
            </tr>
        @endforelse
    </tbody>
</table>