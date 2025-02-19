<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('products.index') }}">{{ __('Product Inventory') }}</a>
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
                                {{ __('Edit Product') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Update product details') }}
                            </p>
                        </header>

                        <form action="{{ route('products.update', ['product' => $product->id]) }}" class="mt-6 space-y-6"
                            method="post">
                            @csrf
                            @method('PUT')

                            <div class="mt-4">
                                <x-input-label :value="__('Name')" for="name" />
                                <x-text-input :value="old('name', $product->name)" autocomplete="name" autofocus
                                    class="block mt-1 w-full {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    id="name" name="name" type="text" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Category')" for="category_id" />
                                <select
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                                    id="category_id" name="category_id">
                                    <option value="">-Select Category-</option>
                                    @foreach ($categories as $categoryOption)
                                        <option
                                            {{ old('category_id', $product->category_id ?? '') == $categoryOption->id ? 'selected' : '' }}
                                            value="{{ $categoryOption->id }}">
                                            {{ $categoryOption->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Description')" for="description" />
                                <textarea
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1 {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                    id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Unit Type')" for="unit_type_id" />
                                <select
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('unit_type_id') ? 'is-invalid' : '' }}"
                                    id="unit_type_id" name="unit_type_id">
                                    <option value="">-Select Unit Type-</option>
                                    @foreach ($unitTypes as $unitTypeOption)
                                        <option {{ old('unit_type_id', $product->unit_type_id ?? '') == $unitTypeOption->id ? 'selected' : '' }}
                                            value="{{ $unitTypeOption->id }}">
                                            {{ $unitTypeOption->name }} ({{ $unitTypeOption->abbreviation }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('unit_type_id')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Quantity')" for="quantity" />
                                <x-text-input :value="old('quantity', $product->quantity)" autocomplete="quantity" autofocus
                                    class="block mt-1 w-full {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                    id="quantity" name="quantity" type="number" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Minimum Stock Treshhold')" for="minimum_stock" />
                                <x-text-input :value="old('minimum_stock', $product->minimum_stock)" autocomplete="minimum_stock" autofocus
                                    class="block mt-1 w-full {{ $errors->has('minimum_stock') ? 'is-invalid' : '' }}"
                                    id="minimum_stock" name="minimum_stock" type="number" />
                                <x-input-error :messages="$errors->get('minimum_stock')" class="mt-2" />
                            </div>


                            <div class="mt-4">
                                <x-input-label :value="__('Buying Price in Peso')" for="buying-price" />
                                <x-text-input :value="old('buying_price', $product->buying_price)" autocomplete="buying-price" autofocus
                                    class="decimal-field block mt-1 w-full text-right {{ $errors->has('buying_price') ? 'is-invalid' : '' }}"
                                    id="buying-price" name="buying_price" placeholder="123.33" step="0.01"
                                    type="number" />
                                <x-input-error :messages="$errors->get('buying_price')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Selling Price in Peso')" for="selling-price" />
                                <x-text-input :value="old('selling_price', $product->selling_price)" autocomplete="selling-price" autofocus
                                    class="decimal-field block mt-1 w-full text-right {{ $errors->has('selling_price') ? 'is-invalid' : '' }}"
                                    id="selling-price" name="selling_price" placeholder="123.33" step="0.01"
                                    type="number" />
                                <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label :value="__('Is Available')" for="status" />
                                <input {{ $product->status == true ? 'checked' : '' }} class="rounded border-gray-300 {{ $errors->has('status') ? 'is-invalid' : ''}}"
                                    name="status" type="checkbox" />
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button class="w-full md:w-fit">{{ __('Update') }}</x-primary-button>

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
    <script src="{{ asset('js/formatDecimal.js') }}"></script>
</x-admin-layout>
