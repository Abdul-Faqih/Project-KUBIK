@extends('user.layout.mobile')

@section('title', 'Availability')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

    <div class="px-4 pt-5 pb-10 w-full max-w-[430px] mx-auto">

        {{-- BACK + SEARCH --}}
        <div class="flex items-center mb-5">
            <a href="{{ route('user.home') }}" class="mr-3">
                <span class="text-2xl font-bold">‹</span>
            </a>

            <form class="flex-1">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search"
                    class="w-full h-10 bg-[#EFEFEF] rounded-xl px-4 text-sm focus:outline-none">
            </form>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="mb-4">
            <div class="flex gap-3 overflow-x-auto no-scrollbar">
                <button name="type" value=""
                    class="px-4 py-1 rounded-full border text-sm {{ !$filterType ? 'bg-[#F26E21] text-white' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                    All
                </button>

                @foreach ($types as $type)
                    <button name="type" value="{{ $type->id_type }}"
                        class="px-4 py-1 rounded-full border text-sm whitespace-nowrap {{ $filterType == $type->id_type ? 'bg-[#F26E21] text-white' : 'bg-white text-[#F26E21] border-[#F26E21]' }}">
                        {{ $type->name }}
                    </button>
                @endforeach
            </div>
        </form>

        {{-- GRID --}}
        <div class="grid grid-cols-2 gap-4">
            @foreach ($items as $item)
                @php
                    // Ambil total dari $item->stock_total atau assets->count()
                    $total = $item->stock_total ?? $item->assets->count();
                    $available = $item->assets->where('status', 'Available')->count();
                    $image = $item->image_asset
                        ? asset('uploads/assetmasters/' . $item->image_asset)
                        : asset('images/noimage.png');
                @endphp

                <div onclick="openDetail('{{ $item->id_master }}')"
                    class="bg-white rounded-2xl shadow-md border border-[#F1F1F1] p-3 flex flex-col h-[250px] cursor-pointer">

                    <img src="{{ $image }}" class="w-full h-[120px] object-cover rounded-xl mb-3">

                    <div class="flex-grow">
                        <p class="font-semibold text-sm text-[#2A2A2A] leading-tight line-clamp-2 h-[36px]">
                            {{ $item->name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $available }} of {{ $total }} available
                        </p>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm {{ $available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- FLY BUTTON (ICON BOX) --}}
    <div id="flyButton"
        class="fixed right-5 bottom-5 z-40 w-16 h-16 rounded-full bg-[#F26E21] flex items-center justify-center shadow-lg cursor-pointer {{ $cartCount > 0 ? '' : 'hidden' }}">

        <img src="{{ asset('images/box_icon.png') }}" class="w-8 h-8 object-contain">

        {{-- Counter Badge --}}
        <span id="flyBadge"
            class="absolute top-0 right-0 transform translate-x-1/4 -translate-y-1/4 bg-white text-[#F26E21] text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center ring-2 ring-[#F26E21] shadow-md">
            {{ $cartCount }}
        </span>
    </div>


    {{-- =============== CART LIST MODAL (BOTTOM SHEET) - DISESUAIKAN MOCKUP =============== --}}
    <div id="cartModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-end z-50 hidden transition-all">

        <div id="cartContent"
            class="w-full max-w-[430px] bg-white rounded-t-[32px] translate-y-full transition-all duration-300 overflow-hidden shadow-xl flex flex-col max-h-[90vh]">

            {{-- HEADER (Sesuai Mockup) --}}
            <div class="px-5 pt-5 pb-3 flex justify-between items-center border-b border-gray-200 flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold text-[#F26E21]">Assets List</h2>
                    {{-- 🟢 cartSummary diletakkan di sini, diisi oleh JS 🟢 --}}
                    <p id="cartSummary" class="text-sm text-gray-500 mt-1">
                        {{-- Diisi JS, contoh: 4 asset added --}}
                    </p>
                </div>
                <button onclick="closeCartModal()">
                    <span class="text-gray-500 text-3xl font-bold">×</span>
                </button>
            </div>

            {{-- CONTENT UTAMA (List Card Simpel) --}}
            <div id="cartListContainer" class="flex-grow overflow-y-auto p-5 space-y-3">
                <ul id="cartListBody" class="space-y-4">
                    {{-- Data Cart akan di-render di sini oleh JavaScript --}}
                </ul>

                {{-- Fallback: Jika Cart Kosong --}}
                <div id="emptyCartMessage" class="py-10 text-center text-gray-500 text-sm hidden">
                    Keranjang pinjaman kosong. Tambahkan item untuk melanjutkan.
                </div>
            </div>

            {{-- FOOTER / ACTION BUTTON --}}
            <div class="px-5 py-4 bg-white border-t border-gray-200 flex-shrink-0">
                <a href="#" id="continueBookingBtn"
                    class="w-full block text-center bg-[#F26E21] text-white py-3 rounded-xl text-lg font-semibold shadow-md active:scale-95 transition disabled:opacity-50">
                    Continue Booking
                </a>
            </div>

        </div>
    </div>


    {{-- MODAL DETAIL (EXISTING) --}}
    <div id="detailModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-end z-50 hidden transition-all">

        <div id="detailContent"
            class="w-full max-w-[430px] bg-white rounded-t-[32px] pb-10 translate-y-full transition-all duration-300 overflow-hidden shadow-xl">

            {{-- ... (DETAIL MODAL CODE SEBELUMNYA) ... --}}

            <div class="bg-[#F26E21] text-white rounded-t-[32px] px-5 py-4 flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Item</p>
                    <h2 id="detailTitle" class="text-2xl font-bold mt-1 leading-tight"></h2>
                </div>

                <button onclick="closeDetail()">
                    <span class="text-white text-3xl font-bold">×</span>
                </button>
            </div>

            <div class="px-5 mt-4">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <img id="detailImage" class="w-full h-[230px] object-cover rounded-xl">
                </div>
            </div>

            <div class="px-5 mt-5">
                <div class="flex justify-between text-sm mb-4">
                    <span id="detailStatus" class="font-semibold"></span>
                    <span id="detailCount" class="opacity-70"></span>
                </div>

                <h3 class="text-lg font-semibold mb-1">Detail</h3>
                <p id="detailDescription" class="text-sm text-gray-700 leading-snug"></p>
            </div>

            <div class="mt-6 px-5">

                <button id="addBtn"
                    class="w-full bg-[#F26E21] text-white py-3 rounded-xl text-lg font-semibold shadow-md hidden transition active:scale-95">
                    Add
                </button>

                <div id="counterBox" class="flex items-center justify-end w-full select-none ">

                    <div class="flex items-center justify-between gap-3 bg-[#e7e7e7] rounded-full shadow-md p-2 px-3">

                        <button id="minusBtn"
                            class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white text-xl font-semibold shadow-md active:scale-90 transition p-0">
                            –
                        </button>

                        <span id="qtyText" class="px-2 flex items-center justify-center text-lg text-[#2A2A2A] text-center">
                            1
                        </span>

                        <button id="plusBtn"
                            class="w-8 h-8 rounded-full bg-[#F26E21] flex items-center justify-center text-white text-xl font-semibold shadow-md active:scale-90 transition p-0">
                            +
                        </button>

                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- ========== JS CART LOGIC (TERMASUK MODAL LIST BARU) ========== --}}
    <script>
        const itemData = @json($itemsJson);
        let currentMaster = null;
        let maxAvailable = 0;
        let assets = [];

        // ----------------------------------------------------
        // FUNGSI CART LIST MODAL
        // ----------------------------------------------------
        function openCartModal() {
            // 1. Hide fly button saat modal cart terbuka
            document.getElementById('flyButton').classList.add('hidden');

            // 2. Render list item
            fetchAndRenderCart();

            // 3. Tampilkan modal
            document.getElementById("cartModal").classList.remove("hidden");
            setTimeout(() => {
                document.getElementById("cartContent").classList.remove("translate-y-full");
            }, 10);
        }

        function closeCartModal() {
            document.getElementById("cartContent").classList.add("translate-y-full");
            setTimeout(() => {
                document.getElementById("cartModal").classList.add("hidden");
                // 4. Tampilkan kembali fly button saat modal cart tertutup (jika ada item)
                globalUpdateCartCount();
            }, 300);
        }

        function fetchAndRenderCart() {
            const listBody = document.getElementById("cartListBody");
            const emptyMsg = document.getElementById("emptyCartMessage");
            const continueBtn = document.getElementById("continueBookingBtn");
            const cartSummary = document.getElementById("cartSummary");

            fetch("{{ route('user.cart.list') }}")
                .then(res => res.json())
                .then(data => {
                    listBody.innerHTML = '';
                    cartSummary.innerText = `${data.length} asset added`;

                    if (data.length === 0) {
                        emptyMsg.classList.remove('hidden');
                        listBody.classList.add('hidden');
                        continueBtn.classList.add('disabled');
                        continueBtn.setAttribute('href', '#');
                        continueBtn.setAttribute('aria-disabled', 'true'); // Untuk non-interaktif
                    } else {
                        emptyMsg.classList.add('hidden');
                        listBody.classList.remove('hidden');
                        continueBtn.classList.remove('disabled');
                        continueBtn.setAttribute('href', '#'); // Sesuai permintaan
                        continueBtn.setAttribute('aria-disabled', 'false');

                        data.forEach((item, index) => {
                            // 🟢 MENGGUNAKAN DESAIN MOCKUP SIMPEL 🟢
                            const listItem = `
                                    <li class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                                        <div class="flex flex-col space-y-1">
                                            <p class="font-bold text-base text-gray-800 line-clamp-1">${item.name}</p>
                                            <span class="text-sm text-gray-500">${item.id_asset}</span>
                                        </div>
                                        <button onclick="deleteCartItem('${item.master_id}', '${item.id_asset}')" 
                                                class="text-red-500 hover:text-red-700 p-2 rounded-full bg-red-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M7 6V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6H22V8H20V20C20 20.5523 19.5523 21 19 21H5C4.44772 21 4 20.5523 4 20V8H2V6H7ZM9 4V6H15V4H9Z" />
                                            </svg>
                                        </button>
                                    </li>
                                `;
                            listBody.innerHTML += listItem;
                        });
                    }
                });
        }

        function deleteCartItem(idMaster, idAsset) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) return;

            // Kita harus menggunakan id_master, karena endpoint remove Anda didasarkan pada master
            fetch("{{ route('user.cart.remove') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id_master: idMaster })
            })
                .then(res => res.json())
                .then(() => {
                    fetchAndRenderCart(); // Reload list
                    globalUpdateCartCount(); // Update badge fly button
                });
        }

        // Event listener untuk menutup Cart Modal saat mengklik backdrop
        document.getElementById('cartModal').addEventListener("click", function (e) {
            const box = document.getElementById("cartContent");
            if (!box.contains(e.target)) closeCartModal();
        });

        // Hubungkan Fly Button ke openCartModal
        document.getElementById('flyButton').addEventListener('click', openCartModal);

        // ----------------------------------------------------
        // FUNGSI FLY BUTTON & MODAL DETAIL (EXISTING)
        // ----------------------------------------------------

        function globalUpdateCartCount() {
            fetch("{{ route('user.cart.count.total') }}")
                .then(res => res.json())
                .then(data => {
                    const totalCount = data.count;
                    const flyButton = document.getElementById('flyButton');
                    const flyBadge = document.getElementById('flyBadge');

                    if (totalCount > 0) {
                        flyBadge.innerText = totalCount;
                        // Tampilkan hanya jika modal CART LIST tidak terbuka
                        if (document.getElementById('cartModal').classList.contains('hidden')) {
                            flyButton.classList.remove('hidden');
                        }
                    } else {
                        flyButton.classList.add('hidden');
                    }
                });
        }

        // ... (Fungsi openDetail, closeDetail, updateUI, addBtn, plusBtn, minusBtn DIBIARKAN SAMA) ...

        function openDetail(id) {
            currentMaster = id;

            const item = itemData.find(i => i.id_master == id);

            assets = item.assets;
            maxAvailable = item.assets.filter(a => a.status === "Available").length;

            document.getElementById("detailTitle").innerText = item.name;
            document.getElementById("detailImage").src =
                item.image_asset ? `/uploads/assetmasters/${item.image_asset}` : `/images/noimage.png`;

            document.getElementById("detailStatus").innerText =
                maxAvailable > 0 ? "Available" : "Unavailable";
            document.getElementById("detailStatus").style.color =
                maxAvailable > 0 ? "#22c55e" : "#ef4444";

            document.getElementById("detailCount").innerText =
                `${maxAvailable} Available`;

            document.getElementById("detailDescription").innerText =
                item.description ?? "-";

            updateUI();
            document.getElementById("detailModal").classList.remove("hidden");

            setTimeout(() => {
                document.getElementById("detailContent").classList.remove("translate-y-full");
            }, 10);
        }

        function closeDetail() {
            document.getElementById("detailContent").classList.add("translate-y-full");
            setTimeout(() => {
                document.getElementById("detailModal").classList.add("hidden");
            }, 300);
        }

        document.getElementById("detailModal").addEventListener("click", function (e) {
            const box = document.getElementById("detailContent");
            if (!box.contains(e.target)) closeDetail();
        });

        function updateUI() {
            fetch("{{ route('user.cart.count') }}?id_master=" + currentMaster)
                .then(res => res.json())
                .then(data => {
                    let qty = data.count;

                    const addBtn = document.getElementById("addBtn");
                    const counterBox = document.getElementById("counterBox");
                    const qtyText = document.getElementById("qtyText");
                    const plusBtn = document.getElementById("plusBtn");

                    qtyText.innerText = qty;

                    if (qty === 0) {
                        addBtn.classList.remove("hidden");
                        counterBox.classList.add("hidden");
                    } else {
                        addBtn.classList.add("hidden");
                        counterBox.classList.remove("hidden");
                    }

                    plusBtn.disabled = qty >= maxAvailable;

                    globalUpdateCartCount();
                });
        }

        document.getElementById("addBtn").onclick = function () {
            fetch("{{ route('user.cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id_master: currentMaster })
            })
                .then(res => res.json())
                .then(() => updateUI());
        };

        document.getElementById("plusBtn").onclick = function () {
            fetch("{{ route('user.cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id_master: currentMaster })
            })
                .then(res => res.json())
                .then(() => updateUI());
        };

        document.getElementById("minusBtn").onclick = function () {
            fetch("{{ route('user.cart.remove') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id_master: currentMaster })
            })
                .then(res => res.json())
                .then(() => updateUI());
        };

        document.addEventListener('DOMContentLoaded', globalUpdateCartCount);
    </script>

@endsection