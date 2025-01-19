<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('unit-types.index') }}">{{ __('Unit of Measurement') }}</a>
        </h2>
    </x-slot>

    {{-- main container --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto md:mx-0">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Add Unit of Measurement') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Fill in the required details to add a new types of product unit.') }}
                            </p>
                        </header>

                        <form action="{{ route('unit-types.store') }}" class="mt-6 space-y-6" method="post">
                            @csrf

                            <div class="mt-4">
                                <x-input-label :value="__('Name')" for="name" />
                                <x-text-input :value="old('name')" autocomplete="name"
                                    class="block mt-1 w-full {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    id="name" name="name" type="text" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Abbreviation')" for="abbreviation" />
                                <x-text-input :value="old('abbreviation')" autocomplete="abbreviation"
                                    class="block mt-1 w-full {{ $errors->has('abbreviation') ? 'is-invalid' : '' }}"
                                    id="abbreviation" name="abbreviation" type="text" />
                                <x-input-error :messages="$errors->get('abbreviation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button class="w-full md:w-fit">{{ __('Create') }}</x-primary-button>

                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there are validation errors
            @if ($errors->any() || $errors->updatePassword->any())
                // Find the first input with an error
                let firstInvalidField = document.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
            @endif
        });
    </script>
</x-admin-layout>
