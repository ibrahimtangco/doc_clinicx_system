<x-guest-layout title="Login">
	<div class="w-full sm:max-w-md md:max-w-lg mt-6 px-6 py-4 bg-white sm:shadow-md overflow-hidden sm:rounded-lg">
		<!-- Session Status -->

		<div class="flex items-center justify-center flex-col mb-6">
			<a class="flex items-center pb-2" href="/">
				<img alt="Logo" class="w-24" src="{{ asset('images/FILARCA.png') }}">
			</a>
			<h1 class="text-3xl text-center font-serif text-title">Filarca-Rabena</h1>
			<p class="text-center font-serif text-title">Dental Clinic and Dental Supply</p>
		</div>
		<x-auth-session-status :status="session('status')" class="mb-4" />
		<form action="{{ route('login') }}" method="POST">
			@csrf

			<!-- Email Address -->
			<div>
				<x-input-label :value="__('Email')" for="email" />
				<x-text-input :value="old('email')" autocomplete="username" autofocus class="block mt-1 w-full" id="email"
					name="email" required type="email" />
				<x-input-error :messages="$errors->get('email')" class="mt-2" />
			</div>

			<!-- Password -->
			<div class="mt-4">
				<div class="py-2" x-data="{ show: true }">
					<x-input-label :value="__('Password')" for="password" />
					<div class="relative">
						<input :type="show ? 'password' : 'text'"
							class="text-md block px-3 py-2 rounded-lg w-full
                bg-white border-2 border-gray-300 shadow-sm
                focus:bg-white
                focus:border-indigo-500
                focus:ring-indigo-500
                focus:outline-none"
							name="password">

						<div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
							<i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" @click="show = !show" aria-hidden="true"
								class="cursor-pointer text-gray-500 hover:text-gray-700"></i>
						</div>
					</div>
				</div>

				<x-input-error :messages="$errors->get('password')" class="mt-2" />
			</div>

			<!-- Remember Me -->
			<div class="flex items-center justify-between mt-4">
				<label class="inline-flex items-center cursor-pointer" for="remember_me">
					<input
						class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
						id="remember_me" name="remember" type="checkbox">
					<span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
				</label>
				@if (Route::has('password.request'))
					<a
						class="text-sm text-link hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
						href="{{ route('password.request') }}">
						{{ __('Forgot your password?') }}
					</a>
				@endif
			</div>

			<div class="mt-8 flex flex-col items-center gap-4">
				<x-primary-button class="w-full py-3">
					{{ __('Log in') }}
				</x-primary-button>

			</div>
			<a class="text-center block pt-3 underline text-sm text-text-desc hover:text-text-title rounded-md"
				href="{{ route('register') }}">
				{{ __('Don\'t have an account?') }}
			</a>
		</form>
	</div>
</x-guest-layout>
