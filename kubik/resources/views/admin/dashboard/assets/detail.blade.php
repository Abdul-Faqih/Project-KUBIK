@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Asset')
@section('content')
    <div class="-mt-5">
        <p class="text-base text-[#2A2A2A] mb-2">
            <a href="{{ route('admin.dashboard.assets') }}" class="hover:underline text-[#F26E21]">Assets</a> >
            {{ $asset->id_asset }}
        </p>

        <!-- Asset Detail Card -->
        <div class="bg-[#FBFBFB] rounded-2xl shadow p-8 relative">
            <form id="editForm" method="POST" action="{{ route('admin.dashboard.assets.update', $asset->id_asset) }}">
                @csrf
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-[#F26E21] font-bold text-xl mb-1">{{ $asset->id_asset }}</h2>
                        <p class="text-base text-[#AEAEAE]">
                            Updated at:
                            {{ \Carbon\Carbon::parse($asset->updated_at)->format('H : i') }} ;
                            {{ \Carbon\Carbon::parse($asset->updated_at)->format('d M Y') }}
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <!-- Edit Button -->
                        <button type="button" onclick="enableEdit()" class="text-[#F26E21] hover:text-[#e65d1f] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                            </svg>
                        </button>

                        <!-- Delete Button -->
                        <button type="button" onclick="toggleDeleteModal(true)"
                            class="text-red-500 hover:text-red-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-3">
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">ID Asset Master</label>
                        <a href="{{ route('admin.assetmasters.detail', $asset->id_master) }}"
                            class="block w-full border border-[#ECEFF3] bg-[#FBFBFB] rounded-md px-3 py-2 text-base text-[#F26E21] hover:underline">
                            {{ $asset->id_master }}
                        </a>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Name</label>
                        <input type="text" value="{{ $asset->master->name }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Type</label>
                        <input type="text" value="{{ $asset->master->type->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Category</label>
                        <input type="text" value="{{ $asset->master->category->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                    </div>

                    <!-- Editable Fields -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Condition</label>
                        <select id="conditionField" name="condition"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#F9FAFB] focus:border-1 focus:border-[#F26E21] focus:outline-none"
                            disabled required>
                            <option value="Good" {{ $asset->condition == 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Minor Damage" {{ $asset->condition == 'Minor Damage' ? 'selected' : '' }}>Minor
                                Damage</option>
                            <option value="Damaged" {{ $asset->condition == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                            <option value="Lost" {{ $asset->condition == 'Lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Status</label>
                        <select id="statusField" name="status"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#F9FAFB] focus:border-1 focus:border-[#F26E21] focus:outline-none"
                            disabled required>
                            <option value="Available" {{ $asset->status == 'Available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="Borrowed" {{ $asset->status == 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                            <option value="Maintenance" {{ $asset->status == 'Maintenance' ? 'selected' : '' }}>Maintenance
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div id="editActions" class="hidden flex justify-end space-x-3 mt-5">
                    <button type="button" onclick="cancelEdit()"
                        class="px-4 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A] hover:bg-[#F5F5F5]">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-[#F26E21] text-white hover:bg-[#e65d1f]">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-lg p-6 w-[380px]">
            <h3 class="text-[#F26E21] font-semibold mb-2">Delete Confirmation</h3>
            <p class="text-sm text-[#2A2A2A] mb-6">
                Are you sure you want to delete
                <span class="font-semibold text-[#F26E21]">{{ $asset->id_asset }}</span>?<br>
                This action cannot be undone.
            </p>

            <form id="deleteForm" method="POST" action="{{ route('admin.dashboard.assets.delete', $asset->id_asset) }}">
                @csrf
                @method('DELETE')

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="toggleDeleteModal(false)"
                        class="px-4 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A] hover:bg-[#F5F5F5]">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 rounded-md bg-red-500 text-white hover:bg-red-600 transition">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // enable edit
        window.enableEdit = function () {
            const cond = document.getElementById('conditionField');
            const stat = document.getElementById('statusField');
            const actions = document.getElementById('editActions');

            cond.removeAttribute('disabled');
            stat.removeAttribute('disabled');
            cond.classList.remove('bg-[#F9FAFB]');
            stat.classList.remove('bg-[#F9FAFB]');
            actions.classList.remove('hidden');
        };

        // cancel edit
        window.cancelEdit = function () {
            const cond = document.getElementById('conditionField');
            const stat = document.getElementById('statusField');
            const actions = document.getElementById('editActions');

            cond.setAttribute('disabled', true);
            stat.setAttribute('disabled', true);
            cond.classList.add('bg-[#F9FAFB]');
            stat.classList.add('bg-[#F9FAFB]');
            cond.value = "{{ $asset->condition }}";
            stat.value = "{{ $asset->status }}";
            actions.classList.add('hidden');
        };

        // toggle delete modal
        window.toggleDeleteModal = function (show) {
            const modal = document.getElementById('deleteModal');
            if (show) {
                modal.classList.remove('hidden');
                modal.style.opacity = '1';
            } else {
                modal.style.opacity = '0';
                setTimeout(() => modal.classList.add('hidden'), 200);
            }
        };
    </script>
@endsection