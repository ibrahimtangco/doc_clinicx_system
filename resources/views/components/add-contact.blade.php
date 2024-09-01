<div
	class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50 backdrop-blur-sm"
	id="add-contact">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
				<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
					Add Contacts
				</h3>
				<button
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-hide="default-modal" id="add-contact-close-btn" type="button">
					<svg aria-hidden="true" class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
						<path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							stroke="currentColor" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-5 space-y-4">
				<form action="{{ route('contacts.store') }}" class="space-y-2" method="POST">
					@csrf
					<div class="w-full">
						<x-input-label :value="__('Phone Number')" for="phone_number" />
						<x-text-input :value="old('phone_number')" autofocus class="mt-1 w-full" id="phone_number" name="phone_number"
							type="text" />
						<x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
					</div>
					<div class="w-full">
						<x-input-label :value="__('Email Address')" for="email" />
						<x-text-input :value="old('email')" autofocus class="mt-1 w-full" id="email" name="email"
							type="text" />
						<x-input-error :messages="$errors->get('email')" class="mt-2" />
					</div>
					<div class="flex items-center pb-2">
						<x-primary-button class=" px-6">
							{{ __('Add') }}
						</x-primary-button>

					</div>
				</form>
			</div>

		</div>
	</div>
</div>
