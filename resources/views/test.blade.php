<x-master-layout>
	<div class="min-h-screen bg-gray-100">
		<!-- Header -->
		<header class="bg-white shadow">
			<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
				<h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
			</div>
		</header>

		<!-- Main Content -->
		<main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
			<!-- Stats Cards -->
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
				<!-- Total Patients -->
				<div class="bg-white shadow rounded-lg p-4 sm:p-6">
					<h3 class="text-sm font-medium text-gray-500">Total Patients</h3>
					<p class="mt-1 text-3xl font-bold text-gray-900">124</p>
				</div>
				<!-- Total Appointments -->
				<div class="bg-white shadow rounded-lg p-4 sm:p-6">
					<h3 class="text-sm font-medium text-gray-500">Total Appointments</h3>
					<p class="mt-1 text-3xl font-bold text-gray-900">42</p>
				</div>
				<!-- Daily Revenue -->
				<div class="bg-white shadow rounded-lg p-4 sm:p-6">
					<h3 class="text-sm font-medium text-gray-500">Revenue Today</h3>
					<p class="mt-1 text-3xl font-bold text-gray-900">$1,250</p>
				</div>
			</div>

			<!-- Charts Section -->
			<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
				<!-- Appointment Trends -->
				<div class="bg-white shadow rounded-lg p-6">
					<h3 class="text-lg font-medium text-gray-900">Appointment Trends</h3>
					<canvas class="mt-4" id="appointment-trends-chart"></canvas>
				</div>
				<!-- Revenue Chart -->
				<div class="bg-white shadow rounded-lg p-6">
					<h3 class="text-lg font-medium text-gray-900">Revenue Overview</h3>
					<canvas class="mt-4" id="revenue-chart"></canvas>
				</div>
			</div>

			<!-- Tables Section -->
			<div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
				<h3 class="text-lg font-medium text-gray-900 p-6">Upcoming Appointments</h3>
				<table class="min-w-full bg-white">
					<thead>
						<tr>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="px-6 py-4 text-sm text-gray-900">John Doe</td>
							<td class="px-6 py-4 text-sm text-gray-500">12/05/2024</td>
							<td class="px-6 py-4 text-sm text-green-600">Confirmed</td>
						</tr>
						<tr>
							<td class="px-6 py-4 text-sm text-gray-900">Jane Smith</td>
							<td class="px-6 py-4 text-sm text-gray-500">12/06/2024</td>
							<td class="px-6 py-4 text-sm text-yellow-600">Pending</td>
						</tr>
					</tbody>
				</table>
			</div>
		</main>
	</div>

	<script>
		const ctx1 = document.getElementById('appointment-trends-chart').getContext('2d');
		new Chart(ctx1, {
			type: 'line',
			data: {
				labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
				datasets: [{
					label: 'Appointments',
					data: [5, 7, 10, 6, 9],
					borderColor: 'rgba(59, 130, 246, 1)',
					backgroundColor: 'rgba(59, 130, 246, 0.2)',
				}]
			},
			options: {
				responsive: true
			}
		});

		const ctx2 = document.getElementById('revenue-chart').getContext('2d');
		new Chart(ctx2, {
			type: 'bar',
			data: {
				labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
				datasets: [{
					label: 'Revenue',
					data: [3000, 4500, 4000, 5000],
					backgroundColor: 'rgba(34, 197, 94, 0.7)',
				}]
			},
			options: {
				responsive: true
			}
		});
	</script>
</x-master-layout>
