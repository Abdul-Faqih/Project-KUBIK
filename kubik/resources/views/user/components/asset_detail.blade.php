@props(['itemsJson'])

{{-- =============== MODAL DETAIL ASET =============== --}}
<div id="detailModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-end z-50 hidden transition-all">

    <div id="detailContent"
        class="w-full max-w-[430px] bg-white rounded-t-[32px] pb-10 translate-y-full transition-all duration-300 overflow-hidden shadow-xl">

        {{-- HEADER --}}
        <div class="bg-[#F26E21] text-white rounded-t-[32px] px-5 py-4 flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Detail Asset</p>
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
            {{-- TAMBAHAN: JADWAL PEMINJAMAN --}}
            <div id="borrowedScheduleBox" class="mt-4 hidden">
                <h4 class="text-base font-semibold text-[#F26E21] uppercase tracking-wider mb-2">Booked Schedule</h4>
                <div id="borrowedList"
                    class="space-y-2 max-h-[100px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 pr-1">
                    {{-- List jadwal akan di-inject lewat JS --}}
                </div>
            </div>
        </div>

        {{-- CART CONTROLS --}}
        <div class="mt-6 px-5">

            <button id="addBtn"
                class="w-full bg-[#F26E21] text-white py-3 rounded-xl text-lg font-semibold shadow-md hidden transition active:scale-95">
                Add
            </button>

            <div id="counterBox" class="flex items-center justify-end w-full select-none ">

                <div class="flex items-center justify-between gap-3 bg-[#ffffff] rounded-full shadow-md p-2 px-3">

                    <button id="minusBtn"
                        class="w-8 h-8 rounded-full bg-[#F26E21] flex items-center justify-center text-white text-xl font-semibold shadow-md active:scale-90 transition p-0">
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

