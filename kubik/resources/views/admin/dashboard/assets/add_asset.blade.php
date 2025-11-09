@extends('admin.dashboard.layout.layoutdashboard')

@section('content')
    <div class="-mt-5">
        <div class="text-base text-[#F26E21] mb-3">
            <a href="{{ route('admin.dashboard.assets') }}" class="hover:underline">Assets</a>
            <span class="text-[#2A2A2A]"> > Add Asset</span>
        </div>

        <div class="bg-white rounded-2xl shadow p-8">
            <h2 class="text-[#F26E21] font-semibold text-lg mb-6">Add Asset</h2>

            <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1 ">Name</label>
                        <input name="name" type="text" placeholder="Asset"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-1 focus:border-[#F26E21] focus:outline-none"
                            required />
                        <p class="text-xs text-[#AEAEAE] mt-1">Please enter asset name</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Type</label>
                        <select name="type_id"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-1 focus:border-[#F26E21] focus:outline-none"
                            required>
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id_type }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-[#AEAEAE] mt-1">Please select a type</p>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Category</label>
                        <select name="category_id"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 mr-10 text-base focus:border-1 focus:border-[#F26E21] focus:outline-none"
                            required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-[#AEAEAE] mt-1">Please select a category</p>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Quantity</label>
                        <input name="stock_total" type="number" min="1"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-1 focus:border-[#F26E21] focus:outline-none"
                            required />
                        <p class="text-xs text-[#AEAEAE] mt-1">Please enter quantity</p>
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Image</label>
                        <input type="file" name="image"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-1 focus:border-[#F26E21] focus:outline-none" />
                        <p class="text-xs text-[#AEAEAE] mt-1">File must be JPG, JPEG, or PNG format, under 5 MB.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[#2A2A2A] text-base mb-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base focus:border-1 focus:border-[#F26E21] focus:outline-none"></textarea>
                        <p class="text-xs text-[#AEAEAE] mt-1">Please enter description of the asset</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('admin.dashboard.assets') }}"
                        class="px-4 py-2 rounded-md bg-[#F26E21]/10 text-[#F26E21] hover:bg-[#F26E21]/20 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-[#F26E21] text-white hover:bg-[#e65d1f] transition">Confirm</button>
                </div>
            </form>
        </div>
    </div>
@endsection