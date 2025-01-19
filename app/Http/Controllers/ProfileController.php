<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Patient;
use App\Models\Provider;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\AddressService;
use App\Services\PatientService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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
            'staff' => 'admin.admin_layouts.profile',
            'superadmin' => 'super_admin.super_admin_layouts.profile',
            default => 'profile.edit',
        };
        return view($view, compact('user', 'provinces', 'cities', 'barangays', 'modifiedAddress'))->with('title', 'Profile | Update Information');
    }

    /**
     * Update the user's profile information.
     */

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $validated = $this->validateRequest($request, $user->userType);

        // Load address components
        $address = $this->buildAddress($request);

        // Update user details and related models based on user type
        if ($user->userType == 'user') {
            $patient = Patient::where('user_id', $user->id)->first();

            DB::transaction(function () use ($validated, $address, $patient) {
                $this->userModel->updateUserDetails($validated, $address, $patient->user_id);
                $this->patientModel->updatePatientDetails($validated, $patient->id);
            });
        } elseif ($user->userType == 'superadmin') {
            $provider = Provider::where('user_id', $user->id)->first();

            DB::transaction(function () use ($validated, $address, $provider) {
                $this->userModel->updateUserDetails($validated, $address, $provider->user_id);
                $this->providerModel->updateProviderDetails($validated, $provider->id);
            });
        } elseif (in_array($user->userType, ['admin', 'staff'])) {
            $this->userModel->updateUserDetails($validated, $address, $user->id);
        }

        // Reset email verification if email was changed
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $userSaved = $request->user()->save();
        if (!$userSaved) {
            emotify('error', 'Failed to update profile');
            return redirect()->back();
        }

        // Display success message after saving
        emotify('success', 'Profile updated successfully');
        return redirect()->back();
    }

    /**
     * Validate the request based on user type.
     */
    protected function validateRequest(Request $request, string $userType): array
    {
        if ($userType === 'user') {
            return $request->validate([
                'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'telephone' => ['required', 'string', 'regex:/^(09[0-9]{9}|\+63[9][0-9]{9})$/'],
                'birthday' => ['required', 'date'],
                'age' => ['required', 'integer', 'min:1'],
                'province' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
                'street' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s,.-]+$/'],
                'status' => ['required', 'in:Single,Married,Annulled,Widowed,Separated,Others'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->id())],
            ]);
        } elseif ($userType === 'superadmin') {
            return $request->validate([
                'title' => ['required', 'string'],
                'reg_number' => ['required', 'string', Rule::unique(Provider::class)->ignore(auth()->id(), 'user_id')],
                'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'specialization' => ['required', 'string'],
                'province' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
                'street' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s,.-]+$/'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->id())],
            ]);
        } else { // Admin or Staff
            return $request->validate([
                'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]+$/'],
                'province' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
                'street' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s,.-]+$/'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->id())],
            ]);
        }
    }

    /**
     * Build the full address string from request data.
     */
    protected function buildAddress(Request $request): string
    {
        $rawBarangays = json_decode(file_get_contents(config_path('barangay.json')), true);
        $barangay = array_filter($rawBarangays, function ($barangay) use ($request) {
            return $barangay['brgy_code'] === $request->barangay;
        });
        $barangay = reset($barangay);

        $rawCities = json_decode(file_get_contents(config_path('cities.json')), true);
        $city = array_filter($rawCities, function ($city) use ($request) {
            return $city['city_code'] === $request->city;
        });
        $city = reset($city);

        $rawProvinces = json_decode(file_get_contents(config_path('province.json')), true);
        $province = array_filter($rawProvinces, function ($province) use ($request) {
            return $province['province_code'] === $request->province;
        });
        $province = reset($province);

        $street = $request->street;
        if ($street) {
            return $street . ', ' . $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
        }
        return $barangay['brgy_name'] . ', ' . $city['city_name'] . ', ' . $province['province_name'];
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $user = auth()->user();

        // Store the uploaded file in the 'profiles' directory on the 'public' disk
        $path = $request->file('profile')->store('profiles', 'public');
        $oldProfile = $user->profile;

        if ($oldProfile) {
            Storage::disk('public')->delete($oldProfile);
        }

        $user->update(['profile' => $path]);

        emotify('success', 'Avatar is updated');
        return redirect()->back();
    }

    public function removeAvatar(Request $request)
    {
        $user = $request->user();

        if ($user->profile) {
            // Delete the avatar from storage
            Storage::delete('public/' . $user->profile);
            // Remove the avatar path from the user record
            $user->update(['profile' => null]);
        }
        emotify('success', 'Avatar removed');
        return redirect()->back();
    }
}
