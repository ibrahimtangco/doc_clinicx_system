<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			<a href="{{ route('services.index') }}">{{ __('Services') }}</a>
		</h2>
	</x-slot>

	{{-- main container --}}
	<div class="py-12">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<div class="max-w-xl mx-auto md:mx-0">
					<section>
						<header>
							<h2 class="text-lg font-medium text-gray-900">
								{{ __('Edit Service Information') }}
							</h2>

							<p class="mt-1 text-sm text-gray-600">
								{{ __('Fill in the required details to add a new service provider to offer.') }}
							</p>
						</header>

						<form action="{{ route('services.update', ['service' => $service->id]) }}" class="mt-6 space-y-6"
							enctype="multipart/form-data" method="post">
							@csrf
							@method('PUT')

							<div class="mt-4">
								<x-input-label :value="__('Name')" for="name" />
								<x-text-input :value="old('name')" :value="$service->name" autocomplete="name" autofocus class="block mt-1 w-full"
									id="name" name="name" type="text" />
								<x-input-error :messages="$errors->get('name')" class="mt-2" />
							</div>

							<div class="mt-4">
								<x-input-label :value="__('Description')" for="email" />
								<textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"
								 id="description" name="description" rows="3">{{ $service->description }}</textarea>
								<x-input-error :messages="$errors->get('email')" class="mt-2" />
							</div>

							<div class="mt-4">
								<x-input-label :value="__('Is Available')" for="availability" />
								<input {{ $service->availability == true ? 'checked' : '' }} class="rounded border-gray-300" name="availability"
									type="checkbox" />
								<x-input-error :messages="$errors->get('availability')" class="mt-2" />
							</div>

							<div class="flex items-center gap-4">
								<x-primary-button class="w-full md:w-fit">{{ __('Update') }}</x-primary-button>

							</div>
						</form>
					</section>

				</div>
			</div>
		</div>
	</div>
    <script src="{{ asset('js/formatDecimal.js') }}"></script>
</x-admin-layout>

