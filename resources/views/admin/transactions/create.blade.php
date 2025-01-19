<x-admin-layout :title="$title">

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			<a href="">{{ __('Transaction') }}</a>
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<div class="">
					<section>
						<header class="flex items-center justify-between">
							<div class="">
								<h2 class="text-lg font-medium text-gray-900">
									{{ __('Add Transaction') }}
								</h2>

								<p class="mt-1 text-sm text-gray-600">
									{{ __('Fill in the required details to add transaction.') }}
								</p>
							</div>

							<button
								class="add-row text-white bg-blue-600 hover:bg-blue-700 py-2 border border-blue-600 rounded block mt-1 uppercase font-semibold w-40"
								type="button">Add</button>
						</header>

						<form action="{{ route('transactions.store') }}" class="mt-6 space-y-6" id="myForm" method="post">
							@csrf
							@if ($errors->any())
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li class="text-sm text-red-500">{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<table class="w-full text-sm text-left rtl:text-right text-gray-500">
								<thead class="text-xs text-gray-700 uppercase bg-gray-50 border">
									<tr>
										<th class="px-6 py-3" scope="col">Product Name</th>
										<th class="px-6 py-3" scope="col">Quantity (pcs)</th>
										<th class="px-6 py-3" scope="col">Action</th>
									</tr>
								</thead>
								<tbody id="tbody">
									{{-- <tr class="mt-2">
										<td class="mt-4 p-2 border">

											<select class="product_id" name="products[0][product_id]">
												<option value="">-- Select Product --</option>
												@foreach ($products as $product)
													<option {{ old('products.0.product_id') == $product->id ? 'selected' : '' }} value="{{ $product->id }}">
														{{ $product->name }}</option>
												@endforeach
											</select>
											<x-input-error :messages="$errors->get('products.0.product_id')" class="mt-2" />
										</td>

										<td class="mt-4 p-2 border">
											<input autocomplete="quantity" autofocus
												class="quantity w-full focus:border-blue-700 focus:ring-blue-700 rounded-[4px] h-[26px] py-[13px] font-normal text-sm text-gray-700 border-gray-400"
												id="quantity" name="products[0][quantity]" placeholder="Quantity" type="number"
												value="old('products.0.quantity')" />
											<x-input-error :messages="$errors->get('products.0.quantity')" class="mt-2" />
										</td>

										<td class="mt-4 p-2 border">

											<button
												class="remove text-white bg-red-600 hover:bg-red-700 py-2 border border-red-600 rounded block mt-1 w-full uppercase font-semibold"
												type="button">Remove</button>
										</td>
									</tr> --}}
								</tbody>
							</table>

							<div class="flex items-center gap-4">
								<x-primary-button id="open-modal">{{ __('Create') }}</x-primary-button>
							</div>
						</form>
					</section>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			// Function to store product and quantity in sessionStorage
			function storeInSession(rowIndex, productValue, quantityValue) {
				sessionStorage.setItem(`row_${rowIndex}`, JSON.stringify({
					product: productValue,
					quantity: quantityValue
				}));
			}

			function hasProductKeys() {
				let hasProductKey = false;
				for (let i = 0; i < sessionStorage.length; i++) {
					const key = sessionStorage.key(i);
					if (key.startsWith('row_')) {
						hasProductKey = true;
						break;
					}
				}
				return hasProductKey;
			}

			// Function to retrieve stored data from sessionStorage
			function loadFromSession() {
				if (!hasProductKeys()) {
					$('#tbody').append(`
					<tr class="mt-2">
						<td class="mt-4 p-2 border">
							<select class="product_id" name="products[0][product_id]">
								<option value="">-- Select Product --</option>
								@foreach ($products as $index => $product)
									<option value="{{ $product->id }}">{{ $product->name }}</option>
								@endforeach
							</select>
						</td>
						<td class="mt-4 p-2 border">
							<input value="" autocomplete="quantity" class="quantity w-full focus:border-blue-700 focus:ring-blue-700 rounded-[4px] h-[26px] py-[13px] font-normal text-sm text-gray-700 border-gray-400" name="products[0][quantity]" placeholder="Quantity" type="number" />
						</td>
						<td class="mt-4 p-2 border">
							<button type="button" class="remove text-white bg-red-600 hover:bg-red-700 py-2 border border-red-600 rounded block mt-1 w-full uppercase font-semibold">Remove</button>
						</td>
					</tr>
				`);
					$('.product_id').last().select2({
						width: '100%'
					});
				}
				// Get all keys that start with 'row_' and sort them by their numeric index
				const sortedKeys = Object.keys(sessionStorage)
					.filter(key => key.startsWith('row_'))
					.sort((a, b) => {
						// Extract numeric parts from 'row_x' and compare them
						const indexA = parseInt(a.split('_')[1]);
						const indexB = parseInt(b.split('_')[1]);
						return indexA - indexB;
					});

				let i = 0;

				// Iterate over the sorted keys and load the data into the UI
				sortedKeys.forEach(function(key) {
					const rowData = JSON.parse(sessionStorage.getItem(key));
					$('#tbody').append(`
        <tr class="mt-2">
            <td class="mt-4 p-2 border">
                <select class="product_id" name="products[${i}][product_id]">
                    <option value="">-- Select Product --</option>
                    @foreach ($products as $index => $product)
                        <option value="{{ $product->id }}" ${rowData.product == "{{ $product->id }}" ? 'selected' : ''}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="mt-4 p-2 border">
                <input value="${rowData.quantity}" class="quantity w-full focus:border-blue-700 focus:ring-blue-700 rounded-[4px] h-[26px] py-[13px] font-normal text-sm text-gray-700 border-gray-400" name="products[${i}][quantity]" placeholder="Quantity" type="number" />
            </td>
            <td class="mt-4 p-2 border">
                <button type="button" class="remove text-white bg-red-600 hover:bg-red-700 py-2 border border-red-600 rounded block mt-1 w-full uppercase font-semibold">Remove</button>
            </td>
        </tr>
        `);
					i++;
				});

				// Initialize Select2 for the loaded rows
				$('.product_id').select2({
					width: '100%'
				});
				$('.product_id').select2({
					width: '100%'
				});
			}

			loadFromSession();

			// Function to validate existing rows
			function validateRows() {
				let isValid = true;
				$('#tbody tr').each(function() {
					const product = $(this).find('.product_id').val();
					const quantity = $(this).find('.quantity').val();
					const productCell = $(this).find('.product_id').closest('td');
					const quantityCell = $(this).find('.quantity').closest('td');

					productCell.find('.product-error').remove();
					quantityCell.find('.quantity-error').remove();

					if (!product) {
						isValid = false;
						productCell.append(
							'<span class="product-error text-red-600">Product is required.</span>');
					}
					if (!quantity) {
						isValid = false;
						quantityCell.append(
							'<span class="quantity-error text-red-600">Quantity is required.</span>');
					}
				});
				return isValid;
			}

			// Update session storage after removing a row
			function updateSessionAfterRemoval() {
				$('#tbody tr').each(function(index) {
					// First clear all row-related sessionStorage items
					Object.keys(sessionStorage).forEach(function(key) {
						if (key.startsWith('row_')) {
							sessionStorage.removeItem(key);
						}
					});

					// Re-store each row with the correct index
					$('#tbody tr').each(function(index) {
						const productValue = $(this).find('.product_id').val();
						const quantityValue = $(this).find('.quantity').val();

						// Store the updated row data in sessionStorage with the new index
						storeInSession(index, productValue, quantityValue);
					});
				});
			}

			$('#tbody').on('change', '.product_id', function(e) {
				const row = $(e.target).closest('tr');
				const rowIndex = row.index();
				const productValue = e.target.value;
				const quantity = row.find('.quantity').val();

				storeInSession(rowIndex, productValue, quantity);
			});

			$('#tbody').on('input', '.quantity', function(e) {
				const row = $(e.target).closest('tr');
				const rowIndex = row.index();
				const productValue = row.find('.product_id').val();
				const quantityValue = e.target.value;

				storeInSession(rowIndex, productValue, quantityValue);
			});

			$('.add-row').click(function() {
				if (!validateRows()) return;

				const newIndex = $('#tbody tr').length;

				$('#tbody').append(`
				<tr class="mt-2">
					<td class="mt-4 p-2 border">
						<select class="product_id" name="products[${newIndex}][product_id]">
							<option value="">-- Select Product --</option>
							@foreach ($products as $index => $product)
								<option value="{{ $product->id }}">{{ $product->name }}</option>
							@endforeach
						</select>
					</td>
					<td class="mt-4 p-2 border">
						<input value="" class="quantity w-full focus:border-blue-700 focus:ring-blue-700 rounded-[4px] h-[26px] py-[13px] font-normal text-sm text-gray-700 border-gray-400" name="products[${newIndex}][quantity]" placeholder="Quantity" type="number" />
					</td>
					<td class="mt-4 p-2 border">
						<button type="button" class="remove text-white bg-red-600 hover:bg-red-700 py-2 border border-red-600 rounded block mt-1 w-full uppercase font-semibold">Remove</button>
					</td>
				</tr>
			`);
				$('.product_id').last().select2({
					width: '100%'
				});
			});

			// Handle row removal and update sessionStorage keys
			$('#tbody').on('click', '.remove', function() {
				const row = $(this).closest('tr'); // Find the row
				const rowIndex = row.index(); // Get the row index

				// Remove the item from sessionStorage for the deleted row
				sessionStorage.removeItem(`row_${rowIndex}`);

				// Remove the row from the DOM
				row.remove();

				// Reindex the remaining rows in sessionStorage to match their new indices
				updateSessionAfterRemoval();
			});

            // Clear session storage on page unload
            window.addEventListener('beforeunload', () => {
                sessionStorage.clear();
            });
		});

	</script>

</x-admin-layout>
