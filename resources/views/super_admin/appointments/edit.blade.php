<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center justify-between">
			{{ __('View Appoinment') }}
            <a href="{{ url()->previous() }}"><div><?xml version="1.0" ?><!DOCTYPE svg  PUBLIC '-//W3C//DTD SVG 1.1//EN'  'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'><svg height="32px" id="Layer_1" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M28,14H8.8l4.62-4.62C13.814,8.986,14,8.516,14,8c0-0.984-0.813-2-2-2c-0.531,0-0.994,0.193-1.38,0.58l-7.958,7.958  C2.334,14.866,2,15.271,2,16s0.279,1.08,0.646,1.447l7.974,7.973C11.006,25.807,11.469,26,12,26c1.188,0,2-1.016,2-2  c0-0.516-0.186-0.986-0.58-1.38L8.8,18H28c1.104,0,2-0.896,2-2S29.104,14,28,14z"/></svg></div> </a>
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Appointment Details</h1>
			<div class="md:grid grid-cols-2 gap-8 space-y-4 md:space-y-0">
				<div class="flex flex-col gap-2 mt-1">
					<label>Appointment Date</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ \Carbon\Carbon::parse($appointmentInfo['appointment']->date)->format('F j, Y') }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label>Appointment Time</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ \Carbon\Carbon::parse($appointmentInfo['appointment']->time)->format('H:i A') }}
					</div>
				</div>
			</div>
		</div>
		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Patient Information</h1>
			<div class="md:grid grid-cols-3 gap-8 space-y-4 md:space-y-0">
				<div class="flex flex-col gap-2 mt-1">
					<label>Full Name</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['user']->first_name }}
						@if ($appointmentInfo['user']->middle_name)
							{{ ucfirst(substr($appointmentInfo['user']->middle_name, 0, 1)) }}.
						@endif
						{{ $appointmentInfo['user']->last_name }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Birthday</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ \Carbon\Carbon::parse($appointmentInfo['patient']->birthday)->format('F j, Y') }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Age</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['patient']->age }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Civil Status</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['patient']->status }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Email Address</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['user']->email }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Phone Number</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['patient']->telephone }}
					</div>
				</div>
			</div>
		</div>
		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Service Details</h1>
			<div class="md:grid grid-cols-3 gap-8 space-y-4 md:space-y-0">
				<div class="flex flex-col gap-2 mt-1">
					<label>Service Name</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['service']->name }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label>Duration</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['service']->formatted_duration }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label>Price</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						Php {{ number_format($appointmentInfo['service']->price, 0, '.' . ',') }}
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1 col-span-3">
					<label>Description</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						{{ $appointmentInfo['service']->description }}
					</div>
				</div>
			</div>
		</div>
		<div class="my-8 p-8 bg-white rounded-md border">
			<div class="flex items-center justify-between">
				<h1 class="font-semibold text-lg mb-4">Appointment Status Update</h1>
				<a class="text-primary underline" href="{{ route('create.prescription', ['patient' => $appointmentInfo['patient']]) }}">Write prescription</a>
			</div>
			<div class=" gap-8">
				<form action="{{ route('superadmin.edit-appointment', $appointmentInfo['appointment']->id) }}" class="space-y-4"
					method="POST">
					@csrf
					<div class="flex flex-col gap-2 mt-1">
						<label for="status">Appointment Status</label>
						<select class="p-2 rounded-md bg-gray-100/80 border-gray-300" name="status">
							<option {{ $appointmentInfo['appointment']->status == 'booked' ? 'selected' : '' }} value="booked">Booked
							</option>
							<option {{ $appointmentInfo['appointment']->status == 'cancelled' ? 'selected' : '' }} value="cancelled">
								Cancelled</option>
							<option {{ $appointmentInfo['appointment']->status == 'completed' ? 'selected' : '' }} value="completed">
								Completed</option>
						</select>
					</div>

					<div class="flex flex-col gap-2 mt-1 w-full">
						<label for="remark">Dentist Remarks / <span class="text-primary">Reason for Cancel</span></label>
						<textarea class="w-full border-gray-300 rounded-md bg-gray-100/80" id="remark" name="remark">{{ $appointmentInfo['appointment']->remark }}</textarea>
					</div>

					<div class="flex justify-end mt-4">
						<x-primary-button type="submit">
							{{ __('Update') }}
						</x-primary-button>

					</div>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>
