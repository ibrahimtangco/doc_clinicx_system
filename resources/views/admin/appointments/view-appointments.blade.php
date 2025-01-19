<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Appoinments') }}
		</h2>
	</x-slot>
	<div class="py-6 px-4">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="overflow-x-auto">
				<table class="p-2 w-full text-sm text-left rtl:text-right text-secondary-text mt-4 mb-8" id="search-table">
					<thead class="text-xs text-primary-text uppercase bg-gray-50 border-b font-semibold">
						<tr>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Patient Name
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Service
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Date
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Schedule
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Status
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Queue Number
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col">
								Action
							</th>
						</tr>
					</thead>
					<tbody class="all-appointments">
						@foreach ($appointments as $appointment)
							<tr class="odd:bg-white even:bg-gray-100 border-b font-medium">
								<td class="px-6 py-3">
									{{ $appointment->reservation->patient->user->full_name }}
								</td>
								<td class="px-6 py-3">
									{{ $appointment->reservation->service->name }}
								</td>
								<td class="px-6 py-3">
									{{ Carbon\Carbon::parse($appointment->reservation->date)->format('F j, Y') }}
								</td>
								<td class="px-6 py-3">
									{{ $appointment->reservation->preferred_schedule }}
								</td>
								@php
									$statusClasses = [
									    'scheduled' => 'text-yellow-500',
									    'no_show' => 'text-red-500',
									    'completed' => 'text-green-500',
									];
								@endphp
								<td
									class="px-6 py-4 {{ $statusClasses[$appointment->status] ?? 'text-gray-500' }} capitalize italic font-bold">
									{{ $appointment->status }}
								</td>
								<td class="px-6 py-4">
									{{ $appointment->queue_number }}
								</td>
								<td class="px-6 py-3 flex items-center gap-1 xl:space-x-1">
									<a
										class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
										href="{{ route('admin.appointment-details.view', ['appointment' => $appointment]) }}">
										<i class="fa-solid fa-eye"></i>
										<span class="hidden md:inline">View</span>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script>
		if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
			const dataTable = new simpleDatatables.DataTable("#search-table", {
				searchable: true,
				sortable: true
			});
		}
	</script>
	<script>
		window.userRole = @json(auth()->user()->userType);
	</script>
	<script src="{{ asset('js/filterByStatus.js') }}"></script>
</x-admin-layout>
