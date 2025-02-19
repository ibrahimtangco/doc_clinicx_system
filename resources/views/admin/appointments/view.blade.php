<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reservations') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-secondary-text mt-4 mb-8 p-2"
                    id="search-table">
                    <thead class="text-xs text-primary-text uppercase bg-gray-50 border-b font-semibold">
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
                                    Service
                                    <svg aria-hidden="true" class="w-4 h-4 ms-1" fill="none" height="24"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8 15 4 4 4-4m0-6-4-4-4 4" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                                    </svg>
                                </span></th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Current Condition
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
                            <th class="px-6 py-3" scope="col">
                                Date
                            </th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Queue Number
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
                            <th class="px-6 py-3" scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="all-appointments">
                        @foreach ($reservations as $reservation)
                            <tr class="odd:bg-white even:bg-gray-100 border-b font-medium">
                                <td class="px-6 py-3">
                                    {{ $reservation->id }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $reservation->patient->user->full_name }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $reservation->service->name }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $reservation->current_condition }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ Carbon\Carbon::parse($reservation->date)->format('F j, Y') }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $reservation->preferred_schedule }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $reservation->queue_number ?? '---------------' }}
                                </td>
                                @php
                                    $statusClasses = [
                                        'pending' => 'text-yellow-500',
                                        'declined' => 'text-red-500',
                                        'approved' => 'text-green-500',
                                    ];
                                @endphp

                                <td
                                    class="px-6 py-4 {{ $statusClasses[$reservation->status] ?? 'text-gray-500' }} capitalize italic font-bold">
                                    {{ $reservation->status }}
                                </td>
                                <td
                                    class="px-6 py-3 flex flex-col justify-between items-center gap-1 xl:block xl:space-x-1">
                                    @if ($reservation->status !== 'pending')
                                        <button
                                            class="font-medium text-white bg-blue-600/50 px-2 py-1 rounded flex items-center justify-center gap-1 w-fit"
                                            disabled>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </button>
                                    @else
                                        <button
                                            class="edit-reservation-status-open font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
                                            data-patient-name="{{ $reservation->patient->user->full_name }}"
                                            data-reservation-id="{{ $reservation->id }}"
                                            data-reservation-status="{{ $reservation->status }}"
                                            onclick="openEditReservationStatus(this)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            <x-update-reservation-status />
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/filterByStatus.js') }}"></script>
    <script src="{{ asset('js/filterByDate.js') }}"></script>

    <script>
        const open = document.querySelectorAll('.edit-reservation-status-open')
        const close = document.querySelector('.edit-reservation-status-close')
        const modal = document.querySelector('.edit-reservation-status-modal')


        function openEditReservationStatus(button) {
            const reservationIdField = document.querySelector('.reservation-id')
            const patientNameField = document.querySelector('.patient-name')
            const reservationStatusField = document.querySelector('.status')

            reservationIdField.value = button.getAttribute('data-reservation-id')
            reservationStatusField.value = button.getAttribute('data-reservation-status')
            patientNameField.value = button.getAttribute('data-patient-name')

            modal.classList.toggle('flex');
            modal.classList.toggle('hidden');

            reservationStatusField.addEventListener('change', () => {
                const val = reservationStatusField.value;
                const reasonContainer = document.querySelector('.reason-container');
                console.log(reasonContainer)
                if (val === 'declined') {
                    console.log(val)
                    reasonContainer.classList.remove('hidden');
                    reasonContainer.classList.add('block');
                } else {
                    reasonContainer.classList.remove('block');
                    reasonContainer.classList.add('hidden');
                }
            })
        }

        close.addEventListener('click', () => {
            modal.classList.toggle('flex');
            modal.classList.toggle('hidden');
        })
    </script>
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: true
            });
        }
    </script>
</x-admin-layout>
