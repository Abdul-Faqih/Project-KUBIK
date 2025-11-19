@extends('admin.dashboard.layout.layoutdashboard')

@section('content')
    <div class="-mt-5">

        <p class="text-base text-[#F26E21] mb-3">
            <a href="{{ route('admin.dashboard.assets') }}" class="hover:underline">Assets</a>
            <span class="text-[#2A2A2A]"> > Add Asset Master</span>
        </p>

        <div class="bg-white rounded-2xl shadow p-8">
            <h2 class="text-[#F26E21] font-semibold text-lg mb-6">Add Asset Master</h2>

            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.assets.store') }}">
                @csrf

                <!-- NAME -->
                <div class="mb-5">
                    <label class="block text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2"
                        placeholder="Name" required>
                </div>

                <!-- TYPE + CATEGORY -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <div>
                        <label class="block text-gray-700 mb-2">Type</label>
                        <select name="type_id" class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2"
                            required>
                            <option value="">Select type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id_type }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Category</label>
                        <select name="category_id" class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2"
                            required>
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_category }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- IMAGE + STOCK + DESCRIPTION -->
                <div class="flex grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- IMAGE -->
                    <div>
                        <label class="block text-gray-700 mb-2">Image</label>

                        <div id="imageBox"
                            class="border border-gray-200 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden w-[508px] h-[381px] max-w-full mb-3">

                            <div id="noImage" class="text-center text-gray-400">
                                <p>No image</p>
                            </div>

                            <img id="previewImage" src="" class="hidden w-full h-full object-cover rounded-xl">
                        </div>

                        <input type="file" name="image_asset" id="imageInput" accept="image/*"
                            class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2">
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="flex flex-col gap-3 w-full">

                        <div>
                            <label class="block text-gray-700 mb-2">Total Stock</label>
                            <input type="number" name="stock_total" min="1"
                                class="w-full rounded-lg bg-gray-100 border border-gray-200 px-4 py-2" placeholder="1">
                        </div>

                        <div class="flex-grow">
                            <label class="block text-gray-700 mb-2">Description</label>
                            <textarea name="description"
                                class="w-full min-h-[350px] rounded-xl bg-gray-100 border border-gray-200 px-4 py-3 resize-none text-gray-700"
                                placeholder="Description"></textarea>
                        </div>

                    </div>

                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <!-- CLEAR IMAGE BUTTON -->
                    <button type="button" id="clearImageBtn"
                        class="px-4 py-2 rounded-lg bg-gray-100 border border-gray-300 text-gray-700 hidden"
                        onclick="clearImage()">
                        Clear Image
                    </button>
                    <a href="{{ route('admin.dashboard.assets') }}"
                        class="px-4 py-2 rounded-lg bg-gray-100 border border-gray-300 text-gray-700 hover:bg-gray-200">Cancel</a>

                    <button type="submit" class="px-4 py-2 rounded-lg bg-[#F26E21] text-white hover:bg-[#e65d1f]">
                        Confirm
                    </button>
                </div>

            </form>
        </div>

        <script>
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const noImage = document.getElementById('noImage');
            const clearBtn = document.getElementById('clearImageBtn');
            const clearFlag = document.getElementById('clearImageFlag');

            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];

                if (!file) return;

                // tampilkan preview
                previewImage.src = URL.createObjectURL(file);
                previewImage.classList.remove('hidden');
                noImage.classList.add('hidden');

                // tampilkan tombol clear
                clearBtn.classList.remove('hidden');

                // reset clear flag
                clearFlag.value = "0";
            });

            // CLEAR IMAGE FUNCTION
            function clearImage() {
                // kosongkan input
                imageInput.value = "";

                // sembunyikan preview
                previewImage.classList.add('hidden');
                previewImage.src = "";

                // tampilkan "no image"
                noImage.classList.remove('hidden');

                // set clear flag
                clearFlag.value = "1";

                // sembunyikan tombol clear
                clearBtn.classList.add('hidden');
            }
        </script>


    </div>
@endsection