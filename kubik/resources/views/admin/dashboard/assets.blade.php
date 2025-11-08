@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Dashboard - Assets')

@section('content')
    <div class="grid">
        <!-- TYPES & CATEGORIES LIST -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- TYPES LIST -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-[#F26E21] font-semibold">Types List</h3>
                    <a href="{{ route('admin.types.create') }}"
                        class="text-[#F26E21] font-semibold text-sm hover:text-[#e65d1f] transition">+ Add</a>
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
                    <a href="{{ route('admin.categories.create') }}"
                        class="text-[#F26E21] font-semibold text-sm hover:text-[#e65d1f] transition">+ Add</a>
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
        <div class="bg-white rounded-2xl shadow p-6 mt-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[#F26E21] text-xl font-semibold">Assets List</h3>

                <!-- FILTER & SEARCH BOX -->
                <div class="flex items-center space-x-2">
                    <input id="searchAsset" type="text" placeholder="Search ID / Name..."
                        class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm focus:ring-1 focus:ring-[#F26E21] focus:outline-none" />

                    <select id="filterType" class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm text-[#2A2A2A]">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>

                    <select id="filterCategory" class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm text-[#2A2A2A]">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <a href="{{ route('admin.assets.create') }}"
                        class="text-[#F26E21] font-semibold text-sm hover:text-[#e65d1f] transition">+ Add</a>

                </div>
            </div>
            <!-- TABLE -->
            <div class="overflow-y-auto max-h-96 scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md"
                id="assetTableContainer">
                @include('admin.dashboard.partials.asset_table', ['assets' => $assets])
            </div>
        </div>

        <!-- JS LOGIC -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchAsset');
                const filterType = document.getElementById('filterType');
                const filterCategory = document.getElementById('filterCategory');
                const container = document.getElementById('assetTableContainer');

                function updateTable() {
                    const params = new URLSearchParams({
                        search: searchInput.value,
                        type: filterType.value,
                        category: filterCategory.value,
                    });

                    fetch(`{{ route('admin.assets.filter') }}?${params.toString()}`)
                        .then(res => res.json())
                        .then(data => {
                            container.innerHTML = data.html;
                        })
                        .catch(err => console.error('Error updating table:', err));
                }

                searchInput.addEventListener('input', updateTable);
                filterType.addEventListener('change', updateTable);
                filterCategory.addEventListener('change', updateTable);
            });
        </script>
@endsection