<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\AddressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected $userModel, $addressService;

    public function __construct(AddressService $addressService, User $userModel)
    {
        $this->addressService = $addressService;
        $this->userModel = $userModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::whereIn('userType', ['admin', 'staff'])->get();

        return view('admin.accounts.index', compact('employees'))
            ->with('title', 'Employees | View List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name');
        return view('admin.accounts.create', compact('provinces'))
            ->with('title', 'Employees | Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'street' => ['max:255'],
            'userType' => ['required', 'in:admin,staff'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%_*#?&]/',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $address = $this->buildAddress($validated);

        $staff = User::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'address' => $address,
            'email' => $validated['email'],
            'userType' => $validated['userType'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!$staff) {
            emotify('error', 'Failed to create staff account.');
            return redirect()->route('accounts.index');
        }

        emotify('success', 'Staff\'s account has been created successfully.');
        return redirect()->route('accounts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $currentAddress = $user->address;
        $modifiedAddress = $this->addressService->getAddress($currentAddress);

        $provinces = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name');
        $cities = $this->getCachedData("cities_{$modifiedAddress['province_code']}", 'cities.json', 'city_code', 'city_name', ['province_code' => $modifiedAddress['province_code']]);
        $barangays = $this->getCachedData("barangays_{$modifiedAddress['city_code']}", 'barangay.json', 'brgy_code', 'brgy_name', ['city_code' => $modifiedAddress['city_code']]);

        return view('admin.accounts.edit', compact('user', 'provinces', 'cities', 'barangays', 'modifiedAddress'))
            ->with('title', 'Employees | Update Information');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge(['is_active' => $request->has('is_active') ? true : false]);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'street' => ['max:255'],
            'userType' => ['required', 'in:admin,staff'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($id)],
            'is_active' => 'sometimes'

        ]);

        $address = $this->buildAddress($validated);

        $user = User::findOrFail($id);
        $user->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'address' => $address,
            'email' => $validated['email'],
            'userType' => $validated['userType'],
            'is_active' => isset($validated['is_active']) ? $validated['is_active'] : 0,
        ]);

        emotify('success', 'Staff information has been updated.');
        return redirect()->route('accounts.index');
    }

    /**
     * Helper method to get cached data.
     */
    private function getCachedData($cacheKey, $jsonFile, $codeKey, $nameKey, $whereClause = null)
    {
        return Cache::remember($cacheKey, 60 * 60, function () use ($jsonFile, $codeKey, $nameKey, $whereClause) {
            $jsonData = json_decode(file_get_contents(config_path($jsonFile)), true);

            if ($whereClause) {
                $filteredData = collect($jsonData)->where(array_keys($whereClause)[0], array_values($whereClause)[0])
                    ->pluck($nameKey, $codeKey)
                    ->toArray();
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
}
