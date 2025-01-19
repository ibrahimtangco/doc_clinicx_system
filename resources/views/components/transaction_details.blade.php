<!-- Main modal -->
<div aria-hidden="true"
	class="hidden fixed inset-0 z-50 justify-center items-center w-full h-screen bg-black bg-opacity-50"
	id="myModal" tabindex="-1">
	<div class="relative w-full max-w-6xl max-h-full p-4 sm:p-6">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow-md">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 border-b rounded-t md:p-5">
				<h3 class="text-lg font-semibold text-gray-900" id="transaction-code">
					<!-- Dynamic Transaction Code -->
				</h3>
				<button
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
					data-modal-hide="myModal" type="button">
					<svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
						<path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							stroke="currentColor" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 space-y-4 overflow-auto md:p-5 max-h-[70vh]">
				<table class="w-full text-sm text-center text-gray-500">
					<thead class="text-xs uppercase bg-primary text-white">
						<tr>
							<th class="px-4 py-2 border-r" scope="col">Product Name</th>
							<th class="px-4 py-2 border-r" scope="col">Price</th>
							<th class="px-4 py-2 border-r" scope="col">Purchased Quantity</th>
							<th class="px-4 py-2" scope="col">Total Price</th>
						</tr>
					</thead>
					<tbody id="modal-product-details" class="divide-y divide-gray-200">
						<!-- Dynamic Content -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