<script>
    // Variabel yang dibutuhkan oleh Asset Detail
    const itemData = @json($itemsJson);
    let currentMaster = null;
    let currentType = null;
    let maxAvailable = 0;
    let assets = [];

    // Fungsi-fungsi detail modal
    function openDetail(id, filteredCount = null) {
        currentMaster = id;
        const item = itemData.find(i => i.id_master == id);
        if (!item) return;

        // Ambil ID Type
        currentType = item.id_type || (item.type ? item.type.id_type : '');
        assets = item.assets;

        // Hitung Ketersediaan (Logic Lama)
        if (filteredCount !== null) {
            maxAvailable = filteredCount;
        } else {
            maxAvailable = item.assets.filter(a => a.status === "Available").length;
        }

        // Update UI Text & Image (Logic Lama)
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

        // --- TAMBAHAN BARU: LOGIKA JADWAL BOOKING ---
        const scheduleBox = document.getElementById("borrowedScheduleBox");
        const scheduleList = document.getElementById("borrowedList");
        scheduleList.innerHTML = ""; // Reset list

        let hasSchedule = false;

        // Loop semua aset di master ini
        if (item.assets && item.assets.length > 0) {
            item.assets.forEach(asset => {
                // Cek bookings di setiap aset
                if (asset.bookings && asset.bookings.length > 0) {
                    asset.bookings.forEach(booking => {
                        // Hanya tampilkan yang APPROVED dan belum selesai (End time > Now)
                        // Logika sederhana: ambil yang status Approved
                        if (booking.status === 'Approved') {
                            hasSchedule = true;

                            // Format Tanggal & Jam (Custom YYYY-MM-DD HH:MM)
                            const start = new Date(booking.start_time);
                            const end = new Date(booking.end_time);

                            // Helper function untuk format 2 digit
                            const pad = (n) => n.toString().padStart(2, '0');

                            const startStr = `${start.getFullYear()}-${pad(start.getMonth() + 1)}-${pad(start.getDate())} ${pad(start.getHours())}:${pad(start.getMinutes())}`;
                            const endStr = `${end.getFullYear()}-${pad(end.getMonth() + 1)}-${pad(end.getDate())} ${pad(end.getHours())}:${pad(end.getMinutes())}`;

                            // Buat Elemen List
                            const div = document.createElement("div");
                            div.className = "bg-orange-50 border border-orange-100 rounded-lg p-2 text-xs text-gray-700 flex items-center gap-2";
                            div.innerHTML = `
                                <span class="material-symbols-rounded text-[#F26E21] text-3xl mt-0.5">event_busy</span>
                                <div>
                                    <p class="font-semibold text-base text-[#2A2A2A]">Booked for</p>
                                    <p class="text-sm">${startStr} - ${endStr}</p>
                                </div>
                            `;
                            scheduleList.appendChild(div);
                        }
                    });
                }
            });
        }

        // Tampilkan/Sembunyikan Box Jadwal
        if (hasSchedule) {
            scheduleBox.classList.remove("hidden");
        } else {
            scheduleBox.classList.add("hidden");
        }
        // --------------------------------------------

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
                const minusBtn = document.getElementById("minusBtn");

                qtyText.innerText = qty;

                // --- CEK KETERSEDIAAN ---
                if (maxAvailable === 0 && qty === 0) {
                    addBtn.classList.remove("hidden");
                    addBtn.disabled = true;
                    addBtn.classList.add("opacity-50", "cursor-not-allowed", "bg-gray-400");
                    addBtn.classList.remove("bg-[#F26E21]", "active:scale-95");
                    addBtn.innerText = "Unavailable";

                    counterBox.classList.add("hidden");
                    return; // Stop eksekusi
                } else {
                    addBtn.disabled = false;
                    addBtn.classList.remove("opacity-50", "cursor-not-allowed", "bg-gray-400");
                    addBtn.classList.add("bg-[#F26E21]", "active:scale-95");
                    addBtn.innerText = "Add";
                }

                // --- LOGIKA TAMPILAN BERDASARKAN TIPE ---
                if (currentType === 'TYP-000001') {
                    // --- ROOM ---
                    if (qty === 0) {
                        addBtn.classList.remove("hidden");
                        counterBox.classList.add("hidden");
                    } else {
                        addBtn.classList.add("hidden");
                        counterBox.classList.remove("hidden");

                        // UBAH JADI TONG SAMPAH (STYLE MERAH/PUTIH)
                        minusBtn.innerHTML = '<span class="material-symbols-rounded text-2xl px-20">delete</span>';
                        minusBtn.classList.remove('bg-[#F26E21]', 'text-white');
                        minusBtn.classList.add('bg-red-50', 'text-red-500');

                        qtyText.classList.add("hidden");
                        plusBtn.classList.add("hidden");

                        counterBox.querySelector('div').classList.remove('justify-between');
                        counterBox.querySelector('div').classList.add('justify-center', 'w-full');
                    }
                } else {
                    // --- BARANG (ITEM) ---
                    minusBtn.innerHTML = '–';
                    minusBtn.classList.remove('bg-red-50', 'text-red-500');
                    minusBtn.classList.add('bg-[#F26E21]', 'text-white');

                    qtyText.classList.remove("hidden");
                    plusBtn.classList.remove("hidden");

                    counterBox.querySelector('div').classList.add('justify-between');
                    counterBox.querySelector('div').classList.remove('justify-center', 'w-full');

                    if (qty === 0) {
                        addBtn.classList.remove("hidden");
                        counterBox.classList.add("hidden");
                    } else {
                        addBtn.classList.add("hidden");
                        counterBox.classList.remove("hidden");
                    }

                    // Matikan tombol plus jika qty >= maxAvailable
                    plusBtn.disabled = qty >= maxAvailable;
                    if (plusBtn.disabled) {
                        plusBtn.classList.add('opacity-50', 'cursor-not-allowed', "bg-gray-400");
                    } else {
                        plusBtn.classList.remove('opacity-50', 'cursor-not-allowed', "bg-gray-400");
                    }
                }

                if (typeof globalUpdateCartCount !== 'undefined') {
                    globalUpdateCartCount();
                }
            });
    }

    // ========= ADD / PLUS / MINUS =========
    document.getElementById("addBtn").onclick = function () {
        if (!this.disabled) addToCart();
    };

    document.getElementById("plusBtn").onclick = function () {
        if (!this.disabled) addToCart();
    };

    document.getElementById("minusBtn").onclick = function () {
        removeFromCart();
    };

    function addToCart() {
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
    }

    function removeFromCart() {
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
    }
</script>