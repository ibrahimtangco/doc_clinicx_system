<x-guest-layout :title="$title">
	<div class="w-full px-6 pb-4 lg:max-w-3xl sm:shadow-md overflow-hidden sm:rounded-lg bg-white">
		<div class="mb-8 flex justify-between items-center">
			<h1 class="text-title text-2xl font-semibold">Create Account</h1>
			<a class="flex items-center pb-2" href="/">
				<img alt="Logo" class="w-20" src="{{ asset('images/FILARCA.png') }}">
			</a>
		</div>
		<form action="{{ route('register') }}" class="w-full" method="POST">
			@csrf

			<x-form-create :provinces="$provinces" />

			<div class="flex items-center justify-end mt-4">
				<a class="underline text-sm text-text-desc hover:text-text-title" href="{{ route('login') }}">
					{{ __('Login account') }}
				</a>

				<x-primary-button class="ms-4">
					{{ __('Register') }}
				</x-primary-button>
			</div>
		</form>
	</div>
	<script src="{{ asset('js/autofill_age.js') }}"></script>
	<script>
		// Fetch old values from Blade template if they exist
		var oldProvince = "{{ old('province') }}";
		var oldCity = "{{ old('city') }}";
		var oldBarangay = "{{ old('barangay') }}";
	</script>
	<script src="{{ asset('js/register_address_handler.js') }}"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Check if there are validation errors
			@if ($errors->any())
				// Find the first input with an error
				let firstInvalidField = document.querySelector('.is-invalid');
				if (firstInvalidField) {
					firstInvalidField.focus();
				}
			@endif
		});
	</script>
</x-guest-layout>
