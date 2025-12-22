@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Permission')

@section('content')

    <div class="-mt-5">

        <p class="text-base text-[#2A2A2A] mb-3">
            <a href="{{ route('admin.dashboard.permissions') }}" class="text-[#F26E21] hover:underline">Permissions</a>
            > {{ $booking->id_booking }}
        </p>

        <div class="bg-[#FBFBFB] rounded-2xl shadow-md px-10 py-8 relative">

            <div class="mb-3">
                <h1 class="text-xl font-semibold text-[#F26E21] mb-1">{{ $booking->id_booking }}</h1>

                <p class="text-sm text-gray-400">
                    Created at: {{ \Carbon\Carbon::parse($booking->created_at)->format('H:i ; d M Y') }} <br>
                    Updated at: {{ \Carbon\Carbon::parse($booking->updated_at)->format('H:i ; d M Y') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-6">

                <div class="flex flex-col gap-6">

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Name</label>
                        <input type="text" value="{{ $booking->user->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] cursor-pointer hover:text-[#F26E21] hover:underline hover:border-[#F26E21] rounded-md px-3 py-2 bg-[#F9FAFB]"
                            readonly
                            onclick="window.location='{{ route('admin.dashboard.user_management.detail', $booking->user) }}'">
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Start Time</label>
                        <input type="text"
                            value="{{ $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Attachment</label>

                        <div
                            class="relative border border-[#ECEFF3] bg-[#F9FAFB] rounded-md h-[405px] flex flex-col items-center justify-center text-gray-400 overflow-hidden p-4">
                            @if ($booking->attachment)
                                {{-- Icon Dokumen Besar --}}
                                <div class="flex flex-col items-center justify-center gap-3">

                                    {{-- Cek Ekstensi File untuk Icon yang Sesuai --}}
                                    @php
                                        $ext = pathinfo($booking->attachment, PATHINFO_EXTENSION);
                                        $icon = match (strtolower($ext)) {
                                            'pdf' => 'picture_as_pdf',
                                            'doc', 'docx' => 'description',
                                            'xls', 'xlsx' => 'table_view',
                                            'jpg', 'jpeg', 'png' => 'image',
                                            default => 'broken_image'
                                        };
                                    @endphp

                                    <span class="material-symbols-rounded text-[70px] text-[#2A2A2A]u">
                                        {{ $icon }}
                                    </span>

                                    <p class="text-sm font-medium text-[#2A2A2A] truncate max-w-[200px]">
                                        {{ basename($booking->attachment) }}
                                    </p>
                                </div>

                                {{-- Tombol Download di Tengah --}}
                                <a href="{{ asset('uploads/attachments/' . $booking->attachment) }}"
                                    class="mt-6 flex items-center gap-2 px-6 py-2.5 bg-[#F26E21] text-white rounded-full font-medium hover:bg-[#d85b17] transition shadow-sm"
                                    download>
                                    <span class="material-symbols-rounded text-xl">download</span>
                                    Download File
                                </a>

                            @else
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-rounded text-4xl text-gray-300">attach_file_off</span>
                                    <p class="text-sm text-gray-400">No Attachment</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="flex flex-col gap-6">

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Admin</label>
                        <input type="text" value="{{ $booking->admin->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] transition
                                        {{ $booking->admin ? 'cursor-pointer hover:text-[#F26E21] hover:underline hover:border-[#F26E21]' : '' }}" readonly @if($booking->admin)
                                                            onclick="window.location='{{ route(
                                            'admin.dashboard.admin_management.detail',
                                            $booking->admin->id_admin
                                        ) }}'" @endif>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">End Time</label>
                        <input type="text"
                            value="{{ $booking->end_time ? \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Status</label>
                        <select name="status" id="statusField"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                            <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Approved" {{ $booking->status == 'Approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="Rejected" {{ $booking->status == 'Rejected' ? 'selected' : '' }}>Rejected
                            </option>
                            <option value="Canceled" {{ $booking->status == 'Canceled' ? 'selected' : '' }}>Canceled
                            </option>
                            <option value="Completed" {{ $booking->status == 'Completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Return at</label>
                        <input type="text"
                            value="{{ $booking->return_at ? \Carbon\Carbon::parse($booking->return_at)->format('Y-m-d H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Late Return</label>
                        {{-- LOGIKA FORMAT DURASI --}}
                        @php
                            $lateText = '-';
                            if ($booking->late_return > 0) {
                                $minutesTotal = round($booking->late_return); // Database simpan menit (float/int)

                                if ($minutesTotal < 60) {
                                    $lateText = $minutesTotal . ' minute' . ($minutesTotal > 1 ? 's' : '');
                                } else {
                                    $hours = floor($minutesTotal / 60);
                                    $minutes = $minutesTotal % 60;

                                    $lateText = $hours . ' hour' . ($hours > 1 ? 's' : '');
                                    if ($minutes > 0) {
                                        $lateText .= ', ' . $minutes . ' minute' . ($minutes > 1 ? 's' : '');
                                    }
                                }

                                // Jika lebih dari 24 jam (misal 1 day, 2 hours)
                                if ($minutesTotal >= 1440) {
                                    $days = floor($minutesTotal / 1440);
                                    $remMinutes = $minutesTotal % 1440;
                                    $hours = floor($remMinutes / 60);
                                    $minutes = $remMinutes % 60;

                                    $lateText = $days . ' day' . ($days > 1 ? 's' : '');
                                    if ($hours > 0) {
                                        $lateText .= ', ' . $hours . ' hour' . ($hours > 1 ? 's' : '');
                                    }
                                    // Opsional: tampilkan menit juga atau cukup hari & jam
                                }
                            } elseif ($booking->late_return === 0 || $booking->late_return === '0') {
                                $lateText = 'On Time';
                            }
                        @endphp

                        <input type="text" value="{{ $lateText }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] {{ $booking->late_return > 0 ? 'text-red-600 font-medium' : 'text-green-600' }}"
                            disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Note</label>
                        <textarea name="note" id="noteField"
                            class="w-full min-h-[120px] border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] disabled:text-gray-500 disabled:cursor-not-allowed"
                            @disabled($booking->status != 'Pending')>{{ $booking->note ?? '' }}</textarea>
                    </div>

                </div>

            </div>

            <div>
                <label class="block text-[#2A2A2A] text-base mt-3 mb-2 font-medium">Proof of Return</label>
                @php
                    // Decode JSON, fallback ke array tunggal jika format lama (string)
                    $proofs = json_decode($booking->proof_return);
                    if (json_last_error() !== JSON_ERROR_NONE || !is_array($proofs)) {
                        $proofs = $booking->proof_return ? [$booking->proof_return] : [];
                    }
                @endphp

                @if(!empty($proofs))
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($proofs as $img)
                            <div class="relative group rounded-lg overflow-hidden border border-gray-200 aspect-video bg-gray-50">
                                {{-- Gambar --}}
                                <img src="{{ asset('uploads/proofs/' . $img) }}" alt="Proof Return"
                                    class="w-full h-full object-cover cursor-pointer transition-transform duration-300 group-hover:scale-105"
                                    onclick="window.open(this.src, '_blank')">

                                {{-- Tombol Download Kecil --}}
                                <a href="{{ asset('uploads/proofs/' . $img) }}" download
                                    class="absolute bottom-2 right-2 bg-white/90 p-1.5 rounded-md text-[#F26E21] hover:bg-[#F26E21] hover:text-white transition shadow-sm"
                                    title="Download Image">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="w-full border border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50 text-gray-400 text-sm">
                        No proof uploaded yet
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto mt-6">
                <table class="w-full text-center border-collapse text-base">
                    <thead>
                        <tr class="border-b border-gray-200 text-[#2A2A2A]">
                            <th class="py-3 px-2">No.</th>
                            <th class="py-3 px-2">ID Asset</th>
                            <th class="py-3 px-2">Name</th>
                            <th class="py-3 px-2">Updated at</th>
                            <th class="py-3 px-2">Condition</th>
                            <th class="py-3 px-2">Status</th>
                            @if($booking->status == 'Pending')
                                <th class="py-3 px-2">Action</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="text-[#2A2A2A]">
                        @foreach ($booking->assets as $i => $asset)
                                        <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white group">

                                            <td class="py-3 px-2 cursor-pointer"
                                                onclick="window.location='{{ route('admin.assets.detail', $asset->id_asset) }}'">{{ $i + 1
                                                                                        }}</td>
                                            <td class="py-3 px-2 cursor-pointer"
                                                onclick="window.location='{{ route('admin.assets.detail', $asset->id_asset) }}'">{{
                            $asset->id_asset }}</td>
                                            <td class="py-3 px-2 cursor-pointer"
                                                onclick="window.location='{{ route('admin.assets.detail', $asset->id_asset) }}'">{{
                            $asset->master->name }}</td>

                                            <td class="py-3 px-2 cursor-pointer"
                                                onclick="window.location='{{ route('admin.assets.detail', $asset->id_asset) }}'">
                                                {{ \Carbon\Carbon::parse($asset->updated_at)->format('d/m/Y H:i') }}
                                            </td>

                                            <td class="py-3 px-2 cursor-pointer"
                                                onclick="window.location='{{ route('admin.assets.detail', $asset->id_asset) }}'">{{
                            $asset->condition }}</td>
                                            <td class="py-3 px-2 cursor-pointer"
                                                onclick="window.location='{{ route('admin.assets.detail', $asset->id_asset) }}'">{{
                            $asset->status }}</td>

                                            @if($booking->status == 'Pending')
                                                <td class="py-3 px-2">
                                                    <form
                                                        action="{{ route('admin.permissions.remove_item', ['id_booking' => $booking->id_booking, 'id_asset' => $asset->id_asset]) }}"
                                                        method="POST" onsubmit="return confirm('Remove this item from booking list?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Remove Item">
                                                            <span
                                                                class="text-base hover:bg-[#FBFBFB] hover:text-[#F26E21] py-1 px-3 rounded-md">delete</span>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif

                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="absolute top-6 right-8 flex gap-3">
                <button type="button" id="editBtn" class="text-[#F26E21] hover:text-[#e65d1f] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                    </svg>
                </button>
            </div>

            <div id="editActions" class="hidden flex justify-end gap-3 mt-10">
                <button type="button" id="cancelEdit"
                    class="px-4 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A] hover:bg-[#F5F5F5]">
                    Cancel
                </button>

                <form id="saveForm" method="POST" action="{{ route('admin.permissions.update', $booking->id_booking) }}">
                    @csrf
                    <input type="hidden" name="status" id="saveStatusInput">
                    <input type="hidden" name="note" id="saveNoteInput">
                    <button class="px-4 py-2 rounded-md bg-[#F26E21] text-white hover:bg-[#d85b17]">
                        Save
                    </button>
                </form>
            </div>

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

        // CANCEL
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