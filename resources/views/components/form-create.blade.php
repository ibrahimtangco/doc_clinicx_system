@props([
    'provinces' => $provinces,
])

@if (request()->routeIs('providers.create'))
    <div class="w-full">
        <x-input-label :value="__('Registration Number')" for="reg_number" />
        <x-text-input :value="old('reg_number')" autofocus
            class=" mt-1 w-full {{ $errors->has('reg_number') ? 'is-invalid' : '' }}" id="reg_number" name="reg_number"
            type="text" />
        <x-input-error :messages="$errors->get('reg_number')" class="mt-2" />
    </div>
    <div class="w-full hidden">
        <x-input-label :value="__('Title')" for="title" />
        <select autocomplete="title"
            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('title') ? 'is-invalid' : '' }}"
            id="title" name="title">
            <option value="Dr.">Dr.</option>
        </select>
    </div>
    <input type="text" class="hidden" name="userType" value="superadmin" />
@endif

<!-- Name -->
<div class="md:flex gap-4 space-y-2 md:space-y-0">
    <div class="w-full">
        <x-input-label :value="__('First Name')" for="first_name" />
        <x-text-input :value="old('first_name')" autofocus
            class=" mt-1 w-full {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" name="first_name"
            type="text" />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>
    <div class="w-full">
        <x-input-label :value="__('Middle Name')" for="middle_name" />
        <x-text-input :value="old('middle_name')" autofocus
            class="mt-1 w-full {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" id="middle_name"
            name="middle_name" type="text" />
        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
    </div>
    <div class="w-full">
        <x-input-label :value="__('Last Name')" for="last_name" />
        <x-text-input :value="old('last_name')" autofocus
            class=" mt-1 w-full {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" name="last_name"
            type="text" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>
</div>

@if (request()->routeIs('register') ||
        request()->routeIs('patients.create') ||
        request()->routeIs('superadmin.patients.create'))
    <div class="md:flex space-y-2 items-start justify-between gap-4 md:space-y-0 mt-4">
        <div class="w-full">
            <x-input-label :value="__('Birthday')" for="birthday" />
            <x-text-input :value="old('birthday')" autofocus
                class="mt-1 w-full {{ $errors->has('birthday') ? 'is-invalid' : '' }}" id="birthday" name="birthday"
                type="date" />
            <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
        </div>

        <div class="w-full">
            <x-input-label :value="__('Age')" for="age" />
            <input class="hidden" id="hiddenAge" name="age" type="text" value="{{ old('age') }}">
            <x-text-input :value="old('age')" class="mt-1 w-full {{ $errors->has('age') ? 'is-invalid' : '' }}" disabled
                id="age" type="text" />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
            <div class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" id="js-age-error"></div>
        </div>
        <input type="text" class="hidden" name="userType" value="user" />
    </div>
@endif
<div class="grid md:grid-cols-2 md:gap-4">
    <div class="mt-4 ">
        <x-input-label :value="__('Province')" for="province" />
        <select
            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('province') ? 'is-invalid' : '' }}"
            id="province" name="province">
            <option value="">--Select Province--</option>
            @if (!empty($provinces))
                @foreach ($provinces as $code => $name)
                    <option {{ old('province') == $code ? 'selected' : '' }} value="{{ $code }}">
                        {{ $name }}</option>
                @endforeach
            @endif

        </select>
        <x-input-error :messages="$errors->get('province')" class="mt-2" />
    </div>
    {{-- City --}}
    <div class="mt-4">
        <x-input-label :value="__('City / Municipality')" for="city" />
        <select
            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('city') ? 'is-invalid' : '' }}"
            id="city" name="city">

        </select>
        <x-input-error :messages="$errors->get('city')" class="mt-2" />
    </div>
    {{-- barangay --}}
    <div class="mt-4">
        <x-input-label :value="__('Barangay')" for="barangay" />
        <select
            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('barangay') ? 'is-invalid' : '' }}"
            id="barangay" name="barangay">

        </select>
        <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
    </div>
    {{-- street --}}
    <div class="mt-4">
        <x-input-label :value="__('Street (Optional)')" for="street" />
        <x-text-input :value="old('street')" class="block mt-1 w-full {{ $errors->has('stree') ? 'is-invalid' : '' }}"
            id="street" name="street" type="text" />
        <x-input-error :messages="$errors->get('street')" class="mt-2" />
    </div>
</div>

@if (request()->routeIs('register') || request()->routeIs('patients.create'))
    <div class="grid md:grid-cols-2 md:gap-4">
        <div class="mt-4">
            <x-input-label :value="__('Phone')" for="telephone" />
            <x-text-input :value="old('telephone')"
                class="block mt-1 w-full {{ $errors->has('telephone') ? 'is-invalid' : '' }}" id="telephone"
                name="telephone" type="text" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label :value="__('Civil Status')" for="status" />
            <select
                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('status') ? 'is-invalid' : '' }}"
                id="status" name="status">
                <option value="">-Select Status-</option>
                <option {{ old('status') == 'Single' ? 'selected' : '' }} value="Single">Single</option>
                <option {{ old('status') == 'Married' ? 'selected' : '' }} value="Married">Married</option>
                <option {{ old('status') == 'Annulled' ? 'selected' : '' }} value="Annulled">Annulled</option>
                <option {{ old('status') == 'Widowed' ? 'selected' : '' }} value="Widowed">Widowed</option>
                <option {{ old('status') == 'Separated' ? 'selected' : '' }} value="Separated">Separated</option>
                <option {{ old('status') == 'Others' ? 'selected' : '' }} value="Others">Others</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

    </div>
@endif

@if (request()->routeIs('admin.accounts.create'))
    <div class="w-full">
        <x-input-label :value="__('User Type')" for="user-type" />
        <select
            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('user-type') ? 'is-invalid' : '' }}"
            id="title" name="userType">
            <option>--Select User Type--</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
    </div>
@endif

<!-- Email Address -->
<div class="mt-4">
    <x-input-label :value="__('Email')" for="email" />
    <x-text-input :value="old('email')" class="block mt-1 w-full {{ $errors->has('email') ? 'is-invalid' : '' }}"
        id="email" name="email" type="email" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Password -->
<div class="mt-4">
    <div class="py-2" x-data="{ show: true }">
        <x-input-label :value="__('Password')" for="password" />
        <div class="relative">
            <input :type="show ? 'password' : 'text'" autofocus
                class="text-md block px-3 py-2 rounded-md w-full
                bg-white border border-gray-300 shadow-sm
                focus:bg-white
                focus:border-indigo-500
                focus:ring-indigo-500
                focus:outline-none {{ $errors->has('password') ? 'is-invalid' : '' }}"
                id="password" name="password">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" @click="show = !show"
                    aria-hidden="true" class="cursor-pointer text-gray-500 hover:text-gray-700"></i>
            </div>
        </div>
    </div>
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <div class="py-2" x-data="{ show: true }">
        <x-input-label :value="__('Confirm Password')" for="password_confirmation" />
        <div class="relative">
            <input :type="show ? 'password' : 'text'" autofocus
                class="text-md block px-3 py-2 rounded-md w-full
                bg-white border border-gray-300 shadow-sm
                focus:bg-white
                focus:border-indigo-500
                focus:ring-indigo-500
                focus:outline-none
                {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                id="password_confirmation" name="password_confirmation">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" @click="show = !show"
                    aria-hidden="true" class="cursor-pointer text-gray-500 hover:text-gray-700"></i>
            </div>
        </div>
    </div>

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>
