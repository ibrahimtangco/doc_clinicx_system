<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reserve Appointment') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden">

                <p class="text-text-desc text-sm">Available services:</p>
                <div class="py-4 text-gray-900">
                   <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                     @foreach ($services as $service)
                         <a href="{{ route('user.reserve', ['service' => $service->id]) }}" >
                            <div class="group bg-white p-4 rounded-xl text-white flex items-center justify-between hover:bg-primary transition ease-linear duration-300 shadow-md">
                                <div class="flex gap-6 items-center">
                                    <div class="text-base bg-primary rounded-full w-8 h-8 flex items-center justify-center group-hover:bg-white">
                                        <i class="fa-solid fa-tooth group-hover:text-primary"></i>
                                    </div>
                                    <div class="text-primary font-semibold group-hover:text-white">{{ $service->name }}</div>
                                </div>
                            </div>
                        </a>

                     @endforeach

                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
