<x-admin-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Settings') }}
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="my-8 p-8 bg-white rounded-md border">
			<div class="flex justify-between align-center">
				<h1 class="font-semibold text-lg mb-4">Contact Information</h1>

				<?xml version="1.0" ?><svg
					class="add-contact-btn w-[30px] h-[30px] stroke-current cursor-pointer hover:stroke-primary stroke-2"
					viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
					<defs></defs>
					<title />
					<g id="plus">
						<line x1="16" x2="16" y1="7" y2="25" />
						<line x1="7" x2="25" y1="16" y2="16" />
					</g>
				</svg>

			</div>
			<div class="md:grid grid-cols-2 gap-8 space-y-4 md:space-y-0">
				<div class="flex flex-col gap-2 mt-1">
					<label>Phone Number</label>
					@foreach ($contacts as $contact)
						@if (!empty($contact->phone_number))
							<div class="p-2 border rounded-md bg-gray-100/80 flex items-center justify-between">
								<span>{{ $contact->phone_number }}</span>
								<?xml version="1.0" ?><svg
									class="update-phone-number-btn cursor-pointer stroke-current hover:stroke-primary feather feather-edit"
									fill="none" height="20" onclick="updatePhoneNumber({{ $contact }})" stroke-linecap="round"
									stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg">
									<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
									<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
								</svg>
								<x-update_phone_number :contactId="$contact->id" />
							</div>
						@endif
					@endforeach
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Email</label>
					@foreach ($contacts as $contact)
						@if (!empty($contact->email))
							<div class="p-2 border rounded-md bg-gray-100/80 flex items-center justify-between">
								<span>{{ $contact->email }}</span>
								<?xml version="1.0" ?><svg
									class="update-phone-number-btn cursor-pointer stroke-current hover:stroke-primary feather feather-edit"
									fill="none" height="20" onclick="updateEmailAddress({{ $contact }})" stroke-linecap="round"
									stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg">
									<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
									<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
								</svg>
								<x-update_email_address :contactId="$contact->id" />
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>

		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Footer Information</h1>
			<div class="">
				<div class="flex flex-col gap-2 mt-1">
					<label>Footer</label>
					<div class="p-2 border rounded-md bg-gray-100/80 flex items-center justify-between">
						<span>{{ $footer->description }}</span>
						<?xml version="1.0" ?><svg
							class="update-footer-btn cursor-pointer stroke-current hover:stroke-primary feather feather-edit" fill="none"
							height="20" onclick="updateFooter({{ $footer }})" stroke-linecap="round" stroke-linejoin="round"
							stroke-width="2" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg">
							<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
							<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
						</svg>
						<x-update_footer :footer="$footer" />
					</div>
				</div>

			</div>

		</div>
		<x-add-contact />

		@if ($errors->any())
			<script>
				document.querySelector('#add-contact').classList.toggle('hidden');
				document.querySelector('#add-contact').classList.toggle('flex');
			</script>
		@endif
        <script type="module" src="{{ asset('/js/settings/add_contact.js') }}"></script>
        <script type="module" src="{{ asset('/js/settings/update_phone_number.js') }}"></script>
        <script type="module" src="{{ asset('/js/settings/update_email_address.js') }}"></script>
        <script type="module" src="{{ asset('/js/settings/update_footer.js') }}"></script>

		</x-admin>
