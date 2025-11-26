@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Permissions')

@section('content')
    <div class="grid">

        <!-- BOOKINGS LIST -->
        <div class="bg-white rounded-2xl shadow p-6 mt-6">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[#F26E21] text-xl font-semibold">Permissions List</h3>

                <!-- FILTER COMPONENTS -->
                <div class="flex items-center space-x-2">

                    <!-- SEARCH -->
                    <input id="searchBooking" type="text" placeholder="Search ID / Name..."
                        class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm focus:ring-1 focus:ring-[#F26E21] focus:outline-none" />

                    <!-- STATUS FILTER -->
                    <select id="filterStatus" class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm text-[#2A2A2A]">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Rejected">Rejected</option>
                    </select>

                    <!-- SORT BY DATE -->
                    <select id="sortDate" class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm text-[#2A2A2A]">
                        <option value="desc">Recent</option>
                        <option value="asc">Oldest</option>
                    </select>

                    <!-- CLEAR -->
                    <button id="clearFilter"
                        class="border border-[#F26E21] text-[#F26E21] px-3 py-1 rounded-md text-sm hover:bg-[#FFF3EC] transition">
                        Clear
                    </button>

                </div>

            </div>

            <!-- TABLE -->
            <div class="overflow-y-auto max-h-[75vh] scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md"
                id="bookingTableContainer">

                @include('admin.dashboard.partials.booking_table', ['bookings' => $bookings])

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const search = document.getElementById("searchBooking");
            const filterStatus = document.getElementById("filterStatus");
            const sortDate = document.getElementById("sortDate");
            const clearFilter = document.getElementById("clearFilter");
            const container = document.getElementById("bookingTableContainer");

            function updateTable() {
                const params = new URLSearchParams({
                    search: search.value,
                    status: filterStatus.value,
                    sort: sortDate.value,
                });

                fetch(`{{ route('admin.permissions.filter') }}?${params}`)
                    .then(res => res.json())
                    .then(data => container.innerHTML = data.html)
                    .catch(err => console.error(err));
            }

            // FILTER HANDLERS
            search.addEventListener("input", updateTable);
            filterStatus.addEventListener("change", updateTable);
            sortDate.addEventListener("change", updateTable);

            clearFilter.addEventListener("click", () => {
                search.value = "";
                filterStatus.value = "";
                sortDate.value = "desc"; // default → terbaru
                updateTable();
            });
        });
    </script>


@endsection