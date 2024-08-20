<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Patient;
use App\Models\Barangay;
use App\Models\Provider;
use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\AddressService;
use App\Services\PatientService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    protected $addressService, $patientModel, $userModel, $patientService, $providerModel;

    public function __construct(AddressService $addressService, PatientService $patientService, Provider $providerModel)
    {
        $this->addressService = $addressService;
        $this->patientService = $patientService;
        $this->providerModel = $providerModel;
        $this->patientModel = new Patient();
        $this->userModel = new User();
    }
    public function getCities($provinceCode)
    {
        $cities = json_decode(file_get_contents(config_path('cities.json')), true);
        $filteredCities['cities'] = array_filter($cities, function ($city) use ($provinceCode) {
            return $city['province_code'] === $provinceCode;
        });


        return response()->json($filteredCities);
    }

    public function getBarangays($cityCode)
    {
        $barangays = json_decode(file_get_contents(config_path('barangay.json')), true);

        $filteredBarangay['barangays'] = array_filter($barangays, function ($barangay) use ($cityCode) {
            return $barangay['city_code'] === $cityCode;
        });

        return response()->json($filteredBarangay);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = auth()->user();
        $currentAddress = $user->address;
        $modifiedAddress = $this->addressService->getAddress($currentAddress);

        $provinces = json_decode(file_get_contents(config_path('province.json')), true);

        $rawCities = json_decode(file_get_contents(config_path('cities.json')), true);
        $cities = array_filter($rawCities, function ($city) use ($modifiedAddress) {
            return $city['province_code'] === $modifiedAddress['province_code'];
        });

        $rawBarangays = json_decode(file_get_contents(config_path('barangay.json')), true);
        $barangays = array_filter($rawBarangays, function ($barangay) use ($modifiedAddress) {
            return $barangay['city_code'] ===  $modifiedAddress['city_code'];
        });

        // $street = $request->street;
        $userType = $request->user()->userType;

        $view = match ($userType) {
            'admin' => 'admin.admin_layouts.profile',
            'SuperAdmin' => 'super_admin.super_admin_layouts.profile',
            default => 'profile.edit',
        };
        return view($view, compact('user', 'provinces', 'cities', 'barangays', 'modifiedAddress'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        if ($user->userType === 'user') {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'telephone' => ['required', 'string', 'min:11', 'max:255'],
                'birthday' => ['required', 'date'],
                'age' => ['required', 'integer'],
                'province' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
                'street' => ['max:255'],
                'status' => ['required', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            ]);
            $patient = Patient::where('user_id', $user->id)->first();
        } elseif ($user->userType === 'SuperAdmin') {
            $validated = $request->validate([
                'title' => ['required', 'string'],
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'specialization' => ['required', 'string'],
                'province' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
                'street' => ['max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            ]);
            $provider  = Provider::where('user_id', $user->id)->first();
        } elseif ($user->userType === 'admin') {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'province' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
                'street' => ['max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            ]);
        }


        $rawBarangays = json_decode(file_get_contents(config_path('barangay.json')), true);
        $barangay = array_filter($rawBarangays, function ($barangay) use ($request) {
            return $barangay['brgy_code'] ===  $request->barangay;
        });
        $barangay = reset($barangay); // Get the first (and only) barangay if it exists

        $rawCities = json_decode(file_get_contents(config_path('cities.json')), true);
        $city = array_filter($rawCities, function ($city) use ($request) {
            return $city['city_code'] === $request->city;
        });
        $city = reset($city); // Get the first (and only) city if it exists

        $rawProvinces = json_decode(file_get_contents(config_path('province.json')), true);
        $province = array_filter($rawProvinces, function ($province) use ($request) {
            return $province['province_code'] === $request->province;
        });
        $province = reset($province); // Get the first (and only) province if it exists

        $street = $request->street;

        if ($street) {
            $address = $street . ', ' . $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
        } else {
            $address = $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
        }

        if ($user->userType == 'user') {
            DB::transaction(function () use ($validated, $address, $patient) {
                $this->userModel->updateUserDetails($validated, $address, $patient->user_id);
                $this->patientModel->updatePatientDetails($validated, $patient->id);
            });
        } elseif ($user->userType == 'SuperAdmin') {
            DB::transaction(function () use ($validated, $address, $provider) {
                $this->userModel->updateUserDetails($validated, $address, $provider->user_id);
                $this->providerModel->updateProviderDetails($validated, $provider->id);
            });
        } elseif ($user->userType == 'admin') {

            $user = $user->update([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'address' => $address,
                'email' => $validated['email']
            ]);
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = $request->user()->save();

        if (!$user) {
            emotify('error', 'Failed to update profile');
            return redirect()->route('profile.edit');
        }
        emotify('success', 'Profile updated successfully');
        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
