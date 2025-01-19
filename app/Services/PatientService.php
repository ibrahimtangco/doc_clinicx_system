<?php

namespace App\Services;

class PatientService
{

    public function searchResults($users)
    {
        $searchDisplay = '';
        $routeView = match (auth()->user()->userType) {
            'admin' => 'show.patient.record',
            'staff' => 'show.patient.record',
            'SuperAdmin' => 'superadmin.show.patient.record'
        };

        $routeEdit = match (auth()->user()->userType) {
            'admin' => 'patients.edit',
            'staff' => 'patients.edit',
            'SuperAdmin' => 'superadmin.patients.edit'
        };

        foreach ($users as $user) {
            $searchDisplay .= '
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4">' . $user->first_name . '</td>
                    <td class="px-6 py-4">' . $user->middle_name . '</td>
                    <td class="px-6 py-4">' . $user->last_name . '</td>
                    <td class="px-6 py-4">' . $user->address . '</td>
                    <td class="px-6 py-4">' . $user->email . '</td>
                    <td class="px-6 py-4 text-right space-x-2 flex items-center">
                        <a class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
                            href="' . route($routeView, ['patient' => $user->patient->id]) . '"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <path d="M12 9a3 3 0 1 0 0 6 3 3 0 1 0 0-6z"></path>
                                                            </svg>
                                                            <span>View</span></a>
                    </td>
                </tr>';
        }

        return $searchDisplay;
    }
}
