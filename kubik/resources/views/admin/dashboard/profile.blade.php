@extends('admin.dashboard.layout.layoutdashboard')
@section('title', 'Detail Admin')

@section('content')

    <div class="">

        <div class="bg-[#FBFBFB] rounded-2xl shadow-md px-10 py-8 relative">

            <div class="mb-6 pb-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-[#F26E21] mb-1">{{ $admin->name }}</h1>
            </div>

            {{-- ADMIN DETAILS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                {{-- Left Column --}}
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">ID Admin</label>
                        <input type="text" value="{{ $admin->id_admin }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Name</label>
                        <input type="text" value="{{ $admin->name }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Email</label>
                        <input type="text" value="{{ $admin->email }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Role</label>
                        <input type="text" value="{{ $admin->role }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Created At</label>
                        <input type="text"
                            value="{{ $admin->created_at ? \Carbon\Carbon::parse($admin->created_at)->format('d M Y, H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                    <div>
                        <label class="block text-[#2A2A2A] text-sm font-semibold mb-1">Last Updated</label>
                        <input type="text"
                            value="{{ $admin->updated_at ? \Carbon\Carbon::parse($admin->updated_at)->format('d M Y, H:i') : '-' }}"
                            class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 bg-[#F9FAFB] text-gray-600" disabled>
                    </div>
                </div>
            </div>

            {{-- HANDLED PERMISSIONS SECTION --}}
            <div class="mt-12">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                    <h3 class="text-[#F26E21] text-lg font-semibold border-l-4 border-[#F26E21] pl-3">
                        Handled Permissions History
                    </h3>

                    {{-- FILTER COMPONENTS --}}
                    <div class="flex items-center space-x-2">
                        <input id="searchBooking" type="text" placeholder="Search ID / User..."
                            class="border border-[#ECEFF3] rounded-md px-3 py-1.5 text-sm focus:ring-1 focus:ring-[#F26E21] focus:outline-none w-48" />

                        <select id="filterStatus" class="border border-[#ECEFF3] rounded-md px-3 py-1.5 text-sm text-[#2A2A2A] cursor-pointer bg-white">
                            <option value="">All Status</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Completed">Completed</option>
                            {{-- Admin biasanya tidak handle Pending/Canceled di history 'handled', tapi jaga2 --}}
                        </select>

                        <select id="sortDate" class="border border-[#ECEFF3] rounded-md px-3 py-1.5 text-sm text-[#2A2A2A] cursor-pointer bg-white">
                            <option value="desc">Recent</option>
                            <option value="asc">Oldest</option>
                        </select>

                        <button id="clearFilter"
                            class="border border-[#F26E21] text-[#F26E21] px-3 py-1.5 rounded-md text-sm hover:bg-[#FFF3EC] transition font-medium">
                            Clear
                        </button>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto rounded-lg border border-gray-100">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-[#2A2A2A] font-semibold border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-center w-[12%]">ID</th>
                                <th class="py-3 px-4 w-[20%]">User Name</th>
                                <th class="py-3 px-4 text-center w-[18%]">Submitted at</th>
                                <th class="py-3 px-4 text-center w-[18%]">Returning at</th>
                                <th class="py-3 px-4 text-center w-[17%]">Time (Start - End)</th>
                                <th class="py-3 px-4 text-center w-[15%]">Status</th>
                            </tr>
                        </thead>

                        <tbody class="text-[#2A2A2A]" id="permissionTableBody">
                            {{-- Load Partial View di sini --}}
                            @include('admin.dashboard.partials.permission_table_rows', ['bookings' => $admin->bookings])
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    {{-- SCRIPT AJAX FILTER --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const search = document.getElementById("searchBooking");
            const filterStatus = document.getElementById("filterStatus");
            const sortDate = document.getElementById("sortDate");
            const clearFilter = document.getElementById("clearFilter");
            const tableBody = document.getElementById("permissionTableBody");
            
            // ID Admin dari variabel blade
            const adminId = "{{ $admin->id_admin }}"; 

            function updateTable() {
                const params = new URLSearchParams({
                    search: search.value,
                    status: filterStatus.value,
                    sort: sortDate.value,
                });

                // Panggil route AJAX Filter
                fetch(`{{ url('admin/admin-management') }}/${adminId}/filter?${params}`)
                    .then(res => res.json())
                    .then(data => {
                        tableBody.innerHTML = data.html;
                    })
                    .catch(err => console.error('Error filtering:', err));
            }

            // EVENT LISTENERS
            search.addEventListener("input", updateTable); // Live search
            filterStatus.addEventListener("change", updateTable);
            sortDate.addEventListener("change", updateTable);

            clearFilter.addEventListener("click", () => {
                search.value = "";
                filterStatus.value = "";
                sortDate.value = "desc";
                updateTable();
            });
        });
    </script>

@endsection