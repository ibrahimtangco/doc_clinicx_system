<?php

namespace App\Http\Controllers\Auth;

use App\Models\City;
use App\Models\User;
use App\Models\Patient;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\RegisteredUserRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $provinces = $this->getCachedData('provinces', 'province.json', 'province_code', 'province_name');
        return view('auth.register', compact('provinces'))->with('title', 'Create Account');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request)
    {
        // Fetch barangay name from 'barangay.json'
        $barangayName = collect(json_decode(file_get_contents(config_path('barangay.json')), true))
            ->where('brgy_code', $request->barangay)
            ->pluck('brgy_name')
            ->first();

        // Fetch city name from 'cities.json'
        $cityName = collect(json_decode(file_get_contents(config_path('cities.json')), true))
            ->where('city_code', $request->city)
            ->pluck('city_name')
            ->first();

        // Fetch province name from 'province.json'
        $provinceName = collect(json_decode(file_get_contents(config_path('province.json')), true))
            ->where('province_code', $request->province)
            ->pluck('province_name')
            ->first();

        $locationDetails = [
            'barangay' => $barangayName,
            'city' => $cityName,
            'province' => $provinceName
        ];

        if (in_array(null, $locationDetails, true)) {
            emotify('error', 'Something wrong with the location. Refresh the page and try again');
            return redirect()->back();
        }

        $street = $request->street;
        $address = $street ? "$street, {$locationDetails['barangay']}, {$locationDetails['city']}, {$locationDetails['province']}" : "{$locationDetails['barangay']}, {$locationDetails['city']}, {$locationDetails['province']}";
        DB::transaction(function () use ($request, $address, &$user) {
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'address' => $address,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Patient::create([
                'user_id' => $user->id,
                'telephone' => $request->telephone,
                'birthday' => $request->birthday,
                'age' => $request->age,
                'status' => $request->status
            ]);
        });
        $user->sendEmailVerificationNotification();
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function fetchCity(Request $request)
    {
        $province_code = $request->province_code;
        $cities = json_decode(file_get_contents(config_path('cities.json')), true);

        $filteredCities['cities'] = array_filter($cities, function ($city) use ($province_code) {
            return $city['province_code'] === $province_code;
        });


        return response($filteredCities);
    }

    public function fetchBarangay(Request $request)
    {
        $city_code = $request->city_code;

        $barangays = json_decode(file_get_contents(config_path('barangay.json')), true);

        $filteredBarangay['barangay'] = array_filter($barangays, function ($barangay) use ($city_code) {
            return $barangay['city_code'] === $city_code;
        });
        // $data['barangay'] = Barangay::where('city_code', $request->city_code)->get();

        return response()->json($filteredBarangay);
    }

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
}
