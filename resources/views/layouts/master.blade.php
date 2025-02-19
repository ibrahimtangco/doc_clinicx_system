@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="{{ csrf_token() }}" name="csrf-token">
	<link href="{{ asset('images/FILARCA.png') }}" rel="icon" type="image/x-icon">

	{{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ $title ?? 'DocClinicx'}}</title>
	<!-- Flowbite -->
	<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

	<!-- AJAX CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<!-- Tailwindcss -->
	@vite('resources/css/app.css')

	{{-- Scripts --}}
	@vite(['resources/css/app.css', 'resources/js/app.js'])

	<!-- Font Awesome -->
	{{-- <script src="https://kit.fontawesome.com/ee634a1922.js" crossorigin="anonymous"></script> --}}

	<!-- Fonts -->
	<link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<!-- Simple Datatables -->
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

</head>

<body class="font-sans antialiased text-dark" x-data="{ isAsideOpen: false }">
	<div>
		{{ $slot }}
	</div>
	<x-notify::notify />
	@notifyJs

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
