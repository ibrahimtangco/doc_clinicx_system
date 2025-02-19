<section>
	<header>
		<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
			{{ __('Avatar') }}
		</h2>

		<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
			{{ __('Add, update, or remove your avatar.') }}
		</p>
	</header>

	<form action="{{ route('avatar.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data" method="post">
		@method('patch')
		@csrf

		<div>
			@if ($user->profile)
				<img alt="Avatar" class="w-10 h-10 rounded-full mb-2 cursor-pointer" data-modal-target="static-modal" data-modal-toggle="static-modal" data-tooltip-target="tooltip-default"
					src="{{ asset('storage/' . $user->profile) }}" type="button">
				<div
					class="hidden absolute z-10 invisible md:inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
					id="tooltip-default" role="tooltip">
					View Avatar
					<div class="tooltip-arrow" data-popper-arrow></div>
				</div>
			@else
				<div
					class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mb-2">
					<span class="font-medium text-gray-600 dark:text-gray-300">{{ Auth::user()->initial }}</span>
				</div>
			@endif

			<x-input-label :value="__('Avatar')" for="profile" />
			<input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 mt-1 {{ $errors->has('profile') ? 'is-invalid' : '' }}"
				id="small_size" name="profile" type="file">
			<x-input-error :messages="$errors->get('profile')" class="mt-2" />
		</div>

		<div class="flex items-center gap-4">
			<x-primary-button class="w-full md:w-fit">{{ __('Save') }}</x-primary-button>

			@if ($user->profile)
				<button
					class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 ease-in-out duration-150 w-full md:w-fit"
					data-modal-target="remove-avatar-modal" data-modal-toggle="remove-avatar-modal" type="button">
					{{ __('Remove Avatar') }}
				</button>
			@endif

			@if (session('status') === 'profile-updated')
				<p class="text-sm text-gray-600 dark:text-gray-400" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
					x-transition>{{ __('Saved.') }}</p>
			@endif

			@if (session('status') === 'avatar-removed')
				<p class="text-sm text-gray-600 dark:text-gray-400" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
					x-transition>{{ __('Avatar Removed.') }}</p>
			@endif
		</div>
	</form>
</section>

<!-- Remove Avatar Modal -->
<div aria-hidden="true" class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50"
	id="remove-avatar-modal" tabindex="-1">
	<div class="relative bg-white rounded-lg shadow dark:bg-gray-800 w-full max-w-md mx-4 sm:mx-0">
		<div class="p-6">
			<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
				{{ __('Remove Avatar') }}
			</h3>
			<p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
				{{ __('Are you sure you want to remove your avatar? This action cannot be undone.') }}
			</p>
			<div class="mt-4 flex flex-wrap justify-end gap-4">
				<button
					class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150"
					data-modal-hide="remove-avatar-modal" type="button">
					{{ __('Cancel') }}
				</button>
				<form action="{{ route('avatar.remove') }}" method="POST">
					@csrf
					@method('DELETE')
					<x-danger-button>
						{{ __('Remove') }}
					</x-danger-button>
				</form>
			</div>
		</div>
	</div>
</div>



<!-- Main modal -->
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-full sm:max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow max-w-md max-h-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Avatar
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="flex justify-center items-center p-4">
                <img src="{{ asset('storage/' . $user->profile) }}" alt="Avatar" class="w-full h-full rounded-lg max-w-sm max-h-sm">
            </div>
        </div>
    </div>
</div>

