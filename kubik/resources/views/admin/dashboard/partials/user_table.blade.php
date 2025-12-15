<table class="w-full">
    <thead class="text-[#2A2A2A] sticky top-0 bg-white text-base">
        <tr>
            <th class="py-2 px-3 text-center ">ID</th>
            <th class="py-2 px-3 text-center ">NIM/NIP</th>
            <th class="py-2 px-3 text-left ">Name</th>
            <th class="py-2 px-3 text-left ">Phone Number</th>
            <th class="py-2 px-3 text-center ">Role</th>
            <th class="py-2 px-3 text-center ">Created At</th>
            <th class="py-2 px-3 text-center ">Last Updated</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white text-sm group"
                onclick="window.location='{{ route('admin.dashboard.user_management.detail', $user->id_user) }}'">
                {{-- ID USER --}}
                <td class="py-2 px-3 text-center">
                    {{ $user->id_user ?? '-' }}
                </td>
                
                {{-- (NIM for Student, NIP for others) --}}
                <td class="py-2 px-3 text-center">
                    {{ $user->nim ?? $user->nip ?? '-' }}
                </td>

                {{-- NAME --}}
                <td class="py-2 px-3 text-left">
                    {{ $user->name }}
                </td>

                {{-- Phone Num --}}
                <td class="py-2 px-3 text-left">
                    {{ $user->phone_number }}
                </td>

                {{-- ROLE BADGE --}}
                <td class="py-2 px-3 text-center">
                    @php
                        $roleColor = match($user->role) {
                            'Student' => 'bg-blue-100 text-blue-600 group-hover:bg-white/20 group-hover:text-white',
                            'Lecturer' => 'bg-purple-100 text-purple-600 group-hover:bg-white/20 group-hover:text-white',
                            'Staff' => 'bg-orange-100 text-orange-600 group-hover:bg-white/20 group-hover:text-white',
                            default => 'bg-gray-100 text-gray-600 group-hover:bg-white/20 group-hover:text-white',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $roleColor }} transition-colors">
                        {{ $user->role }}
                    </span>
                </td>

                {{-- CREATED AT --}}
                <td class="py-2 px-3 text-center">
                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}
                </td>

                {{-- UPDATED AT --}}
                <td class="py-2 px-3 text-center">
                    {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-10 text-center text-[#AEAEAE] italic">
                    <div class="flex flex-col items-center justify-center">
                        <span class="material-symbols-rounded text-4xl mb-2">search_off</span>
                        No users found matching your criteria.
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>