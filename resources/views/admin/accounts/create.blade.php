<x-admin-layout :title="$title">
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			<a href="{{ route('accounts.index') }}">{{ __('Accounts') }}</a>
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
								{{ __('Add Account') }}
							</h2>

							<p class="mt-1 text-sm text-gray-600">
								{{ __('Fill in the required details and credentials to add a new account to the system.') }}
							</p>
						</header>

						<form action="{{ route('admin.accounts.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data" method="post">
							@csrf

							<x-form-create :provinces="$provinces" />

							<div class="flex items-center gap-4">
								<x-primary-button>{{ __('Create') }}</x-primary-button>

							</div>
						</form>
					</section>

				</div>
			</div>
		</div>
	</div>
	<script>
		// Fetch old values from Blade template if they exist
		var oldProvince = "{{ old('province') }}";
		var oldCity = "{{ old('city') }}";
		var oldBarangay = "{{ old('barangay') }}";
	</script>
	<script src="{{ asset('js/register_address_handler.js') }}"></script>
</x-admin-layout>
