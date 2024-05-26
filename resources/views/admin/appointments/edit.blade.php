<x-admin>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('View Appoinment') }}
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Appointment Details</h1>
            <div class="grid grid-cols-2 gap-8">
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
			<div class="grid grid-cols-3 gap-8">
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
			<h1 class="font-semibold text-lg mb-4">Appointment Status Update</h1>
            @if (session('success'))
				<x-alert>
					{{ session('success') }}
				</x-alert>
			@endif
            <div class=" gap-8">
                <form action="{{ route('edit-appointment', $appointmentInfo['appointment']->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex flex-col gap-2 mt-1">
                        <label for="status">Appointment Status</label>
                        <select name="status" class="p-2 rounded-md bg-gray-100/80 border-gray-300">
                            <option value="booked" {{ $appointmentInfo['appointment']->status == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="cancelled" {{ $appointmentInfo['appointment']->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $appointmentInfo['appointment']->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                    </div>

                    <div class="flex flex-col gap-2 mt-1 w-full">
                        <label for="comment">Dentist Comment</label>
                        <textarea name="comment" id="comment" class="w-full border-gray-300 rounded-md bg-gray-100/80">{{ $appointmentInfo['appointment']->comment }}</textarea>
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
</x-admin>
