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
    // FUNGSI SINKRONISASI GLOBAL (Dapat dipanggil dari komponen lain)
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
                    continueBtn.classList.add('disabled');
                    continueBtn.setAttribute('href', '#');
                    continueBtn.setAttribute('aria-disabled', 'true'); 
                } else {
                    emptyMsg.classList.add('hidden');
                    listBody.classList.remove('hidden');
                    continueBtn.classList.remove('disabled');
                    continueBtn.setAttribute('href', '{{ route('user.form') }}'); 
                    continueBtn.setAttribute('aria-disabled', 'false');

                    data.forEach((item, index) => {
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
            fetchAndRenderCart(); 
            globalUpdateCartCount(); 
            // Opsional: Sinkronisasi modal detail jika sedang terbuka
            if (typeof updateUI !== 'undefined') updateUI(); 
        });
    }

    // Event listeners
    document.getElementById('cartModal').addEventListener("click", function (e) {
        const box = document.getElementById("cartContent");
        if (!box.contains(e.target)) closeCartModal();
    });

    document.getElementById('flyButton').addEventListener('click', openCartModal);
    
    document.addEventListener('DOMContentLoaded', globalUpdateCartCount);
</script>