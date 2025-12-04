@props(['itemsJson'])

{{-- =============== MODAL DETAIL ASET =============== --}}
<div id="detailModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-end z-50 hidden transition-all">

    <div id="detailContent"
        class="w-full max-w-[430px] bg-white rounded-t-[32px] pb-10 translate-y-full transition-all duration-300 overflow-hidden shadow-xl">

        {{-- HEADER --}}
        <div class="bg-[#F26E21] text-white rounded-t-[32px] px-5 py-4 flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Item</p>
                <h2 id="detailTitle" class="text-2xl font-bold mt-1 leading-tight"></h2>
            </div>
            <button onclick="closeDetail()">
                <span class="text-white text-3xl font-bold">×</span>
            </button>
        </div>

        {{-- IMAGE --}}
        <div class="px-5 mt-4">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <img id="detailImage" class="w-full h-[230px] object-cover rounded-xl">
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="px-5 mt-5">
            <div class="flex justify-between text-sm mb-4">
                <span id="detailStatus"></span>
                <span id="detailCount" class="opacity-70"></span>
            </div>

            <h3 class="text-lg font-semibold mb-1">Detail</h3>
            <p id="detailDescription" class="text-sm text-gray-700 leading-snug"></p>
        </div>

        {{-- CART CONTROLS --}}
        <div class="mt-6 px-5">

            <button id="addBtn"
                class="w-full bg-[#F26E21] text-white py-3 rounded-xl text-lg font-semibold shadow-md hidden transition active:scale-95">
                Add
            </button>

            <div id="counterBox" class="flex items-center justify-end w-full select-none ">

                <div class="flex items-center justify-between gap-3 bg-[#f0f0f0] rounded-full shadow-md p-2 px-3">

                    <button id="minusBtn"
                        class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[#F26E21] text-xl font-semibold shadow-md active:scale-90 transition p-0">
                        –
                    </button>

                    <span id="qtyText" class="px-2 flex items-center justify-center text-lg text-[#2A2A2A] text-center">
                        1
                    </span>

                    <button id="plusBtn"
                        class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[#F26E21] text-xl font-semibold shadow-md active:scale-90 transition p-0">
                        +
                    </button>

                </div>

            </div>

        </div>


    </div>
</div>

<script>
    // Variabel yang dibutuhkan oleh Asset Detail
    const itemData = @json($itemsJson);
    let currentMaster = null;
    let maxAvailable = 0;
    let assets = [];

    // Fungsi-fungsi detail modal
    function openDetail(id) {
        currentMaster = id;
        const item = itemData.find(i => i.id_master == id);
        if (!item) return;

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

    // ========= UPDATE UI (Untuk Modal Detail) =========
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
                
                // Panggil fungsi global dari komponen Cart Logic (Jika sudah dimuat)
                if (typeof globalUpdateCartCount !== 'undefined') {
                    globalUpdateCartCount(); 
                }
            });
    }

    // ========= ADD / PLUS / MINUS =========
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
</script>