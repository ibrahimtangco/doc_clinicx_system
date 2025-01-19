<x-master-layout>
	<div class="">
		<div class="max-w-4xl mx-auto bg-white rounded-lg">
			<header class="flex justify-between items-start mb-6">
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
			<p class="text-right text-sm mb-4">Date: {{ date('F j, Y') }}</p>
			<h2 class="text-2xl font-bold text-center mb-8">Transaction Records</h2>

			<div class="space-y-8">
				@foreach ($transactions as $transaction)
					<!-- Example: Second Transaction -->
					<div class="border-b pb-6 mb-6">
						<h2 class="text-lg font-semibold mb-4">Transaction Code: {{ $transaction->transaction_code }}</h2>
						<div class="grid grid-cols-2 gap-4 mb-4">
							<div><strong>Date:</strong> {{ Carbon\Carbon::parse($transaction->created_at)->format('F j, Y') }}</div>
							<div><strong>Total Quantity:</strong> {{ $transaction->total_quantity }}</div>
							<div><strong>Total Amount:</strong> Php {{ $transaction->total_amount }}</div>
						</div>

						<!-- Products purchased for this transaction -->
						<h3 class="text-lg font-semibold text-gray-700">Products Purchased</h3>
						<table class="min-w-full bg-white border border-gray-300 mt-2">
							<thead class="bg-gray-50">
								<tr>
									<th class="p-2 text-left text-gray-700">Product Name</th>
									<th class="p-2 text-left text-gray-700">Unit Price</th>
									<th class="p-2 text-left text-gray-700">Purchased Quantity</th>
									<th class="p-2 text-left text-gray-700">Total Price</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
								@foreach ($transaction->details as $details)
									<tr>
										<td class="p-2">{{ $details->product->name }}</td>
										<td class="p-2">{{ $details->price_at_time_of_sale }}</td>
										<td class="p-2">{{ $details->quantity }}</td>
										<td class="p-2">{{ $details->price_at_time_of_sale * $details->quantity }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

						<!-- Total amounts -->
						<div class="grid grid-cols-2 gap-4 mt-4">
							<div><strong>Subtotal:</strong> Php {{ $transaction->total_amount }}</div>
							<div><strong>Grand Total:</strong> Php {{ $transaction->total_amount }}</div>
						</div>
					</div>
				@endforeach
			</div>

			<footer class="mt-8 text-center">
				<p class="text-sm text-gray-600">Generated by Filarca-Rabena Dental Clinic</p>
			</footer>
		</div>
	</div>

</x-master-layout>
