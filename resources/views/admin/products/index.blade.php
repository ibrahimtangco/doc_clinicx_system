<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Product Inventory') }}

		</h2>
	</x-slot>

	{{-- main container --}}
	<div class="py-6 px-4">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{--  --}}
            <div class="md:flex gap-2 items-center justify-between mb-4 flex-wrap space-y-3 md:space-y-0">
                <a class="bg-primary text-white-text py-1.5 px-4 rounded-md flex items-center justify-center text-center w-full md:w-auto"
                    href="{{ route('products.create') }}">
                    <i class="fa-solid fa-plus"></i> {{ __('Add') }}
                </a>
                {{-- download --}}
                <form action="{{ route('download.product.list') }}" method="POST"
                    class="w-full md:w-auto md:flex items-center gap-4 space-y-3 md:space-y-0">
                    @csrf
                    <div class="flex items-center flex-wrap gap-2 w-full md:flex-nowrap" date-rangepicker id="date-range-picker">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <i class="fa-solid fa-calendar-days text-text-desc"></i>
                            </div>
                            <input type="text" id="datepicker-range-start" name="start" placeholder="Select date start"
                                autocomplete="off"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2">
                            <x-input-error :messages="$errors->get('start')" class="mt-2" />
                        </div>
                        <span class="mx-4 text-gray-500">to</span>
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <i class="fa-solid fa-calendar-days text-text-desc"></i>
                            </div>
                            <input type="text" id="datepicker-range-end" name="end" placeholder="Select date end"
                                autocomplete="off"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2">
                            <x-input-error :messages="$errors->get('end')" class="mt-2" />
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full md:w-fit bg-green-600 text-white-text py-1.5 px-4 rounded-md hover:bg-green-700 flex items-center justify-center">
                        <i class="fa-regular fa-file-pdf"></i> {{ __('Export') }}
                    </button>
                </form>
            </div>
            {{--  --}}
			<div class="overflow-x-auto">
				<table class="p-2 w-full text-sm text-left rtl:text-right text-gray-500" id="search-table">
					<thead class="text-xs text-gray-700 uppercase bg-gray-50">
						<tr>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                Id
                                <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        stroke="currentColor" />
                                </svg>
                            </span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Name
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Category
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Unit of Meas.
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Quantity
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3 text-right" scope="col"><span class="flex items-center">
									Buying Price
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3 text-right" scope="col"><span class="flex items-center">
									Selling Price
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24"
										width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="flex items-center">
									Status
									<svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24"
										width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" />
									</svg>
								</span></th>
							<th class="px-6 py-3" scope="col"><span class="hidden md:block">Action</span></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($products as $product)
							<tr class="bg-white border-b hover:bg-gray-50">
								<td class="px-6 py-4">{{ $product->id }}</td>
								<td class="px-6 py-4">{{ $product->name }}</td>
								<td class="px-6 py-4">{{ $product->category->name }}</td>
								<td class="px-6 py-4 whitespace-nowrap">{{ $product->unit_type->name }}
									{{ $product->unit_type->abbreviation }}
								</td>
								<td class="px-6 py-4 text-nowrap">
                                    {{ $product->quantity }}
                                    @if ($product->quantity <= $product->minimum_stock)
                                    <span class="bg-red-500 px-1 py-.5 rounded text-white">Low</span>
                                 @endif
                                </td>
								<td class="px-6 py-4 text-nowrap text-right">Php {{ $product->buying_price }}</td>
								<td class="px-6 py-4 text-nowrap text-right">Php {{ $product->selling_price }}</td>
								<td class="px-6 py-4">
									<span class="{{ $product->status ? 'text-green-500' : 'text-red-500' }}">
										{{ $product->status ? 'Available' : 'Not Available' }}
									</span>
								</td>
								<td class="px-6 py-4 text-right flex items-center justify-center gap-1">
									<a
										class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
										href="{{ route('products.edit', $product->id) }}">
										<svg fill="none" height="15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											stroke="currentColor" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
											<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
											<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
										</svg>
										<span class="hidden md:block">Edit</span>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script>
		if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
			const dataTable = new simpleDatatables.DataTable("#search-table", {
				searchable: true,
				sortable: true,
				responsive: true
			});
		}
	</script>
	</x-admin>
