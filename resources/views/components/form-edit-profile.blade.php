@props([
    'user' => $user,
    'provinces' => $provinces,
    'cities' => $cities,
    'barangays' => $barangays,
    'modifiedAddress' => $modifiedAddress,
])
    @if (request()->routeIs('superadmin.profile.edit'))
        <div class="w-full hidden">
            <x-input-label :value="__('Title')" for="title" />
            <select autocomplete="title"
                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="title"
                name="title">
                <option value="Dr." {{ $user->provider->title === "Dr." ? 'selected' : '' }}>Dr.</option>
            </select>
        </div>
        <div class="w-full">
		<x-input-label :value="__('Registration Number')" for="reg_number" />
		<x-text-input :value="old('reg_number', $user->provider->reg_number)" class=" mt-1 w-full {{ $errors->has('reg_number') ? 'is-invalid' : '' }}"
			id="reg_number" name="reg_number" type="text" />
		<x-input-error :messages="$errors->get('reg_number')" class="mt-2" />
	</div>
    @endif
<div class="md:flex gap-2 space-y-4 md:space-y-0">
    <div>
        <x-input-label :value="__('First Name')" for="first_name" />
        <x-text-input :value="old('first_name', $user->first_name)" autocomplete="first_name" class="mt-1 block w-full {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name"
            name="first_name" type="text" />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label :value="__('Middle Name')" for="middle_name" />
        <x-text-input :value="old('middle_name', $user->middle_name)" autocomplete="middle_name" class="mt-1 block w-full" id="middle_name"
            name="middle_name" type="text" />
        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
    </div>

    <div>
        <x-input-label :value="__('Last Name')" for="last_name" />
        <x-text-input :value="old('last_name', $user->last_name)" autocomplete="last_name" class="mt-1 block w-full {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name"
            name="last_name" type="text" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>
</div>
@if (request()->routeIs('superadmin.profile.edit'))
	<div class="w-full">
		<x-input-label :value="__('Specialization')" for="specialization" />
		<select autocomplete="specialization"
			class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('specialization') ? 'is-invalid' : '' }}"
			id="specialization" name="specialization">
			<option {{ $user->provider->title === 'General Dentist' ? 'selected' : '' }} value="General Dentist">General Dentist</option>
		</select>
	</div>
	<input name="userType" type="hidden" value="superadmin">
@endif
@if (request()->routeIs('profile.edit'))
	<div class="md:flex space-y-2 items-start justify-between gap-4 md:space-y-0 mt-4">
		<div class="w-full">
			<x-input-label :value="__('Birthday')" for="birthday" />
			<x-text-input :value="old('birthday', $user->patient->birthday)" class="mt-1 w-full {{ $errors->has('birthday') ? 'is-invalid' : '' }} {{ $errors->has('age') ? 'is-invalid' : '' }}" id="birthday" name="birthday" type="date" />
			<x-input-error :messages="$errors->get('birthday')" class="mt-2" />
		</div>

		<div class="w-full">
			<x-input-label :value="__('Age')" for="age" />
			<input class="hidden" id="hiddenAge" name="age" type="text" value="{{ old('age', $user->patient->age) }}">
			<x-text-input :value="old('age', $user->patient->age)" class="mt-1 w-full" disabled id="age" type="text" />
			<x-input-error :messages="$errors->get('age')" class="mt-2" />
            <div class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" id="js-age-error"></div>
		</div>
	</div>
@endif
<div class="mt-4">
    <x-input-label :value="__('Province')" for="province" />
    <select autocomplete="province"
        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('province') ? 'is-invalid' : '' }}" id="province"
        name="province">
        <option value="">Select Province</option>
        @foreach ($provinces as $province)
            <option {{ $modifiedAddress['province_code'] == $province['province_code'] ? 'selected' : '' }}
                value="{{ $province['province_code'] }}">
                {{ $province['province_name'] }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('province')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label :value="__('City / Municipality')" for="city" />
    <select autocomplete="city"
        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('city') ? 'is-invalid' : '' }}" id="city"
        name="city">
        @foreach ($cities as $city)
            <option {{ $modifiedAddress['city_code'] == $city['city_code'] ? 'selected' : '' }} value="{{ $city['city_code'] }}">
                {{ $city['city_name'] }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('city')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label :value="__('Barangay')" for="barangay" />
    <select autocomplete="barangay"
        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('barangay') ? 'is-invalid' : '' }}" id="barangay"
        name="barangay">
        @foreach ($barangays as $barangay)
            <option {{ $modifiedAddress['brgy_code'] == $barangay['brgy_code'] ? 'selected' : '' }} value="{{ $barangay['brgy_code'] }}">
                {{ $barangay['brgy_name'] }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label :value="__('Street (Optional)')" for="street" />
    <x-text-input :value="old('street', $modifiedAddress['street_name'])" autocomplete="street" class="block mt-1 w-full {{ $errors->has('street') ? 'is-invalid' : '' }}" id="street" name="street"
        type="text" />
    <x-input-error :messages="$errors->get('street')" class="mt-2" />
</div>
@if (request()->routeIs('profile.edit'))
	<div class="grid md:grid-cols-2 gap-2 space-y-4 md:space-y-0">
		<div>
			<x-input-label :value="__('Phone')" for="telephone" />
			<x-text-input :value="old('telephone', $user->patient->telephone)" autocomplete="username" class="block mt-1 w-full {{ $errors->has('telephone') ? 'is-invalid' : '' }}" id="telephone" name="telephone"
				type="text" />
			<x-input-error :messages="$errors->get('telephone')" class="mt-2" />
		</div>
		<div>
			<x-input-label :value="__('Civil Status')" for="status" />
			<select autocomplete="status"
				class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('status') ? 'is-invalid' : '' }}"
				id="status" name="status">
				<option value="">-Select Status-</option>
				<option {{ $user->patient->status === 'Single' ? 'selected' : '' }} value="Single">Single</option>
				<option {{ $user->patient->status === 'Married' ? 'selected' : '' }} value="Married">Married</option>
				<option {{ $user->patient->status === 'Annulled' ? 'selected' : '' }} value="Annulled">Annulled</option>
				<option {{ $user->patient->status === 'Widowed' ? 'selected' : '' }} value="Widowed">Widowed</option>
				<option {{ $user->patient->status === 'Separated' ? 'selected' : '' }} value="Separated">Separated</option>
				<option {{ $user->patient->status === 'Others' ? 'selected' : '' }} value="Others">Others</option>
			</select>
			<x-input-error :messages="$errors->get('status')" class="mt-2" />
		</div>

	</div>
@endif
<div>
    <x-input-label :value="__('Email')" for="email" />
    <x-text-input :value="old('email', $user->email)" autocomplete="username" class="mt-1 block w-full {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" type="email" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div>
            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                {{ __('Your email address is unverified.') }}

                <button
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    form="send-verification">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
            @endif
        </div>
    @endif
</div>
