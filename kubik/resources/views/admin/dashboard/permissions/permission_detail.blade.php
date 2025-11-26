@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Permission')

@section('content')

    <div class="-mt-5">

        <!-- Breadcrumb -->
        <p class="text-base text-[#2A2A2A] mb-3">
            <a href="{{ route('admin.dashboard.permissions') }}" class="text-[#F26E21] hover:underline">Permissions</a>
            > {{ $booking->id_booking }}
        </p>

        <!-- MAIN CARD -->
        <div class="bg-[#FBFBFB] rounded-2xl shadow-md px-10 py-8 relative">

            <!-- HEADER -->
            <div class="mb-3">
                <h1 class="text-xl font-semibold text-[#F26E21] mb-1">{{ $booking->id_booking }}</h1>

                <p class="text-sm text-gray-400">
                    Created at: {{ \Carbon\Carbon::parse($booking->created_at)->format('H:i ; d M Y') }} <br>
                    Updated at: {{ \Carbon\Carbon::parse($booking->updated_at)->format('H:i ; d M Y') }}
                </p>
            </div>

            <!-- FORM (READONLY) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-6">

                <!-- LEFT SIDE -->
                <div class="flex flex-col gap-6">

                    <!-- USER NAME -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Name</label>
                        <input type="text" value="{{ $booking->user->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <!-- START TIME -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Start Time</label>
                        <input type="text"
                            value="{{ $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <!-- ATTACHMENT -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Attachment</label>

                        <div
                            class="border border-[#ECEFF3] bg-[#F9FAFB] rounded-md h-[405px] flex items-center justify-center text-gray-400">
                            @if ($booking->attachment)
                                <a href="{{ asset('uploads/booking/' . $booking->attachment) }}"
                                    class="underline text-[#F26E21]" target="_blank">View Attachment</a>
                            @else
                                <p>No Attachment</p>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="flex flex-col gap-6">

                    <!-- ADMIN -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Admin</label>
                        <input type="text" value="{{ $booking->admin->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <!-- END TIME -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">End Time</label>
                        <input type="text"
                            value="{{ $booking->end_time ? \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Status</label>

                        <select name="status" id="statusField"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>

                            <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Approved" {{ $booking->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Rejected" {{ $booking->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="Completed" {{ $booking->status == 'Completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>


                    <!-- RETURN AT -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Return at</label>
                        <input type="text"
                            value="{{ $booking->return_at ? \Carbon\Carbon::parse($booking->return_at)->format('Y-m-d H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <!-- LATE RETURN -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Late Return</label>
                        <input type="text" value="{{ $booking->late_return ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <!-- NOTE -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Note</label>

                        <textarea name="note" id="noteField"
                            class="w-full min-h-[120px] border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]"
                            disabled>{{ $booking->note ?? '' }}</textarea>
                    </div>


                </div>

            </div>

            <div class="overflow-x-auto mt-6">
                <table class="w-full text-center border-collapse text-base">
                    <thead>
                        <tr class="border-b border-gray-200 text-[#2A2A2A]">
                            <th class="py-3 px-2">No.</th>
                            <th class="py-3 px-2">ID Asset</th>
                            <th class="py-3 px-2">Updated at</th>
                            <th class="py-3 px-2">Condition</th>
                            <th class="py-3 px-2">Status</th>
                        </tr>
                    </thead>

                    <tbody class="text-[#2A2A2A]">
                        @foreach ($booking->assets as $i => $asset)
                            <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white"
                                onclick="window.location='{{ route('admin.assets.detail', $asset->id_asset) }}'">

                                <td class="py-3 px-2">{{ $i + 1 }}</td>
                                <td class="py-3 px-2">{{ $asset->id_asset }}</td>

                                <td class="py-3 px-2">
                                    {{ \Carbon\Carbon::parse($asset->updated_at)->format('d/m/Y H:i') }}
                                </td>

                                <td class="py-3 px-2">{{ $asset->condition }}</td>
                                <td class="py-3 px-2">{{ $asset->status }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- EDIT & SAVE BUTTONS -->

            <div class="absolute top-6 right-8 flex gap-3">

                <!-- EDIT BUTTON -->
                <button type="button" id="editBtn" class="text-[#F26E21] hover:text-[#e65d1f] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                    </svg>
                </button>

            </div>

            <!-- SAVE / CANCEL BUTTONS (BOTTOM, LIKE MASTER DETAIL) -->
            <div id="editActions" class="hidden flex justify-end gap-3 mt-10">

                <!-- CANCEL -->
                <button type="button" id="cancelEdit"
                    class="px-4 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A] hover:bg-[#F5F5F5]">
                    Cancel
                </button>

                <!-- SAVE -->
                <form id="saveForm" method="POST" action="{{ route('admin.permissions.update', $booking->id_booking) }}">
                    @csrf

                    <input type="hidden" name="status" id="saveStatusInput">
                    <input type="hidden" name="note" id="saveNoteInput">

                    <button class="px-4 py-2 rounded-md bg-[#F26E21] text-white hover:bg-[#d85b17]">
                        Save
                    </button>
                </form>

            </div>

            <!-- ACTION BUTTONS -->
            @if ($booking->status == 'Pending')
                <div class="flex justify-end gap-3 mt-10">

                    <a href="{{ route('admin.dashboard.permissions') }}"
                        class="px-6 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A]">
                        Back
                    </a>

                    <form method="POST" action="{{ route('admin.permissions.reject', $booking->id_booking) }}">
                        @csrf
                        <input type="hidden" name="note" id="rejectNoteInput">
                        <button type="submit" class="px-6 py-2 rounded-md bg-red-500 text-white hover:bg-red-600 transition">
                            Reject
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.permissions.accept', $booking->id_booking) }}">
                        @csrf
                        <input type="hidden" name="note" id="acceptNoteInput">
                        <button type="submit"
                            class="px-6 py-2 rounded-md bg-green-500 text-white hover:bg-green-600 transition">
                            Accept
                        </button>
                    </form>

                </div>
            @endif


        </div>

    </div>
    <script>
        const editBtn = document.getElementById("editBtn");
        const editActions = document.getElementById("editActions");

        const statusField = document.getElementById("statusField");
        const noteField = document.getElementById("noteField");

        const saveStatusInput = document.getElementById("saveStatusInput");
        const saveNoteInput = document.getElementById("saveNoteInput");

        // ENABLE EDIT MODE
        editBtn.addEventListener("click", () => {

            statusField.disabled = false;
            noteField.disabled = false;

            editActions.classList.remove("hidden");
            editBtn.classList.add("hidden");
        });

        // CANCEL — reload
        document.getElementById("cancelEdit").addEventListener("click", () => {
            window.location.reload();
        });

        // SAVE
        document.getElementById("saveForm").addEventListener("submit", () => {
            saveStatusInput.value = statusField.value;
            saveNoteInput.value = noteField.value;
        });


        // Auto send note during Accept / Reject
        document.querySelectorAll("form[action*='accept'], form[action*='reject']").forEach(form => {
            form.addEventListener("submit", () => {
                form.querySelector("input[name='note']").value = noteField.value;
            });
        });
    </script>

@endsection