<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Services Histories') }}
        </h2>
    </x-slot>
    <div class="py-6 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-secondary-text mb-8" id="search-table">
                    <thead class="text-xs text-primary-text uppercase bg-gray-50 border-b font-semibold">
                        <tr>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Service
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Date
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Time
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Remarks
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myServiceHistories as $history)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $history->service->name }}</td>
                                <td class="px-6 py-3" scope="col">
                                    {{ Carbon\Carbon::parse($history->reservation->date)->format('F j, Y') }}
                                </td>
                                <td class="px-6 py-3" scope="col">
                                    {{ Carbon\Carbon::parse($history->updated_at)->format('g:i A') }}
                                </td>
                                <td class="px-6 py-3" scope="col">{{ $history->remarks }}</td>
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
                perPage: 5
            });
        }
    </script>
</x-app-layout>
