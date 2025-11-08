@extends('admin.dashboard.layout.layoutdashboard')

@section('content')
    <div class="-mt-5">
        <!-- Breadcrumb -->
        <div class="text-base text-[#F26E21] mb-3">
            <a href="{{ route('admin.dashboard.assets') }}" class="hover:underline text-[#F26E21]">Assets</a>
            <span class="text-[#2A2A2A]"> > {{ $asset->id_asset }}</span>
        </div>

        <!-- Asset Detail Card -->
        <div class="bg-[#FBFBFB] rounded-2xl shadow p-8 relative">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-[#F26E21] font-bold text-xl mb-1">{{ $asset->id_asset }}</h2>
                    <p class="text-base text-[#AEAEAE]">
                        Updated at:
                        {{ \Carbon\Carbon::parse($asset->updated_at)->format('H : i') }} ;
                        {{ \Carbon\Carbon::parse($asset->updated_at)->format('d M Y') }}
                    </p>
                </div>
                <button class="p-2 hover:bg-[#FBFBFB] rounded-full transition" title="Edit Asset">
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
                    <label class="block text-[#2A2A2A] text-base mb-2">ID Asset Master</label>
                    <a href="{{ route('admin.assetmasters.detail', $asset->id_master) }}"
                        class="block w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB] text-[#F26E21] hover:underline">
                        {{ $asset->id_master }}
                    </a>
                </div>

                <div>
                    <label class="block text-[#2A2A2A] text-base mb-1">Name</label>
                    <input type="text" value="{{ $asset->master->name ?? '-' }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                <div>
                    <label class="block text-[#2A2A2A] text-base mb-1">Type</label>
                    <input type="text" value="{{ $asset->master->type->name ?? '-' }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                </div>

                <div>
                    <label class="block text-[#2A2A2A] text-base mb-1">Category</label>
                    <input type="text" value="{{ $asset->master->category->name ?? '-' }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                </div>

                <div>
                    <label class="block text-[#2A2A2A] text-base mb-1">Condition</label>
                    <input type="text" value="{{ $asset->condition }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                </div>

                <div>
                    <label class="block text-[#2A2A2A] text-base mb-1">Status</label>
                    <input type="text" value="{{ $asset->status }}"
                        class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-base bg-[#FBFBFB]" disabled />
                </div>
            </div>
        </div>
    </div>
@endsection