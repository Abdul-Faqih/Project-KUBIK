@extends('admin.dashboard.layout.layoutdashboard')

@section('title', 'Dashboard - Home')

@section('content')

    <!-- ROW 1: Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="text-left leading-tight">
            <h1 class="text-3xl font-bold text-[rgb(242,110,33)]">Hello, {{ session('admin_name') ?? 'Admin' }}</h1>
            <p class="text-l text-[#aeaeae] font-reguler">ID: {{ session('admin_id') ?? '0001' }}</p>
        </div>
        <!-- Meatball menu -->
        <div class="relative">
            <button id="menuButton" class="p-2 rounded-full hover:bg-[#FBFBFB]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#2A2A2A]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5.25a.75.75 0 110 1.5.75.75 0 010-1.5zm0 6a.75.75 0 110 1.5.75.75 0 010-1.5zm0 6a.75.75 0 110 1.5.75.75 0 010-1.5z" />
                </svg>
            </button>
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-md py-2">
                <a href="{{ route('admin.export.bookings') }}"
                    class="block px-4 py-2 text-base text-[#2A2A2A] hover:bg-[#FBFBFB]">Export Loan Report</a>
            </div>
        </div>
    </div>

    <!-- ROW 2: Statistic Cards -->
    <div class="grid grid-cols-1 base:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $cards = [
                ['title' => 'Total Assets', 'value' => $totalAssets ?? 0, 'showToday' => false],
                ['title' => 'Total Loan Demand', 'value' => $loanDemand ?? 0, 'showToday' => true],
                ['title' => 'Active Loan', 'value' => $activeLoan ?? 0, 'showToday' => true],
                ['title' => 'Active Assets', 'value' => $activeAssets ?? 0, 'showToday' => true],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition">
                <div>
                    <p class="text-base text-[#2A2A2A] font-semibold">{{ $card['title'] }}</p>
                    <h2 class="text-3xl font-bold text-[#F26E21] mt-3">{{ number_format($card['value']) }}</h2>
                </div>

                @if($card['showToday'])
                    <p class="text-xs text-[#AEAEAE] mt-4">Today</p>
                @endif
            </div>
        @endforeach
    </div>


    <!-- ====== ROW 3: CHARTS ====== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <!-- Asset Distribution -->
        <div class="bg-white rounded-2xl shadow-base border border-[#FBFBFB] p-6">
            <h3 class="text-[#F26E21] font-semibold mb-4 text-xl">Asset Distribution</h3>
            <div class="flex justify-center items-center h-[300px]">
                <canvas id="assetDistributionChart"></canvas>
            </div>
        </div>

        <!-- Loan Activities -->
        <div class="bg-white rounded-2xl shadow-base border border-[#FBFBFB] p-6">
            <h3 class="text-[#F26E21] font-semibold mb-4 text-xl">Loan Activities</h3>
            <div class="h-[300px]">
                <canvas id="loanActivitiesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ROW 4: Activity Table -->
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[#F26E21] font-semibold mb-4 text-xl">Activity Table</h3>

            <!-- Date picker -->
            <form method="GET" action="{{ route('admin.dashboard.home') }}" class="flex items-center space-x-2">
                <input type="date" name="date" value="{{ \Carbon\Carbon::parse($selectedDate)->format('Y-m-d') }}"
                    class="border border-[#ECEFF3] rounded-md px-3 py-1 text-base text-[#2A2A2A] focus:outline-none focus:ring-2 focus:ring-[#F26E21]" />
                <button type="submit"
                    class="bg-[#F26E21] text-white px-3 py-1 rounded-md text-base hover:bg-[#e85f16] transition">Apply</button>
            </form>
        </div>

        <table class="w-full text-sm">
            <thead class="text-[#2A2A2A] border-b border-[#ECEFF3]">
                <tr>
                    <th class="py-2 px-3 text-center">ID</th>
                    <th class="py-2 px-3 text-left">Name</th>
                    <th class="py-2 px-3 text-center">Status</th>
                    <th class="py-2 px-3 text-center">Date</th>
                    <th class="py-2 px-3 text-center">Time</th>
                    <th class="py-2 px-3 text-center">Returning At</th>
                    <th class="py-2 px-3 text-center">Returning Lated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $item)
                    <tr class="border-b border-[#ECEFF3] hover:bg-[#FBFBFB] transition">
                        <td class="py-2 px-3 text-center">{{ $item->id_booking }}</td>
                        <td class="py-2 px-3 text-left">{{ $item->user?->name ?? 'Unknown' }}</td>
                        <td class="py-2 px-3 text-center">
                            @if($item->status === 'Pending')
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-600">Pending</span>
                            @elseif($item->status === 'Rejected')
                                <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-600">Rejected</span>
                            @elseif($item->status === 'Approved')
                                <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-600">Approved</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">Completed</span>
                            @endif
                        </td>
                        <td class="py-2 px-3 text-center">
                            {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-' }}
                        </td>
                        <td class="py-2 px-3 text-center">
                            {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('H:i') : '-' }}
                        </td>
                        <td class="py-2 px-3 text-center">
                            {{ $item->return_at ? \Carbon\Carbon::parse($item->return_at)->format('H:i') : '-' }}
                        </td>

                        <td class="py-2 px-3 text-center">
                            @if($item->status !== 'Completed')
                                <span class="text-[#AEAEAE] text-xs">-</span>
                            @elseif($item->is_late)
                                <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-600">Lated</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">On Time</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-3 text-center text-[#AEAEAE]">No activity found for this date.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>

    <script>
        document.addEventListener('alpine:init', () => {
            // Pie Chart - Asset Distribution
            const assetCtx = document.getElementById('assetDistributionChart').getContext('2d');
            new Chart(assetCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($assetLabels ?? ['Rooms', 'Items']) !!},
                    datasets: [{
                        data: {!! json_encode($assetCounts ?? [0, 0]) !!},
                        backgroundColor: ['#1D4ED8', '#F26E21'],
                        borderWidth: 2,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 15,
                                color: '#2A2A2A',
                                font: { size: 13 }
                            }
                        }
                    }
                }
            });

            // Line Chart - Loan Activities
            const loanCtx = document.getElementById('loanActivitiesChart').getContext('2d');
            new Chart(loanCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($loanMonths ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                    datasets: [
                        {
                            label: 'Permission Completed',
                            data: {!! json_encode($loanBorrowing ?? [0, 0, 0, 0, 0, 0]) !!},
                            borderColor: '#2563EB',
                            tension: 0.3,
                            fill: false,
                            pointRadius: 3,
                            pointBackgroundColor: '#2563EB'
                        },
                        {
                            label: 'Permission Rejected',
                            data: {!! json_encode($loanRejecting ?? [0, 0, 0, 0, 0, 0]) !!},
                            borderColor: '#22C55E',
                            tension: 0.3,
                            fill: false,
                            pointRadius: 3,
                            pointBackgroundColor: '#22C55E'
                        },
                        {
                            label: 'Used Assets',
                            data: {!! json_encode($loanUsed ?? [0, 0, 0, 0, 0, 0]) !!},
                            borderColor: '#F59E0B',
                            tension: 0.3,
                            fill: false,
                            pointRadius: 3,
                            pointBackgroundColor: '#F59E0B'
                        },
                        {
                            label: 'Returning Lated',
                            data: {!! json_encode($loanLateReturning ?? [0, 0, 0, 0, 0, 0]) !!},
                            borderColor: '#DC2626',
                            tension: 0.3,
                            fill: false,
                            pointRadius: 3,
                            pointBackgroundColor: '#DC2626'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#2A2A2A', font: { size: 12 } }
                        }
                    },
                    scales: {

                        x: {
                            ticks: { color: '#AEAEAE' },
                            grid: { display: '#ECEFF3' }
                        },
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: 105, // batas atas sumbu Y
                            ticks: {
                                stepSize: 5, // jarak antar nilai (5, 10, 15, dst)
                                color: '#AEAEAE',
                                font: { size: 11 }
                            },
                            grid: {
                                color: '#ECEFF3'
                            }
                        }
                    }
                }
            });
        });

        // Dropdown export
        const btn = document.getElementById('menuButton');
        const menu = document.getElementById('dropdownMenu');
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    </script>

@endsection