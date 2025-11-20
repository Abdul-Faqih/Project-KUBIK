@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Asset Master')
@section('content')

    <div class="-mt-5">

        <!-- Breadcrumb -->
        <p class="text-base text-[#2A2A2A] mb-3">
            <a href="{{ route('admin.dashboard.assets') }}" class="text-[#F26E21] hover:underline">Assets</a>
            > {{ $master->id_master }}
        </p>

        <!-- MAIN CARD -->
        <div class="bg-[#FBFBFB] rounded-2xl shadow-md px-10 py-8 relative">

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
            <div class="mb-3">
                <h1 class="text-xl font-semibold text-[#F26E21] mb-1">{{ $master->id_master }}</h1>

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
                    <label class="block text-[#2A2A2A] text-base mb-1">Name</label>
                    <input type="text" name="name" value="{{ $master->name }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]" disabled>
                </div>

                <!-- TYPE + CATEGORY -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Type</label>
                        <select name="type_id" class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]"
                            disabled>
                            @foreach ($types as $type)
                                <option value="{{ $type->id_type }}" {{ $master->id_type == $type->id_type ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Category</label>
                        <select name="category_id" class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB]"
                            disabled>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id_category }}" {{ $master->id_category == $cat->id_category ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                </div>

                <!-- IMAGE + STOCK + DESCRIPTION -->
                <div class="flex grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- LEFT: IMAGE -->
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Image</label>

                        <div id="imagePreviewContainer"
                            class="border border-[#ECEFF3] bg-[#F9FAFB] rounded-md px-3 py-2 flex items-center justify-center overflow-hidden w-[508px] h-[381px] max-w-full mb-3">

                            @if ($master->image_asset)
                                <img src="{{ asset('uploads/assetmasters/' . $master->image_asset) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-[#2A2A2A] text-base">
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
                            <label class="block text-[#2A2A2A] text-base mb-1">Total Stock</label>
                            <input type="number" name="stock_total" value="{{ $master->stock_total }}" disabled
                                class="w-full border border-[#ECEFF3] rounded-md px-3 py-2">
                        </div>

                        <div class="flex-grow">
                            <label class="block text-[#2A2A2A] text-base mb-1">Description</label>
                            <textarea name="description"
                                class="w-full min-h-[278px] rounded-xl border border-[#ECEFF3] px-4 py-3 resize-none text-[#2A2A2A]"
                                disabled>{{ $master->description }}</textarea>
                        </div>

                    </div>

                </div>

                <!-- Button SAVE / CANCEL -->
                <div id="editActions" class="hidden flex justify-end gap-3 mt-8">

                    <button type="button" onclick="clearImage()" id="clearImageBtn"
                        class="px-4 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A] hover:bg-[#F5F5F5]">
                        Clear Image
                    </button>

                    <button type="button" onclick="cancelEdit()"
                        class="px-4 py-2 rounded-md bg-[#FBFBFB] border border-[#ECEFF3] text-[#2A2A2A] hover:bg-[#F5F5F5]">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 rounded-md bg-[#F26E21] text-white hover:bg-[#e65d1f]">
                        Save
                    </button>

                </div>

            </form>

            </div>

            <!-- ASSET LIST TABLE -->
            <div class="bg-white rounded-2xl shadow-md px-10 py-6 mt-10">

                <h2 class="text-lg font-semibold text-[#F26E21] mb-4">Asset List</h2>

                @if ($master->assets->count() > 0)

                    <div class="overflow-x-auto">
                        <table class="w-full text-center border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-[#2A2A2A] text-base">
                                    <th class="py-3 px-2">ID Asset</th>
                                    <th class="py-3 px-2">Condition</th>
                                    <th class="py-3 px-2">Status</th>
                                </tr>
                            </thead>

                            <tbody class="text-[#2A2A2A] text-center text-base">

                                @foreach ($master->assets as $asset)
                                    <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white"
                                    onclick="window. location='{{ route('admin.assets.detail', $asset->id_asset) }}'">

                                        <td class="py-3 px-2"> {{ $asset->id_asset }}
                                        </td>

                                        <td class="py-3 px-2">
                                            {{ $asset->condition }}
                                        </td>

                                        <td class="py-3 px-2">
                                            {{ $asset->status }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                @else
                    <p class="text-gray-500 italic">No assets found for this Asset Master.</p>
                @endif

            </div>

    </div>

    <!-- DELETE MODAL -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">

        <div class="bg-white rounded-2xl p-6 w-[380px] shadow-xl">

            <h3 class="text-[#F26E21] text-xl font-semibold mb-4">Delete Confirmation</h3>

            <p class="text-base text-[#2A2A2A] mb-7">
                Are you sure you want to delete
                <span class="font-semibold text-[#F26E21]">{{ $master->id_master }}</span>?<br>
                This action cannot be undone.
            </p>

            <form method="POST" action="{{ route('admin.dashboard.assetmasters.delete', $master->id_master) }}">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">

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