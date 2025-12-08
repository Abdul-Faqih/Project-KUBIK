@props(['cartCount'])

{{-- 🟢 FLY BUTTON (ICON BOX) 🟢 --}}
<div id="flyButton"
    class="fixed right-5 bottom-5 z-40 w-16 h-16 rounded-full bg-[#F26E21] flex items-center justify-center shadow-lg cursor-pointer {{ $cartCount > 0 ? '' : 'hidden' }}">

    <img src="{{ asset('images/box_icon.png') }}" class="w-8 h-8 object-contain">

    {{-- Counter Badge --}}
    <span id="flyBadge"
        class="absolute top-0 right-0 transform translate-x-1/4 -translate-y-1/4 bg-white text-[#F26E21] text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center ring-2 ring-[#F26E21] shadow-md">
        {{ $cartCount }}
    </span>
</div>

{{-- =============== CART LIST MODAL (BOTTOM SHEET) =============== --}}
<div id="cartModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-end z-50 hidden transition-all">

    <div id="cartContent"
        class="w-full max-w-[430px] bg-white rounded-t-[32px] translate-y-full transition-all duration-300 overflow-hidden shadow-xl flex flex-col max-h-[90vh]">

        {{-- HEADER --}}
        <div class="px-5 pt-5 pb-3 flex justify-between items-center border-b border-gray-200 flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold text-[#F26E21]">Assets List</h2>
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
            <a href="{{ route('user.form') }}" id="continueBookingBtn"
                class="w-full block text-center bg-[#F26E21] text-white py-3 rounded-xl text-lg font-semibold shadow-md active:scale-95 transition disabled:opacity-50">
                Continue Booking
            </a>
        </div>
    </div>
</div>

<script>
    // ----------------------------------------------------
    // FUNGSI SINKRONISASI GLOBAL
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
                    if (document.getElementById('cartModal').classList.contains('hidden')) {
                        flyButton.classList.remove('hidden');
                    }
                } else {
                    flyButton.classList.add('hidden');
                }
            });
    }

    // ----------------------------------------------------
    // FUNGSI CART LIST MODAL
    // ----------------------------------------------------
    function openCartModal() {
        document.getElementById('flyButton').classList.add('hidden');
        fetchAndRenderCart();
        document.getElementById("cartModal").classList.remove("hidden");
        setTimeout(() => {
            document.getElementById("cartContent").classList.remove("translate-y-full");
        }, 10);
    }

    function closeCartModal() {
        document.getElementById("cartContent").classList.add("translate-y-full");
        setTimeout(() => {
            document.getElementById("cartModal").classList.add("hidden");
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
                    continueBtn.classList.add('disabled', 'opacity-50', 'cursor-not-allowed');
                    continueBtn.removeAttribute('href');
                } else {
                    emptyMsg.classList.add('hidden');
                    listBody.classList.remove('hidden');
                    continueBtn.classList.remove('disabled', 'opacity-50', 'cursor-not-allowed');
                    continueBtn.setAttribute('href', '{{ route('user.form') }}');

                    // 1. GROUPING DATA BERDASARKAN MASTER ID
                    // Kita ubah array flat menjadi object group untuk menghitung Qty
                    const groupedItems = {};

                    data.forEach(item => {
                        if (!groupedItems[item.master_id]) {
                            groupedItems[item.master_id] = {
                                ...item,
                                qty: 0
                            };
                        }
                        groupedItems[item.master_id].qty += 1;
                    });

                    // 2. RENDER HASIL GROUPING
                    Object.values(groupedItems).forEach(item => {
                        const listItem = `
                            <li class="flex items-center justify-between py-4 border-b border-gray-100 last:border-0">
                                {{-- KIRI: NAMA ASET --}}
                                <div class="pr-4">
                                    <p class="font-semibold text-[#2A2A2A] text-[15px] leading-tight line-clamp-2">
                                        ${item.name}
                                    </p>
                                </div>

                                {{-- KANAN: COUNTER WIDGET --}}
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    {{-- TOMBOL KURANG (-) --}}
                                    <button onclick="updateCartItem('${item.master_id}', 'decrease')" 
                                            class="w-7 h-7 rounded-full bg-[#F26E21] text-white flex items-center justify-center shadow-sm active:scale-90 transition">
                                        <span class="text-xl font-bold leading-none mb-[2px]">-</span>
                                    </button>

                                    {{-- JUMLAH QTY --}}
                                    <span class="text-[#2A2A2A] font-semibold text-lg w-4 text-center">
                                        ${item.qty}
                                    </span>

                                    {{-- TOMBOL TAMBAH (+) --}}
                                    <button onclick="updateCartItem('${item.master_id}', 'increase')" 
                                            class="w-7 h-7 rounded-full bg-[#F26E21] text-white flex items-center justify-center shadow-sm active:scale-90 transition">
                                        <span class="text-xl font-bold leading-none mb-[2px]">+</span>
                                    </button>
                                </div>
                            </li>
                        `;
                        listBody.innerHTML += listItem;
                    });
                }
            });
    }

    // FUNGSI UPDATE ITEM (TAMBAH / KURANG)
    function updateCartItem(idMaster, action) {
        // Tentukan URL berdasarkan aksi
        // Asumsi: Anda punya route 'user.cart.add' untuk menambah. 
        // Jika belum ada, pastikan buat route-nya atau sesuaikan URL di bawah.
        let url = "";

        if (action === 'decrease') {
            url = "{{ route('user.cart.remove') }}";
        } else {
            // Ganti route ini dengan route untuk menambah item (sama seperti di halaman katalog)
            url = "{{ route('user.cart.add') }}";
        }

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id_master: idMaster })
        })
            .then(res => res.json())
            .then(response => {
                // Refresh list setelah update
                fetchAndRenderCart();
                globalUpdateCartCount();
            })
            .catch(err => console.error("Error updating cart:", err));
    }

    // Event listeners
    document.getElementById('cartModal').addEventListener("click", function (e) {
        const box = document.getElementById("cartContent");
        if (!box.contains(e.target)) closeCartModal();
    });

    document.getElementById('flyButton').addEventListener('click', openCartModal);

    document.addEventListener('DOMContentLoaded', globalUpdateCartCount);
</script>