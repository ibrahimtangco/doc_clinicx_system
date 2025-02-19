<x-master-layout>
    <div class="">
        <div class="max-w-4xl mx-auto bg-white rounded-lg">
            <header class="flex justify-between items-center mb-6">
                <div class="flex-1 text-left">
                    <h1 class="text-2xl font-bold">Filarca-Rabena-Corpuz Dental Clinic</h1>
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
            <h2 class="text-2xl font-bold text-center mb-8">Patient List Report</h2>
            <p class="text-sm mb-4">Showing:
                @if ($fromDate && $toDate)
                    <strong>{{ Carbon\Carbon::parse($fromDate)->format('F j, Y') }}</strong>
                    @if ($fromDate !== $toDate)
                        to <strong>{{ Carbon\Carbon::parse($toDate)->format('F j, Y') }}</strong>
                    @endif
                @else
                    <strong>All</strong>
                @endif
            </p>

            <table class="min-w-full border-collapse border border-gray-300 mt-4">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-2 py-1 text-center text-gray-700">Patient ID</th>
                        <th class="border border-gray-300 px-2 py-1 text-center text-gray-700">Name</th>
                        <th class="border border-gray-300 px-2 py-1 text-center text-gray-700">Email</th>
                        <th class="border border-gray-300 px-2 py-1 text-center text-gray-700">Age</th>
                        <th class="border border-gray-300 px-2 py-1 text-center text-gray-700">Contact Number</th>
                        <th class="border border-gray-300 px-2 py-1 text-center text-gray-700">Address</th>
                        <th class="border border-gray-300 px-2 py-1 text-center text-gray-700">Civil Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $patient->id }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $patient->user->full_name }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @php
                                    $emailParts = explode('@', $patient->user->email);
                                @endphp
                                <span>{{ $emailParts[0] }}</span>@
                                <span>{{ $emailParts[1] }}</span>
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $patient->age }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $patient->telephone }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $patient->user->address }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">{{ $patient->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <footer class="mt-12 flex justify-end">
                <div class="flex flex-col items-center gap-1">
                    <div class="border-b border-black w-48"></div>
                    <p class="text-center">{{ Auth::user()->full_name }}</p>
                    <p class="text-sm">
                        @switch(Auth::user()->userType)
                            @case('admin')
                                Administrator
                                @break
                            @case('staff')
                                Staff
                            @break
                            @default
                                ''
                        @endswitch
                    </p>
                </div>
            </footer>
        </div>
    </div>

</x-master-layout>
