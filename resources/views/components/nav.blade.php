<nav @click.outside="open = false" class="bg-white animate__animated" data-animation="animate_fadeInDown" x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="animate__animated flex" data-animation="animate__fadeInDown">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a class="flex items-center gap-4" href="{{ url('/') }}">
                        <img alt="" class="w-14" src="{{ asset('images/FILARCA.png') }}">
                        <span class="hidden -ml-2 font-serif text-2xl mt-2 md:block">
                            Filarca-Rabena-Corpuz
                        </span>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <ul data-animation="animate__fadeInDown" class="animate__animated hidden text-sm sm:flex sm:items-center sm:ms-6 sm:gap-6">
                <li><a class="hover:text-primary text-text-desc font-semibold transition" href="#hero">Home</a></li>
                <li><a class="hover:text-primary text-text-desc font-semibold transition" href="#about">About</a></li>
                <li><a class="hover:text-primary text-text-desc font-semibold transition" href="#services">Services</a>
                </li>
                <li><a class="hover:text-primary text-text-desc font-semibold transition" href="#contact">Contact</a>
                </li>

                @auth

                    @if (auth()->user()->userType == 'admin')
                        <a class="px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-background-hover focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @elseif (auth()->user()->userType == 'staff')
                        <a class="px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-background-hover focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @elseif (auth()->user()->userType == 'superadmin')
                        <a class="px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-background-hover focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            href="{{ route('superadmin.appointments.view') }}">View Appointments</a>
                    @else
                        <a class="px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-background-hover focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            href="{{ url('/dashboard') }}">Book</a>
                    @endif
                @else
                    <a class="px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-background-hover focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        href="{{ url('/login') }}">Login</a>
                @endauth
            </ul>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" />
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
                <div class="font-medium text-base text-gray-800">
                    @auth
                        {{ auth()->user()->full_name }}
                    @else
                        Guest
                    @endauth

                </div>
                <div class="font-medium text-sm text-gray-700">
                    @auth
                        {{ Auth::user()->email }}
                    @endauth
                </div>
            </div>

            <div class="space-y-1 px-2 mt-3 border-t font-semibold flex flex-col">
                <x-responsive-nav-link :href="route('profile.edit')" class="block py-2 px-3 text-gray-900">
                    {{ __('Home') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')" class="block py-2 px-3 text-gray-900">
                    {{ __('About') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')" class="block py-2 px-3 text-gray-900">
                    {{ __('Services') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')" class="block py-2 px-3 text-gray-900">
                    {{ __('Contact') }}
                </x-responsive-nav-link>

                @auth
                    @if (Auth::user()->userType == 'user')
                        <a class="block py-2 px-3 text-white bg-primary rounded" href="{{ route('user.dashboard') }}">
                            Book
                        </a>
                    @elseif (Auth::user()->userType == 'admin')
                        <a class="block py-2 px-3 text-white bg-primary rounded" href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    @elseif (Auth::user()->userType == 'staff')
                        <a class="block py-2 px-3 text-white bg-primary rounded" href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    @elseif (Auth::user()->userType == 'superadmin')
                        <a class="block py-2 px-3 text-white bg-primary rounded" href="{{ route('admin.dashboard') }}">
                            Reservations
                        </a>
                    @endif
                @endauth

                @guest
                <a class="block py-2 px-3 text-white bg-primary rounded" href="{{ route('login') }}">
                    Login
                </a>
                @endguest

            </div>

        </div>
    </div>
</nav>
