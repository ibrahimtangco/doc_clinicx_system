<div
id="change-app-name"
	class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50 backdrop-blur-sm">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
				<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
					Change App Name
				</h3>
				<button id="change-app-name-close-btn"
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-hide="default-modal" type="button">
					<svg aria-hidden="true" class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
						<path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							stroke="currentColor" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-5 space-y-4">
				<form action="" class="space-y-2" method="POST">
					@csrf
					<div class="w-full">
						<x-input-label :value="__('App Name')" for="app-name" />
						<x-text-input :value="old('condition')" autofocus class="mt-1 w-full" id="app-name" name="app-name" type="text" />
						<x-input-error :messages="$errors->get('app-name')" class="mt-2" />
					</div>

					<div class="flex items-center pb-2">
						<x-primary-button class=" px-6" >
							{{ __('Update') }}
						</x-primary-button>

					</div>
				</form>
			</div>

		</div>
	</div>
</div>
