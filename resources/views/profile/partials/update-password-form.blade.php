<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form action="{{ route('password.update') }}" class="mt-6 space-y-6" method="post">
        @csrf
        @method('put')
        <!-- Current Password -->
        <div class="mt-4">
            <div class="py-2" x-data="{ show: true }">
                <x-input-label :value="__('Current Password')" for="update_password_current_password" />
                <div class="relative">
                    <input :type="show ? 'password' : 'text'" autocomplete="current-password"
                        class="text-md block px-3 py-2 rounded-md w-full
                bg-white border border-gray-300 shadow-sm
                focus:bg-white
                focus:border-indigo-500
                focus:ring-indigo-500
                focus:outline-none {{ $errors->updatePassword->has('current_password') ? 'is-invalid' : '' }} {{ $errors->updatePassword->has('password') ? 'is-invalid' : '' }}"
                        id="update_password_current_password" name="current_password">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" @click="show = !show"
                            aria-hidden="true" class="cursor-pointer text-gray-500 hover:text-gray-700"></i>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="mt-4">
            <div class="py-2" x-data="{ show: true }">
                <x-input-label :value="__('New Password')" for="update_password_password" />
                <div class="relative">
                    <input :type="show ? 'password' : 'text'" autocomplete="new-password"
                        class="text-md block px-3 py-2 rounded-md w-full
                bg-white border border-gray-300 shadow-sm
                focus:bg-white
                focus:border-indigo-500
                focus:ring-indigo-500
			focus:outline-none"
                        id="update_password_password" name="password">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" @click="show = !show"
                            aria-hidden="true" class="cursor-pointer text-gray-500 hover:text-gray-700"></i>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <div class="py-2" x-data="{ show: true }">
                <x-input-label :value="__('Confirm Password')" for="update_password_password_confirmation" />
                <div class="relative">
                    <input :type="show ? 'password' : 'text'" autocomplete="password"
                        class="prevent-paste text-md block px-3 py-2 rounded-md w-full
                bg-white border border-gray-300 shadow-sm
                focus:bg-white
                focus:border-indigo-500
                focus:ring-indigo-500
                focus:outline-none"
                        id="update_password_password_confirmation" name="password_confirmation">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" @click="show = !show"
                            aria-hidden="true" class="cursor-pointer text-gray-500 hover:text-gray-700"></i>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="w-full md:w-fit">{{ __('Update') }}</x-primary-button>
            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600 dark:text-gray-400" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)"
                    x-show="show" x-transition>{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script src="{{ asset('js/preventPaste.js') }}"></script>

