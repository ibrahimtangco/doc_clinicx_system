<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Barangay;
use App\Models\Provider;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Services\AddressService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;

class ProviderController extends Controller
{
    protected $addressService, $providerModel, $userModel;

    public function __construct(AddressService $addressService, Provider $providerModel, User $userModel)
    {
        $this->addressService = $addressService;
        $this->providerModel = $providerModel;
        $this->userModel = $userModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::all();
        return view('admin.providers.index', compact('providers'))
            ->with('title', 'Dentists | View List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name');
        return view('admin.providers.create', compact('provinces'))
            ->with('title', 'Dentists | Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProviderRequest $request)
    {
        $validated = $request->validated();

        // Build Address
        $address = $this->buildAddress($validated);

        DB::transaction(function () use ($validated, $address) {
            $user = $this->userModel->storeUserDetails($validated, $address);
            $this->providerModel->storeProviderDetails($validated, $user->id);
        });

        emotify('success', 'Provider created successfully');
        return redirect()->route('providers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        $user = $provider;
        $currentAddress = $user->user->address;
        $modifiedAddress = $this->addressService->getAddress($currentAddress);

        // Fetch data
        $provinces = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name');
        $cities = $this->getCachedData(
            "cities_{$modifiedAddress['province_code']}",
            'cities.json',
            'city_code',
            'city_name',
            ['province_code' => $modifiedAddress['province_code']]
        );
        $barangays = $this->getCachedData(
            "barangays_{$modifiedAddress['city_code']}",
            'barangay.json',
            'brgy_code',
            'brgy_name',
            ['city_code' => $modifiedAddress['city_code']]
        );

        return view('admin.providers.edit', compact('user', 'provinces', 'cities', 'barangays', 'modifiedAddress'))
            ->with('title', 'Dentist | Update Information');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        $validated = $request->validated();

        // Build Address
        $address = $this->buildAddress($validated);

        DB::transaction(function () use ($validated, $address, $provider) {
            $this->userModel->updateUserDetails($validated, $address, $provider->user_id);
            $this->providerModel->updateProviderDetails($validated, $provider->id);
        });

        emotify('success', 'Provider information has been updated');
        return redirect()->route('providers.index');
    }

    /**
     * Build Address from request data.
     *
     * @param array $validated
     * @return string
     */
    private function buildAddress(array $validated): string
    {
        $barangay = $this->getCachedData('barangay', 'barangay.json', 'brgy_code', 'brgy_name')[$validated['barangay']] ?? '';
        $city = $this->getCachedData('city', 'cities.json', 'city_code', 'city_name')[$validated['city']] ?? '';
        $province = $this->getCachedData('province', 'province.json', 'province_code', 'province_name')[$validated['province']] ?? '';
        $street = $validated['street'] ?? '';

        return $street
            ? "$street, $barangay, $city, $province"
            : "$barangay, $city, $province";
    }

    /**
     * Helper function to fetch data from JSON file and cache it.
     *
     * @param string $cacheKey
     * @param string $jsonFile
     * @param string $codeKey
     * @param string $nameKey
     * @param array|null $whereClause
     * @return array
     */
    private function getCachedData(string $cacheKey, string $jsonFile, string $codeKey, string $nameKey, array $whereClause = null): array
    {
        return Cache::remember($cacheKey, 60 * 60, function () use ($jsonFile, $codeKey, $nameKey, $whereClause) {
            $filePath = config_path($jsonFile);

            if (!file_exists($filePath)) {
                \Log::error("JSON file not found: {$filePath}");
                return [];
            }

            $jsonData = json_decode(file_get_contents($filePath), true);
            if ($jsonData === null) {
                \Log::error("Failed to decode JSON from file: {$filePath}");
                return [];
            }

            $data = collect($jsonData);
            if ($whereClause) {
                foreach ($whereClause as $key => $value) {
                    $data = $data->where($key, $value);
                }
            }

            return $data->pluck($nameKey, $codeKey)->toArray();
        });
    }
}
