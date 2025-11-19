@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Asset Master')

@section('content')

    <div class="mt-2">

        <!-- Breadcrumb -->
        <p class="text-sm text-gray-500 mb-3">
            <a href="{{ route('admin.dashboard.assets') }}" class="text-[#F26E21] hover:underline">Assets</a>
            > {{ $master->id_master }}
        </p>

        <!-- MAIN CARD -->
        <div class="bg-white rounded-2xl shadow-md px-10 py-8 relative">

            <!-- EDIT + DELETE BUTTONS -->
            <div class="absolute top-6 right-8 flex gap-3">

                <button type="button" onclick="enableEdit()" class="text-[#F26E21] hover:text-[#e65d1f] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                    </svg>
                </button>

                <!-- Delete Button -->
                <button type="button" onclick="toggleDeleteModal(true)" class="text-red-500 hover:text-red-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            <!-- HEADER -->
            <div class="mb-8">
                <h1 class="text-xl font-semibold text-[#F26E21]">{{ $master->id_master }}</h1>

                <p class="text-sm text-gray-400">
                    Updated at:
                    {{ \Carbon\Carbon::parse($master->updated_at)->format('H : i') }} ;
                    {{ \Carbon\Carbon::parse($master->updated_at)->format('d M Y') }}
                </p>
            </div>

            <!-- FORM -->
            <form id="editForm" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.dashboard.assetmasters.update', $master->id_master) }}">
                @csrf

                <!-- NAME -->
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" value="{{ $master->name }}"
                        class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2" disabled>
                </div>

                <!-- TYPE + CATEGORY -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                    <div>
                        <label class="block text-gray-700 mb-2">Type</label>
                        <select name="type_id" class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2"
                            disabled>
                            <option value="{{ $master->id_type }}">
                                {{ $master->type->name ?? '-' }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Category</label>
                        <select name="category_id" class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2"
                            disabled>
                            <option value="{{ $master->id_category }}">
                                {{ $master->category->name ?? '-' }}
                            </option>
                        </select>
                    </div>

                </div>

                <!-- IMAGE + STOCK + DESCRIPTION -->
                <div class="flex grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- LEFT: IMAGE -->
                    <div>
                        <label class="block text-gray-700 mb-2">Image</label>

                        <div id="imagePreviewContainer"
                            class="border border-gray-200 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden w-[508px] h-[381px] max-w-full mb-3">

                            @if ($master->image_asset)
                                <img src="{{ asset('uploads/assetmasters/' . $master->image_asset) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-gray-400">
                                    <p>No image</p>
                                </div>
                            @endif

                        </div>


                        <div class="flex items-center gap-3">

                            <input type="file" name="image_asset" id="imageInput" accept="image/*" class="block" disabled>

                            <!-- hidden input for controller -->
                            <input type="hidden" name="clear_image" id="clearImageFlag" value="0">
                        </div>

                    </div>

                    <!-- RIGHT: STOCK + DESCRIPTION -->
                    <div class="flex flex-col gap-6 w-full">

                        <div>
                            <label class="block text-gray-700 mb-2">Total Stock</label>
                            <input type="number" name="stock_total" value="{{ $master->stock_total }}" disabled
                                class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2">
                        </div>

                        <div class="flex-grow">
                            <label class="block text-gray-700 mb-2">Description</label>
                            <textarea name="description"
                                class="w-full min-h-[278px] rounded-xl bg-gray-100 border border-gray-200 px-4 py-3 resize-none text-gray-700"
                                placeholder="Description" disabled>{{ $master->description }}</textarea>
                        </div>

                    </div>

                </div>

                <!-- SAVE / CANCEL -->
                <div id="editActions" class="hidden flex justify-end gap-3 mt-8">

                    <!-- CLEAR IMAGE BUTTON -->
                    <button type="button" onclick="clearImage()" id="clearImageBtn"
                        class="px-4 py-2 rounded-lg bg-gray-100 border border-gray-300 text-gray-700">
                        Clear Image
                    </button>

                    <button type="button" onclick="cancelEdit()"
                        class="px-4 py-2 rounded-lg bg-gray-100 border border-gray-300 text-gray-700">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 rounded-lg bg-[#F26E21] text-white hover:bg-[#e65d1f]">
                        Save
                    </button>

                </div>

            </form>
        </div>

    </div>

    <!-- DELETE MODAL -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">

        <div class="bg-white rounded-2xl p-6 w-[380px] shadow-xl">

            <h3 class="text-[#F26E21] font-semibold mb-2">Delete Confirmation</h3>

            <p class="text-sm text-gray-700 mb-6">
                Are you sure you want to delete
                <span class="font-semibold text-[#F26E21]">{{ $master->id_master }}</span>?
            </p>

            <form method="POST" action="{{ route('admin.dashboard.assetmasters.delete', $master->id_master) }}">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">

                    <button type="button" onclick="toggleDeleteModal(false)"
                        class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        Delete
                    </button>

                </div>
            </form>
        </div>
    </div>

    <script>

        function enableEdit() {
            document.querySelectorAll('input, select, textarea').forEach(el => {
                el.disabled = false;
            });

            // pastikan input file tampil dan aktif
            const fileInput = document.getElementById('imageInput');
            fileInput.disabled = false;

            document.getElementById('editActions').classList.remove('hidden');
            document.getElementById('clearImageBtn').classList.remove('hidden');
            document.getElementById('editActions').classList.remove('hidden');
        }

        function clearImage() {
            document.getElementById('clearImageFlag').value = "1";
            document.getElementById('imageInput').value = "";

            // Replace preview image with "No image"
            document.querySelector('#imagePreviewContainer').innerHTML = `
                                        <div class="text-center text-gray-400">
                                            <p>No image</p>
                                        </div>
                                    `;
        }

        document.getElementById('imageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            // Reset clear flag
            document.getElementById('clearImageFlag').value = "0";

            // Replace preview with new image
            const previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.innerHTML = `
                        <img src="${URL.createObjectURL(file)}"
                             class="w-full h-full object-cover">
                    `;
        });

        function cancelEdit() {
            window.location.reload();
        }
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