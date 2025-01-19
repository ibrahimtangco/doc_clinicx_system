@component('mail::message')
# <span style="color: #28a745; font-weight: bold; font-size: 1.5rem;">Reservation Request Submitted</span>

Hello {{ $user->full_name }},

Thank you for submitting your reservation request! We’re currently reviewing it and will notify you once it's approved. Below are the details of your reservation:

---

## Reservation Details:
- **Date:** {{ \Carbon\Carbon::parse($reservation->date)->format('j F Y') }}
- **Schedule:** {{ $reservation->preferred_schedule }}
- **Service:** {{ $reservation->service->name }}

---

For more information about your reservation, click the button below:

@component('mail::button', ['url' => $url, 'color' => 'success'])
View Reservation Details
@endcomponent


We appreciate your trust in **{{ config('app.name') }}** and look forward to serving you. Please note that we aim to review all reservation requests within 24 hours. If your request has not been reviewed 3 hours before your scheduled date, please feel free to contact us lol.

---
{{\Log::info($url)}}

## Stay Connected
@foreach ($socials as $social)
- <strong>{{ ucfirst($social->platform) }}:</strong> [{{ $social->username }}]({{ $social->url }})
@endforeach

## Contact Us
@foreach ($contacts as $contact)
- **Phone**: {{ $contact->phone_number }}
- **Email**: [{{ $contact->email }}](mailto:{{ $contact->email }})
@endforeach

---

Thank you for choosing **{{ config('app.name') }}**. We look forward to welcoming you!

Warm regards,
**The {{ config('app.name') }} Team**

@slot('footer')
@component('mail::subcopy')
If you have any questions or need assistance, please contact us through our support channels.

## Stay Connected
@foreach ($socials as $social)
- <strong>{{ ucfirst($social->platform) }}:</strong> [{{ $social->username }}]({{ $social->url }})
@endforeach

## Contact Us
@foreach ($contacts as $contact)
- **Phone**: {{ $contact->phone_number }}
- **Email**: [{{ $contact->email }}](mailto:{{ $contact->email }})
@endforeach

---

This email was generated automatically—do not reply directly to this message.
@endcomponent
@endslot
@endcomponent
