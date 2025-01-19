@props(['contactId'])
<div
	class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/50 backdrop-blur-sm min-w-[275px]"
	id="update-email-address">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
				<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
					Update Email Address
				</h3>
				<button
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-hide="default-modal" id="update-email-address-close-btn" type="button">
					<svg aria-hidden="true" class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
						<path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							stroke="currentColor" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-5 space-y-4 relative">
				<form action="{{ route('contacts.update', ['contact' => $contactId]) }}" class="space-y-2" method="POST">
					@method('PATCH')
					@csrf
					<input class="hidden contact-id" name="contact_id" type="text">

					<div class="w-full">
						<x-input-label :value="__('Email Address')" for="email" />
						<x-text-input :value="old('email')" autofocus class="mt-1 w-full" id="update-email-address-input" name="email"
							type="text" />
						<x-input-error :messages="$errors->get('email')" class="mt-2" />
					</div>
					<div class="flex items-center justify-between pb-2 ">
						<x-primary-button class=" px-6">
							{{ __('Update') }}
						</x-primary-button>
					</div>
				</form>
				<form action="{{ route('unset', ['contact' => $contactId]) }}" method="POST" class="absolute right-5 bottom-6">
					@method('PATCH')
					@csrf
					<input class="hidden contact-id" name="contact_id" type="text">
					<input class="hidden" id="delete-email-address-input" name="email" type="text">
					<x-danger-button class="text-red-600 px-6">
						{{ __('Delete') }}
					</x-danger-button>
				</form>
			</div>

		</div>
	</div>
</div>
