<x-admin-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Patients Record') }}
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Contact Information</h1>
			<div class="md:grid grid-cols-2 gap-8 space-y-4 md:space-y-0">
				<div class="flex flex-col gap-2 mt-1">
					<label>Phone Number</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						09123123123
					</div>
                    <div class="p-2 border rounded-md bg-gray-100/80">
						09123123123
					</div>
                    <div class="p-2 border rounded-md bg-gray-100/80">
						09123123123
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Email</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						test@gmail.com
					</div>
                    <div class="p-2 border rounded-md bg-gray-100/80">
						test@gmail.com
					</div>
				</div>
			</div>
		</div>

        <div class="my-8 p-8 bg-white rounded-md border">
			<h1 class="font-semibold text-lg mb-4">Footer Information</h1>
			<div class="md:grid grid-cols-2 gap-8 space-y-4 md:space-y-0">
				<div class="flex flex-col gap-2 mt-1">
					<label>Footer</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						09123123123
					</div>
				</div>
				<div class="flex flex-col gap-2 mt-1">
					<label for="name">Socials</label>
					<div class="p-2 border rounded-md bg-gray-100/80">
						test@gmail.com
					</div>
				</div>
			</div>
		</div>
	</div>
<x-change_app_name/>
<script>
    const changeAppNameBtn = document.querySelector('.change-app-name-btn');
    const changeAppNameModal = document.querySelector('#change-app-name');
    const changeAppNameCloseBtn = document.querySelector('#change-app-name-close-btn');

    changeAppNameBtn.addEventListener('click', () => {
        changeAppNameModal.classList.toggle('hidden');
        changeAppNameModal.classList.toggle('flex');
    })

    changeAppNameCloseBtn.addEventListener('click', () => {
        changeAppNameModal.classList.toggle('hidden');
        changeAppNameModal.classList.toggle('flex');
    })


</script>
	</x-admin>
