<x-admin-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Patients Record') }}
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Personal Information</h1>
			<div class="md:grid grid-cols-3 gap-8 space-y-4 md:space-y-0">
				<div class="flex flex-col gap-2 mt-1">
					<label>Full Name</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->user->full_name }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Birthday</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ \Carbon\Carbon::parse($patient->birthday)->format('F j, Y') }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Age</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->age }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Civil Status</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->status }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Email Address</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->user->email }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Phone Number</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->telephone }}
					</div>
				</div>

                <div class="flex flex-col gap-2 mt-1">
					<label for="name">Address</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $patient->user->address }}
					</div>
				</div>
			</div>
		</div>
        <div class="my-8 p-8 bg-white rounded-md" >
			<div class="flex items-center mb-6 justify-between">
				<h1 class="font-semibold text-lg">Service History</h1>
			</div>
			@if (!$serviceHistories->isEmpty())
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
								<td class="px-6 py-3" scope="col"><span class="text-primary font-semibold">{{ $serviceHistory->service->name }}</span></td>
								<td class="px-6 py-3" scope="col">{{ Carbon\Carbon::parse($serviceHistory->date)->format('F j, Y') }}</td>
								<td class="px-6 py-3" scope="col">{{ $serviceHistory->time }}</td>
								<td class="px-6 py-3" scope="col">{{ $serviceHistory->remark }}</td>

						@endforeach
					</tbody>
				</table>
                <div class="p-4">
                    {{ $serviceHistories->links('pagination::tailwind') }}
                </div>
			@else
				<p>No record</p>
			@endif
		</div>
		<div class="my-8 p-8 bg-white rounded-md" >
			<div class="flex items-center mb-6 justify-between">
				<h1 class="font-semibold text-lg">Medical History</h1>
			</div>
			@if (!$medicalHistories->isEmpty())
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
								<td class="px-6 py-3" scope="col"><span class="text-primary font-semibold">{{ $medicalHistory->condition }}</span></td>
								<td class="px-6 py-3" scope="col">{{ $medicalHistory->diagnosed_date_formatted }}</td>
								<td class="px-6 py-3 font-semibold" scope="col">
                                    @if ($medicalHistory->status == 'active')
                                        <span class="text-green-500">{{ Str::ucfirst($medicalHistory->status) }}</span>
                                    @else
                                    <span class="text-red-500">{{ Str::ucfirst($medicalHistory->status) }}</span>
                                    @endif</td>
								<td class="px-6 py-3" scope="col"><button
                                    data-condition="{{ $medicalHistory->condition }}"
                                    data-diagnosed-date="{{ $medicalHistory->diagnosed_date }}"
                                    data-status="{{ $medicalHistory->status }}"
                                    data-treatment="{{ $medicalHistory->treatment }}"
                                    data-description="{{ $medicalHistory->description }}"
                                    data-id="{{ $medicalHistory->id }}"
                                    onclick="openMedicalHistoryModal(this)"
										class="view-medical-history-btn font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700">View</button></td>
							</tr>
                            <x-view_medical_history_modal :patientId="$patient->id"/>
						@endforeach
					</tbody>
				</table>
                <div class="p-4">
                    {{ $medicalHistories->links('pagination::tailwind') }}
                </div>
			@else
				<p>No record</p>
			@endif
		</div>
		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg">Delete All Patient Records</h1>
			<p class="text-sm text-text-desc">Once your account is deleted, all of its resources and data will be permanently
				deleted.</p>

			<section class="space-y-6 mt-4">
				<x-danger-button x-data=""
					x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

				<x-modal :show="$errors->userDeletion->isNotEmpty()" focusable name="confirm-user-deletion">
					<form action="{{ route('patients.destroy', ['patient' => $patient->id]) }}" class="p-6" method="post">
						@csrf
						@method('delete')

						<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
							{{ __('Are you sure you want to delete your account?') }}
						</h2>

						<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
							{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
						</p>

						<div class="mt-6 flex justify-end">
							<x-secondary-button x-on:click="$dispatch('close')">
								{{ __('Cancel') }}
							</x-secondary-button>

							<x-danger-button class="ms-3">
								{{ __('Delete Account') }}
							</x-danger-button>
						</div>
					</form>
				</x-modal>
			</section>

		</div>
	</div>

    <script>
    // Get references to the button, modal, and close button
    const viewBtns = document.querySelectorAll('.view-medical-history-btn')
    const addModal = document.querySelector('#add-medical-history-modal');
    const viewModal = document.querySelector('.view-medical-history-modal');
    const closeViewBtn = document.querySelector('.view-medical-history-close-btn');

    function formatDateTime(dateTimeString) {
        // Split the string by space and take the first part
        return dateTimeString.split(' ')[0];
    }

    function openMedicalHistoryModal(button) {

        // Get data from the button's data attributes
        const condition = button.getAttribute('data-condition');
        const diagnosedDate = button.getAttribute('data-diagnosed-date');
        const status = button.getAttribute('data-status');
        const treatment = button.getAttribute('data-treatment');
        const description = button.getAttribute('data-description');
        const id = button.getAttribute('data-id');

        document.querySelector('#edit-condition').value = condition;
        document.querySelector('#edit-diagnosed_date').value = formatDateTime(diagnosedDate);
        document.querySelector('#edit-status').value = status;
        document.querySelector('#edit-treatment').value = treatment;
        document.querySelector('#edit-description').value = description;
        document.querySelector('#edit-id').value = id;

    }


    function toggleEditModal() {
        viewModal.classList.toggle('hidden')
        viewModal.classList.toggle('flex')
    }


    viewBtns.forEach(viewBtn => {
        viewBtn.addEventListener('click', toggleEditModal);
    });

    closeViewBtn.addEventListener('click', toggleEditModal);
</script>


</x-admin>
