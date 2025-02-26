@props(['appointment'])
<div
	class="edit-appointment-status-modal hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/50 backdrop-blur-sm">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
				<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
					Edit Appointment
				</h3>
				<button
					class="edit-appointment-status-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-hide="default-modal" type="button">
					<svg aria-hidden="true" class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
						<path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							stroke="currentColor" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-5 space-y-4">
				<form action="{{ route('superadmin.update.appointment') }}" class="space-y-2" method="POST">
					@method('PATCH')
					@csrf
					<input class="appointment-id hidden" name="appointment_id" type="text">
					<input class="patient-id hidden" type="text" name="patient_id">
					<div class="w-full">
						<x-input-label :value="__('Patient Name')" for="patient-name" />
						<x-text-input autofocus class="mt-1 w-full patient-name" readonly type="text" />
					</div>
					<div class="w-full">
						<x-input-label :value="__('Service Name')" for="service-name" />
						<x-text-input autofocus class="mt-1 w-full service-name" readonly type="text" />
					</div>

					<div class="w-full">
						<x-input-label :value="__('Status')" for="status" />
						<select
							class="status mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
							id="status" name="status">
							<option value="scheduled">Scheduled</option>
							<option value="completed">Completed</option>
							<option value="no_show">No Show</option>
						</select>
						<x-input-error :messages="$errors->get('status')" class="mt-2 error-message" />
					</div>

                    <div class="w-full">
						<x-input-label :value="__('Remarks/Reason')" for="remarks" />
                        <textarea class="remarks mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="remarks" id=""></textarea>
					</div>

					<div class="write-prescription hidden gap-2 items-center w-full pt-2">
						<input class="write-prescription-checkbox rounded border-gray-300" type="checkbox" name="write_prescription" value="1">
						<x-input-label :value="__('Write prescription after submition')" />
					</div>

					<div class="flex items-center pb-2 py-6">
						<x-primary-button class="px-6">
							{{ __('Update') }}
						</x-primary-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
