<x-master-layout title="Prescription | View as PDF">
	<div class="">
		<div class="max-w-3xl mx-auto bg-white rounded-lg">
			<header class="flex justify-between items-center mb-6">
				<div class="flex-1 text-left">
					<h1 class="text-2xl font-bold">Filarca-Rabena Dental Clinic</h1>
					<p class="text-sm">113 Salcedo St. Brgy 3, Vigan City, Ilocos Sur, Philippines 2700.</p>
					<p class="text-sm">Clinic Hours: Monday - Saturday 8am - 6pm | Sunday: By Appointment</p>
				</div>
				<div class="flex-none">
					<img alt="Clinic Logo" class="w-24 h-24 object-contain" src="{{ $imageSrc }}">
					{{-- <img alt="Clinic Logo" class="w-24 h-24 object-contain" src="{{ asset('images/DocClinicx.png') }}"> --}}
				</div>
			</header>

			<div class="border-b border-gray-300 mb-6"></div>

			<div class="mb-6">
				<h2 class="text-xl font-semibold">Prescription</h2>
				<p class="text-sm">Date: {{ date('F j, Y') }}</p>
			</div>

			<div class="mb-6">
				<h3 class="font-bold">Patient Information:</h3>
				<p>Name: <span class="font-medium">{{ $prescription->patient->user->full_name }}</span></p>
				<p>Age: <span class="font-medium">{{ $prescription->patient->age }}</span></p>
				<p>Address: <span class="font-medium">{{ $prescription->patient->user->address }}</span></p>
			</div>

			<div class="mb-6">
				<h3 class="font-bold">Medication Details:</h3>
				<table class="min-w-full border-collapse border border-gray-300">
					<thead>
						<tr>
							<th class="border border-gray-300 px-4 py-2 text-left">Medication</th>
							<th class="border border-gray-300 px-4 py-2 text-left w-fit">Quantity</th>
							<th class="border border-gray-300 px-4 py-2 text-left">Dosage</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($prescription->medicines as $index => $medicine)
							<tr class="hover:bg-gray-100">
								<td class="border border-gray-300 px-4 py-2">{{ $medicine }}</td>
								<td class="border border-gray-300 px-4 py-2">{{ $prescription->quantities[$index] }}</td>
								<td class="border border-gray-300 px-4 py-2">{{ $prescription->dosages[$index] }}</td>
							</tr>
						@endforeach

					</tbody>
				</table>
			</div>

			<div class="mb-6">
				<h3 class="font-bold">Instructions:</h3>
				<p class="text-sm">Take the medications as prescribed. Contact the clinic if you experience any side effects.</p>
			</div>

			<footer class="flex justify-between items-center mt-12">
				<div>

					<p class="text-sm">Doctor: Dr. {{ $prescription->provider->user->full_name }}</p>
					<p class="text-sm">Reg. No: {{ $prescription->provider->reg_number }}</p>
				</div>
				<div>
					<p class="text-sm">Signature:</p>
					<p class="text-xs">____________________</p>
				</div>
			</footer>
		</div>

	</div>
</x-master-layout>
