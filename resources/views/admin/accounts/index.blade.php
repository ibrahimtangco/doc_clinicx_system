<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Accounts') }}

        </h2>
    </x-slot>

    {{-- main container --}}
    <div class="py-6 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-end mb-4">
                @if (Auth::user()->userType === 'admin')
                    <a class="bg-primary text-white-text py-1 px-2 rounded-md flex items-center justify-center gap-1 w-full md:w-auto"
                        href="{{ route('admin.accounts.create') }}">
                        <i class="fa-solid fa-plus"></i> {{ __('Add') }}
                    </a>
                @endif
            </div>

            <div class="overflow-x-auto">
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
                                    Name
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Address
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Email
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Role
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>

                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Status
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            @if (Auth::user()->userType === 'admin')
                                <th class="px-6 py-3" scope="col">
                                    <span>Action</span>
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="allData">
                        @foreach ($employees as $user)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap" scope="row">
                                    {{ $user->id }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap" scope="row">
                                    {{ $user->full_name }}
                                </td>
                                <td class="px-6 py-4 " scope="row">
                                    {{ $user->address }}
                                </td>
                                <td class="px-6 py-4 ">{{ $user->email }}</td>

                                <td class="px-6 py-4 capitalize text-primary font-semibold">{{ $user->userType }}</td>
                                <td class="px-6 py-4 {{ $user->is_active ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                                @if (Auth::user()->userType === 'admin')
                                    <td class="px-6 py-4 text-right space-x-2 flex items-center justify-center">
                                        <a class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
                                            href="{{ route('admin.accounts.edit', ['account' => $user->id]) }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span class="hidden md:block">Edit</span>
                                        </a>
                                    </td>
                                @endif
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
