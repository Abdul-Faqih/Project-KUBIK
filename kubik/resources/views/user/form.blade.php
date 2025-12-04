@extends('user.layout.mobile')

@section('title', 'Loan Request Form')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')
    <div class="w-full max-w-[430px] mx-auto px-5 py-6 bg-white min-h-screen font-sans">

        {{-- Header --}}
        <div class="flex items-center mb-6">
            <a href="{{ route('user.home') }}" class="mr-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="#1F2937" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Loan Request Form</h1>
        </div>

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('user.form.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Section: Date Loan --}}
            <h2 class="text-base font-bold text-gray-800 mb-3">Date Loan</h2>

            <div class="mb-4">
                <label class="block text-gray-500 text-sm mb-1">Start</label>
                <div class="flex items-center border-b border-gray-200 py-2 mb-2">
                    <input type="date" name="start_date" required value="{{ old('start_date') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-calendar text-gray-400"></i>
                </div>
                <div class="flex items-center border-b border-gray-200 py-2">
                    <input type="time" name="start_time" required value="{{ old('start_time') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-clock text-gray-400"></i>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-500 text-sm mb-1">End</label>
                <div class="flex items-center border-b border-gray-200 py-2 mb-2">
                    <input type="date" name="end_date" required value="{{ old('end_date') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-calendar text-gray-400"></i>
                </div>
                <div class="flex items-center border-b border-gray-200 py-2">
                    <input type="time" name="end_time" required value="{{ old('end_time') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-clock text-gray-400"></i>
                </div>
            </div>

            {{-- Section: List Assets --}}
            <h2 class="text-base font-bold text-gray-800 mb-3">List Assets</h2>

            {{-- Rooms --}}
            <div class="mb-5">
                <p class="text-sm text-gray-500 mb-2">Room</p>
                @forelse($rooms as $room)
                    <div class="flex items-center mb-2 room-row" id="room-row-{{ $room->id_asset }}">
                        {{-- REVISI POIN 2: Panggil fungsi deleteCartItem --}}
                        <button type="button" onclick="deleteCartItem('{{ $room->id_master }}', '{{ $room->id_asset }}', this)" class="mr-2 text-[#F26E21]">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z" />
                            </svg>
                        </button>
                        <span class="text-gray-800 font-medium">{{ $room->name }}</span>
                        <input type="hidden" name="assets[]" value="{{ $room->id_asset }}">
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic">No room selected</p>
                @endforelse

                {{-- REVISI POIN 1: Link Availability Rooms --}}
                <a href="{{ route('user.availability') }}?type=TYP-000001"
                    class="flex items-center text-[#F26E21] text-sm mt-2 font-medium">
                    <span class="mr-1 text-lg font-bold">+</span> Add another room
                </a>
            </div>

            {{-- Items --}}
            <div class="mb-6">
                <p class="text-sm text-gray-500 mb-2">Item</p>
                @forelse($groupedItems as $group)
                    <div class="flex items-center justify-between mb-3 item-group" id="group-{{ $group['master_id'] }}">
                        <span class="text-gray-800 font-medium">{{ $group['name'] }}</span>

                        <div class="flex items-center gap-3">
                            {{-- REVISI POIN 3: Minus Button (Hapus Cart) --}}
                            <button type="button" onclick="deleteCartItem('{{ $group['master_id'] }}', null, this, true)"
                                class="w-6 h-6 rounded-full bg-[#F26E21] text-white flex items-center justify-center font-bold">
                                -
                            </button>

                            <span class="font-semibold w-4 text-center text-gray-800" id="count-{{ $group['master_id'] }}">
                                {{ count($group['assets']) }}
                            </span>

                            {{-- REVISI POIN 3: Plus Button (Tambah Cart) --}}
                            <button type="button" onclick="addCartItem('{{ $group['master_id'] }}')"
                                class="w-6 h-6 rounded-full bg-[#F26E21] text-white flex items-center justify-center font-bold">
                                +
                            </button>
                        </div>

                        {{-- Hidden Inputs Container --}}
                        <div id="inputs-{{ $group['master_id'] }}" class="hidden">
                            @foreach($group['assets'] as $assetId)
                                <input type="hidden" name="assets[]" value="{{ $assetId }}" class="asset-input">
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic">No items selected</p>
                @endforelse

                {{-- REVISI POIN 1: Link Availability Items --}}
                <a href="{{ route('user.availability') }}?type=TYP-000002"
                    class="flex items-center text-[#F26E21] text-sm mt-2 font-medium">
                    <span class="mr-1 text-lg font-bold">+</span> Add another item
                </a>
            </div>

            {{-- Section: Attachment --}}
            <h2 class="text-base font-bold text-gray-800 mb-2">Attachment</h2>
            <div>
                <input type="file" name="attachment" id="attachmentInput" class="hidden" accept=".pdf,.jpg,.png">

                {{-- REVISI POIN 5: Button Logic (Add / Remove) --}}
                <p id="file-label" class="text-left text-sm text-gray-500 mb-1 hidden"></p>
                <button type="button" id="attachmentBtn"
                    class="w-full border border-[#F26E21] text-[#F26E21] rounded-xl py-3 font-semibold hover:bg-orange-50 transition">
                    Add
                </button>
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                class="w-full bg-[#F26E21] mt-5 text-white rounded-xl py-4 font-bold text-lg shadow-md hover:bg-orange-600 transition">
                Submit
            </button>
        </form>
    </div>

    <script>
        // --- LOGIKA ATTACHMENT (REVISI POIN 5) ---
        const attachmentInput = document.getElementById('attachmentInput');
        const attachmentBtn = document.getElementById('attachmentBtn');
        const fileLabel = document.getElementById('file-label');

        attachmentBtn.addEventListener('click', function() {
            if (attachmentBtn.innerText === 'Remove') {
                // Hapus file
                attachmentInput.value = ''; // Reset input
                fileLabel.innerText = '';
                fileLabel.classList.add('hidden');
                
                // Ubah tombol kembali ke "Add"
                attachmentBtn.innerText = 'Add';
                attachmentBtn.classList.remove('border-red-500', 'text-red-500', 'hover:bg-red-50');
                attachmentBtn.classList.add('border-[#F26E21]', 'text-[#F26E21]', 'hover:bg-orange-50');
            } else {
                // Trigger upload dialog
                attachmentInput.click();
            }
        });

        attachmentInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Tampilkan nama file
                fileLabel.innerText = this.files[0].name;
                fileLabel.classList.remove('hidden');

                // Ubah tombol menjadi "Remove"
                attachmentBtn.innerText = 'Remove';
                attachmentBtn.classList.remove('border-[#F26E21]', 'text-[#F26E21]', 'hover:bg-orange-50');
                attachmentBtn.classList.add('border-red-500', 'text-red-500', 'hover:bg-red-50');
            }
        });

        // --- LOGIKA CART (REVISI POIN 2 & 3) ---

        // Fungsi Hapus Item dari Cart (Minus Button)
        function deleteCartItem(idMaster, idAsset = null, btnElement, isGrouped = false) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) return;

            fetch("{{ route('user.cart.remove') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id_master: idMaster })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (isGrouped) {
                        // Logic untuk Items (mengurangi counter & hidden input)
                        removeOneItemInput(idMaster);
                    } else {
                        // Logic untuk Room (menghapus baris)
                        btnElement.closest('.room-row').remove();
                    }
                    // Opsional: Reload jika Anda ingin data benar-benar sinkron total
                    // window.location.reload(); 
                } else {
                    alert('Gagal menghapus item.');
                }
            })
            .catch(err => console.error(err));
        }

        // Helper: Manipulasi DOM untuk pengurangan Item Group
        function removeOneItemInput(masterId) {
            const container = document.getElementById('inputs-' + masterId);
            const counter = document.getElementById('count-' + masterId);
            const inputs = container.getElementsByClassName('asset-input');

            if (inputs.length > 0) {
                inputs[inputs.length - 1].remove(); // Hapus satu input hidden
                counter.innerText = inputs.length; // Update angka

                if (inputs.length === 0) {
                    document.getElementById('group-' + masterId).remove(); // Hapus baris jika habis
                }
            }
        }

        // Fungsi Tambah Item ke Cart (Plus Button)
        function addCartItem(idMaster) {
            fetch("{{ route('user.cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id_master: idMaster })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // PENTING: Kita harus reload halaman karena kita butuh ID Asset baru (ex: AST-002)
                    // yang digenerate database untuk dimasukkan ke hidden input form.
                    // Jika tidak reload, form submit nanti error karena ID assetnya tidak ada.
                    window.location.reload();
                } else {
                    alert('Gagal menambah item: ' + (data.message || 'Stok habis'));
                }
            })
            .catch(err => console.error(err));
        }
    </script>
@endsection