{{--
KOMPONEN: LOG HISTORY MODAL
--}}


<button onclick="openLogModal()"
    class="flex items-center gap-2 px-4 py-2 bg-white border border-[#ECEFF3] rounded-lg text-[#2A2A2A] hover:bg-gray-50 hover:text-[#F26E21] transition shadow-sm font-medium text-sm">
    <span class="material-symbols-rounded text-lg">history</span>
    View History Log
</button>

<div id="logModal" class="fixed inset-0 z-[999] hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeLogModal()"></div>

    <div class="absolute right-0 top-0 h-full w-full max-w-2xl bg-white shadow-2xl transform transition-transform duration-300 translate-x-full"
        id="logModalPanel">

        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <h3 class="text-xl font-bold text-[#2A2A2A]">Activity Log</h3>
                <p class="text-sm text-gray-400">History of changes for this item</p>
            </div>
            <button onclick="closeLogModal()" class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition">
                <span class="material-symbols-rounded text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto h-[calc(100vh-100px)] space-y-6">

            @forelse($activities as $activity)
                <div class="relative pl-6 border-l-2 border-gray-200">
                    <span
                        class="absolute -left-[9px] top-0 h-4 w-4 rounded-full border-2 border-white 
                            {{ $activity->event == 'created' ? 'bg-green-500' : ($activity->event == 'deleted' ? 'bg-red-500' : 'bg-[#F26E21]') }}">
                    </span>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-bold text-[#2A2A2A]">
                                    {{ $activity->causer->name ?? 'System' }}
                                </p>
                                <p class="text-xs text-gray-500 capitalize">
                                    {{ $activity->description }} ({{ $activity->event }})
                                </p>
                            </div>
                            <span class="text-[11px] text-gray-400 bg-white px-2 py-1 rounded border">
                                {{ $activity->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>

                        @if($activity->event == 'updated' && isset($activity->properties['old']))
                            <div class="mt-3 bg-white rounded-lg border border-gray-200 overflow-hidden">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 flex justify-between items-center cursor-pointer"
                                    onclick="toggleDetails('details-{{ $activity->id }}')">
                                    <span class="text-xs font-semibold text-gray-600">Changes Details</span>
                                    <span class="material-symbols-rounded text-sm text-gray-500">expand_more</span>
                                </div>

                                <div id="details-{{ $activity->id }}" class="hidden">
                                    <table class="w-full text-left text-xs">
                                        <thead class="bg-gray-50 text-gray-500 border-b">
                                            <tr>
                                                <th class="px-3 py-2 font-medium">Field</th>
                                                <th class="px-3 py-2 font-medium text-red-500">Before</th>
                                                <th class="px-3 py-2 font-medium text-green-600">After</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($activity->properties['attributes'] as $key => $newVal)
                                                @if(isset($activity->properties['old'][$key]) && $activity->properties['old'][$key] != $newVal)
                                                    <tr>
                                                        <td class="px-3 py-2 font-medium text-gray-700 capitalize">
                                                            {{ str_replace('_', ' ', $key) }}</td>
                                                        <td class="px-3 py-2 text-red-500 bg-red-50/30 break-all">
                                                            {{ $activity->properties['old'][$key] }}</td>
                                                        <td class="px-3 py-2 text-green-600 bg-green-50/30 break-all">{{ $newVal }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <form action="{{ route('admin.activity.revert', $activity->id) }}" method="POST"
                                class="mt-3 text-right"
                                onsubmit="return confirm('Are you sure you want to revert changes to this state? Current data will be overwritten.');">
                                @csrf
                                <button type="submit"
                                    class="text-xs text-[#F26E21] hover:text-[#d85b17] font-semibold flex items-center justify-end gap-1 w-full">
                                    <span class="material-symbols-rounded text-sm">undo</span> Undo this change
                                </button>
                            </form>
                        @elseif($activity->event == 'created')
                            <p class="text-xs text-gray-400 italic mt-2">Item created initially.</p>
                        @endif

                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <span class="material-symbols-rounded text-4xl text-gray-300 mb-2">history_toggle_off</span>
                    <p class="text-gray-400 text-sm">No history found.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>

<script>
    function openLogModal() {
        const modal = document.getElementById('logModal');
        const panel = document.getElementById('logModalPanel');
        modal.classList.remove('hidden');
        // Small delay for transition
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 10);
    }

    function closeLogModal() {
        const modal = document.getElementById('logModal');
        const panel = document.getElementById('logModalPanel');
        panel.classList.add('translate-x-full');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function toggleDetails(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
    }
</script>