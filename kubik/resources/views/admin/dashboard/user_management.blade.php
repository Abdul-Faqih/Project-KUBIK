@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'User Management')

@section('content')
    <div class="grid">

        <div class="bg-white rounded-2xl shadow p-6 mt-6">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[#F26E21] text-xl font-semibold">Users List</h3>

                <div class="flex items-center space-x-2">

                    <input id="searchUser" type="text" placeholder="Search Name / NIM / NIP..."
                        class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm focus:ring-1 focus:ring-[#F26E21] focus:outline-none w-64" />

                    <select id="filterRole" class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm text-[#2A2A2A] cursor-pointer">
                        <option value="">All Roles</option>
                        <option value="Student">Student</option>
                        <option value="Lecturer">Lecturer</option>
                        <option value="Staff">Staff</option>
                    </select>

                    <select id="sortDate" class="border border-[#ECEFF3] rounded-md px-3 py-1 text-sm text-[#2A2A2A] cursor-pointer">
                        <option value="desc">Newest</option>
                        <option value="asc">Oldest</option>
                    </select>

                    <button id="clearFilter"
                        class="border border-[#F26E21] text-[#F26E21] px-3 py-1 rounded-md text-sm hover:bg-[#FFF3EC] transition">
                        Clear
                    </button>

                </div>

            </div>

            <div class="overflow-y-auto max-h-[75vh] scrollbar-thin scrollbar-thumb-[#F26E21]/60 scrollbar-track-gray-100 rounded-md"
                id="userTableContainer">

                @include('admin.dashboard.partials.user_table', ['users' => $users])

            </div>
        </div>

    </div>

    {{-- SCRIPT AJAX FILTER --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const search = document.getElementById("searchUser");
            const filterRole = document.getElementById("filterRole");
            const sortDate = document.getElementById("sortDate");
            const clearFilter = document.getElementById("clearFilter");
            const container = document.getElementById("userTableContainer");

            function updateTable() {
                const params = new URLSearchParams({
                    search: search.value,
                    role: filterRole.value,
                    sort: sortDate.value,
                });

                // Pastikan route ini sudah didefinisikan di web.php
                fetch(`{{ route('admin.dashboard.user_management.filter') }}?${params}`)
                    .then(res => res.json())
                    .then(data => {
                        container.innerHTML = data.html;
                    })
                    .catch(err => console.error('Error fetching users:', err));
            }

            // FILTER HANDLERS
            search.addEventListener("input", updateTable); // Realtime typing
            filterRole.addEventListener("change", updateTable);
            sortDate.addEventListener("change", updateTable);

            clearFilter.addEventListener("click", () => {
                search.value = "";
                filterRole.value = "";
                sortDate.value = "desc";
                updateTable();
            });
        });
    </script>

@endsection