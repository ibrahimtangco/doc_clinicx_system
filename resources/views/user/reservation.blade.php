<x-app-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Reserve Appointment') }} 
		</h2>
	</x-slot>
	{{-- breadcrumbs --}}

	<div class="py-4">

		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="overflow-hidden">
				<form action="{{ route('user.reserve.store', ['service' => $service]) }}" class="flex flex-col gap-4 max-w-xl" method="POST">
					@csrf
					<div class="w-full">
						<x-input-label :value="__('Selected Service')" for="Service" />
						<x-text-input class="mt-2 w-full" disabled type="text" value="{{ $service->name }}" />
					</div>
					<div class="w-full">
						<x-input-label :value="__('Available Date')" for="date" />
						<select class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
							id="date-select" name="date">
                            <option value="">Select Date</option>
							@foreach ($availableDates as $availableDate)
								<option value="{{ $availableDate->date }}">{{ Carbon\Carbon::parse($availableDate->date)->format('F j, Y') }}
								</option>
							@endforeach
						</select>
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />

					</div>
					<div class="w-full">
						<x-input-label :value="__('Preferred Schedule')" for="preferred_schedule" />
						<select class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
							id="slot-select" name="preferred_schedule">

						</select>
                        <x-input-error :messages="$errors->get('preferred_schedule')" class="mt-2" />
                        <div class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2 no_available_error"></div>
					</div>
					<div class="w-full">
						<x-input-label :value="__('Current Condition')" for="current_condition" />
						<textarea class="mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
						 id="current_condition" name="current_condition" rows="2"></textarea>
						<x-input-error :messages="$errors->get('current_condition')" class="mt-2 error-mesage" />
					</div>
					<div class="flex items-center pb-2">
						<x-primary-button class=" px-6 w-full md:w-fit">
							{{ __('Reserve') }}
						</x-primary-button>

					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#date-select').change(function() {
				const selectedDate = $(this).val();
				if (selectedDate) {
					$.ajax({
						url: `/capacity/${selectedDate}`,
						type: 'GET',
						success: function(response) {
                            console.log(response)
                            if(response['no_available']) {
                                $('.no_available_error').html(response['no_available'])
                            } else {
                                $('.no_available_error').html('')
                            }
							const {
								am_capacity,
								pm_capacity
							} = response;

							// Clear the Slot options
							$('#slot-select').empty();

							// Check capacities and add appropriate options
							if (am_capacity > 0) {
								$('#slot-select').append('<option value="AM">AM</option>');
							}
							if (pm_capacity > 0) {
								$('#slot-select').append('<option value="PM">PM</option>');
							}

							// If both capacities are zero, show a message or handle as needed
							if (am_capacity === 0 && pm_capacity === 0) {
								$('#slotSelect').append(
									'<option value="">No slots available</option>');
							}
						},
						error: function(status) {
                            console.log(status)
							alert('Unable to fetch capacity data for the selected date. Try again later');
						}
					});
				}
                else{
                    $('#slot-select').empty();
                }
			});
		});
	</script>
</x-app-layout>
