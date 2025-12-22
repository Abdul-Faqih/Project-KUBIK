@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Categories')

@section('content')
    <div class="grid">

        {{-- COMPONENT LOG MODAL --}}
        {{-- Pastikan controller mengirim variable $activities --}}
        <div class="">
            @include('admin.dashboard.components.log_modal', ['activities' => $activities ?? collect([])])
        </div>

        <!-- CATEGORIES LIST -->
        <div class="bg-white rounded-2xl shadow p-6 mt-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[#F26E21] text-xl font-semibold">Categories List</h3>
                <a href="{{ route('admin.categories.create') }}"
                    class="text-[#F26E21] font-semibold text-sm hover:text-[#FBFBFB] hover:bg-[#F26E21] py-1 px-2 rounded-md transition">+
                    Add</a>
            </div>
            <div
                class="overflow-y-auto max-h-[72vh] scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md">
                <table class="w-full">
                    <thead class="text-[#2A2A2A] sticky top-0 bg-white text-base">
                        <tr>
                            <th class="py-2 px-3 text-center">ID</th>
                            <th class="py-2 px-3 text-center">Name</th>
                            <th class="py-2 px-3 text-center">Total Asset Masters</th>
                            <th class="py-2 px-3 text-center">Total Assets</th>
                            <th class="py-2 px-3 text-center">Created At</th>
                            <th class="py-2 px-3 text-center">Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $cat)
                            <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white text-sm"
                                onclick="window. location='{{ route('admin.dashboard.categories.detail', $cat->id_category) }}'">
                                <td class="py-2 px-3 text-center">{{ $cat->id_category }}</td>
                                <td class="py-2 px-3 text-left">{{ $cat->name }}</td>
                                <td class="py-2 px-3 text-center"> {{ $cat->assetmasters->count() }} </td>
                                <td class="py-2 px-3 text-center"> {{ $cat->assets->count() }} </td>
                                <td class="py-2 px-3 text-center">
                                    {{ \Carbon\Carbon::parse($cat->create_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2 px-3 text-center">
                                    {{ \Carbon\Carbon::parse($cat->updated_at)->format('d/m/Y H:i') }}
                                </td>
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
@endsection