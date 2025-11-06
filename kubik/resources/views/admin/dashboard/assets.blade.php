@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Dashboard - Assets')

@section('content')
    <div class="grid gap-6">
        <!-- TYPES & CATEGORIES LIST -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- TYPES LIST -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[#F26E21] text-xl font-semibold">Types List</h3>

                    <!-- Add -->
                    <button
                        class="text-[#AEAEAE] px-2 py-1 rounded-md text-base hover:bg-[#F26E21] hover:text-white transition">
                        + Add
                    </button>
                </div>
                <div
                    class="overflow-y-auto max-h-64 scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md">
                    <table class="w-full text-base">
                        <thead class="text-[#2A2A2A] border-b border-[#FBFBFB] sticky top-0 bg-white">
                            <tr>
                                <th class="py-2 px-3 text-center">No.</th>
                                <th class="py-2 px-3 text-center">ID</th>
                                <th class="py-2 px-3 text-center">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($types as $index => $type)
                                <tr class="border-b border-[#FBFBFB] hover:bg-[#00000010] transition">
                                    <td class="py-2 px-3 text-center">{{ $index + 1 }}</td>
                                    <td class="py-2 px-3 text-center">{{ $type->id_type }}</td>
                                    <td class="py-2 px-3">{{ $type->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-3 text-center text-[#AEAEAE]">No type data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CATEGORIES LIST -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[#F26E21] text-xl font-semibold">Categories List</h3>

                    <!-- Add -->
                    <button
                        class=" text-[#AEAEAE] px-2 py-1 rounded-md text-base hover:bg-[#F26E21] hover:text-white transition">
                        + Add
                    </button>
                </div>
                <div
                    class="overflow-y-auto max-h-64 scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md">
                    <table class="w-full text-base">
                        <thead class="text-[#2A2A2A] border-b border-[#FBFBFB] sticky top-0 bg-white">
                            <tr>
                                <th class="py-2 px-3 text-center">No.</th>
                                <th class="py-2 px-3 text-center">ID</th>
                                <th class="py-2 px-3 text-center">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $index => $cat)
                                <tr class="border-b border-[#FBFBFB] hover:bg-[#00000010] transition">
                                    <td class="py-2 px-3 text-center">{{ $index + 1 }}</td>
                                    <td class="py-2 px-3 text-center">{{ $cat->id_category }}</td>
                                    <td class="py-2 px-3">{{ $cat->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-3 text-center text-[#AEAEAE]">No category data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ASSETS LIST -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[#F26E21] text-xl font-semibold">Assets List</h3>
                
                    <!-- Search -->
                    <div class="relative">
                        <input type="search" placeholder="ID or Name assets..."
                            class="border border-[#AEAEAE] rounded-md pr-3 pl-10 py-1 text-base text-[#2A2A2A] hover:border-[#F26E21] focus:outline-none focus:border-[#F26E21]"/>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-2 text-[#AEAEAE] cursor-pointer hover:text-[#F26E21]" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                        </svg>
                    </div>

                <div class="flex items-center space-x-3">

                    <!-- Filter -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="px-2 py-2 rounded-md w-9 h- text-[#AEAEAE] cursor-pointer hover:bg-[#F26E21] hover:text-white transition"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-6 7v6l-6 3v-9L3 6V4z" />
                    </svg>

                    <!-- Add -->
                    <button
                        class=" text-[#AEAEAE] px-2 py-1 rounded-md text-base hover:bg-[#F26E21] hover:text-white transition">
                        + Add
                    </button>
                </div>
            </div>

            <div
                class="overflow-y-auto max-h-96 scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md">
                <table class="w-full text-base">
                    <thead class="text-[#2A2A2A] border-b border-[#FBFBFB] sticky top-0 bg-white">
                        <tr>
                            <th class="py-2 px-3 text-center">No.</th>
                            <th class="py-2 px-3 text-center">ID</th>
                            <th class="py-2 px-3 text-center">ID Master</th>
                            <th class="py-2 px-3 text-center">Name</th>
                            <th class="py-2 px-3 text-center">Type</th>
                            <th class="py-2 px-3 text-center">Category</th>
                            <th class="py-2 px-3 text-center">Status</th>
                            <th class="py-2 px-3 text-center">Condition</th>
                            <th class="py-2 px-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $index => $asset)
                            <tr class="border-b border-[#FBFBFB] hover:bg-[#00000010] transition">
                                <td class="py-2 px-3 text-center">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 text-center">{{ $asset->id_asset }}</td>
                                <td class="py-2 px-3 text-[#F26E21] text-center font-medium hover:underline cursor-pointer">
                                    {{ $asset->master?->id_master ?? '-' }}
                                </td>
                                <td class="py-2 px-3">{{ $asset->master->name ?? '-' }}</td>
                                <td class="py-2 px-3 text-center">{{ $asset->master?->type?->name ?? '-' }}</td>
                                <td class="py-2 px-3 text-center">{{ $asset->master?->category?->name ?? '-' }}</td>
                                <td class="py-2 px-3 text-center">{{ $asset->status ?? '-' }}</td>
                                <td class="py-2 px-3 text-center">{{ $asset->condition ?? '-' }}</td>
                                <td class="py-2 px-3 text-center">
                                    <button
                                        class=" text-[#F26E21] px-3 py-1 rounded-md text-base hover:bg-[#F26E21] hover:text-white transition">Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-3 text-center text-[#AEAEAE]">No asset data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection