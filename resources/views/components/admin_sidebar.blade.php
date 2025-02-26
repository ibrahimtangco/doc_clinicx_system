<aside :class="isAsideOpen ? 'translate-x-0' : '-translate-x-full'" @click.outside="isAsideOpen = false"
	class="fixed left-0 z-30 top-0 h-screen hide-scrollbar overflow-y-scroll w-64 bg-[#1C2434] text-white-text flex flex-col gap-6 duration-300 ease-linear lg:static lg:translate-x-0">
	{{-- LOGO START --}}
	<div class="flex items-center justify-between pr-6 py-4 mb-4">
		<a class="flex items-center gap-2" href="{{ url('/') }}">
			<img alt="" class=" w-12 md:w-14 ml-2" src="{{ asset('images/FILARCA.png') }}">
			<div class="font-serif text-lg -ml-2 mt-2 leading-6">Filarca-Rabena-Corpuz</div>
		</a>
		<div
			class="cursor-pointer block rounded-full p-2 lg:hidden hover:bg-gray-200 hover:text-primary-text ease-linear duration-100">
			{{-- <svg @click.stop="isAsideOpen = !isAsideOpen" fill="currentColor" id="Layer_1"
				style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve"
				xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
				<g>
					<polygon points="48.1,29.1 13.2,64 48.1,98.9 53.8,93.2 28.5,68 92,68 92,60 28.5,60 53.8,34.8  " />
					<rect height="8" width="8" x="104" y="60" />
				</g>
			</svg> --}}
            <i class="fa-solid fa-xmark text-xl" @click.stop="isAsideOpen = !isAsideOpen"></i>
		</div>

	</div>
	{{-- LOGO END --}}

	{{-- MENU START --}}
	<div class="flex flex-col gap-2 px-6 mb-2">
		<h2 class="font-medium text-white-text/75 mb-4">MENU</h2>
		<ul class="font-medium space-y-1" x-data="{ isOpenProduct: false, isOpenCategory: false, isOpenUnitType: false }">
			<li
				class="cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}">
				<div class="flex items-center gap-2">
					<i class="fa-solid fa-house"></i>
					<a href="{{ route('admin.dashboard') }}">Dashboard</a>
				</div>
			</li>
			<li
				class="cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('admin.prescriptions.index') ? 'bg-white/10' : '' }}">
				<div class="flex items-center gap-2">
					<i class="fa-solid fa-prescription"></i>
					<a href="{{ route('admin.prescriptions.index') }}">Prescription</a>
				</div>
			</li>
			<li
				class="cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('transactions.index') || request()->routeIs('transactions.create') ? 'bg-white/10' : '' }}">
				<div class="flex items-center gap-2">
					<i class="fa-solid fa-cart-shopping"></i>
					<a href="{{ route('transactions.index') }}">Sales Transaction</a>
				</div>
			</li>
			<li @click="isOpenCategory = !isOpenCategory" class="">
				<button
					class="flex w-full items-center justify-between cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200">
					<div class="flex gap-2 items-center">
						<i class="fa-solid fa-list"></i>
						<span>Category</span>
					</div>
					{{-- arrow --}}
					<svg fill="currentColor" height="20px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1"
						viewBox="0 0 512 512" width="20px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink"
						xmlns="http://www.w3.org/2000/svg">
						<path
							x-bind:d="isOpenCategory ?
							    'M413.1,327.3l-1.8-2.1l-136-106.5c-4.6-5.3-11.5-8.6-19.2-8.6c-7.7,0-14.6,3.4-19.2,8.6L101,324.9l-2.3,2.6  C97,330,96,333,96,336.2c0,8.7,7.4,10.8,16.6,10.8v0h286.8v0c9.2,0,16.6-7.1,16.6-10.8C416,332.9,414.9,329.8,413.1,327.3z' :
							    'M98.9,184.7l1.8,2.1l136,106.5c4.6,5.3,11.5,8.6,19.2,8.6c7.7,0,14.6-3.4,19.2-8.6L411,187.1l2.3-2.6  c1.7-2.5,2.7-5.5,2.7-8.7c0-8.7-7.4-10.8-16.6-10.8v0H112.6v0c-9.2,0-16.6,7.1-16.6,10.8C96,179.1,97.1,182.2,98.9,184.7z'" />
					</svg>
				</button>
				<div class="pl-6 space-y-1" x-show="isOpenCategory">
					<a
						class="flex w-full items-center gap-2 cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('categories.index') ? 'bg-white/10' : '' }}"
						href="{{ route('categories.index') }}">
						<i class="fa-solid fa-eye"></i>
						<span>View Category</span>
					</a>
					<a
						class="flex w-full items-center gap-2 cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('categories.create') ? 'bg-white/10' : '' }}"
						href="{{ route('categories.create') }}">
						<i class="fa-solid fa-plus"></i>
						<span>Add Category</span>
					</a>
				</div>
			</li>

			<li @click="isOpenUnitType = !isOpenUnitType" class="">
				<button
					class="flex w-full items-center justify-between cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200">
					<div class="flex gap-2 items-center">
						<i class="fa-solid fa-weight-scale"></i>
						<span class="text-nowrap">Unit of Meas.</span>
					</div>
					{{-- arrow --}}
					<svg fill="currentColor" height="20px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1"
						viewBox="0 0 512 512" width="20px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink"
						xmlns="http://www.w3.org/2000/svg">
						<path
							x-bind:d="isOpenUnitType ?
							    'M413.1,327.3l-1.8-2.1l-136-106.5c-4.6-5.3-11.5-8.6-19.2-8.6c-7.7,0-14.6,3.4-19.2,8.6L101,324.9l-2.3,2.6  C97,330,96,333,96,336.2c0,8.7,7.4,10.8,16.6,10.8v0h286.8v0c9.2,0,16.6-7.1,16.6-10.8C416,332.9,414.9,329.8,413.1,327.3z' :
							    'M98.9,184.7l1.8,2.1l136,106.5c4.6,5.3,11.5,8.6,19.2,8.6c7.7,0,14.6-3.4,19.2-8.6L411,187.1l2.3-2.6  c1.7-2.5,2.7-5.5,2.7-8.7c0-8.7-7.4-10.8-16.6-10.8v0H112.6v0c-9.2,0-16.6,7.1-16.6,10.8C96,179.1,97.1,182.2,98.9,184.7z'" />
					</svg>
				</button>
				<div class="pl-6 space-y-1" x-show="isOpenUnitType">
					<a
						class="flex w-full items-center gap-2 cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('unit-types.index') ? 'bg-white/10' : '' }}"
						href="{{ route('unit-types.index') }}">
						<i class="fa-solid fa-eye"></i>

						<span>View All Meas.</span>
					</a>
					<a
						class="flex w-full items-center gap-2 cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('unit-types.create') ? 'bg-white/10' : '' }}"
						href="{{ route('unit-types.create') }}">
						<i class="fa-solid fa-plus"></i>
						<span>Add Meas.</span>
					</a>
				</div>
			</li>

			<li @click="isOpenProduct = !isOpenProduct" class="">
				<button
					class="flex w-full items-center justify-between cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200">
					<div class="flex gap-2 items-center">
						<i class="fa-solid fa-capsules"></i>

						<span>Product Inventory</span>
					</div>
					{{-- arrow --}}
					<svg fill="currentColor" height="20px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1"
						viewBox="0 0 512 512" width="20px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink"
						xmlns="http://www.w3.org/2000/svg">
						<path
							x-bind:d="isOpenProduct ?
							    'M413.1,327.3l-1.8-2.1l-136-106.5c-4.6-5.3-11.5-8.6-19.2-8.6c-7.7,0-14.6,3.4-19.2,8.6L101,324.9l-2.3,2.6  C97,330,96,333,96,336.2c0,8.7,7.4,10.8,16.6,10.8v0h286.8v0c9.2,0,16.6-7.1,16.6-10.8C416,332.9,414.9,329.8,413.1,327.3z' :
							    'M98.9,184.7l1.8,2.1l136,106.5c4.6,5.3,11.5,8.6,19.2,8.6c7.7,0,14.6-3.4,19.2-8.6L411,187.1l2.3-2.6  c1.7-2.5,2.7-5.5,2.7-8.7c0-8.7-7.4-10.8-16.6-10.8v0H112.6v0c-9.2,0-16.6,7.1-16.6,10.8C96,179.1,97.1,182.2,98.9,184.7z'" />
					</svg>
				</button>
				<div class="pl-6 space-y-1" x-show="isOpenProduct">
					<a
						class="flex w-full items-center gap-2 cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('products.index') ? 'bg-white/10' : '' }}"
						href="{{ route('products.index') }}">
						<i class="fa-solid fa-eye"></i>

						<span>View Products</span>
					</a>
					<a
						class="flex w-full items-center gap-2 cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200 {{ request()->routeIs('products.create') ? 'bg-white/10' : '' }}"
						href="{{ route('products.create') }}">
						<i class="fa-solid fa-plus"></i>
						<span>Add Product</span>
					</a>
				</div>
			</li>

		</ul>
	</div>
	{{-- MENU END --}}

	{{-- ACTIONS START --}}
	<x-action_group />
	{{-- ACTIONS END --}}

	{{-- OTHERS START --}}
	<div class="flex flex-col gap-2 px-6 mb-2">
		<h2 class="text-white-text/75 font-medium mb-2">OTHERS</h2>
		<ul class="font-medium space-y-1">
			@if (auth()->user()->userType === 'admin')
				<li
					class="cursor-pointer hover:bg-white/10 p-2  rounded-sm ease-in-out duration-200 {{ request()->routeIs('accounts.index') ? 'bg-white/10' : '' }}">
					<a class="flex gap-2 items-center" href="{{ route('accounts.index') }}">
						<i class="fa-solid fa-circle-user"></i>
						<span class="ml-2">Accounts</span>
					</a>
				</li>
				<li
					class="cursor-pointer hover:bg-white/10 p-2  rounded-sm ease-in-out duration-200 {{ request()->routeIs('display.activity.logs') ? 'bg-white/10' : '' }}">
					<a class="flex gap-2 items-center" href="{{ route('display.activity.logs') }}">
						<i class="fa-solid fa-history"></i>
						<span class="ml-2">Audit Trail</span>
					</a>
				</li>
			@endif
			<li
				class="cursor-pointer hover:bg-white/10 p-2  rounded-sm ease-in-out duration-200 {{ request()->routeIs('admin.settings') ? 'bg-white/10' : '' }}">
				<a class="flex gap-2 items-center" href="{{ route('admin.settings') }}">
					<i class="fa-solid fa-gear"></i>
					<span class="ml-2">Settings</span>
				</a>
			</li>
			<li class="cursor-pointer hover:bg-white/10 p-2 rounded-sm ease-in-out duration-200">
				<form action="{{ route('logout') }}" method="POST">
					@csrf
					<a class="flex items-center gap-3.5 text-sm font-medium" href="route('logout')"
						onclick="event.preventDefault();
                                        this.closest('form').submit();">
						<i class="fa-solid fa-right-from-bracket rotate-180"></i>
						Log Out
					</a>
				</form>
			</li>

		</ul>
	</div>
	{{-- OTHERS END --}}

</aside>
