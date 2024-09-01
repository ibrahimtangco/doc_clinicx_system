<x-admin-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			<a href="{{ route('categories.index') }}">{{ __('Contact') }}</a>
		</h2>
	</x-slot>

	{{-- main container --}}
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<div class="max-w-xl">
					<section>
						<header>
							<h2 class="text-lg font-medium text-gray-900">
								{{ __('Add Contact') }}
							</h2>

							<p class="mt-1 text-sm text-gray-600">
								{{ __('Fill in the required details to add contact information.') }}
							</p>
						</header>

						<form action="{{ route('categories.store') }}" class="mt-6 space-y-6" method="post">
							@csrf

							<div class="mt-4">
								<x-input-label :value="__('Phone Number')" for="phone_number" />
								<x-text-input :value="old('phone_number')" autocomplete="phone_number" autofocus class="block mt-1 w-full" id="name"
									name="phone_number" type="text" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
							</div>

							<div class="mt-4">
								<x-input-label :value="__('Email Address')" for="email_address" />
								<x-text-input :value="old('email_address')" autocomplete="email_address" autofocus class="block mt-1 w-full" id="name"
									name="email_address" type="text" />
                                <x-input-error :messages="$errors->get('email_address')" class="mt-2" />
							</div>

							<div class="flex items-center gap-4">
								<x-primary-button>{{ __('Create') }}</x-primary-button>

							</div>
						</form>
					</section>

				</div>
			</div>
		</div>
	</div>
</x-admin-layout>
