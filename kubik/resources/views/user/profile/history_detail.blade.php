@extends('user.layout.mobile')

@section('title', 'Detail Peminjaman')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    {{-- LOGIKA TOMBOL BACK (TIDAK DIUBAH) --}}
    @php
        $backRoute = route('user.rentals.history');
        if (request()->query('from') == 'profile') {
            $backRoute = route('user.profile');
        }
    @endphp

    {{-- HEADER (TIDAK DIUBAH) --}}
    <div class="flex items-center justify-between mb-6 mt-6 px-4">
        <div class="flex items-center gap-4">
            <a href="{{ $backRoute }}" class="material-symbols-rounded text-[#2A2A2A] text-[26px]">arrow_back</a>
            <h1 class="text-[20px] font-bold text-[#2A2A2A]">Loan Details</h1>
        </div>
        <span class="material-symbols-rounded text-[28px] text-[#2A2A2A]">more_vert</span>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="px-5 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="px-5 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="px-5 pb-10">
        {{-- BAGIAN ATAS (NOMOR, TANGGAL, DETAIL BARANG) TIDAK DIUBAH --}}

        {{-- NOMOR PEMINJAMAN --}}
        <div class="mb-6">
            <p class="text-[15px] font-semibold text-[#2A2A2A]">ID Booking</p>
            <p class="text-[15px] font-medium text-[#2A2A2A] mt-1">{{ $booking->id_booking }}</p>
        </div>

        {{-- TANGGAL PENGAJUAN --}}
        <div class="mb-6 space-y-3">
            <p class="text-[15px] font-semibold text-[#2A2A2A]">Submited at</p>
            <div class="flex items-center gap-3 text-[#2A2A2A]">
                <span class="material-symbols-rounded text-[20px]">calendar_today</span>
                <span class="text-[15px] font-medium">
                    {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <div class="flex items-center gap-3 text-[#2A2A2A]">
                <span class="material-symbols-rounded text-[20px]">schedule</span>
                <span class="text-[15px] font-medium">
                    {{ \Carbon\Carbon::parse($booking->created_at)->format('H : i') }}
                </span>
            </div>
            <div class="flex items-center gap-3 text-[#2A2A2A]">
                @if($booking->status == 'Pending')
                    <span class="material-symbols-rounded text-[20px]">hourglass</span>
                    <span class="text-[15px] font-medium">Pending</span>
                @elseif($booking->status == 'Approved')
                    <span class="material-symbols-rounded text-[20px]">check</span>
                    <span class="text-[15px] font-medium">Approved</span>
                @elseif($booking->status == 'Rejected')
                    <span class="material-symbols-rounded text-[20px]">cancel</span>
                    <span class="text-[15px] font-medium">Rejected</span>
                @elseif($booking->status == 'Canceled')
                    <span class="material-symbols-rounded text-[20px]">cancel</span>
                    <span class="text-[15px] font-medium">Canceled</span>
                @elseif($booking->status == 'Completed')
                    <span class="material-symbols-rounded text-[20px]">task_alt</span>
                    <span class="text-[15px] font-medium">Completed</span>
                @endif
            </div>
        </div>

        {{-- TANGGAL PEMINJAMAN --}}
        <div class="mb-6">
            <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Booking for</p>
            <div class="mb-4">
                <p class="text-[13px] text-gray-700 mb-1 ">Start Time</p>
                <div class="flex items-center gap-3 text-[#2A2A2A]">
                    <span class="material-symbols-rounded text-[20px]">event_available</span>
                    <span class="text-[15px] font-medium">
                        {{ \Carbon\Carbon::parse($booking->start_time)->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                <div class="flex items-center gap-3 text-[#2A2A2A] mt-1">
                    <span class="material-symbols-rounded text-[20px]">schedule</span>
                    <span class="text-[15px] font-medium">
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H : i') }} WIB
                    </span>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-[13px] text-gray-700 mb-1 ">End Time</p>
                <div class="flex items-center gap-3 text-[#2A2A2A]">
                    <span class="material-symbols-rounded text-[20px]">event_available</span>
                    <span class="text-[15px] font-medium">
                        {{ \Carbon\Carbon::parse($booking->end_time)->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                <div class="flex items-center gap-3 text-[#2A2A2A] mt-1">
                    <span class="material-symbols-rounded text-[20px]">schedule</span>
                    <span class="text-[15px] font-medium">
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H : i') }} WIB
                    </span>
                </div>
            </div>
        </div>

        {{-- DETAIL PEMINJAMAN --}}
        <div class="mb-8">
            <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">List Asset</p>
            @foreach($ruangan as $r)
                <div class="mb-4">
                    <p class="text-[13px] text-[#9A9A9A] mb-1">Room</p>
                    <div class="flex items-center gap-2">
                        <span class="text-[15px] font-medium text-[#2A2A2A]">{{ $r->asset_name }}</span>
                        <span
                            class="bg-[#F5F5F5] text-[#2A2A2A] text-[11px] px-2 py-0.5 rounded flex items-center gap-1 font-medium">
                            <span class="material-symbols-rounded text-[12px]">schedule</span>
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                        </span>
                    </div>
                </div>
            @endforeach

            @if($barang->isNotEmpty())
                <p class="text-[13px] text-gray-700 mb-1 mt-4">Item</p>
                @foreach($barang as $b)
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[15px] font-medium text-[#2A2A2A]">{{ $b->asset_name }}</span>
                        <span class="text-[13px] text-[#2A2A2A] font-medium">{{ $b->total_qty }} @if($b->total_qty > 1) items @else
                        item @endif</span>
                    </div>
                @endforeach
            @else
                <p class="text-[13px] text-gray-700 mb-1 mt-4">Item</p>
                <p class="text-[15px] font-medium text-[#2A2A2A]">-</p>
            @endif
        </div>

        {{-- ================================================= --}}
        {{-- LOGIKA TOMBOL & PENGEMBALIAN --}}
        {{-- ================================================= --}}

        @if($booking->status == 'Completed')
            <div class="mb-8">
                <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Image</p>
                @if($booking->proof_return)
                    <div class="mb-4 rounded-xl overflow-hidden border border-gray-200">
                        <img src="{{ asset('uploads/proofs/' . $booking->proof_return) }}" alt="Return"
                            class="w-full h-auto object-cover">
                    </div>
                @else
                    <div
                        class="w-full border border-[#F26E21] text-[#F26E21] py-3 rounded-xl flex items-center justify-center gap-2 font-semibold">
                        <span class="material-symbols-rounded">image</span>
                        Image is not found
                    </div>
                @endif
            </div>
            <a href="{{ route('user.home') }}"
                class="block w-full bg-[#F26E21] text-white text-center py-3 rounded-xl font-bold text-[15px] shadow-md shadow-orange-200/50">
                Back to Home page
            </a>

        @elseif($booking->status == 'Approved')
            <div class="mb-6">
                <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Attachment</p>
                @if($booking->attachment)
                    <a href="{{ asset('uploads/attachments/' . $booking->attachment) }}" target="_blank"
                        class="w-full border border-[#F26E21] text-[#F26E21] py-3 rounded-xl flex items-center justify-center gap-2 mb-4 hover:bg-[#FFF2E9]">
                        <span class="material-symbols-rounded">description</span>
                        File
                    </a>
                @endif

                {{-- AREA INTERAKSI PENGEMBALIAN --}}
                <div id="btnAjukanContainer">
                    <button type="button" onclick="showReturnForm()"
                        class="block w-full bg-[#F26E21] text-white text-center py-4 rounded-xl text-[15px] shadow-md shadow-orange-200/50 font-bold">
                        Return
                    </button>
                </div>

                <form id="formReturn" action="{{ route('user.rentals.return.process', $booking->id_booking) }}" method="POST"
                    enctype="multipart/form-data" class="hidden mt-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    @csrf
                    @method('PUT')

                    <p class="text-[13px] text-gray-500 mb-3 font-medium text-center">Upload photo of return</p>

                    <input type="file" name="proof_return" id="fileInput" class="hidden" accept="image/*"
                        onchange="previewFile()" required>

                    {{-- WRAPPER AREA UPLOAD (DENGAN TOMBOL HAPUS) --}}
                    <div class="relative mb-4">
                        {{-- Tombol Pilih Foto --}}
                        <div onclick="document.getElementById('fileInput').click()"
                            class="w-full border-2 border-dashed border-gray-300 text-gray-500 py-6 rounded-xl flex flex-col items-center justify-center gap-2 hover:bg-white transition relative overflow-hidden cursor-pointer bg-white">

                            {{-- Preview Image --}}
                            <div id="previewContainer"
                                class="hidden w-full h-full absolute inset-0 bg-white items-center justify-center">
                                <img id="imgPreview" src="" class="h-full object-contain">
                            </div>

                            {{-- Default Icon --}}
                            <div id="defaultUploadInfo" class="flex flex-col items-center">
                                <span class="material-symbols-rounded text-3xl">add_a_photo</span>
                                <span id="fileNameLabel" class="text-xs mt-1">Only image formats allowed.</span>
                            </div>
                        </div>

                        {{-- Tombol Hapus (Muncul jika ada gambar) --}}
                        <button type="button" id="removeBtn" onclick="removeFile()"
                            class="hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md hover:bg-red-600 transition z-10">
                            <span class="material-symbols-rounded text-sm font-bold">close</span>
                        </button>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="openCancelModal()"
                            class="w-1/2 bg-gray-200 text-gray-700 py-3 rounded-xl font-bold text-[14px]">
                            Cancel
                        </button>
                        <button type="button" onclick="openSubmitModal()"
                            class="w-1/2 bg-[#F26E21] text-white py-3 rounded-xl font-bold text-[14px] shadow-md shadow-orange-200/50">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

        @else
            <div class="mb-8">
                <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Attachment</p>
                @if($booking->attachment)
                    <a href="{{ asset('uploads/attachments/' . $booking->attachment) }}" target="_blank"
                        class="w-full border border-[#F26E21] text-[#F26E21] py-3 rounded-xl flex items-center justify-center gap-2 font-semibold hover:bg-[#FFF2E9]">
                        <span class="material-symbols-rounded">description</span>
                        File
                    </a>
                @else
                    <div
                        class="w-full border border-[#E5E5E5] text-[#9A9A9A] py-3 rounded-xl flex items-center justify-center gap-2 font-medium italic bg-gray-50">
                        File is not found
                    </div>
                @endif
            </div>

            <a href="{{ route('user.home') }}"
                class="block w-full bg-[#F26E21] text-white text-center py-3 rounded-xl font-bold text-[15px] shadow-md shadow-orange-200/50">
                Back to Home page
            </a>

            @if($booking->status == 'Pending')
                <button type="button" onclick="openCancelBookingModal()"
                    class="block w-full mt-3 bg-[#FFECEC] text-red-600 border border-red-200 text-center py-3 rounded-xl font-bold text-[15px] hover:bg-red-50 transition">
                    Cancel Request
                </button>
            @endif
        @endif

    </div>

    {{-- TOAST --}}
    <div id="toast"
        class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-full shadow-lg z-50 transition-all duration-300 opacity-0 pointer-events-none translate-y-[-20px] flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd" />
        </svg>
        <span id="toast-message" class="text-sm font-semibold">Please fill all fields!</span>
    </div>

    {{-- MODALS (Code Modal Cancel, Submit, CancelBooking sama seperti sebelumnya) --}}
    {{-- ... (Sisanya sama, modal tidak diubah sesuai instruksi) ... --}}

    {{-- MODAL VALIDASI CANCEL RETURN --}}
    <div id="cancelReturnModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-[85%] max-w-[320px] p-6 text-center transform scale-90 transition-transform duration-300"
            id="cancelModalContent">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Leave Return Form?</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to leave the return form?</p>
            <div class="flex gap-3">
                <button onclick="closeCancelModal()"
                    class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">Stay</button>
                <button onclick="confirmCancel()"
                    class="flex-1 py-2.5 bg-red-500 text-white rounded-xl font-semibold shadow-md hover:bg-red-600 transition">Leave</button>
            </div>
        </div>
    </div>

    {{-- MODAL VALIDASI SUBMIT RETURN --}}
    <div id="submitReturnModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-[85%] max-w-[320px] p-6 text-center transform scale-90 transition-transform duration-300"
            id="submitModalContent">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Confirm Submission</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to leave the return form and submit?</p>
            <div class="flex gap-3">
                <button onclick="closeSubmitModal()"
                    class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">Cancel</button>
                <button onclick="confirmSubmit()"
                    class="flex-1 py-2.5 bg-[#F26E21] text-white rounded-xl font-semibold shadow-md hover:bg-orange-600 transition">Submit</button>
            </div>
        </div>
    </div>

    {{-- MODAL CANCEL BOOKING --}}
    <div id="cancelBookingModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-[85%] max-w-[320px] p-6 text-center transform scale-90 transition-transform duration-300"
            id="cancelBookingContent">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Cancel Booking?</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to cancel this booking request? This action cannot
                be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeCancelBookingModal()"
                    class="flex-1 py-2.5 border border-gray-300 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">No,
                    Keep</button>
                <form action="{{ route('user.booking.cancel', $booking->id_booking) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                        class="w-full py-2.5 bg-red-500 text-white rounded-xl font-semibold shadow-md hover:bg-red-600 transition">Yes,
                        Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // --- PREVIEW & VALIDATION FILE ---
        function previewFile() {
            const input = document.getElementById('fileInput');
            const previewContainer = document.getElementById('previewContainer');
            const imgPreview = document.getElementById('imgPreview');
            const defaultInfo = document.getElementById('defaultUploadInfo');
            const removeBtn = document.getElementById('removeBtn');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileType = file.type;
                const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'];

                // 1. VALIDASI TIPE FILE
                if (!validImageTypes.includes(fileType)) {
                    showToast("Invalid file format! Please upload an image (JPG, PNG).");
                    input.value = ''; // Reset input
                    return;
                }

                // Tampilkan Preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    imgPreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    previewContainer.classList.add('flex');
                    defaultInfo.classList.add('hidden');
                    removeBtn.classList.remove('hidden'); // Tampilkan tombol hapus
                }
                reader.readAsDataURL(file);
            }
        }

        // --- HAPUS FILE (NEW) ---
        function removeFile() {
            const input = document.getElementById('fileInput');
            const previewContainer = document.getElementById('previewContainer');
            const defaultInfo = document.getElementById('defaultUploadInfo');
            const removeBtn = document.getElementById('removeBtn');

            input.value = ''; // Reset value input file
            previewContainer.classList.add('hidden');
            previewContainer.classList.remove('flex');
            defaultInfo.classList.remove('hidden');
            removeBtn.classList.add('hidden'); // Sembunyikan tombol hapus
        }

        // --- SHOW/HIDE FORM ---
        function showReturnForm() {
            document.getElementById('btnAjukanContainer').classList.add('hidden');
            document.getElementById('formReturn').classList.remove('hidden');
        }

        function hideReturnForm() {
            document.getElementById('btnAjukanContainer').classList.remove('hidden');
            document.getElementById('formReturn').classList.add('hidden');
            // Reset form saat hide
            removeFile();
        }

        // --- TOAST ---
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');
            toastMsg.innerText = message;
            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-20px]');
            }, 3000);
        }

        // --- MODAL LOGIC (CANCEL & SUBMIT) ---
        // (Tetap sama seperti sebelumnya)
        const cancelModal = document.getElementById('cancelReturnModal');
        const cancelModalContent = document.getElementById('cancelModalContent');
        const submitModal = document.getElementById('submitReturnModal');
        const submitModalContent = document.getElementById('submitModalContent');
        const cancelBookingModal = document.getElementById('cancelBookingModal');
        const cancelBookingContent = document.getElementById('cancelBookingContent');

        function openCancelModal() {
            cancelModal.classList.remove('hidden');
            setTimeout(() => { cancelModal.classList.remove('opacity-0'); cancelModalContent.classList.remove('scale-90'); cancelModalContent.classList.add('scale-100'); }, 10);
        }
        function closeCancelModal() {
            cancelModal.classList.add('opacity-0'); cancelModalContent.classList.remove('scale-100'); cancelModalContent.classList.add('scale-90'); setTimeout(() => { cancelModal.classList.add('hidden'); }, 300);
        }
        function confirmCancel() { closeCancelModal(); hideReturnForm(); }

        function openSubmitModal() {
            const fileInput = document.getElementById('fileInput');
            if (!fileInput.files || fileInput.files.length === 0) { showToast('Please upload photo first!'); return; }
            submitModal.classList.remove('hidden');
            setTimeout(() => { submitModal.classList.remove('opacity-0'); submitModalContent.classList.remove('scale-90'); submitModalContent.classList.add('scale-100'); }, 10);
        }
        function closeSubmitModal() {
            submitModal.classList.add('opacity-0'); submitModalContent.classList.remove('scale-100'); submitModalContent.classList.add('scale-90'); setTimeout(() => { submitModal.classList.add('hidden'); }, 300);
        }
        function confirmSubmit() { document.getElementById('formReturn').submit(); }

        function openCancelBookingModal() {
            cancelBookingModal.classList.remove('hidden');
            setTimeout(() => { cancelBookingModal.classList.remove('opacity-0'); cancelBookingContent.classList.remove('scale-90'); cancelBookingContent.classList.add('scale-100'); }, 10);
        }
        function closeCancelBookingModal() {
            cancelBookingModal.classList.add('opacity-0'); cancelBookingContent.classList.remove('scale-100'); cancelBookingContent.classList.add('scale-90'); setTimeout(() => { cancelBookingModal.classList.add('hidden'); }, 300);
        }
    </script>

@endsection