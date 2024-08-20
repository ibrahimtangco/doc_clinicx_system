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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
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
        // dd($providers);
        return  view('admin.providers.index', ['providers' => $providers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = json_decode(file_get_contents(config_path('province.json')), true);
        return view('admin.providers.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage. StoreProviderRequest
     */
    public function store(StoreProviderRequest $request)
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
        $street = $validated['street'];
        if ($street) {
            $address = $street . ', ' . $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
        } else {
            $address = $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
        }

        DB::transaction(function () use ($validated, $address) {
            $user = $this->userModel->storeUserDetails($validated, $address);
            $this->providerModel->storeProviderDetails($validated, $user->id);
        });

        emotify('success', 'Provider created successfully');
        return redirect()->route('providers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        return view('admin.providers.show', ['provider' => $provider]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        $user = $provider;
        $currentAddress = $user->user->address;
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


        return view('admin.providers.edit', compact('user', 'provinces', 'cities', 'barangays', 'modifiedAddress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
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
        DB::transaction(function () use ($validated, $address, $provider) {
            $this->userModel->updateUserDetails($validated, $address, $provider->user_id);
            $this->providerModel->updateProviderDetails($validated, $provider->id);
        });

        emotify('success', 'Providers information has been updated');
        return redirect()->route('providers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {

        $provider = Provider::findOrFail($provider->id);
        $user = User::findOrFail($provider->user->id);
        $provider->delete();
        $user = $user->delete();

        if (!$user) {
            emotify('error', 'Failed to delete provider');
            return redirect()->route('providers.index');
        }
        emotify('success', 'Providers information has been deleted');
        return redirect()->route('providers.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string'
        ]);
        $search = $request->search;
        // Perform the search query
        $providers = Provider::whereHas('user', function ($query) use ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('title', 'LIKE', str_replace('.', '', '%' . $search . '%')); // Remove dot for matching
            })
                ->orWhere('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(first_name, ' ', middle_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(last_name, ' ', middle_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(first_name, ' ', middle_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(last_name, ' ', middle_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(middle_name, ' ', first_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(middle_name, ' ', last_name, ' ', first_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(middle_name, ' ', first_name, ' ', last_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(last_name, ' ', middle_name, ' ', first_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(title, ' ', first_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(title, ' ', first_name, ' ', last_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(title, ' ', first_name, ' ', last_name, ' ', middle_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(title, ' ', last_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(title, ' ', last_name, ' ', first_name) LIKE ?", ['%' . $search . '%'])
                ->orWhereRaw("CONCAT(title, ' ', first_name, ' ', middle_name, ' ', last_name) LIKE ?", ['%' . $search . '%'])
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        })
            ->get();




        $searchDisplay = '';

        foreach ($providers as $provider) {
            $searchDisplay .= '
    <tr class="bg-white border-b hover:bg-gray-50">
        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
            <a href="' . route('providers.show', ['provider' => $provider->id]) . '">
                ' . $provider->title . '
                ' . $provider->user->first_name . '
                ' . ($provider->user->middle_name ? strtoupper(substr($provider->user->middle_name, 0, 1)) . '. ' : '') . '
                ' . $provider->user->last_name . '
            </a>
        </td>
        <td class="px-6 py-4">' . $provider->user->email . '</td>
        <td class="px-6 py-4 text-right space-x-2 flex items-center">
            <a class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
                href="' . route('providers.edit', ['provider' => $provider->id]) . '"><svg fill="none" height="15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												stroke="currentColor" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
												<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
												<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
											</svg><span>Edit</span></a>
            <form action="' . route('providers.destroy', ['provider' => $provider->id]) . '" method="post">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button class="font-medium text-white bg-red-600 px-2 py-1 rounded hover:bg-red-700 flex items-center justify-center gap-1 w-fit" onclick="return confirm(\'Are you sure you want to delete ' . $provider->user->first_name . ' ' . $provider->user->last_name . '\\\'s record?\')"><svg fill="none" height="15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
													stroke="currentColor" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
													<path d="M3 6h18"></path>
													<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
												</svg><span>Delete</span></button>
            </form>
        </td>
    </tr>';
        }

        return response($searchDisplay);
    }
}
