<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Appoinment Details') }}
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="my-6 p-6 bg-white rounded-lg border shadow-sm">
			<div>
				<p class="text-2xl font-medium flex items-center gap-2">{{ $appointment->reservation->patient->user->full_name }}</p>
				<p class="text-xs text-text-desc flex gap-1 items-center">
				<i class="fa-regular fa-calendar-days text-[10px]"></i> Joined Since: {{ Carbon\Carbon::parse($appointment->reservation->patient->created_at)->format('j F Y') }}
				</p>
			</div>

			{{-- personal info and appointment info container --}}
			<div class="grid grid-cols-3 gap-6 mt-8">
				{{-- basic info --}}
				<div class="border border-gray-300 p-6 rounded-lg col-span-1">
					<h2 class="text-title font-bold">Basic Information</h2>
					<div class="mt-6 space-y-6">
						<div class="flex gap-4 items-start text-gray-400">
							<div>
								<i class="fa-solid fa-cake-candles text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Birthday</p>
								<p class="text-text-title">
									{{ Carbon\Carbon::parse($appointment->reservation->patient->birthday)->format('j F Y') }}</p>
							</div>
						</div>
						<div class="flex gap-4 items-start text-gray-400">
							<div>
								<i class="fa-solid fa-circle text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Civil Status</p>
								<p class="text-text-title">{{ $appointment->reservation->patient->status }}</p>
							</div>
						</div>
						<div class="flex gap-4 items-start text-gray-400">
							<div>
								<i class="fa-solid fa-phone text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Phone Number</p>
								<p class="text-text-title">{{ $appointment->reservation->patient->telephone }}</p>
							</div>
						</div>
						<div class="flex gap-4 items-start text-gray-400">
							<div>
								<i class="fa-solid fa-envelope text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Email Address</p>
								<p class="text-text-title">{{ $appointment->reservation->patient->user->email }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="border border-gray-300 p-6 rounded-lg col-span-2">
					<h2 class="text-title font-bold">Appointment Information</h2>
					<div class="mt-6 gap-6 grid grid-cols-3">
						<div class="flex gap-4 items-start text-gray-400 col-span-1">
							<div>
								<i class="fa-solid fa-tooth text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Dental Service</p>
								<p class="text-text-title">{{ $appointment->reservation->service->name }}</p>
							</div>
						</div>
						{{--  --}}
						<div class="flex gap-4 items-start text-gray-400 col-span-2">
							<div>
								<i class="fa-solid fa-calendar-days text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Date</p>
								<p class="text-text-title">{{ Carbon\Carbon::parse($appointment->reservation->date)->format('j F Y') }}</p>
							</div>
						</div>
						<div class="flex gap-4 items-start text-gray-400 col-span-1">
							<div>
								<i class="fa-solid fa-clock text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Schedule</p>
								<p class="text-text-title">{{ $appointment->reservation->preferred_schedule }}</p>
							</div>
						</div>
						<div class="flex gap-4 items-start text-gray-400 col-span-2">
							<div>
								<i class="fa-solid fa-hourglass-start text-gray-600"></i>
							</div>
							<div class="space-y-1">
								<p class="text-sm font-medium">Queue Number</p>
								<p class="text-text-title">{{ $appointment->reservation->queue_number }}</p>
							</div>
						</div>
						<div class="flex gap-4 items-start text-gray-400 col-span-1">
							<div>

								<i class="fa-solid fa-circle-question text-gray-600"></i>
							</div>
							<div class="space-y-1 w-full">
								<p class="text-sm font-medium">Status</p>
								@php
									$statusClasses = [
									    'scheduled' => 'bg-yellow-500',
									    'no_show' => 'bg-red-500',
									    'completed' => 'bg-green-500',
									];
								@endphp
								<p class="capitalize {{ $statusClasses[$appointment->status] }} text-white px-1 text-sm rounded w-fit">
									@if ($appointment->status === 'no_show')
										No Show
									@else
										{{ $appointment->status }}
									@endif
								</p>
							</div>
						</div>
						<div class="flex gap-4 items-start text-gray-400 col-span-2">
							<div>
								<i class="fa-solid fa-disease text-gray-600"></i>
							</div>
							<div class="space-y-1 w-full">
								<p class="text-sm font-medium">Current Condition</p>
								<p class="text-text-title bg-gray-100 p-2 rounded">{{ $appointment->reservation->current_condition }}</p>
							</div>
						</div>

						@if ($appointment->remarks)
							<div class="flex gap-4 items-start text-gray-400 col-span-3">
								<div>
									<i class="fa-solid fa-message text-gray-600"></i>
								</div>
								<div class="space-y-1 w-full">
									<p class="text-sm font-medium">Additional Remarks:</p>
									<p class="text-text-title bg-gray-100 p-2 rounded">{{ $appointment->remarks }}</p>
								</div>
						@endif
					</div>

				</div>
			</div>
		</div>
	</div>
	</div>
</x-admin-layout>
