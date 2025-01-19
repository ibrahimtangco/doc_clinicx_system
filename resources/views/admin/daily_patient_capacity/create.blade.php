<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('daily-patient-capacity.index') }}">{{ __('Daily Patient Capacity') }}</a>
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
                                {{ __('Add Patient Capacity') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Fill in the required details to set the daily patient capacity for AM and PM slots.') }}
                            </p>
                        </header>

                        <form action="{{ route('daily-patient-capacity.store') }}" class="mt-6 space-y-6" method="post">
                            @csrf

                            <div class="mt-4">
                                <x-input-label :value="__('Date')" for="date" />
                                <x-text-input :value="old('date')" autocomplete="date"
                                    class="block mt-1 w-full {{ $errors->has('date') ? 'is-invalid' : '' }}"
                                    id="date" name="date" type="date" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('AM Capcity')" for="am_capacity" />
                                <x-text-input :value="old('am_capacity')" autocomplete="am_capacity"
                                    class="block mt-1 w-full {{ $errors->has('am_capacity') ? 'is-invalid' : '' }}"
                                    id="am_capacity" name="am_capacity" type="number" />
                                <x-input-error :messages="$errors->get('am_capacity')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('PM Capacity')" for="pm_capacity" />
                                <x-text-input :value="old('pm_capacity')" autocomplete="pm_capacity"
                                    class="block mt-1 w-full {{ $errors->has('pm_capacity') ? 'is-invalid' : '' }}"
                                    id="pm_capacity" name="pm_capacity" type="number" />
                                <x-input-error :messages="$errors->get('pm_capacity')" class="mt-2" />
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
