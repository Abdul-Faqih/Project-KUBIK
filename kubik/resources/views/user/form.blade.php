@extends('user.layout.mobile')

@section('title', 'Loan Request Form')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')
    <div class="w-full max-w-[430px] mx-auto px-5 py-6 bg-white min-h-screen font-sans relative">

        {{-- Header --}}
        <div class="flex items-center mb-6">
            <a href="javascript:void(0)" onclick="openLeaveModal()" class="mr-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="#1F2937" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Loan Request Form</h1>
        </div>

        {{-- Alert Error (Server Side) --}}
        @if(session('error'))
            <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM UTAMA --}}
        <form id="loanForm" action="{{ route('user.form.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Date Loan --}}
            <h2 class="text-base font-bold text-gray-800 mb-3">Date Loan <span class="text-red-500">*</span></h2>
            <div class="mb-4">
                <label class="block text-gray-500 text-sm mb-1">Start</label>
                <div class="flex items-center border-b border-gray-200 py-2 mb-2">
                    <input type="date" name="start_date" id="start_date" required value="{{ old('start_date') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-calendar text-gray-400"></i>
                </div>
                <div class="flex items-center border-b border-gray-200 py-2">
                    <input type="time" name="start_time" id="start_time" required value="{{ old('start_time') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-clock text-gray-400"></i>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-gray-500 text-sm mb-1">End</label>
                <div class="flex items-center border-b border-gray-200 py-2 mb-2">
                    <input type="date" name="end_date" id="end_date" required value="{{ old('end_date') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-calendar text-gray-400"></i>
                </div>
                <div class="flex items-center border-b border-gray-200 py-2">
                    <input type="time" name="end_time" id="end_time" required value="{{ old('end_time') }}"
                        class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    <i class="far fa-clock text-gray-400"></i>
                </div>
            </div>

            {{-- List Assets --}}
            <h2 class="text-base font-bold text-gray-800 mb-3">List Assets <span class="text-red-500">*</span></h2>

            {{-- Rooms --}}
            <div class="mb-5">
                <p class="text-sm text-gray-500 mb-2">Room</p>
                @forelse($rooms as $room)
                    <div class="flex items-center mb-2 room-row" id="room-row-{{ $room->id_asset }}">
                        <button type="button" onclick="deleteCartItem('{{ $room->id_master }}', '{{ $room->id_asset }}', this)"
                            class="mr-2 text-[#F26E21]">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z" />
                            </svg>
                        </button>
                        <span class="text-gray-800 font-medium">{{ $room->name }}</span>
                        <input type="hidden" name="assets[]" value="{{ $room->id_asset }}">
                    </div>
                @empty
                    @if(!session('booking_success'))
                        <p class="text-xs text-gray-400 italic" id="empty-room-msg">No room selected</p>
                    @endif
                @endforelse

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
                            <button type="button" onclick="deleteCartItem('{{ $group['master_id'] }}', null, this, true)"
                                class="w-6 h-6 rounded-full bg-[#F26E21] text-white flex items-center justify-center font-bold">
                                -
                            </button>

                            <span class="font-semibold w-4 text-center text-gray-800" id="count-{{ $group['master_id'] }}">
                                {{ count($group['assets']) }}
                            </span>

                            {{-- LOGIKA TOMBOL MATI JIKA MAX --}}
                            @php
                                $currentQty = count($group['assets']);
                                $maxStock = $group['max_stock'] ?? 999;
                                $isMax = $currentQty >= $maxStock;
                            @endphp

                            <button type="button" @if(!$isMax) onclick="addCartItem('{{ $group['master_id'] }}')" @endif
                                class="w-6 h-6 rounded-full flex items-center justify-center font-bold text-white transition {{ $isMax ? 'bg-[#E0E0E0] cursor-not-allowed' : 'bg-[#F26E21] hover:bg-orange-600' }}"
                                {{ $isMax ? 'disabled' : '' }}>
                                +
                            </button>
                        </div>

                        <div id="inputs-{{ $group['master_id'] }}" class="hidden">
                            @foreach($group['assets'] as $assetId)
                                <input type="hidden" name="assets[]" value="{{ $assetId }}" class="asset-input">
                            @endforeach
                        </div>
                    </div>
                @empty
                    @if(!session('booking_success'))
                        <p class="text-xs text-gray-400 italic" id="empty-item-msg">No items selected</p>
                    @endif
                @endforelse

                <a href="{{ route('user.availability') }}?type=TYP-000002"
                    class="flex items-center text-[#F26E21] text-sm mt-2 font-medium">
                    <span class="mr-1 text-lg font-bold">+</span> Add another item
                </a>
            </div>

            {{-- Attachment --}}
            <h2 class="text-base font-bold text-gray-800 mb-3">Attachment <span class="text-red-500">*</span></h2>
            <div>
                <input type="file" name="attachment" id="attachmentInput" class="hidden" accept=".pdf, .jpg, .png">
                <p id="file-label" class="text-left text-sm text-gray-500 mb-1 hidden"></p>
                <button type="button" id="attachmentBtn"
                    class="w-full border border-[#F26E21] text-[#F26E21] rounded-xl py-3 font-semibold hover:bg-orange-50 transition">
                    Add
                </button>
                <p class="text-[11px] text-gray-400 mt-2 italic text-left">
                    Only PDF, JPG, or PNG formats allowed.
                </p>
            </div>

            {{-- Submit Button --}}
            <button type="button" onclick="validateAndConfirm()"
                class="w-full bg-[#F26E21] mt-4 text-white rounded-xl py-4 font-bold text-lg shadow-md hover:bg-orange-600 transition active:scale-95">
                Submit
            </button>
        </form>
    </div>

    {{-- =========================================== --}}
    {{-- TOAST NOTIFICATION --}}
    {{-- =========================================== --}}
    <div id="toast"
        class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-full shadow-lg z-[60] transition-all duration-300 opacity-0 pointer-events-none translate-y-[-20px] flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd" />
        </svg>
        <span id="toast-message" class="text-sm font-semibold">Message</span>
    </div>

    {{-- =========================================== --}}
    {{-- MODAL CONFIRM SUBMIT --}}
    {{-- =========================================== --}}
    <div id="confirmModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-[85%] max-w-[320px] p-6 text-center transform scale-90 transition-transform duration-300"
            id="modalContent">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Confirm Submission</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to submit this booking request?</p>
            <div class="flex gap-3">
                <button onclick="closeModal()"
                    class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">Cancel</button>
                <button onclick="submitRealForm()"
                    class="flex-1 py-2.5 bg-[#F26E21] text-white rounded-xl font-semibold shadow-md hover:bg-orange-600 transition">Submit</button>
            </div>
        </div>
    </div>

    {{-- =========================================== --}}
    {{-- MODAL LEAVE CONFIRMATION --}}
    {{-- =========================================== --}}
    <div id="leaveModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-[85%] max-w-[320px] p-6 text-center transform scale-90 transition-transform duration-300"
            id="leaveModalContent">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Discard Changes?</h3>
            <p class="text-sm text-gray-500 mb-6">If you leave now, your form data will be lost. Are you sure?</p>
            <div class="flex gap-3">
                <button onclick="closeLeaveModal()"
                    class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">Stay</button>
                <button onclick="confirmLeave()"
                    class="flex-1 py-2.5 bg-red-500 text-white rounded-xl font-semibold shadow-md hover:bg-red-600 transition">Leave</button>
            </div>
        </div>
    </div>

    {{-- =========================================== --}}
    {{-- MODAL SUCCESS (POP-UP) --}}
    {{-- =========================================== --}}
    @if(session('booking_success'))
        <div class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white p-8 rounded-2xl shadow-2xl text-center max-w-sm w-[90%] transform scale-100 transition-all">
                {{-- Icon Check --}}
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-rounded text-5xl text-green-600">check_circle</span>
                </div>

                <h2 class="text-2xl font-bold text-[#2A2A2A] mb-2">Booking Submitted!</h2>
                <p class="text-[#9A9A9A] mb-6">Redirecting to details in <span id="countdown">5</span>s...</p>

                {{-- Progress Bar --}}
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-6 overflow-hidden">
                    <div class="bg-green-500 h-1.5 rounded-full animate-progress"></div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <a href="{{ route('user.home') }}"
                        class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 text-sm">
                        Back to Home
                    </a>
                    {{-- Pastikan route detail ini benar --}}
                    <a href="{{ route('user.rentals.detail', session('booking_success')) }}"
                        class="flex-1 py-2.5 bg-[#F26E21] text-white rounded-xl font-semibold shadow-md hover:bg-orange-600 text-sm">
                        See Details
                    </a>
                </div>
            </div>
        </div>

        <script>
            let timeLeft = 5;
            const countdownEl = document.getElementById('countdown');
            const detailUrl = "{{ route('user.rentals.detail', session('booking_success')) }}";

            const interval = setInterval(() => {
                timeLeft--;
                if (countdownEl) countdownEl.innerText = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    window.location.href = detailUrl;
                }
            }, 1000);
        </script>
        <style>
            @keyframes progress {
                from {
                    width: 0%;
                }

                to {
                    width: 100%;
                }
            }

            .animate-progress {
                animation: progress 5s linear forwards;
            }
        </style>
    @endif

    <script>
        // --- HELPER: Validasi Ekstensi File ---
        function isValidFileType(fileName) {
            const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            const fileExtension = fileName.split('.').pop().toLowerCase();
            return allowedExtensions.includes(fileExtension);
        }

        // --- LOGIKA ATTACHMENT ---
        const attachmentInput = document.getElementById('attachmentInput');
        const attachmentBtn = document.getElementById('attachmentBtn');
        const fileLabel = document.getElementById('file-label');

        attachmentBtn.addEventListener('click', function () {
            if (attachmentBtn.innerText === 'Remove') {
                attachmentInput.value = '';
                fileLabel.innerText = '';
                fileLabel.classList.add('hidden');

                attachmentBtn.innerText = 'Add';
                attachmentBtn.classList.remove('border-red-500', 'text-red-500', 'hover:bg-red-50');
                attachmentBtn.classList.add('border-[#F26E21]', 'text-[#F26E21]', 'hover:bg-orange-50');
            } else {
                attachmentInput.click();
            }
        });

        // VALIDASI SAAT PILIH FILE (onChange)
        attachmentInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;

                // Cek Format File
                if (!isValidFileType(fileName)) {
                    showToast("Invalid format! Only PDF, JPG, PNG allowed.");
                    this.value = ''; // Reset input
                    return;
                }

                fileLabel.innerText = fileName;
                fileLabel.classList.remove('hidden');

                attachmentBtn.innerText = 'Remove';
                attachmentBtn.classList.remove('border-[#F26E21]', 'text-[#F26E21]', 'hover:bg-orange-50');
                attachmentBtn.classList.add('border-red-500', 'text-red-500', 'hover:bg-red-50');
            }
        });

        // --- TOAST FUNCTION ---
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');

            toastMsg.innerText = message;
            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');

            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');
            }, 3000);
        }

        // --- VALIDASI SUBMIT ---
        function validateAndConfirm() {
            // 1. Ambil Value
            const startDate = document.getElementById('start_date').value;
            const startTime = document.getElementById('start_time').value;
            const endDate = document.getElementById('end_date').value;
            const endTime = document.getElementById('end_time').value;
            const fileInput = document.getElementById('attachmentInput');
            const file = fileInput.files.length;

            const assets = document.querySelectorAll('input[name="assets[]"]').length;

            // 2. Logic Check
            if (!startDate || !startTime || !endDate || !endTime) {
                showToast("Please fill in all Date & Time fields!");
                return;
            }

            if (assets === 0) {
                showToast("Please select at least one Asset or Room!");
                return;
            }

            if (file === 0) {
                showToast("Please upload the Attachment!");
                return;
            }

            // Cek ulang ekstensi file sebelum submit (untuk keamanan ganda)
            if (file > 0) {
                const fileName = fileInput.files[0].name;
                if (!isValidFileType(fileName)) {
                    showToast("Invalid file format! Please upload PDF or Image.");
                    return;
                }
            }

            // 3. Jika Lolos Semua -> Buka Modal
            openModal();
        }

        // --- MODALS ---
        const modal = document.getElementById('confirmModal');
        const modalContent = document.getElementById('modalContent');
        const leaveModal = document.getElementById('leaveModal');
        const leaveModalContent = document.getElementById('leaveModalContent');

        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); modalContent.classList.remove('scale-90'); modalContent.classList.add('scale-100'); }, 10);
        }
        function closeModal() {
            modal.classList.add('opacity-0'); modalContent.classList.remove('scale-100'); modalContent.classList.add('scale-90'); setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
        function submitRealForm() {
            document.getElementById('loanForm').submit();
        }
        function openLeaveModal() {
            leaveModal.classList.remove('hidden');
            setTimeout(() => { leaveModal.classList.remove('opacity-0'); leaveModalContent.classList.remove('scale-90'); leaveModalContent.classList.add('scale-100'); }, 10);
        }
        function closeLeaveModal() {
            leaveModal.classList.add('opacity-0'); leaveModalContent.classList.remove('scale-100'); leaveModalContent.classList.add('scale-90'); setTimeout(() => { leaveModal.classList.add('hidden'); }, 300);
        }
        function confirmLeave() {
            window.location.href = "{{ route('user.home') }}";
        }

        // --- CART LOGIC (With Toast) ---
        function deleteCartItem(idMaster, idAsset = null, btnElement, isGrouped = false) {
            fetch("{{ route('user.cart.remove') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ id_master: idMaster })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (isGrouped) { removeOneItemInput(idMaster); } else { btnElement.closest('.room-row').remove(); }
                    } else {
                        showToast('Failed to remove item.');
                    }
                })
                .catch(err => console.error(err));
        }

        function removeOneItemInput(masterId) {
            const container = document.getElementById('inputs-' + masterId);
            const counter = document.getElementById('count-' + masterId);
            const inputs = container.getElementsByClassName('asset-input');
            if (inputs.length > 0) {
                inputs[inputs.length - 1].remove();
                counter.innerText = inputs.length;
                if (inputs.length === 0) { document.getElementById('group-' + masterId).remove(); }
                window.location.reload();
            }
        }

        function addCartItem(idMaster) {
            fetch("{{ route('user.cart.add') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ id_master: idMaster })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        // GANTI ALERT DENGAN TOAST
                        showToast('Failed to add item: ' + (data.message || 'Out of stock'));
                    }
                })
                .catch(err => console.error(err));
        }
    </script>
@endsection