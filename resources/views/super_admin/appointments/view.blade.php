<x-app-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Appoinments') }}
		</h2>
	</x-slot>

	<div class="py-6 px-4">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="overflow-x-auto">
				<table class="w-full text-sm text-left rtl:text-right text-secondary-text mt-4 mb-8" id="search-table">
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
									Procedure
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
									Remarks
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
									@if ($appointment->status === 'no_show')
										No Show
									@else
										{{ $appointment->status }}
									@endif
								</td>
								<td class="px-6 py-4">
									{{ $appointment->remarks }}
								</td>
								<td class="px-6 py-4">
									{{ $appointment->queue_number }}
								</td>
								<td class="px-6 py-3 flex items-center gap-1">
									<a
										class="font-medium text-white bg-orange-600 px-2 py-1 rounded hover:bg-orange-700 flex items-center justify-center gap-1 w-fit"
										href="{{ route('superadmin.appointment-details.view', ['appointment' => $appointment]) }}">
										<svg fill="none" height="15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
											<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
											<path d="M12 9a3 3 0 1 0 0 6 3 3 0 1 0 0-6z"></path>
										</svg>
										<span class="hidden md:inline">View</span>
									</a>
									@if ($appointment->status !== 'scheduled')
										<button
											class="font-medium text-white bg-blue-600/50 px-2 py-1 rounded flex items-center justify-center gap-1 w-fit"
											disabled>
											<?xml version="1.0" ?><svg height="15px" version="1.1" viewBox="0 0 18 18" width="15px"
												xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"
												xmlns="http://www.w3.org/2000/svg">
												<title />
												<desc />
												<defs />
												<g fill-rule="evenodd" fill="none" id="Page-1" stroke-width="1" stroke="none">
													<g fill="currentColor" id="Core" transform="translate(-213.000000, -129.000000)">
														<g id="create" transform="translate(213.000000, 129.000000)">
															<path
																d="M0,14.2 L0,18 L3.8,18 L14.8,6.9 L11,3.1 L0,14.2 L0,14.2 Z M17.7,4 C18.1,3.6 18.1,3 17.7,2.6 L15.4,0.3 C15,-0.1 14.4,-0.1 14,0.3 L12.2,2.1 L16,5.9 L17.7,4 L17.7,4 Z"
																id="Shape" />
														</g>
													</g>
												</g>
											</svg>
											<span class="hidden md:inline">Edit</span>
										</button>
									@else
										<button
											class="edit-appointment-status-open font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
											data-appointment-id="{{ $appointment->id }}" data-appointment-status="{{ $appointment->status }}"
											data-patient-id="{{ $appointment->reservation->patient->id }}"
											data-patient-name="{{ $appointment->reservation->patient->user->full_name }}"
											data-service-name="{{ $appointment->reservation->service->name }}"
											onclick="openEditAppointmentStatus(this)">
											<?xml version="1.0" ?><svg height="15px" version="1.1" viewBox="0 0 18 18" width="15px"
												xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"
												xmlns="http://www.w3.org/2000/svg">
												<title />
												<desc />
												<defs />
												<g fill-rule="evenodd" fill="none" id="Page-1" stroke-width="1" stroke="none">
													<g fill="currentColor" id="Core" transform="translate(-213.000000, -129.000000)">
														<g id="create" transform="translate(213.000000, 129.000000)">
															<path
																d="M0,14.2 L0,18 L3.8,18 L14.8,6.9 L11,3.1 L0,14.2 L0,14.2 Z M17.7,4 C18.1,3.6 18.1,3 17.7,2.6 L15.4,0.3 C15,-0.1 14.4,-0.1 14,0.3 L12.2,2.1 L16,5.9 L17.7,4 L17.7,4 Z"
																id="Shape" />
														</g>
													</g>
												</g>
											</svg>
											<span class="hidden md:inline">Edit</span>
										</button>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>
	<x-update_appointment_status />
	<script>
		const editAppointmentBtns = document.querySelectorAll('.edit-appointment-status-open');
		const editAppointmentModal = document.querySelector('.edit-appointment-status-modal');
		const editAppointmentModalClose = document.querySelector('.edit-appointment-status-close');
		const status = document.querySelector('#status');
		const prescriptionOption = document.querySelector('.write-prescription-checkbox'); // Checkbox for writing prescription
		let patientId;

		function openEditAppointmentStatus(button) {
			// Get references to elements
			const appointmentId = document.querySelector('.appointment-id');
			const patientName = document.querySelector('.patient-name');
			const appointmentStatus = document.querySelector('.status');
			const serviceName = document.querySelector('.service-name');
			const patientID = document.querySelector('.patient-id');

			// Set values from button attributes
			appointmentId.value = button.getAttribute('data-appointment-id');
			patientName.value = button.getAttribute('data-patient-name');
			appointmentStatus.value = button.getAttribute('data-appointment-status');
			serviceName.value = button.getAttribute('data-service-name');
			patientID.value = button.getAttribute('data-patient-id');
			patientId = button.getAttribute('data-patient-id');

			// Show the modal
			editAppointmentModal.classList.toggle('flex');
			editAppointmentModal.classList.toggle('hidden');

			// Add event listener to status dropdown
			appointmentStatus.addEventListener('change', () => {
				const val = appointmentStatus.value;

				// Show or hide prescription option based on status value
				if (val === 'completed') {
					prescriptionOption.parentElement.classList.add('flex');
					prescriptionOption.parentElement.classList.remove('hidden');
				} else {
					prescriptionOption.parentElement.classList.remove('flex');
					prescriptionOption.parentElement.classList.add('hidden');
				}
			});
		}

		// Handle modal close
		editAppointmentModalClose.addEventListener('click', () => {
			editAppointmentModal.classList.add('hidden');
			editAppointmentModal.classList.remove('flex');
		});
	</script>

	<script>
		if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
			const dataTable = new simpleDatatables.DataTable("#search-table", {
				searchable: true,
				sortable: true,
				perPage: 5
			});
		}
	</script>
</x-app-layout>
