<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden flex flex-col h-full">
    
    {{-- Header Oranye --}}
    <div class="bg-[#F7941E] px-5 py-3 flex justify-between items-center">
        <p class="text-white text-[15px] font-medium">Peminjaman no. {{ $item->id_booking }}</p>
    </div>

    {{-- Body --}}
    <div class="p-5 flex-1 flex flex-col justify-between">
        
        {{-- Wrapper Konten Atas --}}
        <div>
            <div class="space-y-4">
                
                {{-- LOGIC ICON & DATE --}}
                @php
                    $isRoom = false;
                    if(isset($item->category_name)) {
                        $isRoom = stripos($item->category_name, 'Room') !== false || stripos($item->category_name, 'Ruangan') !== false;
                    }
                @endphp

                {{-- 1. TANGGAL --}}
                <div class="flex items-center gap-3">
                    <span class="material-symbols-rounded text-[#9A9A9A] text-[20px]">calendar_today</span>
                    <span class="text-[#2A2A2A] text-[15px] font-medium">
                        {{ \Carbon\Carbon::parse($item->start_time)->translatedFormat('l, d F Y') }}
                    </span>
                </div>

                {{-- 2. NAMA ASET & ITEM COUNT --}}
                <div class="flex items-start gap-3">
                    {{-- Icon berubah sesuai kategori --}}
                    <span class="material-symbols-rounded text-[#9A9A9A] text-[20px] mt-0.5">
                        {{ $isRoom ? 'apartment' : 'inventory_2' }}
                    </span>
                    
                    <div class="flex flex-col">
                        <span class="text-[#2A2A2A] text-[15px] font-medium leading-tight line-clamp-2">
                            {{ $item->asset_name }}
                        </span>

                        {{-- Jika lebih dari 1 barang --}}
                        @if($item->total_items > 1)
                            <span class="text-[#F26E21] text-[13px] font-medium mt-1">
                                + {{ $item->total_items - 1 }} Item Lainnya
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            {{-- 3. STATUS (Tanpa Garis, langsung di bawahnya) --}}
            <div class="mt-4">
                <div class="flex items-center gap-2.5">
                    @if($item->status == 'Pending')
                        {{-- KUNING --}}
                        <div class="w-3 h-3 rounded-full bg-yellow-500 shadow-sm"></div>
                        <span class="text-[14px] font-bold text-yellow-600">Menunggu Konfirmasi</span>
                
                    @elseif($item->status == 'Approved')
                        {{-- HIJAU --}}
                        <div class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></div>
                        <span class="text-[14px] font-bold text-green-600">Disetujui</span>
                
                    @elseif($item->status == 'Rejected')
                        {{-- MERAH --}}
                        <div class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></div>
                        <span class="text-[14px] font-bold text-red-600">Ditolak</span>
                
                    @elseif($item->status == 'Completed')
                        {{-- BIRU --}}
                        <div class="w-3 h-3 rounded-full bg-blue-500 shadow-sm"></div>
                        <span class="text-[14px] font-bold text-blue-600">Selesai</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- 4. BUTTON DETAIL (Dikasih jarak mt-5) --}}
        <a href="{{ route('user.rentals.detail', $item->id_booking) }}" 
           class="block w-full border border-[#F26E21] text-[#F26E21] text-center py-2.5 rounded-xl text-[15px] font-bold hover:bg-[#FFF2E9] transition-colors mt-5">
            Lihat Detail
        </a>
    </div>
</div>