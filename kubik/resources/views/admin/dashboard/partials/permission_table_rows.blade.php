@forelse ($bookings as $booking)
    <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] hover:text-white transition cursor-pointer"
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
            No permissions found matching criteria.
        </td>
    </tr>
@endforelse