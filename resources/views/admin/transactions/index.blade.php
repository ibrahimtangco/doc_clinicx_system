<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales Transaction') }}
        </h2>
    </x-slot>

    {{-- Main container --}}
    <div class="py-6 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:flex gap-2 items-center justify-between mb-4 flex-wrap space-y-3 md:space-y-0">
                <a class="bg-primary text-white-text py-1.5 px-4 rounded-md flex items-center justify-center text-center w-full md:w-auto"
                    href="{{ route('transactions.create') }}">
                    <i class="fa-solid fa-plus"></i> {{ __('Add') }}
                </a>
                <form action="{{ route('download.transaction.records') }}" method="POST"
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

            {{-- Table wrapper for responsiveness --}}
            <div class="overflow-x-auto">
                <table id="search-table" class="p-2 w-full text-sm text-left rtl:text-right text-gray-500">
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
                                Tranaction Code
                                <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        stroke="currentColor" />
                                </svg>
                            </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                Date
                                <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        stroke="currentColor" />
                                </svg>
                            </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                Total Quantity
                                <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        stroke="currentColor" />
                                </svg>
                            </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                Total Amount
                                <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24" viewBox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        stroke="currentColor" />
                                </svg>
                            </span></th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody id="allData">
                        @foreach ($transactions as $transaction)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $transaction->id }}</td>
                                <td class="px-6 py-4">{{ $transaction->transaction_code }}</td>
                                <td class="px-6 py-4">{{ $transaction->created_at->format('F j, Y, g:i a') }}</td>
                                <td class="px-6 py-4">{{ $transaction->total_quantity }}</td>
                                <td class="px-6 py-4">Php {{ $transaction->total_amount }}</td>
                                <td class="px-6 py-4 text-right space-x-2 flex items-center">
                                    <button data-modal-target="myModal" data-modal-toggle="myModal"
                                        data-transaction="{{ json_encode($transaction) }}"
                                        class="modal-btn font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center gap-1">
                                        <i class="fa-solid fa-eye"></i> <span class="hidden md:block">View</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-transaction_details />
    <script src="{{ asset('js/transaction_details.js') }}"></script>
    <script>
		if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
			const dataTable = new simpleDatatables.DataTable("#search-table", {
				searchable: true,
				sortable: true,
				responsive: true
			});
		}
	</script>
</x-admin-layout>
