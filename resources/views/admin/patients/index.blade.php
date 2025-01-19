<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Patients') }}
		</h2>
	</x-slot>

	{{-- Main container --}}
	<div class="py-6 px-4">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="md:flex items-center justify-end mb-4">
				<div class="flex flex-col gap-3 items-center justify-center md:flex-row">
					@if (Auth::user()->userType === 'admin')
						<a class="w-full md:w-auto bg-primary text-white-text py-1 px-2 rounded-md text-center"
							href="{{ route('patients.create') }}">
							<i class="fa-solid fa-plus"></i> {{ __('Add') }}
						</a>
					@endif
					<a class="w-full md:w-auto bg-green-600 text-white-text py-1 px-2 rounded-md text-center hover:bg-green-700"
						href="{{ route('download.patient.list') }}">
						<i class="fa-regular fa-file-pdf"></i> {{ __('Export') }}
					</a>
				</div>
			</div>

			<div class="overflow-x-auto">
				<table class="p-2 w-full text-sm text-left rtl:text-right text-gray-500" id="search-table">
					<thead class="text-xs text-gray-700 uppercase bg-gray-50">
						<tr>
							<th class="px-4 py-2 md:px-6 md:py-3" scope="col"><span class="flex items-center">
								Name
								<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
									xmlns="http://www.w3.org/2000/svg">
									<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										stroke="currentColor" />
								</svg>
							</span></th>
							<th class="px-4 py-2 md:px-6 md:py-3" scope="col"><span class="flex items-center">
								Address
								<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
									xmlns="http://www.w3.org/2000/svg">
									<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										stroke="currentColor" />
								</svg>
							</span></th>
							<th class="px-4 py-2 md:px-6 md:py-3" scope="col"><span class="flex items-center">
								Email
								<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
									xmlns="http://www.w3.org/2000/svg">
									<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										stroke="currentColor" />
								</svg>
							</span></th>
							<th class="px-4 py-2 md:px-6 md:py-3" scope="col"><span>Action</span></th>
						</tr>
					</thead>
					<tbody id="allData">
						@foreach ($patients as $patient)
							<tr class="bg-white border-b hover:bg-gray-50">
								<td class="px-4 py-2 md:px-6 md:py-4">{{ $patient->user->full_name }}</td>
								<td class="px-4 py-2 md:px-6 md:py-4">{{ $patient->user->address }}</td>
								<td class="px-4 py-2 md:px-6 md:py-4">{{ $patient->user->email }}</td>
								<td class="px-4 py-2 md:px-6 md:py-4 text-right space-x-2 flex items-center">
									<a
										class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-full md:w-fit"
										href="{{ route('show.patient.record', ['patient' => $patient->id]) }}">
										<i class="fa-solid fa-eye"></i>
										<span class="hidden md:block">View</span>
									</a>
									@if (Auth::user()->userType === 'admin')
										<a
											class="font-medium text-white bg-orange-600 px-2 py-1 rounded hover:bg-orange-700 flex items-center justify-center gap-1 w-full md:w-fit"
											href="{{ route('patients.edit', ['patient' => $patient->id]) }}">
											<i class="fa-solid fa-pen-to-square"></i>
											<span class="hidden md:block">Edit</span>
										</a>
									@endif
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
				sortable: true,
				responsive: true
			});
		}
	</script>
</x-admin-layout>
