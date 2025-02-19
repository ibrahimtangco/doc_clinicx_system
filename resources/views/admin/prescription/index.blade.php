<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Prescriptions') }}
        </h2>
    </x-slot>

    {{-- main container --}}
    <div class="py-6 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full py-2">
                <div class="relative w-full overflow-x-auto">
                    <table class="p-2 w-full text-sm text-left rtl:text-right text-gray-500" id="search-table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                        Id
                                        <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                            viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                        </svg>
                                    </span></th>
                                <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                        Patient Name
                                        <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                            viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                        </svg>
                                    </span></th>
                                <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                        Medicines
                                        <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                            viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                        </svg>
                                    </span></th>
                                <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                        Quantities
                                        <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                            viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                        </svg>
                                    </span></th>
                                <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                        Dosages
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
                                <th class="px-6 py-3" scope="col"><span>Action</span></th>
                            </tr>
                        </thead>
                        <tbody id="allData">
                            @foreach ($prescriptions as $prescription)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $prescription->id }}</td>
                                    <td class="px-6 py-4">{{ $prescription->patient->user->full_name }}</td>
                                    <td class="px-6 py-4 space-y-1">
                                        @foreach ($prescription->medicines as $medicine)
                                            <p>{{ $medicine }}</p>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 space-y-1">
                                        @foreach ($prescription->quantities as $quantity)
                                            <p>{{ $quantity }}</p>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 space-y-1">
                                        @foreach ($prescription->dosages as $dosage)
                                            <p>{{ $dosage }}</p>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 space-y-1">
                                        {{ Carbon\Carbon::parse($prescription->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 text-right gap-2 flex items-center">
                                        <a class="font-medium text-white bg-green-600 px-2 py-1 rounded hover:bg-green-700 flex items-center justify-center gap-1 w-fit"
                                            href="{{ route('admin.prescriptions.downloadPDF', ['prescription' => $prescription->id]) }}">
                                            <i class="fa-solid fa-download"></i>
                                            <span class="hidden md:block">Download</span>
                                        </a>
                                        <a class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
                                            href="{{ route('admin.prescriptions.previewPDF', ['prescription' => $prescription->id]) }}"
                                            target="_blank">
                                            <i class="fa-solid fa-eye"></i>
                                            <span class="hidden md:inline">View</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: true
            });
        }
    </script>
</x-admin-layout>
