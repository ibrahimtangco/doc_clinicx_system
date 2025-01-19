@props(['title'])
<x-master-layout :title="$title">
	<div
		class="min-h-screen sm:flex flex-col justify-center items-center md:pt-6 sm:pt-0 sm:bg-gradient-to-bl from-primary to-white mt-8 sm:mt-0">
		<div class="w-full flex items-center justify-center">

			{{ $slot }}
		</div>
	</div>
</x-master-layout>
