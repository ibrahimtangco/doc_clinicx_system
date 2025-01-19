<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			<a href="{{ route('categories.index') }}">{{ __('Social Media') }}</a>
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
								{{ __('Edit Social Media') }}
							</h2>

							<p class="mt-1 text-sm text-gray-600">
								{{ __('Update details about social media') }}
							</p>
						</header>

						<form action="{{ route('social-media.update', ['social_media' => $social_media]) }}" class="mt-6 space-y-6"
							method="post">
							@csrf
							@method('put')

							<div class="mt-4">
								<x-input-label :value="__('Platform')" for="platform" />
								<x-text-input :value="old('platform', $social_media->platform)" autocomplete="platform" autofocus class="block mt-1 w-full" id="platform"
									name="platform" type="text" />
								<x-input-error :messages="$errors->get('platform')" class="mt-2" />
							</div>

							<div class="mt-4">
								<x-input-label :value="__('Username')" for="username" />
								<x-text-input :value="old('username', $social_media->username)" autocomplete="username" autofocus class="block mt-1 w-full" id="username"
									name="username" type="text" />
								<x-input-error :messages="$errors->get('username')" class="mt-2" />
							</div>

							<div class="mt-4">
								<x-input-label :value="__('Url')" for="url" />
								<x-text-input :value="old('url', $social_media->url)" autocomplete="url" autofocus class="block mt-1 w-full" id="url"
									name="url" type="text" />
								<x-input-error :messages="$errors->get('url')" class="mt-2" />
							</div>

							<div class="mt-4">
								<x-input-label :value="__('Status')" for="status" />
								<input {{ $social_media->status == true ? 'checked' : '' }} class="rounded border-gray-300" name="status"
									type="checkbox" />
								<x-input-error :messages="$errors->get('status')" class="mt-2" />
							</div>

							<div class="flex items-center gap-4">
								<x-primary-button>{{ __('Update') }}</x-primary-button>

							</div>
						</form>
					</section>

				</div>
			</div>
		</div>
	</div>
</x-admin-layout>
