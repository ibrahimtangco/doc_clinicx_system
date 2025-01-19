<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Patients Record') }}
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-2">
		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Personal Information</h1>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				<div class="flex flex-col gap-2">
					<label>Full Name</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->user->full_name }}
					</div>
				</div>
				<div class="flex flex-col gap-2">
					<label for="name">Birthday</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ \Carbon\Carbon::parse($patient->birthday)->format('F j, Y') }}
					</div>
				</div>
				<div class="flex flex-col gap-2">
					<label for="name">Age</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->age }}
					</div>
				</div>
				<div class="flex flex-col gap-2">
					<label for="name">Civil Status</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->status }}
					</div>
				</div>
				<div class="flex flex-col gap-2">
					<label for="name">Email Address</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->user->email }}
					</div>
				</div>
				<div class="flex flex-col gap-2">
					<label for="name">Phone Number</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->telephone }}
					</div>
				</div>
				<div class="flex flex-col gap-2">
					<label for="name">Address</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->user->address }}
					</div>
				</div>
			</div>
		</div>

		<div class="my-8 p-8 bg-white rounded-md">
			<div class="flex items-center mb-6 justify-between">
				<h1 class="font-semibold text-lg">Service History</h1>
				<a href="{{ route('download.patient.service.histories', ['patient' => $patient]) }}">
					<i class="fa-solid fa-download text-xl mr-4 hover:text-primary cursor-pointer"
						data-tooltip-target="tooltip-default" type="button"></i>
				</a>
				<div
					class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
					id="tooltip-default" role="tooltip">
					Download Service Histories
					<div class="tooltip-arrow" data-popper-arrow></div>
				</div>
			</div>
			@if (!$serviceHistories->isEmpty())
				<div class="overflow-x-auto">
					<table class="border w-full text-sm text-left rtl:text-right text-gray-500">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50">
							<tr>
								<th class="px-6 py-3" scope="col">Service</th>
								<th class="px-6 py-3" scope="col">Date</th>
								<th class="px-6 py-3" scope="col">Time</th>
								<th class="px-6 py-3" scope="col">Remark</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($serviceHistories as $serviceHistory)
								<tr class="border-y odd:bg-white even:bg-gray-100">
									<td class="px-6 py-3 text-primary font-semibold" scope="col">{{ $serviceHistory->service->name }}</td>
									<td class="px-6 py-3" scope="col">
										{{ Carbon\Carbon::parse($serviceHistory->reservation->date)->format('F j, Y') }}
									</td>
									<td class="px-6 py-3" scope="col">{{ Carbon\Carbon::parse($serviceHistory->updated_at)->format('g:i A') }}
									</td>
									<td class="px-6 py-3" scope="col">{{ $serviceHistory->remarks }}</td>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="p-4">
					{{ $serviceHistories->links('pagination::tailwind') }}
				</div>
			@else
				<p>No record</p>
			@endif
		</div>

		<div class="my-8 p-8 bg-white rounded-md">
			<div class="flex items-center mb-6 justify-between">
				<h1 class="font-semibold text-lg">Medical History</h1>
			</div>
			@if (!$medicalHistories->isEmpty())
				<div class="overflow-x-auto">
					<table class="border w-full text-sm text-left rtl:text-right text-gray-500">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50">
							<tr>
								<th class="px-6 py-3" scope="col">Condition</th>
								<th class="px-6 py-3" scope="col">Diagnosed Date</th>
								<th class="px-6 py-3" scope="col">Status</th>
								<th class="px-6 py-3" scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($medicalHistories as $medicalHistory)
								<tr class="border-y odd:bg-white even:bg-gray-100">
									<td class="px-6 py-3" scope="col">
										<span class="text-primary font-semibold">{{ $medicalHistory->condition }}</span>
									</td>
									<td class="px-6 py-3" scope="col">{{ $medicalHistory->diagnosed_date_formatted }}</td>
									<td class="px-6 py-3 font-semibold" scope="col">
										@if ($medicalHistory->status == 'active')
											<span class="text-green-500">{{ Str::ucfirst($medicalHistory->status) }}</span>
										@else
											<span class="text-red-500">{{ Str::ucfirst($medicalHistory->status) }}</span>
										@endif
									</td>
									<td class="px-6 py-3 gap-1 space-y-1 md:flex md:space-y-0" scope="col">
										{{-- View Medical History --}}
										<button
											class="max-w-14 w-full flex gap-1 items-center justify-center font-medium text-white bg-green-600 px-2 py-1 rounded hover:bg-green-700 md:max-w-none md:w-fit"
											data-condition="{{ $medicalHistory->condition }}" data-description="{{ $medicalHistory->description }}"
											data-diagnosed-date="{{ $medicalHistory->diagnosed_date }}" data-modal-target="view-medical-history-modal"
											data-modal-toggle="view-medical-history-modal" data-status="{{ $medicalHistory->status }}"
											data-treatment="{{ $medicalHistory->treatment }}" onclick="viewMedicalHistory(this)"><i
												class="fa-solid fa-eye"></i> <span class="hidden md:block">View</span>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@else
				<p>No record</p>
			@endif
		</div>
		<x-view_medical_history_modal />
	</div>

	<script>
		function formatDateTime(dateTimeString) {
			// Split the string by space and take the first part
			return dateTimeString.split(' ')[0];
		}

		function viewMedicalHistory(button) {
			const condition = button.getAttribute('data-condition');
			const diagnosedDate = button.getAttribute('data-diagnosed-date');
			const status = button.getAttribute('data-status');
			const treatment = button.getAttribute('data-treatment');
			const description = button.getAttribute('data-description');

			document.querySelector('#view-condition').value = condition;
			document.querySelector('#view-diagnosed_date').value = formatDateTime(diagnosedDate);
			document.querySelector('#view-status').value = status;
			document.querySelector('#view-treatment').value = treatment;
			document.querySelector('#view-description').value = description;
		}
	</script>

</x-admin-layout>
