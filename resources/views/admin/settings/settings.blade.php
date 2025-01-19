<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-8 p-8 bg-white rounded-md border">
            <div class="flex justify-between align-center">
                <h1 class="font-semibold text-lg mb-4">Social Media Information</h1>
                <a href="{{ route('social-media.create') }}"><i class="fa-solid fa-plus text-xl cursor-pointer"></i></a>
            </div>
            <div class="space-y-4 md:space-y-0 overflow-x-auto">
                <table class="p-2 w-full text-sm text-left rtl:text-right text-gray-500" id="search-table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Platform</th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Username</th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Url</th>
                            <th class="px-6 py-3" scope="col"><span class="flex items-center">
                                    Status</th>
                            <th class="px-6 py-3" scope="col"><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socials as $social)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $social->platform }}</td>
                                <td class="px-6 py-4">{{ $social->username }}</td>
                                <td class="px-6 py-4">{{ $social->url }}</td>
                                <td class="px-6 py-4 {{ $social->status ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $social->status ? 'Active' : 'Inactive' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a class="font-medium text-white bg-blue-600 px-2 py-1 rounded hover:bg-blue-700 flex items-center justify-center gap-1 w-fit"
                                        href="{{ route('social-media.edit', ['social_media' => $social]) }}"> <i
                                            class="fa-solid fa-pen-to-square"></i><span
                                            class="hidden md:block">Edit</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="my-8 p-8 bg-white rounded-md border">
            <div class="flex justify-between align-center">
                <h1 class="font-semibold text-lg mb-4">Contact Information</h1>
                <i class="fa-solid fa-plus text-xl cursor-pointer add-contact-btn"
                    data-action="open-add-contact-modal"></i>
            </div>
            <div class="md:grid grid-cols-2 gap-8 space-y-4 md:space-y-0">
                <div class="flex flex-col gap-2 mt-1">
                    <label>Phone Number</label>
                    @foreach ($contacts as $contact)
                        @if (!empty($contact->phone_number))
                            <div class="p-2 border rounded-md bg-gray-100/80 flex items-center justify-between">
                                <span>{{ $contact->phone_number }}</span>
                                <i class="fa-solid fa-pen-to-square text-text-desc cursor-pointer"
                                    onclick="updatePhoneNumber({{ $contact }})"></i>
                                <x-update_phone_number :contactId="$contact->id" />
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="flex flex-col gap-2 mt-1">
                    <label>Email</label>
                    @foreach ($contacts as $contact)
                        @if (!empty($contact->email))
                            <div class="p-2 border rounded-md bg-gray-100/80 flex items-center justify-between">
                                <span>{{ $contact->email }}</span>
                                <i class="fa-solid fa-pen-to-square text-text-desc cursor-pointer"
                                    onclick="updateEmailAddress({{ $contact }})"></i>
                                <x-update_email_address :contactId="$contact->id" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="my-8 p-8 bg-white rounded-md border">
            <h1 class="font-semibold text-lg mb-4">Footer Information</h1>
            <div class="flex flex-col gap-2 mt-1">
                <label>Footer</label>
                <div class="p-2 border rounded-md bg-gray-100/80 flex items-center justify-between">
                    @if ($footer?->description)
                        <span>{{ $footer->description }}</span>
                    @endif

                    <i class="fa-solid fa-pen-to-square text-text-desc cursor-pointer"
                        onclick="updateFooter({{ $footer }})"></i>
                    <x-update_footer :footer="$footer" />
                </div>
            </div>
        </div>

        <x-add-contact />

        @if ($errors->has('phone_number') || $errors->has('email'))
            <script>
                document.querySelector('#add-contact').classList.toggle('hidden');
                document.querySelector('#add-contact').classList.toggle('flex');
            </script>
        @endif

		@if ($errors->has('description'))
		<script>
			document.querySelector('#update-footer').classList.toggle('hidden');
			document.querySelector('#update-footer').classList.toggle('flex');
		</script>
		@endif


        <script type="module" src="{{ asset('/js/settings/add_contact.js') }}"></script>
        <script type="module" src="{{ asset('/js/settings/update_phone_number.js') }}"></script>
        <script type="module" src="{{ asset('/js/settings/update_email_address.js') }}"></script>
        <script type="module" src="{{ asset('/js/settings/update_footer.js') }}"></script>
    </div>
</x-admin-layout>
