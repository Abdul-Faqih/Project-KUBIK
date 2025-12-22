<table class="w-full">
    <thead class="text-[#2A2A2A] sticky top-0 bg-white text-base">
        <tr>
            <th class="py-2 px-3 text-center">ID</th>
            <th class="py-2 px-3 text-center">ID Master</th>
            <th class="py-2 px-3 text-center">Name</th>
            <th class="py-2 px-3 text-center">Type</th>
            <th class="py-2 px-3 text-center">Category</th>
            <th class="py-2 px-3 text-center">Status</th>
            <th class="py-2 px-3 text-center">Condition</th>
            <th class="py-2 px-3 text-center">Created At</th>
            <th class="py-2 px-3 text-center">Last Updated</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assets as $i => $asset)
            <tr class="border-b border-[#FBFBFB] hover:bg-[#F26E21] transition hover:text-white text-sm"
                onclick="window. location='{{ route('admin.assets.detail', $asset->id_asset) }}'">
                <td class="py-2 px-3 text-center">{{ $asset->id_asset }}</td>
                <td class="py-2 px-3 text-center">
                    <a href="{{ route('admin.assetmasters.detail', $asset->id_master) }}"
                        class="hover:text-[#F26E21] hover:bg-[#FBFBFB] py-1 px-3 rounded-md">
                        {{ $asset->id_master }}
                    </a>
                </td>
                <td class="py-2 px-3">{{ $asset->master->name }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->master->type->name ?? '-' }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->master->category->name ?? '-' }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->status }}</td>
                <td class="py-2 px-3 text-center">{{ $asset->condition }}</td>
                <td class="py-2 px-3 text-center">
                    {{ \Carbon\Carbon::parse($asset->create_at)->format('d/m/Y H:i') }}
                </td>
                <td class="py-2 px-3 text-center">
                    {{ \Carbon\Carbon::parse($asset->updated_at)->format('d/m/Y H:i') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="py-4 text-center text-[#AEAEAE]">No assets found</td>
            </tr>
        @endforelse
    </tbody>
</table>