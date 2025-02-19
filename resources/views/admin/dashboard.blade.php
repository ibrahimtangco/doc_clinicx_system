<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats Cards -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 items-stretch">
            <!-- Weekly Patients -->
            <a href="{{ route('patients.index') }}">
                <div
                    class="h-full hover:bg-primary/10 transition-colors bg-white p-6 shadow-sm rounded-lg col-span-1 flex gap-4">
                    <div class="bg-primary text-white rounded-full w-14 h-14 flex items-center justify-center">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-text-desc font-semibold">Patients This Week</p>
                        <p class="text-2xl font-bold">{{ $totalPatients }}</p>
                    </div>
                </div>
            </a>

            <!-- Weekly Scheduled Appointments -->
            <a href="{{ route('admin.appointments.view') }}">
                <div
                    class="h-full hover:bg-purple-100 transition-colors bg-white p-6 shadow-sm rounded-lg col-span-1 flex gap-4">
                    <div class="bg-purple-800 text-white rounded-full w-14 h-14 flex items-center justify-center">
                        <i class="fa-solid fa-calendar-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-text-desc font-semibold">Appointments This Week</p>
                        <p class="text-2xl font-bold">{{ $totalAppointments }}</p>
                    </div>
                </div>
            </a>

            <!-- Weekly Pending Reservations -->
            <a href="{{ route('admin.reservation.list') }}">
                <div
                    class="h-full hover:bg-yellow-100 transition-colors bg-white p-6 shadow-sm rounded-lg col-span-1 flex gap-4">
                    <div class="bg-yellow-500 text-white rounded-full w-14 h-14 flex items-center justify-center">
                        <i class="fa-solid fa-hourglass-half text-xl"></i>
                    </div>
                    <div>
                        <p class="text-text-desc font-semibold">Pending Reservations This Week</p>
                        <p class="text-2xl font-bold">{{ $pendingReservations }}</p>
                    </div>
                </div>
            </a>

            <!-- Weekly Prescriptions -->
            <a href="{{ route('admin.prescriptions.index') }}">
                <div
                    class="h-full hover:bg-blue-100 transition-colors bg-white p-6 shadow-sm rounded-lg col-span-1 flex gap-4">
                    <div class="bg-blue-500 text-white rounded-full w-14 h-14 flex items-center justify-center">
                        <i class="fa-solid fa-file-prescription text-xl"></i>
                    </div>
                    <div>
                        <p class="text-text-desc font-semibold">Prescriptions This Week</p>
                        <p class="text-2xl font-bold">{{ $totalPrescriptions }}</p>
                    </div>
                </div>
            </a>

            <!-- Weekly Transactions -->
            <a href="{{ route('transactions.index') }}">
                <div
                    class="h-full hover:bg-green-100 transition-colors bg-white p-6 shadow-sm rounded-lg col-span-1 flex gap-4">
                    <div class="bg-green-500 text-white rounded-full w-14 h-14 flex items-center justify-center">
                        <i class="fa-solid fa-exchange-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-text-desc font-semibold">Transactions This Week</p>
                        <p class="text-2xl font-bold">{{ $totalTransactions }}</p>
                    </div>
                </div>
            </a>
        </div>


        <!-- Appointment Trends Graph -->
        <div class="mt-8 grid sm:grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Appointment Trends -->
            <div class="bg-white p-6 shadow-sm rounded-lg overflow-x-auto">
                <div class="flex items-center justify-between mb-4 md:mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Trends</h3>
                    <div class="flex gap-2 items-center">
                        <label class="block text-gray-700 font-medium text-sm" for="trend-selector">View Trends:</label>
                        <select class="block w-full border-gray-300 rounded-md text-text-desc" id="trend-selector"
                            onchange="updateChart(this.value)">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                </div>
                <canvas id="appointment-trends-chart"></canvas>
            </div>

            <!-- Product Sales Chart -->
            <div class="bg-white p-6 shadow-sm rounded-lg overflow-x-auto">
                <div class="flex items-center justify-between mb-4 md:mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Sales</h3>
                    {{-- <div class="flex gap-2 items-center">
                        <label class="block text-gray-700 font-medium text-sm" for="trend-selector">View Sales:</label>
                        <select class="block w-full border-gray-300 rounded-md text-text-desc" id="trend-selector"
                            onchange="">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div> --}}
                </div>
                <canvas id="product-sales-chart"></canvas>
            </div>
        </div>

        <!-- Upcoming Appointments Section -->
        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
            <a href="{{ route('admin.appointments.view') }}">
                <h3 class="text-lg font-medium text-gray-900 p-6"><span class="hover:underline">Upcoming
                        Appointments</span></h3>
            </a>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="text-xs text-primary-text uppercase bg-gray-50 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($upcomingAppointments->isNotEmpty())
                            @foreach ($upcomingAppointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $appointment->reservation->patient->user->full_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $appointment->reservation->service->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ Carbon\Carbon::parse($appointment->reservation->date)->format('F j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-green-600">{{ $appointment->status }}</td>
                                </tr>
                            @endforeach
                        @else
                            <td class="text-center text-sm text-text-desc py-4" colspan="4">No upcoming appointments
                            </td>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Add Products -->

    <script>
        const productSalesCtx = document.getElementById('product-sales-chart').getContext('2d');
        new Chart(productSalesCtx, {
            type: 'bar',
            data: {
                labels: @json($productNames),
                datasets: [{
                        label: 'Total Sales Amount',
                        data: @json($salesAmounts),
                        backgroundColor: 'rgb(63, 131, 248, 0.6)', // Green for sales
                        borderColor: 'rgb(63, 131, 248)',
                        borderWidth: 2,
                        stack: 'sales'
                    },
                    {
                        label: 'Quantity Sold',
                        data: @json($quantities),
                        type: 'line',
                        borderColor: '#FF5733', // Orange for quantity
                        borderWidth: 2,
                        backgroundColor: 'rgba(255, 87, 51, 0.3)',
                        tension: 0.4,
                        fill: false,
                        yAxisID: 'y2' // To create a secondary axis
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Product Name'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Sales Amount'
                        },
                        beginAtZero: true
                    },
                    y2: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Quantity Sold'
                        },
                        grid: {
                            drawOnChartArea: false // Hide grid lines for the secondary axis
                        }
                    }
                }
            }
        });
    </script>

    <script>
        // This function will fetch data based on the selected trend and update the chart
        function updateChart(view) {
            fetch(`/get-appointment-trends?view=${view}`)
                .then(response => response.json())
                .then(data => {
                    const appointmentTrendsCtx = document.getElementById('appointment-trends-chart').getContext('2d');

                    // Check if the chart instance already exists
                    if (window.appointmentTrendsChart) {
                        // Update the existing chart with new data
                        window.appointmentTrendsChart.data.labels = data.labels;
                        window.appointmentTrendsChart.data.datasets[0].data = data.data;
                        window.appointmentTrendsChart.update();
                    } else {
                        // Create a new chart instance if it doesn't exist
                        window.appointmentTrendsChart = new Chart(appointmentTrendsCtx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Appointments',
                                    data: data.data,
                                    borderColor: '#7e22ce',
                                    backgroundColor: '#d8b4fe',
                                    borderWidth: 2,
                                    tension: 0.4 // Smooth line
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Date'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Number of Appointments'
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Initialize the chart with default data (e.g., 'daily') on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateChart('daily');
        });
    </script>

</x-admin-layout>
