@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Type')
@section('content')
    <div class="-mt-5">
        <p class="text-base text-[#2A2A2A] mb-2">
            <a href="{{ route('admin.dashboard.assets') }}" class="hover:underline text-[#F26E21]">Assets</a> >
            {{ $type->id_type }}
        </p>

        <!-- type Detail Card -->
        <div class="bg-[#FBFBFB] rounded-2xl shadow p-8 relative">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-[#F26E21] font-bold text-xl mb-1">{{ $type->id_type }}</h2>
                    <p class="text-base text-[#AEAEAE]">
                        Updated at:
                        {{ \Carbon\Carbon::parse($type->updated_at)->format('H : i') }} ;
                        {{ \Carbon\Carbon::parse($type->updated_at)->format('d M Y') }}
                    </p>
                </div>
                <div class="flex items-start justify-between gap-3">
                    <!-- Edit Button -->
                    <button type="button" onclick="toggleEditModal(true)"
                        class="text-[#F26E21] hover:text-[#e65d1f] transition">
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
                    <label class="block text-[#2A2A2A] text-base font-base mb-1">ID Type</label>
                    <input type="text" value="{{ $type->id_type }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base" disabled>
                </div>

                <div>
                    <label class="block text-[#2A2A2A] text-base font-base mb-1">Name</label>
                    <input type="text" value="{{ $type->name }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base" disabled>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-lg p-6 w-[400px]">
            <h3 class="text-[#F26E21] text-xl font-semibold mb-4">Edit Type</h3>
            <form method="POST" action="{{ route('admin.dashboard.types.update', $type->id_type) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-[#2A2A2A] text-base font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ $type->name }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-1 focus:border-[#F26E21] focus:outline-none"
                        required>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="toggleEditModal(false)"
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
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-lg p-6 w-[380px]">
            <h3 class="text-[#F26E21] text-xl font-semibold mb-5">Delete Confirmation</h3>
            <p class="text-base text-[#2A2A2A] mb-6 text-justify">
                Are you sure you want to delete <span class="font-semibold text-base text-[#F26E21]">{{ $type->id_type }}</span>?<br>
                This action cannot be undone.
            </p>

            <form method="POST" action="{{ route('admin.dashboard.types.delete', $type->id_type) }}">
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
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');

            // pastikan selalu tersembunyi saat load pertama
            modal.classList.add('hidden');

            // fungsi show/hide modal
            window.toggleEditModal = function (show) {
                if (show) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            };

            // fungsi toggle delete modal
            window.toggleDeleteModal = function (show) {
                if (show) {
                    deleteModal.classList.remove('hidden');
                } else {
                    deleteModal.classList.add('hidden');
                }
            };
        });
    </script>
@endsection