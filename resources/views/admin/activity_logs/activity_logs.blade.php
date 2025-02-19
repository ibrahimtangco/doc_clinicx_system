<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Audit Trails') }}

        </h2>
    </x-slot>

    {{-- main container --}}
    <div class="py-6 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
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
                                    Log Name
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Description
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Subject
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Causer
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Old Value
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    New Value
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
                        </tr>
                    </thead>
                    <tbody id="allData">
                        @foreach ($activityLogs as $log)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="font-medium">{{ $log->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium">{{ $log->log_name }}</span>
                                </td>
                                <td class="px-6 py-4 capitalize">
                                    {{ $log->description }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($log->subject_name)
                                        <span class="font-semibold">{{ $log->subject_name }}</span>
                                    @else
                                        <span class="font-medium">{{ $log->subject_type_friendly }}</span>:
                                        <span class="font-semibold">{{ $log->subject_id }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium">{{ $log->causer_name }}</span>
                                    <span class="text-gray-600">({{ $log->causer_role }})</span>
                                </td>
                                <td class="px-6 py-4">
                                    <ul class="list-disc list-inside">
                                        @foreach ($log->old_value as $field => $value)
                                            <li class="text-sm relative">
                                                <span
                                                    class="font-semibold">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>:
                                                <span class="text-gray-700" title="{{ $value }}">
                                                    {{ \Illuminate\Support\Str::limit($value, 12, '...') ?? 'N/A' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4">
                                    <ul class="list-disc list-inside">
                                        @foreach ($log->new_value as $field => $value)
                                            <li class="text-sm relative">
                                                <span
                                                    class="font-semibold">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>:
                                                <span class="text-gray-700" title="{{ $value }}">
                                                    {{ \Illuminate\Support\Str::limit($value, 12, '...') ?? 'N/A' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $log->created_at->format('Y-m-d') }}
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
                perPage: 5,
            });
        }
    </script>
</x-admin-layout>
