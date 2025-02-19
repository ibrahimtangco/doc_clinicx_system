<nav @click.outside="open = false" class="bg-white border-gray-100" x-data="{ open: false }">
	<!-- Primary Navigation Menu -->
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<div class="flex">
				<!-- Logo -->
				<div class="shrink-0 flex items-center">
					<a class="flex items-center gap-4" href="{{ url('/') }}">
						<img alt="" class="w-14" src="{{ asset('images/FILARCA.png') }}">
						<span class="hidden -ml-2 font-serif text-xl mt-2 sm:block md:text-2xl">
							Filarca-Rabena-Corpuz
						</span>
					</a>
				</div>
			</div>

			<!-- Settings Dropdown -->
			<div class="hidden sm:flex sm:items-center sm:ms-6">
				<x-dropdown align="right" width="48">
					<x-slot name="trigger">
						<button
							class="inline-flex gap-2 items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
							<div class="flex items-center gap-4">
								@if (Auth::user()->profile)
									<img alt="Rounded avatar" class="w-10 h-10 rounded-full" src="{{ asset('storage/' . Auth::user()->profile) }}">
								@else
									<div
										class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
										<span class="font-semibold text-gray-600 dark:text-gray-300">{{ Auth::user()->initial }}</span>
									</div>
								@endif

								<span class="hidden md:block">{{ auth()->user()->full_name }}</span>
							</div>

							<div class="ms-1">
								<svg class="fill-current h-4 w-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<path clip-rule="evenodd"
										d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
										fill-rule="evenodd" />
								</svg>
							</div>
						</button>
					</x-slot>

					<x-slot name="content">
						@if (auth()->user()->userType == 'superadmin')
							<x-dropdown-link :href="route('superadmin.profile.edit')">
								{{ __('Profile') }}
							</x-dropdown-link>
							<x-dropdown-link :href="route('superadmin.appointments.view')">
								{{ __('View Appointments') }}
							</x-dropdown-link>
							<x-dropdown-link :href="route('superadmin.patients.index')">
								{{ __('View Patients') }}
							</x-dropdown-link>
							<x-dropdown-link :href="route('superadmin.prescriptions.index')">
								{{ __('View Prescriptions') }}
							</x-dropdown-link>
						@else
							<x-dropdown-link :href="route('profile.edit')">
								{{ __('Profile') }}
							</x-dropdown-link>
							<x-dropdown-link :href="route('user.reservation.list')">
								{{ __('My Reservations') }}
							</x-dropdown-link>
							<x-dropdown-link :href="route('user.appointment.list')">
								{{ __('My Appointments') }}
							</x-dropdown-link>
                            <x-dropdown-link :href="route('user.service-histories.list')">
								{{ __('My Service Histories') }}
							</x-dropdown-link>
						@endif

						<!-- Authentication -->
						<form action="{{ route('logout') }}" method="POST">
							@csrf

							<x-dropdown-link :href="route('logout')"
								onclick="event.preventDefault();
                                                this.closest('form').submit();">
								{{ __('Log Out') }}
							</x-dropdown-link>
						</form>
					</x-slot>
				</x-dropdown>
			</div>

			<!-- Hamburger -->
			<div class="-me-2 flex items-center sm:hidden">
				<button @click="open = ! open"
					class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
					<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" d="M4 6h16M4 12h16M4 18h16"
							stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
						<path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" d="M6 18L18 6M6 6l12 12"
							stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
					</svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Responsive Navigation Menu -->
	<div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

		<!-- Responsive Settings Options -->
		<div class="pt-4 pb-1 border-t border-gray-200">
			<div class="px-4 py-2 bg-indigo-100">
				<div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
				<div class="font-medium text-sm text-gray-700">{{ Auth::user()->email }}</div>
			</div>

			<div class="mt-3 px-4 space-y-1">
				@if (auth()->user()->userType == 'superadmin')
					<x-responsive-nav-link :href="route('superadmin.profile.edit')">
						{{ __('Profile') }}
					</x-responsive-nav-link>
					<x-responsive-nav-link :href="route('superadmin.appointments.view')">
						{{ __('View Appointments') }}
					</x-responsive-nav-link>
					<x-responsive-nav-link :href="route('superadmin.patients.index')">
						{{ __('View Patients') }}
					</x-responsive-nav-link>
					<x-responsive-nav-link :href="route('superadmin.prescriptions.index')">
						{{ __('View Prescriptions') }}
					</x-responsive-nav-link>
				@else
					<x-responsive-nav-link :href="route('profile.edit')">
						{{ __('Profile') }}
					</x-responsive-nav-link>
					<x-responsive-nav-link :href="route('user.reservation.list')">
						{{ __('My Reservations') }}
					</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.appointment.list', Auth::user()->id)">
                        {{ __('My Appointments') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.service-histories.list', Auth::user()->id)">
                        {{ __('My Service Histories') }}
                    </x-responsive-nav-link>
				@endif
{{--
				@php
					$user = auth()->user();
				@endphp

				@switch($user->userType)
					@case('user')
						<x-responsive-nav-link :href="route('user.reservation.list', $user->id)">
							{{ __('My Appointments') }}
						</x-responsive-nav-link>
					@break
				@endswitch --}}

				<!-- Authentication -->
				<form action="{{ route('logout') }}" method="POST">
					@csrf

					<x-responsive-nav-link :href="route('logout')"
						onclick="event.preventDefault();
                                        this.closest('form').submit();">
						{{ __('Log Out') }}
					</x-responsive-nav-link>
				</form>
			</div>
		</div>
	</div>
</nav>
