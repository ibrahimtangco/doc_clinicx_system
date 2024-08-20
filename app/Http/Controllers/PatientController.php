<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Patient;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Services\AddressService;
use App\Services\PatientService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{

    protected $addressService, $patientModel, $userModel, $patientService;

    public function __construct(AddressService $addressService, PatientService $patientService)
    {
        $this->addressService = $addressService;
        $this->patientService = $patientService;
        $this->patientModel = new Patient();
        $this->userModel = new User();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::paginate(10);

        $view = match (auth()->user()->userType) {
            'admin' => 'admin.patients.index',
            'SuperAdmin' => 'super_admin.patients.index'
        };

        return view($view, compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = json_decode(file_get_contents(config_path('province.json')), true);

        $view = match (auth()->user()->userType) {
            'admin' => 'admin.patients.create',
            'SuperAdmin' => 'super_admin.patients.create'
        };

        return view($view, compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Fetch barangay name
        $barangayData = json_decode(file_get_contents(config_path('barangay.json')), true);
        $barangayCode = $validated['barangay'];
        $barangay = null;
        foreach ($barangayData as $item) {
            if ($item['brgy_code'] === $barangayCode) {
                $barangay = $item;
                break;
            }
        }

        // Fetch city name
        $citiesData = json_decode(file_get_contents(config_path('cities.json')), true);
        $cityCode = $validated['city'];
        $city = null;
        foreach ($citiesData as $item) {
            if ($item['city_code'] === $cityCode) {
                $city = $item;
                break;
            }
        }

        // Fetch province name
        $provinceData = json_decode(file_get_contents(config_path('province.json')), true);
        $provinceCode = $validated['province'];
        $province = null;
        foreach ($provinceData as $item) {
            if ($item['province_code'] === $provinceCode) {
                $province = $item;
                break;
            }
        }

        $street = $request->street;

        if ($street) {
            $address = $street . ', ' . $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
        } else {
            $address =
                $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
        }

        DB::transaction(function () use ($validated, $address) {
            $user = $this->userModel->storeUserDetails($validated, $address);
            $this->patientModel->storePatientDetails($user->id, $validated);
        });
        emotify('success', 'Patient created successfully');
        return redirect()->route('patients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $user = $patient;
        $currentAddress = $patient->user->address;
        $modifiedAddress = $this->addressService->getAddress($currentAddress);

        // Helper function to fetch data from JSON file and cache it
        function getCachedData($cacheKey, $jsonFile, $codeKey, $nameKey, $whereClause = null)
        {
            return Cache::remember($cacheKey, 60 * 60, function () use ($jsonFile, $codeKey, $nameKey, $whereClause) {
                $jsonData = json_decode(file_get_contents(config_path($jsonFile)), true);

                if (isset($whereClause['province_code'])) {
                    // Filter data based on whereClause
                    $filteredData = collect($jsonData)->where('province_code', $whereClause['province_code'])->pluck($nameKey, $codeKey)->toArray();
                    return $filteredData;
                } elseif (isset($whereClause['city_code'])) {
                    // Filter data based on whereClause
                    $filteredData = collect($jsonData)->where('city_code', $whereClause['city_code'])->pluck($nameKey, $codeKey)->toArray();
                    return $filteredData;
                }

                // Return all data if no whereClause is provided
                return collect($jsonData)->pluck($nameKey, $codeKey)->toArray();
            });
        }


        // Usage in your code
        // Fetch provinces
        $provinces = getCachedData('provinces', 'province.json', 'province_code', 'province_name');

        // Fetch cities based on province_code
        $cities = getCachedData("cities_{$modifiedAddress['province_code']}", 'cities.json', 'city_code', 'city_name', ['province_code' => $modifiedAddress['province_code']]);

        // Fetch barangays based on city_code
        $barangays = getCachedData("barangays_{$modifiedAddress['city_code']}", 'barangay.json', 'brgy_code', 'brgy_name', ['city_code' => $modifiedAddress['city_code']]);

        $view = match (auth()->user()->userType) {
            'admin' => 'admin.patients.edit',
            'SuperAdmin' => 'super_admin.patients.edit'
        };
        return view($view, compact('user', 'provinces', 'cities', 'barangays', 'modifiedAddress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {

        $validated = $request->validated();

        // Fetch barangay name from 'barangay.json'
        $barangay = collect(json_decode(file_get_contents(config_path('barangay.json')), true))
            ->where('brgy_code', $validated['barangay'])
            ->pluck('brgy_name')
            ->first();

        // Fetch city name from 'cities.json'
        $city = collect(json_decode(file_get_contents(config_path('cities.json')), true))
            ->where('city_code', $validated['city'])
            ->pluck('city_name')
            ->first();

        // Fetch province name from 'province.json'
        $province = collect(json_decode(file_get_contents(config_path('province.json')), true))
            ->where('province_code', $validated['province'])
            ->pluck('province_name')
            ->first();

        $street = $validated['street'];

        if ($street) {
            $address = $street . ', ' . $barangay . ', ' . $city . ', ' . $province;
        } else {
            $address = $barangay . ', ' . $city . ', ' . $province;
        }

        DB::transaction(function () use ($validated, $address, $patient) {
            $this->userModel->updateUserDetails($validated, $address, $patient->user_id);
            $this->patientModel->updatePatientDetails($validated, $patient->id);
        });
        emotify('success', 'Patiend information has been updated');
        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $user = User::where('id', $patient->user_id)->first();
        $result = $user->delete();

        if (!$result) {
            emotify('errpr', 'Failed to delete patient');
            return redirect()->route('patients.index');
        }
        emotify('success', 'Patient deleted successfully');
        return redirect()->route('patients.index');
    }

    public function search(Request $request)
    {
        $users = $this->patientModel->searchPatient($request->search);
        $searchDisplay = $this->patientService->searchResults($users);

        return response($searchDisplay);
    }
}
