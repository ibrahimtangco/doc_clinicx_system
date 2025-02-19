<x-app-layout>
	<div class="bg-white">
		{{-- HERO --}}
		<main class="max-w-7xl mx-auto space-y-10 -mt-12 md:-mt-0 px-6 grid-cols-2 pt-40 md:px-10 md:grid md:space-y-0"
			id="hero">
			<div class="space-y-4 col-span-1 md:w-10/12">
				<h1 class="text-5xl  font-bold text-primary-hover md:text-6xl">We care about your smile</h1>
				<p class="text-medium text-secondary-text">Welcome to DocClinicx, where your smile is our priority. Schedule an
					appointment today for personalized dental care tailored to brighten your smile and enhance your oral health
					journey.
				</p>

				@auth
					@if (auth()->user()->userType == 'admin')
						<a class="bg-primary block w-max text-white-text text-sm px-8 py-3 rounded font-semibold hover:bg-background-hover"
							href="{{ route('admin.dashboard') }}">Go to Dashboard</a>
					@elseif (auth()->user()->userType == 'staff')
						<a class="bg-primary block w-max text-white-text text-sm px-8 py-3 rounded font-semibold hover:bg-background-hover"
							href="{{ route('admin.dashboard') }}">Go to Dashboard</a>
					@elseif (auth()->user()->userType == 'superadmin')
						<a class="bg-primary block w-max text-white-text text-sm px-8 py-3 rounded font-semibold hover:bg-background-hover"
							href="{{ route('superadmin.appointments.view') }}">View Reservations</a>
					@else
						<a class="bg-primary block w-max text-white-text text-sm px-8 py-3 rounded font-semibold hover:bg-background-hover"
							href="{{ url('/dashboard') }}">Book appointment</a>
					@endif
				@else
					<a class="bg-primary block w-max text-white-text text-sm px-8 py-3 rounded font-semibold hover:bg-background-hover"
						href="{{ url('/login') }}">Book appointment</a>
				@endauth
			</div>
			<div class="col-span-1">
				<img alt="" class="" src="{{ asset('images/illustration/illustration_2.svg') }}">
			</div>
		</main>
		{{-- HERO --}}

		{{-- ABOUT --}}
		<section class="my-20 px-6 bg-primary py-12 " id="about">
			<div class="max-w-7xl mx-auto md:grid grid-cols-2 gap-4">
				<div class="col-span-1 place-self-center md:pr-32 space-y-3 md:order-2">
					<h2 class="text-5xl font-semibold text-white mb-4">About Us</h2>
					<p class="text-white-text ">Welcome to DocClinicx, your trusted destination for convenient and professional dental
						care. At DocClinicx, we're
						committed to providing top-quality oral health services tailored to meet your individual needs.</p>

					<p class="text-white-text">With our easy-to-use online appointment system, you can schedule your dental check-ups,
						cleanings, fillings,
						extractions, and orthodontic treatments with ease, all from the comfort of your home or on-the-go.</p>

					<p class="text-white-text">Our experienced team of dentists and staff are dedicated to ensuring your comfort and
						satisfaction throughout every
						visit, delivering gentle and compassionate care in a welcoming environment.</p>

					<p class="text-white-text">Whether you're due for a routine check-up or seeking specialized treatment, trust
						DocClinicx to help you achieve a
						healthy and radiant smile that lasts a lifetime.</p>

				</div>
				<div class="col-span-1 flex items-center justify-center md:order-1">
					<img alt="" class="w-full lg:w-8/12" src="{{ asset('images/illustration/illustration_3.svg') }}">
				</div>
			</div>
		</section>
		{{-- ABOUT --}}

		{{-- SERVICES --}}
		<section class="max-w-7xl mx-auto my-20 text-center space-y-4" id="services">
			<div class="space-y-2 mb-12 md:mb-20">
				<p class="text-primary font-semibold">Treatments</p>
				<h2 class="text-primary-text font-bold text-3xl md:text-4xl">What we can do to your teeth</h2>
			</div>
			<div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 max-w-[80%] mx-auto">
				<div
					class="flex flex-col items-center justify-center col-span-1 p-6 rounded-lg bg-slate-100 shadow-sm md:hover:scale-105 duration-300 transition-transform">
					<img alt="" class="mb-4 w-16" src="{{ asset('images/tooth/dental-checkup.png') }}">
					<h3 class="text-primary font-semibold text-lg">Checkup</h3>
					<p class="text-primary-text font-medium">Regular examinations to assess oral health.</p>
				</div>
				<div
					class="flex flex-col items-center justify-center col-span-1 p-6 rounded-lg bg-slate-100 shadow-sm md:hover:scale-105 duration-300 transition-transform">
					<img alt="" class="mb-4 w-16" src="{{ asset('images/tooth/dental-filling.png') }}">
					<h3 class="text-primary font-semibold text-lg">Filling</h3>
					<p class="text-primary-text font-medium">Repairing cavities by filling them with dental materials.</p>
				</div>
				<div
					class="flex flex-col items-center justify-center col-span-1 p-6 rounded-lg bg-slate-100 shadow-sm md:hover:scale-105 duration-300 transition-transform">
					<img alt="" class="mb-4 w-16" src="{{ asset('images/tooth/tooth-extraction.png') }}">
					<h3 class="text-primary font-semibold text-lg">Extraction</h3>
					<p class="text-primary-text font-medium">Removal of teeth due to damage, decay, or other issues.</p>
				</div>
			</div>
			<div class="grid gap-6 sm:grid-cols-2 md:grid-col-3 max-w-[80%] mx-auto">
				<div
					class="flex flex-col items-center justify-center place-self-end col-span-1 p-6 rounded-lg bg-slate-100 shadow-sm md:hover:scale-105 duration-300 transition-transform">
					<img alt="" class="mb-4 w-16" src="{{ asset('images/tooth/tooth-whitening.png') }}">
					<h3 class="text-primary font-semibold text-lg">Cleaning</h3>
					<p class="text-primary-text font-medium"> Removal of plaque, tartar, and stains from teeth.</p>
				</div>
				<div
					class="flex flex-col items-center justify-center place-self-start col-span-1 p-6 rounded-lg bg-slate-100 shadow-sm md:hover:scale-105 duration-300 transition-transform">
					<img alt="" class="mb-4 w-16" src="{{ asset('images/tooth/braces.png') }}">
					<h3 class="text-primary font-semibold text-lg">Orthodontics</h3>
					<p class="text-primary-text font-medium"> Alignment and straightening of teeth and jaws.</p>
				</div>
			</div>
		</section>
		{{-- TODO: contact section --}}

		<section class="my-20 text-desc body-font relative w-full h-full" id="contact">
			<div class="absolute inset-0 bg-gray-300">
				<iframe frameborder="0" height="100%" loading="lazy" marginheight="0" marginwidth="0"
					referrerpolicy="no-referrer-when-downgrade" scrolling="no"
					src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3803.638481998934!2d120.38231127463084!3d17.57239059745028!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x338e658cfeda5f71%3A0xeb1cde8a4557b257!2sFilarca-Rabena%20Dental%20Clinic!5e0!3m2!1sen!2sph!4v1711639439783!5m2!1sen!2sph"
					style="filter: grayscale(40%)" title="map" width="100%">
				</iframe>

			</div>
			<div class="container px-5 py-24 mx-auto flex">
				<div
					class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 relative shadow-lg">
					<h2 class="text-title text-2xl mb-1 font-semibold">Get in touch</h2>
					<p class="leading-relaxed mb-1 text-desc">Feel free to contact us any time. We will get back to you as soon as we
						can!</p>
					<div class="relative mb-4">
						<label class="leading-7 text-sm text-desc" for="email">Emails</label>
						<div class="space-y-2">
							@foreach ($contacts as $contact)
								@if (!empty($contact->email))
									<div class="p-2 border rounded-md">
										{{ $contact->email }}

									</div>
								@endif
							@endforeach
						</div>
					</div>
					<div class="relative mb-4">
						<label class="leading-7 text-sm text-desc" for="email">Phone Numbers</label>
						<div class="space-y-2">
							@foreach ($contacts as $contact)
								@if (!empty($contact->phone_number))
									<div class="p-2 border rounded-md">
										{{ $contact->phone_number }}

									</div>
								@endif
							@endforeach
						</div>
					</div>
					<p class="text-xs text-gray-500 mt-3">Filarca-Rabena Dental Clinic and Dental Supply Official website.</p>
				</div>
			</div>
		</section>

		<footer class="text-desc body-font border-t">
			<div class="container px-5 py-4 mx-auto flex items-center sm:flex-row flex-col">
				<a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900 gap-2">
					<img alt="" class="w-16 -mr-4" src="{{ asset('images/FILARCA.png') }}">
				</a>
				<p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">
					@php
						echo $footer->description ?? 'Filarca-Rabena'
					@endphp
				</p>
				<span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start gap-2">
					@foreach ($socials as $platform => $data)
						@if ($data['status'] === 1)
							{{-- Only show active links --}}
							<a class="text-gray-500" href="{{ $data['url'] ?? '#' }}" target="{{ $data['url'] ? '_blank' : '_self' }}">
								<i class="fab fa-{{ $platform }} text-lg"></i>
							</a>
						@endif
					@endforeach

				</span>
			</div>
		</footer>
		<header class="shadow fixed top-0 left-0 w-full">
			<x-nav />
		</header>
	</div>
</x-app-layout>
