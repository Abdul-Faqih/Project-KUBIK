@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Dashboard - Assets')

@section('content')
    <div class="grid relative ">

        {{-- COMPONENT LOG MODAL --}}
        {{-- Pastikan controller mengirim variable $activities --}}
        <div class="">
            @include('admin.dashboard.components.log_modal', ['activities' => $activities ?? collect([])])
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-6">

            <div class="flex items-center justify-between mb-4">

                {{-- TITLE AREA & LOG BUTTON --}}
                <div class="flex items-center gap-3">
                    <h3 class="text-[#F26E21] text-xl font-semibold">Assets List</h3>
                </div>

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
                        class="text-[#F26E21] font-semibold text-sm hover:text-[#FBFBFB] hover:bg-[#F26E21] py-1 px-2 rounded-md transition">+
                        Add</a>

                </div>
            </div>

            <div class="overflow-y-auto max-h-[75vh] scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md"
                id="assetTableContainer">
                @include('admin.dashboard.partials.asset_table', ['assets' => $assets])
            </div>
        </div>

    </div>

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