<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Patient;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Services\AddressService;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    protected $addressService, $patientModel, $userModel;

    public function __construct(AddressService $addressService, Patient $patientModel, User $userModel)
    {
        $this->addressService = $addressService;
        $this->patientModel = $patientModel;
        $this->userModel = $userModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::paginate(10);
        $userType = auth()->user()->userType;

        $view = match ($userType) {
            'admin' => 'admin.patients.index',
            'staff' => 'admin.patients.index',
            'superadmin' => 'super_admin.patients.index'
        };

        return view($view, compact('patients'))
            ->with('title', 'Patients | View List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name');
        return view('admin.patients.create', compact('provinces'))
            ->with('title', 'Patients | Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreRequest $request)
    {
        $validated = $request->validated();

        // Build Address
        $address = $this->buildAddress($validated);
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

        // Fetch data
        $provinces = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name');
        $cities = $this->getCachedData("cities_{$modifiedAddress['province_code']}", 'cities.json', 'city_code', 'city_name', ['province_code' => $modifiedAddress['province_code']]);
        $barangays = $this->getCachedData("barangays_{$modifiedAddress['city_code']}", 'barangay.json', 'brgy_code', 'brgy_name', ['city_code' => $modifiedAddress['city_code']]);

        return view('admin.patients.edit', compact('user', 'provinces', 'cities', 'barangays', 'modifiedAddress'))
            ->with('title', 'Patient | Update Information');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $validated = $request->validated();

        // Build Address
        $address = $this->buildAddress($validated);

        DB::transaction(function () use ($validated, $address, $patient) {
            $this->userModel->updateUserDetails($validated, $address, $patient->user_id);
            $this->patientModel->updatePatientDetails($validated, $patient->id);
        });

        emotify('success', 'Patient information has been updated');
        return redirect()->route('patients.index');
    }

    /**
     * Helper method to get cached data.
     */
    private function getCachedData($cacheKey, $jsonFile, $codeKey, $nameKey, $whereClause = null)
    {
        return Cache::remember($cacheKey, 60 * 60, function () use ($jsonFile, $codeKey, $nameKey, $whereClause) {
            $jsonData = json_decode(file_get_contents(config_path($jsonFile)), true);

            if ($whereClause) {
                $filteredData = collect($jsonData)->where(array_keys($whereClause)[0], array_values($whereClause)[0])->pluck($nameKey, $codeKey)->toArray();
                return $filteredData;
            }
            return collect($jsonData)->pluck($nameKey, $codeKey)->toArray();
        });
    }

    /**
     * Helper method to build the full address from the validated data.
     */
    private function buildAddress($validated)
    {
        $street = $validated['street'] ?? '';
        $barangay = $this->getCachedData('barangays', 'barangay.json', 'brgy_code', 'brgy_name')[$validated['barangay']] ?? '';
        $city = $this->getCachedData('cities', 'cities.json', 'city_code', 'city_name')[$validated['city']] ?? '';
        $province = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name')[$validated['province']] ?? '';

        return $street ? "{$street}, {$barangay}, {$city}, {$province}" : "{$barangay}, {$city}, {$province}";
    }

    public function downloadPatientList()
    {
        $patients = Patient::all();
        if ($patients->isEmpty()) {
            emotify('error', 'There are no registered patients.');
            return redirect()->back();
        }
        
        $path = public_path('images/FILARCA.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $html = view('reports_template.patient_list', [
            'imageSrc' => $src,
            'patients' => $patients,
        ])->render();
        $pdfPath = public_path('FR_patient_list.pdf');

        Browsershot::html($html)
        ->margins(15.4, 15.4, 15.4, 15.4)
        ->showBackground()
        ->save($pdfPath);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
