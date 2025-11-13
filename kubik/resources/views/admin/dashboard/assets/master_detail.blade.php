@extends('admin.dashboard.layout.layoutdashboard')

@section('content')
    <div class="-mt-5">
        <!-- Breadcrumb -->
        <div class="text-base text-[#F26E21] mb-3">
            <a href="{{ route('admin.dashboard.assets') }}" class="hover:underline text-[#F26E21]">Assets</a>
            <span class="text-[#2A2A2A]"> > {{ $master->id_master }}</span>
        </div>

        <!-- Asset Master Card -->
        <div class="bg-[#FBFBFB] rounded-2xl shadow p-8 relative">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-[#F26E21] font-bold text-xl mb-1">{{ $master->id_master }}</h2>
                    <p class="text-base text-[#AEAEAE]">
                        Updated at:
                        {{ \Carbon\Carbon::parse($master->updated_at)->format('H : i') }} ;
                        {{ \Carbon\Carbon::parse($master->updated_at)->format('d M Y') }}
                    </p>
                </div>
                <button class="p-2 hover:bg-[#FBFBFB] rounded-full transition" title="Edit Master Asset">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#F26E21" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13l-2.685.8a.75.75 0 01-.933-.933l.8-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L17.25 4.875" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-3">
                <div>
                    <label class="block text-[#2A2A2A] text-base mb-1">Name</label>
                    <input type="text" value="{{ $master->name }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Type</label>
                        <input type="text" value="{{ $master->type->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Category</label>
                        <input type="text" value="{{ $master->category->name ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Quantity</label>
                        <input type="text" value="{{ $master->stock_total }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                    </div>

                    <div>
                        <label class="block text-[#2A2A2A] text-base mb-1">Image</label>
                        <input type="text" value="{{ $master->image_asset ?? '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[#2A2A2A] text-base mb-1">Description</label>
                        <textarea rows="3"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]"
                            disabled>{{ $master->description ?? '-' }}</textarea>

                    </div>
                </div>
            </div>
        </div>

        <!-- List Asset Section -->
        <div class="mt-6 bg-white rounded-2xl shadow p-8">
            <h3 class="text-[#F26E21] text-xl font-semibold mb-3">Asset List</h3>
            <table class="w-full text-base text-center">
                <thead class="text-[#2A2A2A] ">
                    <tr>
                        <th class="py-2 px-3">No.</th>
                        <th class="py-2 px-3">ID</th>
                        <th class="py-2 px-3">Condition</th>
                        <th class="py-2 px-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($master->assets as $index => $item)
                        <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white"
                            onclick="window. location='{{ route('admin.assets.detail', $item->id_asset) }}'">
                            <td class="py-2 px-3">{{ $index + 1 }}</td>
                            <td class="py-2 px-3 text-center">
                                {{ $item->id_asset }}
                            </td>
                            <td class="py-2 px-3">{{ $item->condition }}</td>
                            <td class="py-2 px-3">{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 text-center text-[#AEAEAE]">No assets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection