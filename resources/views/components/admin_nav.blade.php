<header class="sticky top-0 flex left-0 w-full bg-white shadow z-10">

	<div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
		<div class="flex items-center lg:hidden gap-2">
			<!-- Hamburger Toggle BTN -->
			<button @click.stop="isAsideOpen = !isAsideOpen"
				class="z-20 block rounded-sm bg-white p-1.5 shadow-sm">
				<img alt=""
					x-bind:src="!isAsideOpen ? '{{ asset('images/icons/menu.svg') }}' : '{{ asset('images/icons/close_dark.svg') }}'">
			</button>
			<!-- Hamburger Toggle BTN -->
			<img alt="" class="w-12" src="{{ asset('images/FILARCA.png') }}">
		</div>
		<div>

		</div>

		<div class="flex items-center gap-3  2xsm:gap-7 self-end">

			<!-- User Area -->
			<div @click.outside="dropdownOpen = false" class="relative cursor-pointer" x-data="{ dropdownOpen: false }">
				<a @click.prevent="dropdownOpen = ! dropdownOpen" class="flex items-center gap-4" href="#">
					@if (Auth::user()->profile)
						<img alt="Rounded avatar" class="w-10 h-10 rounded-full" src="{{ asset('storage/' . Auth::user()->profile) }}">
					@else
						<div
							class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
							<span class="font-medium text-gray-600 dark:text-gray-300">{{ Auth::user()->initial }}</span>
						</div>
					@endif

					<span class="hidden text-right md:block">
						<span class="block text-sm font-semibold text-primary-text">
							{{ Auth::user()->first_name }}
							@if (Auth::user()->middle_name)
								{{ ucfirst(substr(Auth::user()->middle_name, 0, 1)) }}.
							@endif
							{{ Auth::user()->last_name }}
						</span>
						<span class="block text-xs font-semibold text-secondary-text">{{ ucfirst(Auth::user()->userType) }}</span>
					</span>

					<svg :class="dropdownOpen && 'rotate-180'" class="hidden fill-current sm:block" fill="none" height="8"
						viewBox="0 0 12 8" width="12" xmlns="http://www.w3.org/2000/svg">
						<path clip-rule="evenodd"
							d="M0.410765 0.910734C0.736202 0.585297 1.26384 0.585297 1.58928 0.910734L6.00002 5.32148L10.4108 0.910734C10.7362 0.585297 11.2638 0.585297 11.5893 0.910734C11.9147 1.23617 11.9147 1.76381 11.5893 2.08924L6.58928 7.08924C6.26384 7.41468 5.7362 7.41468 5.41077 7.08924L0.410765 2.08924C0.0853277 1.76381 0.0853277 1.23617 0.410765 0.910734Z"
							fill-rule="evenodd" fill="" />
					</svg>
				</a>

				<!-- Dropdown Start -->
				<div class="absolute right-0 mt-4 flex w-screen sm:w-60 flex-col rounded-sm bg-white shadow-default shadow border-t"
					x-show="dropdownOpen">
					<ul class="flex flex-col gap-5 border-b border-stroke p-6 text-secondary-text">
						<li>
							<a class="flex items-center gap-3.5 text-sm font-medium duration-300 text-text-desc ease-in-out hover:text-link lg:text-base"
								href="{{ route('admin.profile.edit') }}">
								<i class="fa-solid fa-user"></i>
								My Profile
							</a>
						</li>

						<form action="{{ route('logout') }}" method="POST">
							@csrf
							<a
								class="flex items-center gap-3.5 pt-4 text-sm font-medium duration-300 text-text-desc ease-in-out hover:text-link lg:text-base"
								href="route('logout')"
								onclick="event.preventDefault();
                                        this.closest('form').submit();">
								<i class="fa-solid fa-right-from-bracket rotate-180"></i>
								Log Out
							</a>
						</form>
					</ul>

				</div>
				<!-- Dropdown End -->
			</div>
			<!-- User Area -->
		</div>
	</div>
</header>
