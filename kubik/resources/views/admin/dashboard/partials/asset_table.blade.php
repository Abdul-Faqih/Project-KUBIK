<table class="w-full text-base">
    <thead class="text-[#2A2A2A] sticky top-0 bg-white">
        <tr>
            <th class="py-2 px-3 text-center">No.</th>
            <th class="py-2 px-3 text-center">ID</th>
            <th class="py-2 px-3 text-center">ID Master</th>
            <th class="py-2 px-3 text-center">Name</th>
            <th class="py-2 px-3 text-center">Type</th>
            <th class="py-2 px-3 text-center">Category</th>
            <th class="py-2 px-3 text-center">Status</th>
            <th class="py-2 px-3 text-center">Condition</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assets as $i => $asset)
            <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white"
                onclick="window. location='{{ route('admin.assets.detail', $asset->id_asset) }}'">
                <td class="py-2 px-3 text-center">{{ $i + 1 }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->id_asset }}</td>
                <td class="py-2 px-3 text-center">
                    <a href="{{ route('admin.assetmasters.detail', $asset->id_master) }}"
                        class="hover:bg-[#FBFBFB] hover:text-[#F26E21] hover:underline py-1 px-3 rounded-md">
                        {{ $asset->id_master }}
                    </a>
                </td>
                <td class="py-2 px-3">{{ $asset->master->name }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->master->type->name ?? '-' }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->master->category->name ?? '-' }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->status }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->condition }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="py-4 text-center text-[#AEAEAE]">No assets found</td>
            </tr>
        @endforelse
    </tbody>
</table>