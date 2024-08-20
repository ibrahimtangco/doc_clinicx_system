<x-admin-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Appoinments History') }}
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

		<div class="md:flex items-center gap-4 mt-8 space-y-4 md:space-y-0 px-2 md:px-0">
			<div class="flex flex-col gap-2 w-full max-w-md">
				<label for="status">Filter By Status</label>
				<select class="border-gray-300 rounded-md " id="status" name="status">
					<option value="all">Show All</option>
					<option class="text-green-500" value="completed">Show Completed</option>
					<option class="text-red-500" value="cancelled">Show Cancelled</option>
				</select>
			</div>
		</div>
		<div class="relative overflow-x-auto">
			<table class="p-2 w-full text-sm text-left rtl:text-right text-secondary-text mt-4 mb-8">
				<thead class="text-xs text-primary-text uppercase bg-gray-50 border-b font-semibold">
					<tr>
						<th class="px-6 py-3" scope="col">
							Patient Name
						</th>
						<th class="px-6 py-3 " scope="col">
							Procedure
						</th>
						<th class="px-6 py-3 " scope="col">
							Date
						</th>
						<th class="px-6 py-3 " scope="col">
							Time
						</th>
						<th class="px-6 py-3" scope="col">
							Status
						</th>
						<th class="px-6 py-3" scope="col">
							Action
						</th>
					</tr>
				</thead>
				<tbody class="all-appointments">
					@foreach ($appointments as $appointment)
						<tr class="odd:bg-white even:bg-gray-100 border-b font-medium">
							<th class="px-6 py-3 font-semibold text-gray-900 whitespace-nowrap" scope="row">
								{{ $appointment->user->full_name }}
							</th>
							<td class="px-6 py-3 ">
								{{ $appointment->service->name }}
							</td>
							<td class="px-6 py-3 ">
								{{ $appointment->formatted_date }}
							</td>
							<td class="px-6 py-3 ">
								{{ $appointment->formatted_time }}
							</td>
							<td class="px-6 py-3 font-semibold">
								@if ($appointment->status == 'cancelled')
									<span class="text-red-500 px-2 py-0.5 rounded-full">{{ Str::ucfirst($appointment->status) }}</span>
								@elseif ($appointment->status == 'completed')
									<span class="text-green-500 px-2 py-0.5 rounded-full">{{ Str::ucfirst($appointment->status) }}</span>
								@else
									<span class="text-gray-500 px-2 py-0.5 rounded-full">{{ Str::ucfirst($appointment->status) }}</span>
								@endif
							</td>
							<td class="px-6 py-3 flex flex-col gap-1 xl:block xl:space-x-1">
								<a
									class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit text-sm"
									href="{{ route('admin.edit-appointment', $appointment) }}">
									<svg fill="none" height="15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										stroke="currentColor" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
										<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
										<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
									</svg>
									<span class="">View</span>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>

				<div class="error-container"></div>

			</table>
		</div>
		<div class="mt-4">
			{{ $appointments->links('pagination::tailwind') }}
		</div>
        <script>
    window.userRole = @json(auth()->user()->userType);

</script>
		<script src="{{ asset('js/filterByStatus.js') }}"></script>
</x-admin-layout>
